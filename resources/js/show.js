export function postBid() {
    $(function() {
        $("#bidform").on("submit", function(e) {
            e.preventDefault();
            var inputbid = $("#getbid").val();
            $.ajax({
                type: "post",
                url: "/bids",
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
                        $("#getbid").addClass("is-invalid");
                        $("#print-error-msg").html(data.error[0]);
                        $("#submitbutton").blur();
                        $("#getbid").focus();
                    }
                },
                failure: function(data) {
                    $("#getbid").addClass("is-invalid");
                    $("#print-error-msg").html(
                        "something went wrong! call 911"
                    );
                    $("#submitbutton").blur();
                }
            });
        });
    });
}

export function deleteBid() {
    function attachDelete() {
        $(".deletebid").on("submit", function(e) {
            e.preventDefault();
            var bid = $(this).attr("action");
            $.ajax({
                type: "delete",
                url: `/bids/${bid}`,
                data: { bid: bid },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $(".bidcontent").html(data);
                        attachDelete();
                    } else {
                        $("#print-error-msg").html(data.error);
                    }
                },
                failure: function(data) {
                    $("#print-error-msg").html(data.error);
                }
            });
        });
    }
}

export function visitorBid() {
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
    });
}

attachDelete();
