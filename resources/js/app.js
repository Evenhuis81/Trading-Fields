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

$(document).ready(function() {
    // For all pages
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
});

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

// $('#my-form').submit( processForm );

$(function() {
    $("#bid-form").on("submit", function(e) {
        e.preventDefault(); // prevent the form submission
        $.ajax({
            type: "post",
            // dataType: "JSON",
            url: "/bids",
            data: $(this).serialize(), // serialize all form inputs
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                console.log("de response terug");
                console.log(response);
                $(".bidcont")
                    .empty()
                    .html(response);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
});

// $(function() {
//     $("#submitbid").on("click", function(e) {
//         e.preventDefault();
//         console.log(this);
//         return;
//         $.ajax({
//             url: "bids/",
//             type: "POST",
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//             },
//             data: "",
//             success: function() {
//                 $(".poss" + id)
//                     .css({
//                         opacity: 0.5,
//                         "user-select": "none"
//                     })
//                     .removeClass("hoverer")
//                     .addClass("deleted");

//                 swal("Poof! Your advert has been deleted!", {
//                     icon: "success"
//                 });
//             }
//         });
//     });
// });

$(function() {
    $("body").on("click", "#plainbutton", function() {
        var textArr = document.querySelector("#plaindiv").innerHTML.split("\n");
        console.log(textArr);
    });
});

//     function loadDoc(querystring = []) {
//         var xhttp = new XMLHttpRequest();
//         xhttp.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 document.getElementById(
//                     "advertIndex"
//                 ).innerHTML = this.responseText;
//             }
//         };
//         xhttp.open("GET", "advertindex?numbers=" + querystring, true);
//         xhttp.send();
//     }
// });

// var imgmax = 0;
//     $(".imgAdd").click(function() {
//         imgmax += 1;
//         $(this)
//             .closest(".row")
//             .find(".imgAdd")
//             .before(
//                 '<div class="col-sm-4 imgUp"><div class="imagePreview"></div><label class="btn btn-primary" id="btn-primary">Upload<input type="file" name="images[]" class="uploadFile" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>'
//             );
//         if (imgmax == 2) {
//             $(".imgAdd").css("display", "none");
//         }
//     });

//     $(document).on("click", "i.del", function() {
//         imgmax -= 1;
//         $(this)
//             .parent()
//             .remove();
//         if (imgmax == 1) {
//             $(".imgAdd").css("display", "block");
//         }
//     });

// var imgmax = 0;
//     $(".imgAdd").click(function() {
//         imgmax += 1;
//         $(this)
//             .closest(".row")
//             .find(".imgAdd")
//             .before(
//                 '<div class="col-sm-4 imgUp"><div class="imagePreview"></div><label class="btn btn-primary" id="btn-primary">Upload<input type="file" name="images[]" class="uploadFile" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>'
//             );
//         if (imgmax == 2) {
//             $(".imgAdd").css("display", "none");
//         }
//     });

//     $(document).on("click", "i.del", function() {
//         imgmax -= 1;
//         $(this)
//             .parent()
//             .remove();
//         if (imgmax == 1) {
//             $(".imgAdd").css("display", "block");
//         }
