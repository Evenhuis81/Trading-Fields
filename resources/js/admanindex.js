export function toggle() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
}

export function deletead() {
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
}
