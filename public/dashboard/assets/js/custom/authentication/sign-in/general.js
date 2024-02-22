"use strict";

// Class definition
var KTSigninGeneral = (function () {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(form, {
            fields: {
                email: {
                    validators: {
                        regexp: {
                            regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: "The value is not a valid email address",
                        },
                        notEmpty: {
                            message: "Email address is required",
                        },
                    },
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "The password is required",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "", // comment to enable invalid state icons
                    eleValidClass: "", // comment to enable valid state icons
                })
            },
        });

        // Handle form submit
        submitButton.addEventListener("click", function (e) {
            // Prevent button default action
            e.preventDefault();

            // Validate form
            validator.validate({
                rules: {
                    password: {
                        minlength: 5
                    },
                    password_confirm: {
                        minlength: 5,
                        equalTo: "#password"
                    }
                }
            }).then(function (status) {
                if (status == "Valid") {
                    // Show loading indication
                    submitButton.setAttribute("data-kt-indicator", "on");

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        method: "POST",
                        url: route,
                        data: new FormData(form),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false
                    }).
                    done(function (res) {
                        // Hide loading indication
                        submitButton.removeAttribute("data-kt-indicator");
                        // Enable button
                        submitButton.disabled = false;
                        if (res.redirect === true){
                            location.href = res.url;
                        }
                        let redirectUrl = form.getAttribute("data-kt-redirect-url");
                        if (redirectUrl) {
                            location.href = redirectUrl;
                        }
                    }).
                    fail(function (res) {
                        let text = "";
                        if (res.responseJSON) {
                            text = res.responseJSON.message;
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: text,
                        });
                            // Hide loading indication
                            submitButton.removeAttribute("data-kt-indicator");
                            submitButton.disabled = false;

                        })
                    ;
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
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
        });
    };

    // Public functions
    return {
        // Initialization
        init: function () {
            form = document.querySelector("#kt_sign_in_form");
            submitButton = document.querySelector("#kt_sign_in_submit");

            handleForm();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
;