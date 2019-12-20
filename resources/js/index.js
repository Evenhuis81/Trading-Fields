export function closeCookie() {
    $(".closecookie").on("click", function() {
        $.ajax({
            type: "post",
            url: "/acceptedcookies",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function() {
                alert("cookie set");
            },
            failure: function() {
                alert("no");
            }
        });
    });
}

export function selectCats() {
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
        let url = "?categories=" + catArrPush;
        loadAjaxDoc(url);
    });
}

export function allCat() {
    $("#allCat").on("click", function() {
        $(this).prop({ disabled: true });
        let catArr = $(".selectCats");
        for (let el of catArr) {
            el.checked = false;
        }
        // let url = '';
        loadAjaxDoc();
    });
}

export function paginate() {
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
}

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
