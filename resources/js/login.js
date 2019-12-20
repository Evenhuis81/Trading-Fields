export function showpass() {
    $("#showPass").on("change", function() {
        $("#password").attr(
            "type",
            $("#showPass").prop("checked") == true ? "text" : "password"
        );
    });
}
