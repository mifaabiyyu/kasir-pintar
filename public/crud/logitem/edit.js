"use strict";
var EditCategory = (function () {
    const modal = document.getElementById("editLogModal");
    const editForm = modal.querySelector("#edit_log_item");
    // var kode;
    const initModal = new bootstrap.Modal(modal);

    return {
        init: function () {
            (() => {
                const onSubmit = modal.querySelector(
                    '[data-submit-edititem="submit"]'
                );

                onSubmit.addEventListener("click", (t) => {
                    onSubmit.setAttribute("data-kt-indicator", "on");
                    var formData = new URLSearchParams(new FormData(editForm));

                    $.ajax({
                        type: "POST",
                        url: route("log-data.update", kode),
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            (onSubmit.disabled = !0),
                                setTimeout(function () {
                                    onSubmit.removeAttribute(
                                        "data-kt-indicator"
                                    ),
                                        (onSubmit.disabled = !1),
                                        Swal.fire({
                                            text: response.message,
                                            icon: "success",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton:
                                                    "btn btn-primary",
                                            },
                                        }).then(function (t) {
                                            t.isConfirmed && initModal.hide();
                                            editForm.reset();
                                            var oTable =
                                                $("#log_table").DataTable();
                                            oTable.draw(false);
                                        });
                                }, 200);
                        },
                        error: function (error) {
                            onSubmit.removeAttribute("data-kt-indicator");
                            if (error.responseJSON.errors) {
                                const errors = Object.values(
                                    error.responseJSON.errors
                                );

                                errors.forEach((element) => {
                                    toastr.error(element[0], options);
                                });
                            } else {
                                toastr.error(
                                    error.responseJSON.message,
                                    options
                                );
                            }
                        },
                    });
                });
            })();
        },
    };
})();
window.addEventListener("DOMContentLoaded", (event) => {
    EditCategory.init();
});
