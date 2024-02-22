"use strict";

// Class definition
// var KTDatatablesServerSide = (function () {
//     // Shared variables
//     var table;
//     var dt;
//     var filterPayment;
//     var datatable;
//     var toolbarBase;
//     var toolbarSelected;
//     var selectedCount;
//
//
//     // Private functions
//     var initDatatable = function () {
//         dt = $("#kt_influencer_table").DataTable({
//
//         });
//
//         table = dt.$;
//
//         // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
//         dt.on("draw", function () {
//             initToggleToolbar();
//             toggleToolbars();
//             handleDeleteRows();
//             KTMenu.createInstances();
//         });
//     };
//
//     // Search Datatable --- official influencer reference: https://datatables.net/reference/api/search()
//     var handleSearchDatatable = function () {
//         const filterSearch = document.querySelector(
//             '[data-kt-influencer-table-filter="search"]'
//         );
//         if (filterSearch) {
//             filterSearch.addEventListener("keyup", function (e) {
//                 // dt.search(e.target.value).draw();
//
//                 dt = $("#kt_influencer_table").DataTable({paging: false, info: false});
//                 dt.search(e.target.value).draw();
//             });
//         }
//     };
//
//     // Filter Datatable
//     var handleFilterDatatable = () => {
//         // Select filter options
//         filterPayment = document.querySelectorAll(
//             '[data-kt-influencer-table-filter="group"] [name="group"]'
//         );
//         const filterButton = document.querySelector(
//             '[data-kt-influencer-table-filter="filter"]'
//         );
//
//         if (filterButton) {
//             // Filter datatable on submit
//             filterButton.addEventListener("click", function () {
//                 // Get filter values
//                 let paymentValue = "";
//
//                 // Get payment value
//                 filterPayment.forEach((r) => {
//                     if (r.checked) {
//                         paymentValue = r.value;
//                     }
//
//                     // Reset payment value if "All" is selected
//                     if (paymentValue === "all") {
//                         paymentValue = "";
//                     }
//                 });
//
//                 // Filter datatable --- official influencer reference: https://datatables.net/reference/api/search()
//                 dt.search(paymentValue).draw();
//             });
//         }
//     };
//
//     // Delete influencer
//     var handleDeleteRows = () => {
//         // Select all delete buttons
//         const deleteButtons = document.querySelectorAll(
//             '[data-kt-influencer-table-filter="delete_row"]'
//         );
//         if (deleteButtons) {
//             deleteButtons.forEach((d) => {
//
//                 // Delete button on click
//                 d.addEventListener("click", function (e) {
//                     e.preventDefault();
//
//                     // Select parent row
//                     const parent = e.target.closest("tr");
//
//                     // Get influencer name
//                     const influencerName = parent.querySelectorAll("td")[2].innerText;
//                     const influencerId = parent.querySelectorAll("td div input")[0].value;
//
//                     // SweetAlert2 pop up --- official influencer reference: https://sweetalert2.github.io/
//                     Swal.fire({
//                         text:
//                             are_you_sure_you_want_to_delete +
//                             influencerName +
//                             "?",
//                         icon: "warning",
//                         showCancelButton: true,
//                         buttonsStyling: false,
//                         confirmButtonText: yes_delete,
//                         cancelButtonText: no_cancel,
//                         customClass: {
//                             confirmButton: "btn fw-bold btn-danger",
//                             cancelButton:
//                                 "btn fw-bold btn-active-light-primary",
//                         },
//                     }).then(function (result) {
//                         if (result.value) {
//                             $.ajax({
//                                 method: "POST",
//                                 headers: {
//                                     "X-CSRF-TOKEN": $(
//                                         'meta[name="csrf-token"]'
//                                     ).attr("content"),
//                                 },
//                                 url: route + "/" + influencerId,
//                                 data: {
//                                     _token: csrfToken,
//                                     _method: "DELETE",
//                                     id: influencerId,
//                                 },
//                             })
//                                 .done(function (res) {
//                                     // Simulate delete request -- for demo purpose only
//                                     Swal.fire({
//                                         text:
//                                             you_have_deleted +
//                                             influencerName +
//                                             "!.",
//                                         icon: "success",
//                                         buttonsStyling: false,
//                                         confirmButtonText: ok_got_it,
//                                         customClass: {
//                                             confirmButton:
//                                                 "btn fw-bold btn-primary",
//                                         },
//                                     }).then(function () {
//                                         // delete row data from server and re-draw datatable
//                                         // dt.draw();
//                                         location.reload();
//                                     });
//                                 })
//                                 .fail(function (res) {
//                                     Swal.fire({
//                                         text:
//                                             influencerName + was_not_deleted,
//                                         icon: "error",
//                                         buttonsStyling: false,
//                                         confirmButtonText: ok_got_it,
//                                         customClass: {
//                                             confirmButton:
//                                                 "btn fw-bold btn-primary",
//                                         },
//                                     });
//                                 });
//                         } else if (result.dismiss === "cancel") {
//                             Swal.fire({
//                                 text: influencerName + was_not_deleted,
//                                 icon: "error",
//                                 buttonsStyling: false,
//                                 confirmButtonText: ok_got_it,
//                                 customClass: {
//                                     confirmButton: "btn fw-bold btn-primary",
//                                 },
//                             });
//                         }
//                     });
//                 });
//             });
//         }
//     };
//
//     // Reset Filter
//     var handleResetForm = () => {
//         // Select reset button
//         const resetButton = document.querySelector(
//             '[data-kt-influencer-table-filter="reset"]'
//         );
//         if (resetButton) {
//             // Reset datatable
//             resetButton.addEventListener("click", function () {
//                 // Reset payment type
//                 filterPayment[0].checked = true;
//
//                 // Reset datatable --- official influencer reference: https://datatables.net/reference/api/search()
//                 dt.search("").draw();
//             });
//         }
//     };
//
//     // Init toggle toolbar
//     var initToggleToolbar = function () {
//         // Toggle selected action toolbar
//         // Select all checkboxes
//         const container = document.querySelector("#kt_influencer_table");
//         const checkboxes = container.querySelectorAll('[type="checkbox"]');
//
//
//         // Select elements
//         const deleteSelected = document.querySelector(
//             '[data-kt-influencer-table-select="delete_selected"]'
//         );
//
//         // Toggle delete selected toolbar
//         checkboxes.forEach((c) => {
//             // Checkbox on click event
//             c.addEventListener("click", function () {
//                 setTimeout(function () {
//                     toggleToolbars();
//                 }, 50);
//             });
//         });
//         if (deleteSelected) {
//             // Deleted selected rows
//             deleteSelected.addEventListener("click", function () {
//
//                 // SweetAlert2 pop up --- official influencer reference: https://sweetalert2.github.io/
//                 Swal.fire({
//                     text: are_you_sure_you_want_to_delete_selected,
//                     icon: "warning",
//                     showCancelButton: true,
//                     buttonsStyling: false,
//                     showLoaderOnConfirm: true,
//                     confirmButtonText: yes_delete,
//                     cancelButtonText: no_cancel,
//                     customClass: {
//                         confirmButton: "btn fw-bold btn-danger",
//                         cancelButton: "btn fw-bold btn-active-light-primary",
//                     },
//                 }).then(function (result) {
//                     if (result.value) {
//                         $('input[name="item_check"]:checked').each(function (index) {
//
//                             $.ajax({
//                                 method: "POST",
//                                 headers: {
//                                     "X-CSRF-TOKEN": $(
//                                         'meta[name="csrf-token"]'
//                                     ).attr("content"),
//                                 },
//                                 url: route + "/" + this.value,
//                                 data: {
//                                     _token: csrfToken,
//                                     _method: "DELETE",
//                                     id: this.value,
//                                 },
//                             }).done(function (res) {
//
//                                 Swal.fire({
//                                     text: "Deleting " + influencerName,
//                                     icon: "info",
//                                     buttonsStyling: false,
//                                     showConfirmButton: false,
//                                     timer: 1,
//                                 })
//                                 // Remove header checked box
//                                 const headerCheckbox =
//                                     container.querySelectorAll(
//                                         '[type="checkbox"]'
//                                     )[0];
//                                 headerCheckbox.checked = false;
//
//                                 location.reload();
//                             }).fail(function (res) {
//
//                                 Swal.fire({
//                                     text: res.responseJSON.message,
//                                     icon: "error",
//                                     buttonsStyling: false,
//                                     confirmButtonText: ok_got_it,
//                                     customClass: {
//                                         confirmButton: "btn fw-bold btn-primary",
//                                     },
//                                 });
//                             });
//
//                             Swal.fire({
//                                 text: you_have_deleted_all_selected,
//                                 icon: "success",
//                                 buttonsStyling: false,
//                                 confirmButtonText: ok_got_it,
//                                 customClass: {
//                                     confirmButton: "btn fw-bold btn-primary",
//                                 },
//                             }).then(function () {
//                                 // delete row data from server and re-draw datatable
//                                 // dt.draw();
//                                 location.reload();
//
//                             });
//
//                         });
//
//                     } else if (result.dismiss === "cancel") {
//                         Swal.fire({
//                             text: was_not_deleted,
//                             icon: "error",
//                             buttonsStyling: false,
//                             confirmButtonText: ok_got_it,
//                             customClass: {
//                                 confirmButton: "btn fw-bold btn-primary",
//                             },
//                         });
//                     }
//                 });
//             });
//         }
//     };
//
//     // Toggle toolbars
//     var toggleToolbars = function () {
//         // Define variables
//         const container = document.querySelector("#kt_influencer_table");
//         const toolbarBase = document.querySelector(
//             '[data-kt-influencer-table-select="base"]'
//         );
//         const toolbarSelected = document.querySelector(
//             '[data-kt-influencer-table-select="selected"]'
//         );
//         const selectedCount = document.querySelector(
//             '[data-kt-influencer-table-select="selected_count"]'
//         );
//
//         // Select refreshed checkbox DOM elements
//         const allCheckboxes = container.querySelectorAll(
//             'tbody [type="checkbox"]'
//         );
//
//         // Detect checkboxes state & count
//         let checkedState = false;
//         let count = 0;
//
//         // Count checked boxes
//         allCheckboxes.forEach((c) => {
//             if (c.checked) {
//                 checkedState = true;
//                 count++;
//             }
//         });
//     };
//
//     // Public methods
//     return {
//         init: function () {
//             // initDatatable();
//             handleSearchDatatable();
//             initToggleToolbar();
//             handleFilterDatatable();
//             handleDeleteRows();
//             handleResetForm();
//         },
//     };
// })();
//
// // On document ready
// KTUtil.onDOMContentLoaded(function () {
//     KTDatatablesServerSide.init();
// });


var toggleActive = function (id) {

    $.ajax({
        type: "POST",
        dataType: "json",
        url: toggleActiveRoute,
        headers: {
            "X-CSRF-TOKEN": $(
                'meta[name="csrf-token"]'
            ).attr("content"),
        },
        data: {
            _token: csrfToken,
            'id': id
        },
        success: function (data) {
            $('#card-'+id).hide();
            var labelItem = $('#active-label-' + id)
            var label = data.status == 'true' ? activeText : inactiveText;
            labelItem.html(label);

            if (data.status == 'true') {
                $('.activeBadge-' + id).removeClass('badge-danger');
                $('.activeBadge-' + id).addClass('badge-success');
                $('.activeBadge-' + id).html(label);

                $('.activeInput-' + id).prop("checked", true)

                var innerData = 'Deactivate' + `
                    <i class="fas fa-toggle-off text-primary ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-kt-initialized="1"></i>
                `;
                $('.activeBtn-' + id).html(innerData)
            } else {
                $('.activeBadge-' + id).addClass('badge-danger');
                $('.activeBadge-' + id).removeClass('badge-success');
                $('.activeBadge-' + id).html(label);
                $('.activeInput-' + id).prop("checked", false)

                var innerData = 'Activate' + `
                    <i class="fas fa-toggle-on text-primary ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-kt-initialized="1"></i>
                `;
                $('.activeBtn-' + id).html(innerData)
            }
        }
    });
}
;

var toggleAnswer = function (id) {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: toggleAnswerRoute,
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content"),
            },
            data: {
                _token: csrfToken,
                'id': id
            },
            success: function (data) {
                var labelItem = $('#active-label-' + id)
                var label = data.status == 'true' ? answerText : notAnswerText;
                labelItem.html(label);

                if (data.status == 'true') {
                    $('.activeBadge-' + id).removeClass('badge-danger');
                    $('.activeBadge-' + id).addClass('badge-success');
                    $('.activeBadge-' + id).html(label);

                    $('.answerInput-' + id).prop("checked", true)

                    var innerData = 'Deactivate' + `
                    <i class="fas fa-toggle-off text-primary ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-kt-initialized="1"></i>
                `;
                    $('.activeBtn-' + id).html(innerData)
                } else {
                    $('.activeBadge-' + id).addClass('badge-danger');
                    $('.activeBadge-' + id).removeClass('badge-success');
                    $('.activeBadge-' + id).html(label);
                $('.activeInput-' + id).prop("checked", false)

                    var innerData = 'Activate' + `
                    <i class="fas fa-toggle-on text-primary ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-kt-initialized="1"></i>
                `;
                    $('.activeBtn-' + id).html(innerData)
                }
            }
        });
    }
;
