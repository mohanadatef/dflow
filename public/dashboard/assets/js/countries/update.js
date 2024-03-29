"use strict";

// Class definition
var KTUsersUpdatePermissions = (function () {
    // Shared variables
    const element = document.getElementById("kt_modal_edit_country");
    const form = element.querySelector("#kt_modal_edit_country_form");
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdatePermissions = () => {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(form, {
            fields: {
                name_ar: {
                    validators: {
                        notEmpty: {
                            message: "Full name is required",
                        },
                    },
                },
                name_en: {
                    validators: {
                        notEmpty: {
                            message: "Full name is required",
                        },
                    },
                },
                code: {
                    validators: {
                        notEmpty: {
                            message: "Full name is required",
                        },
                    },
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });

        // Close button handler
        const closeButton = element.querySelector(
            '[data-kt-roles-modal-action="close"]'
        );
        closeButton.addEventListener("click", (e) => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to close?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, close it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light",
                },
            }).then(function (result) {
                if (result.value) {
                    modal.hide(); // Hide modal
                }
            });
        });

        // Cancel button handler
        const cancelButton = element.querySelector(
            '[data-kt-roles-modal-action="cancel"]'
        );
        cancelButton.addEventListener("click", (e) => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light",
                },
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide(); // Hide modal
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: ok_got_it,
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        });

        // Submit button handler
        const submitButton = element.querySelector(
            '[data-kt-roles-modal-action="submit"]'
        );
        submitButton.addEventListener("click", function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {

                    if (status == "Valid") {
                        // Show loading indication
                        submitButton.setAttribute("data-kt-indicator", "on");

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;
                        var countryId = $('#countryId').val();
                        // Ajax request
                        $.ajax({
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            url: route + '/' + countryId,
                            data: new FormData(form),
                            dataType: "JSON",
                            contentType: false,
                            cache: false,
                            processData: false,
                            error: function (err) {
                                if (err.hasOwnProperty("responseJSON")) {
                                    if (
                                        err.responseJSON.hasOwnProperty(
                                            "message"
                                        )
                                    ) {
                                        swal.fire({
                                            title: "Error !",
                                            text: err.responseJSON.message,
                                            confirmButtonText: "Ok",
                                            icon: "error",
                                            confirmButtonClass:
                                                "btn font-weight-bold btn-primary",
                                        });
                                    }
                                }
                                submitButton.setAttribute("data-kt-indicator", "off");
                                submitButton.disabled = false;
                            },
                        })
                            .done(function (res) {
                                // Remove loading indication
                                submitButton.removeAttribute(
                                    "data-kt-indicator"
                                );

                                // Enable button
                                submitButton.disabled = false;
                                // Remove loading indication
                                submitButton.removeAttribute("data-kt-indicator");

                                // Show popup confirmation
                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: ok_got_it,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        modal.hide();
                                        var table = $("#kt_customers_table").DataTable();
                                        table.draw();
                                    }
                                });
                            })
                            .fail(function (res) {
                                Swal.fire({
                                    text: res.responseJSON.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: ok_got_it,
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            });

                    } else {
                        // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: ok_got_it,
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            }
        });
    };

    // Select all handler
    const handleSelectAll = () => {
        // Define variables
        const selectAll = form.querySelector("#kt_roles_select_all");
        const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

        // Handle check state
        selectAll.addEventListener("change", (e) => {
            // Apply check state to all checkboxes
            allCheckboxes.forEach((c) => {
                c.checked = e.target.checked;
            });
        });
    };

    return {
        // Public functions
        init: function () {
            initUpdatePermissions();
            handleSelectAll();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePermissions.init();
});

function loadCountry(countryId) {
    $("#kt_modal_edit_country_scroll").html('<img src="https://static.collectui.com/shots/3678774/dash-loader-large" alt="">');

    $.ajax({
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: route + "/" + countryId + "/edit",
        data: {
            id: countryId,
        },
    })
        .done(function (res) {
            $("#kt_modal_edit_country_scroll").html(res);
        })
        .fail(function (res) {
            Swal.fire({
                text: res.responseJSON,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: ok_got_it,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
            });
        });
}
;