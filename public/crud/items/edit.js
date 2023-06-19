"use strict";
var EditItems = (function () {
    const modal = document.getElementById("editItemModal");
    const editForm = modal.querySelector("#edit_item");
    var kode;
    const initModal = new bootstrap.Modal(modal);

    $("body").on("click", "#edit-data", function () {
        kode = $(this).data("id");
        // showUrl.replace(":id", kode);
        $.ajax({
            type: "GET",
            url: route("items-data.show", kode),

            success: function (response) {
                $("#edit_name").val(response.data.name);
                $("#edit_sku").val(response.data.sku);
                $("#edit_status").val(response.data.status);
                $("#edit_category").val(response.data.category_id);
                $("#edit_stock").val(response.data.stock);
                if (response.data.image != null) {
                    $("#imagesData").attr(
                        "href",
                        baseUrl + "/images/" + response.data.image
                    );
                    $("#imagesData").html("View File");
                } else {
                    $("#imagesData").attr("href", "javascript:void(0)");
                    $("#imagesData").html("No File");
                }
                let arraySatuan = [];

                response.data.item_satuan.forEach((element) => {
                    arraySatuan.push(element.id);
                });

                $("#edit_satuan").val(arraySatuan).change();
            },
            error: function (error) {
                Swal.fire({
                    text: error.responseJSON.message,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            },
        });
    });

    return {
        init: function () {
            (() => {
                const onSubmit = modal.querySelector(
                    '[data-submit-edititem="submit"]'
                );

                onSubmit.addEventListener("click", (t) => {
                    onSubmit.setAttribute("data-kt-indicator", "on");
                    var formData = new FormData(editForm);

                    $.ajax({
                        type: "POST",
                        url: route("items.update", kode),
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
                                                $("#item_table").DataTable();
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
    EditItems.init();
});
