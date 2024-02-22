"use strict";

// Class definition
let KTUsersUpdatePermissions = (function () {
    // Shared variables
    const element = document.getElementById("kt_modal_show");
    const modal = new bootstrap.Modal(element);

    $(".swal2-confirm").click(function(){
        $('#kt_modal_show').modal('hide');
    });
    // Init add schedule modal
    var initUpdatePermissions = () => {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

        // Close button handler
        const closeButton = element.querySelector(
            '[data-kt-merge-modal-action="close"]'
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
                if (result.isConfirmed == true){
                    modal.hide(); // Hide modal
                    $('#kt_modal_show').modal('hide');
                    modal.hide(); // Hide modal
                }
            });
        });

        // Cancel button handler
        const cancelButton = element.querySelector(
            '[data-kt-merge-modal-action="cancel"]'
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
                $('#kt_modal_show').modal('hide');
                $('#kt_modal_show').removeClass("show");
                if (result.isConfirmed == true){
                    $('#kt_modal_show').modal('hide');
                }
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide(); // Hide modal
                    $('#kt_modal_show').modal('hide');
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
            '[data-kt-merge-modal-action="submit"]'
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

                        // Ajax request
                        $.ajax({
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            url: route + '/update',
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
                            },
                        }).
                        done(function () {
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
                                    location.reload();
                                    $('#kt_modal_show').modal('hide');
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
        const selectAll = form.querySelector("#kt_merge_select_all");
        const allCheckboxes = form.querySelectorAll('#all [type="checkbox"]');

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
