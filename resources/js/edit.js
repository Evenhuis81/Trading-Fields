export function titlehover() {
    $("#titlehover").on("click", function() {
        $(this).removeAttr("id");
        $(this).attr("id", "notitlehover");
        $("#titleText").hide();
        $("#title").show();
        // $("#title").popover({
        //     trigger: "focus"
        // });
    });
}
