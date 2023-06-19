"use strict";
var AddSupplier = (function () {
    const modal = document.getElementById("addSupplierModal");
    const addForm = modal.querySelector("#add_supplier");

    const initModal = new bootstrap.Modal(modal);

    return {
        init: function () {
            (() => {
                const onSubmit = modal.querySelector(
                    '[data-submit-item="submit"]'
                );

                onSubmit.addEventListener("click", (t) => {
                    onSubmit.setAttribute("data-kt-indicator", "on");
                    var formData = new FormData(addForm);

                    $.ajax({
                        type: "POST",
                        url: route("vendor-data.store"),
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
                                            addForm.reset();
                                            var oTable =
                                                $(
                                                    "#supplier_table"
                                                ).DataTable();
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
    AddSupplier.init();
});
