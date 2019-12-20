export function inputQuery() {
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
}

export function selectQuery() {
    $(document).on("click", "li", function() {
        $("#search").val($(this).text());
    });
}

export function searchListOn() {
    $("#search").click(function(e) {
        e.stopPropagation();
        jQuery(".searchList").fadeIn(500);
    });
}

export function searchListOff() {
    $("body").click(function(e) {
        if (!$(e.target).hasClass(".searchList")) {
            jQuery(".searchList").fadeOut(500);
        }
    });
}

export function escapePressed() {
    $("body").keydown(function(e) {
        if (e.keyCode === 27 || e.which === 27) {
            jQuery(".searchList").fadeOut(500);
        }
    });
}

function attachKeypress() {
    $("body").keydown(function(e) {
        if (e.keyCode === 40 || e.which === 40) {
            // jQuery(".searchList").fadeOut(500);
            e.stopPropagation();
        } else if (e.keyCode === 38 || e.which === 38) {
            e.stopPropagation();
            //
        }
    });
}
