export function loadAjaxDoc(url) {
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
