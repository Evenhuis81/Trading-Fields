/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

// maak voor iedere pagina een eigen aparte javascript file en include deze alleen voor de desbetreffende pagina voor betere
// projectorganisatie van bestanden en betere leesbaarheid / lagere laadtijd / makkelijker debuggen van code

$(document).ready(function() {
    // For all pages
    $(".closecookie").on("click", function() {
        // console.log('clicked');
        $.ajax({
            type: "post",
            url: "/acceptedcookies",
            // data: { inputbid: inputbid },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function() {
                    alert('yes');
                },
            failure: function() {
                    alert('no');
            }
        });
        // Ajax post make cookie accepted
    })

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Login
    $("#showPass").on("change", function() {
        $("#password").attr(
            "type",
            $("#showPass").prop("checked") == true ? "text" : "password"
        );
    });

    // Create Advert
    if ($("#bids").prop("checked") == true) {
        $("#inputBid").toggle();
    }

    $("#bids").on("change", function() {
        if ($(this).prop("checked") == false) {
            $("#bid").removeAttr("name");
        } else {
            $("#bid").attr("name", "startbid");
        }
        $("#inputBid").toggle("slow");
    });

    $(function() {
        $(document).on("change", ".uploadFile", function() {
            // var msize = 11600;
            var msize = 2 * 1024 * 1024;
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];

            // return;
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (!/^image/.test(files[0].type)) {
                // only image file
                message = "This is not a valid image!";
                ImageMessage(message);
                $(this).val("");
                return;
            } else if (this.files[0].size > msize) {
                var message = "Exceeds file size of 2MB!";
                ImageMessage(message);
                $(this).val("");
                return;
            } else {
                $("#imagename").attr({
                    name: "imagename",
                    value: this.files[0].name
                    // insert remove hidden input with name base64key etc
                });
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() {
                    // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile
                        .closest(".imgUp")
                        .find(".imagePreview")
                        .css("background-image", "url(" + this.result + ")");
                };
            }
        });
    });
    function ImageMessage(message) {
        var imgMsg = $("#imgMsg");
        var display = imgMsg.css("display");
        imgMsg.find("strong").html(message);
        imgMsg
            .css("visibility", "visible")
            .hide()
            .fadeIn("slow");
        imgMsg.delay(2000).fadeOut("slow", function() {
            imgMsg.css("visibility", "hidden");
            imgMsg.css("display", display);
        });
    }

    // Manage Adverts
    $(".delete").click(function() {
        var id = $(this).data("id");
        console.log(id);
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this advert!",
            icon: "warning",
            buttons: ["Cancel", "DELETE!"],
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                $.ajax({
                    url: "adverts/" + id,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    success: function() {
                        $(".poss" + id)
                            .css({
                                opacity: 0.5,
                                "user-select": "none"
                            })
                            .removeClass("hoverer")
                            .addClass("deleted");

                        swal("Poof! Your advert has been deleted!", {
                            icon: "success"
                        });
                    }
                });
            } else {
                swal("Your advert is safe!");
            }
        });
    });

    // Edit Advert
    $("#titlehover").on("click", function() {
        $(this).removeAttr("id");
        $(this).attr("id", "notitlehover");
        $("#titleText").hide();
        $("#title").show();
        // $("#title").popover({
        //     trigger: "focus"
        // });
    });

    // Main Index Page

    $(".selectCats").on("click", function() {
        let catArrPush = [];
        let catArr = $(".selectCats");
        for (let index = 0; index < catArr.length; index++) {
            if (catArr[index].checked == true) {
                catArrPush.push(catArr[index].value);
            }
        }
        catArrPush.length === 0
            ? $("#allCat").prop({ disabled: true, checked: true })
            : $("#allCat").prop({ disabled: false, checked: false });
        // loadAjaxDoc(catArrPush);
        let url = "?categories=" + catArrPush;
        // console.log(url);
        // return;
        loadAjaxDoc(url);
    });

    $("#allCat").on("click", function() {
        $(this).prop({ disabled: true });
        let catArr = $(".selectCats");
        for (let el of catArr) {
            el.checked = false;
        }
        // let url = '';
        loadAjaxDoc();
    });

    // Searchbar
    $("#search").keyup(function() {
        var query = $(this).val();
        if (query != "") {
            $.ajax({
                url: "/autocomplete",
                method: "POST",
                data: { query: query },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    $(".searchList").fadeIn();
                    $(".searchList").html(data);
                    attachKeypress();
                }
            });
        } else {
            $(".searchList").empty();
        }
    });

    $(document).on("click", "li", function() {
        $("#search").val($(this).text());
        // console.log($(this).text());
        // $(".searchList").fadeOut();
    });

    $("#search").click(function(e) {
        e.stopPropagation();
        jQuery(".searchList").fadeIn(500);
    });

    $("body").click(function(e) {
        if (!$(e.target).hasClass(".searchList")) {
            jQuery(".searchList").fadeOut(500);
        }
    });

    $("body").keydown(function(e) {
        if (e.keyCode === 27 || e.which === 27) {
            jQuery(".searchList").fadeOut(500);
        }
    });
});

function attachKeypress() {
    $("body").keydown(function(e) {
        if (e.keyCode === 40 || e.which === 40) {
            // jQuery(".searchList").fadeOut(500);
            e.stopPropagation();
            // alert("ye");
        } else if (e.keyCode === 38 || e.which === 38) {
            e.stopPropagation();
            //
        }
    });
    //     $(".dropss").bind("keydown", function(event) {
    //         console.log("heee");
    //         return;
    //         var keyChar = String.fromCharCode(event.keyCode);
    //         var selectedItem = $(this)
    //             .find("a")
    //             .filter(function() {
    //                 return (
    //                     $(this)
    //                         .text()
    //                         .indexOf(keyChar) === 0
    //                 );
    //             })
    //             .first();
    //         selectedItem.focus();
    //     });
}

// attachKeypress();

function loadAjaxDoc(url) {
    $.ajax({
        url: url
    })
        .done(function(data) {
            $("#advertIndex").html(data);
        })
        .fail(function() {
            alert("Articles could not be loaded.");
        });
}

$(function() {
    $("body").on("click", ".pagination a", function(e) {
        e.preventDefault();
        // $('#load a').css('color', '#dfecf6');
        $("#load").append(
            '<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/loading_spinner.gif" />'
        );
        let catArrPush = [];
        let catArr = $(".selectCats");
        for (let index = 0; index < catArr.length; index++) {
            if (catArr[index].checked == true) {
                catArrPush.push(catArr[index].value);
            }
        }
        var url = $(this).attr("href");
        if (catArrPush.length === 0) {
            loadAjaxDoc(url);
        } else {
            url += "&categories=" + catArrPush;
            loadAjaxDoc(url);
        }
        // window.history.pushState("", "", url);
    });
});

// Show page
$(function() {
    $("#bidform").on("submit", function(e) {
        e.preventDefault(); // prevent the form submission
        var inputbid = $("#getbid").val();
        // formDataAsJson = JSON.stringify($("#bid-form").serializeArray());
        $.ajax({
            type: "post",
            // dataType: "JSON",
            // contentType: "application/json; charset=utf-8",
            url: "/inputbid",
            // data: $(this).serialize(), // serialize all form inputs
            // data: formDataAsJson,
            data: { inputbid: inputbid },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $(".bidcontent").html(data);
                    $("#getbid")
                        .val("")
                        .removeClass("is-invalid");
                    $("#print-error-msg").html("");
                    $("#submitbutton").blur();
                    attachDelete();
                } else {
                    // printErrorMsg(data.error);
                    $("#getbid").addClass("is-invalid");
                    $("#print-error-msg").html(data.error[0]);
                    $("#submitbutton").blur();
                    $("#getbid").focus();
                    // $.each(data.error, function(index, value) {
                    //     $("#print-error-msg").html(value);
                    // });
                }
            },
            failure: function(data) {
                $("#getbid").addClass("is-invalid");
                $("#print-error-msg").html("something went wrong! call 911");
                $("#submitbutton").blur();
            }
        });
    });
});
// function printErrorMsg(msg) {
//     $(".print-error-msg")
//         .find("ul")
//         .html("");
//     $(".print-error-msg").css("display", "block");
//     $.each(msg, function(key, value) {
//         $(".print-error-msg")
//             .find("ul")
//             .append("<li>" + value + "</li>");
//     });
// }

function attachDelete() {
    $(".deletebid").on("submit", function(e) {
        e.preventDefault();
        var bid = $(this).attr("action");
        $.ajax({
            type: "post",
            url: "/deletebid",
            data: { bid: bid },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $(".bidcontent").html(data);
                    attachDelete();
                } else {
                    printErrorMsg(data.error);
                }
            },
            failure: function(data) {
                printErrorMsg(data.error);
            }
        });
    });
}

attachDelete();

$("#visitorsubmit").on("click", function(e) {
    e.preventDefault();
    swal("You have to login or register to place bids", {
        buttons: {
            cancel: true,
            Register: true,
            Login: true
        }
    }).then(value => {
        switch (value) {
            case "Register":
                var inputbid = $("#getbid").val();
                if (inputbid == "") {
                    inputbid = "null";
                }
                var inputbid = "143";
                location.href = "/register?redirect=" + inputbid;
                break;
            case "Login":
                var inputbid = $("#getbid").val();
                if (inputbid == "") {
                    inputbid = "null";
                }
                location.href = "/login?redirect=" + inputbid;
                break;
            // default:
            // swal("Got away safely!");
        }
    });
    // var bid = $(this).attr("action");
    // $.ajax({
    //     type: "post",
    //     url: "/deletebid",
    //     data: { bid: bid },
    //     headers: {
    //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    //     },
    //     success: function (data) {
    //         if ($.isEmptyObject(data.error)) {
    //             $(".bidcontent").html(data);
    //             attachDelete();
    //         } else {
    //             printErrorMsg(data.error);
    //         }
    //     },
    //     failure: function (data) {
    //         printErrorMsg(data.error);
    //     }
    // });
});
