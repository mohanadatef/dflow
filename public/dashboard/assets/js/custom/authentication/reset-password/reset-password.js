"use strict";

// Class Definition
var KTAuthResetPassword = function () {
    // Elements
    var form;
    var submitButton;
    var validator;

    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'email': {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: 'The value is not a valid email address',
                            },
                            notEmpty: {
                                message: 'Email address is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',  // comment to enable invalid state icons
                        eleValidClass: '' // comment to enable valid state icons
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            let result = null;
            // Validate form
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    $.ajax({
                        type: "POST",
                        url: URL,
                        data: {
                            'email': form.querySelector('[name="email"]').value,
                            "_token": csrfToken,
                        },
                        success: function (res) {
                            submitButton.disabled = false;
                            result = res;

                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button

                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/


                            Swal.fire({
                                text: "We have send a password reset link to your email.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function () {
                                if (result.status) {
                                    form.querySelector('[name="email"]').value = "";
                                    //form.submit();

                                    var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                    if (redirectUrl) {
                                        location.href = redirectUrl;
                                    }
                                }
                            });
                        }, error: function (res) {
                        }
                    });

                    // Simulate ajax request
                    setTimeout(function () {
                    }, 1500);
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: ok_got_it,
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function () {
            form = document.querySelector('#kt_password_reset_form');
            submitButton = document.querySelector('#kt_password_reset_submit');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAuthResetPassword.init();
});
;