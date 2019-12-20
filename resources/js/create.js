export function bidcheck() {
    if ($("#bids").prop("checked") == true) {
        $("#inputBid").toggle();
    }
}

export function bidchange() {
    $("#bids").on("change", function() {
        if ($(this).prop("checked") == false) {
            $("#bid").removeAttr("name");
        } else {
            $("#bid").attr("name", "startbid");
        }
        $("#inputBid").toggle("slow");
    });
}

export function filechange() {
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
}

export function a() {
    //
}

export function b() {
    //
}
