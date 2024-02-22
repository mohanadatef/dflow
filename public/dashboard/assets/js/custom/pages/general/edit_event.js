"use strict";

// Class definition
var KTContactApplyEdit = function () {
    var submitButton;
    var validator;
    var form;

    // Private functions

    // Init form inputs
    var initForm = function () {
        // Team assign. For more info, plase visit the official plugin site: https://select2.org/
        // $(form.querySelector('[name="position"]')).on('change', function () {
        //     // Revalidate the field when an option is chosen
        //     validator.revalidateField('position');
        // });
    }

    // Handle form validation and submittion
    var handleForm = function () {
        // Stepper custom navigation
        let currentTime = new Date();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'title': {
                        validators: {
                            notEmpty: {
                                message: 'The Name is required'
                            }
                        }
                    },
                    'campaign': {
                        validators: {
                            notEmpty: {
                                message: 'The Campaign is required'
                            }
                        }
                    },
                    'from': {
                        validators: {
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'The date is not a valid'
                            },
                            notEmpty: {
                                message: 'From date is required'
                            },
                        }
                    },
                    'to': {
                        validators: {
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'The value is not a valid date'
                            },
                            notEmpty: {
                                message: 'To date is required'
                            },
                            callback: {
                                message: 'The end date must be after the start date',
                                callback: function(value, validator) {
                                    let startDateInput = $('#from').val();
                                    let startDate = new moment(startDateInput, 'YYYY-MM-DD', true).toDate().getTime();
                                    let endDate = new moment(value.value, 'YYYY-MM-DD', true).toDate().getTime();
                                    if (startDate <= endDate) {
                                        return true;
                                    }
                                    return false;
                                }
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({}),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
        // Action buttons
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    $('.save-spinner').removeClass('d-none');

                    if (status === 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        $.ajax({
                            method: "POST",
                            url: route,
                            data: new FormData(form),
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false
                        }).done(function (res) {
                            // Hide loading indication
                            submitButton.removeAttribute("data-kt-indicator");
                            // Enable button
                            submitButton.disabled = false;

                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/


                            setTimeout(function () {
                                submitButton.removeAttribute('data-kt-indicator');
                                // Enable button
                                submitButton.disabled = false;
                                Swal.fire({
                                    text: success_message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: ok_got_it,
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function (result) {
                                });
                                //window.location.href = '/coredata/calendar';
                                $('#calendar').fullCalendar('refetchEvents');
                                $('#update').modal('hide');
                            }, 500);

                            $('.save-spinner').addClass('d-none');

                        }).fail(function (res) {
                            var text = "";
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
                            $('.save-spinner').addClass('d-none');
                        })
                        ;

                    } else {
                        // Scroll top

                        // Show error popuo. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: ok_got_it,
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            KTUtil.scrollTop();
                        });
                        $('.save-spinner').addClass('d-none');
                    }
                });
            }
        });
    }

    return {
        // Public functions
        init: function () {
            // Elements
            form = document.querySelector('#edit_form');
            submitButton = document.getElementById('edit_submit_button');
            initForm();
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTContactApplyEdit.init();
});
