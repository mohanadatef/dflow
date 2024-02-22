"use strict";

// Class definition
var KTDatatablesServerSide = (function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;
    var datatable;
    var toolbarBase;
    var toolbarSelected;
    var selectedCount;


    // Private functions
    var initDatatable = function () {
        dt = $("#kt_customers_table").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            select: {
                style: "multi",
                selector: 'td:first-child input[type="checkbox"]',
                className: "row-selected",
            },
            ajax: {
                url: route,
            },
            columns: [
                {data: null},
                {data: null},
                {data: null},
                {data: null},
                 {data: null},
                {data: null},
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        return data.influencer_follower_platform ? data.influencer_follower_platform.influencer.name_en : "";
                    },
                },
                {
                    targets: 1,
                    orderable: false,
                    render: function (data) {
                        return data.influencer_follower_platform ? data.influencer_follower_platform.platform.name_en : "";
                    },
                },
                {
                    targets: 2,
                    orderable: false,
                    render: function (data) {
                        return data.type ? "add" : "remove";
                    },
                },
                {
                    targets: 3,
                    orderable: false,
                    render: function (data) {
                        return new Date(data.created_at).toDateString();

                    },
                },
       
                {
                    targets: 4,
                    data: null,
                    orderable: false,
                    render: function (data) {
                        return data.user ? data.user.name : "";
                    },
                },

            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row)
                    .find("td:eq(3)")
                    .attr("data-filter", data.CreditCardType);
            },"language": {
                "info": ShowingText+" _START_ "+toText+" _END_ "+ofText+" _TOTAL_ "+recordsText,
                "infoEmpty": showing_no_records,
                "lengthMenu": "_MENU_",
                "paginate": {
                    "first": '<i class="first"></i>',
                    "last": '<i class="last"></i>',
                    "next": '<i class="next"></i>',
                    "previous": '<i class="previous"></i>'
                }
            }
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on("draw", function () {
            initToggleToolbar();
            toggleToolbars();
           // handleDeleteRows();
            KTMenu.createInstances();
        });
    };

    // Search Datatable --- official influencer_group reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector(
            '[data-kt-influencer_group-table-filter="search"]'

        );
        if (filterSearch) {
            filterSearch.addEventListener("keyup", function (e) {
                dt.search(e.target.value).draw();
            });
        }
    };

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        filterPayment = document.querySelectorAll(
            '[data-kt-influencer_group-table-filter="group"] [name="group"]'
        );
        const filterButton = document.querySelector(
            '[data-kt-influencer_group-table-filter="filter"]'

        );

        if (filterButton) {
            // Filter datatable on submit
            filterButton.addEventListener("click", function () {
                // Get filter values
                let paymentValue = "";

                // Get payment value
                filterPayment.forEach((r) => {
                    if (r.checked) {
                        paymentValue = r.value;
                    }

                    // Reset payment value if "All" is selected
                    if (paymentValue === "all") {
                        paymentValue = "";
                    }
                });

                // Filter datatable --- official influencer_group reference: https://datatables.net/reference/api/search()
                dt.search(paymentValue).draw();
            });
        }
    };

    // Delete customer
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll(
            '[data-kt-influencer_group-table-filter="delete_row"]'

        );
        if (deleteButtons) {
           
            deleteButtons.forEach((d) => {

                // Delete button on click
                d.addEventListener("click", function (e) {
                    e.preventDefault();

                    // Select parent row
                    const parent = e.target.closest("tr");

                    // Get customer name
                    const customerName = parent.querySelectorAll("td")[1].innerText;
                    const customerId = parent.querySelectorAll("td div input")[0].value;

                    // SweetAlert2 pop up --- official influencer_group reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text:
                            are_you_sure_you_want_to_delete +
                            customerName +
                            "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: yes_delete,
                        cancelButtonText: no_cancel,
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (result) {
                        if (result.value) {
                            $.ajax({
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content"),
                                },
                                url: route + "/" + customerId,
                                data: {
                                    _token: csrfToken,
                                    _method: "DELETE",
                                    id: customerId,
                                },
                            })
                                .done(function (res) {
                                    // Simulate delete request -- for demo purpose only
                                    Swal.fire({
                                        text:
                                            you_have_deleted +
                                            customerName +
                                            "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: ok_got_it,
                                        customClass: {
                                            confirmButton:
                                                "btn fw-bold btn-primary",
                                        },
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                      $("#remove"+customerId).remove();

                                     //   dt.draw();

                                    });
                                })
                                .fail(function (res) {
                                    Swal.fire({
                                        text:
                                            customerName + was_not_deleted,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: ok_got_it,
                                        customClass: {
                                            confirmButton:
                                                "btn fw-bold btn-primary",
                                        },
                                    });
                                });
                        } else if (result.dismiss === "cancel") {
                            Swal.fire({
                                text: customerName + was_not_deleted,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            });
                        }
                    });
                });
            });
        }
    };

    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector(
            '[data-kt-influencer_group-table-filter="reset"]'
        );
        if (resetButton) {
            // Reset datatable
            resetButton.addEventListener("click", function () {
                // Reset payment type
                filterPayment[0].checked = true;

                // Reset datatable --- official influencer_group reference: https://datatables.net/reference/api/search()
                dt.search("").draw();
            });
        }
    };

    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector("#kt_customers_table");

        const checkboxes = container.querySelectorAll('[type="checkbox"]');


        // Select elements
        const deleteSelected = document.querySelector(
            '[data-kt-customer-table-select="delete_selected"]'
        );

        // Toggle delete selected toolbar
        checkboxes.forEach((c) => {
            // Checkbox on click event
            c.addEventListener("click", function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });
        if (deleteSelected) {
            // Deleted selected rows
            deleteSelected.addEventListener("click", function () {

                // SweetAlert2 pop up --- official influencer_group reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: are_you_sure_you_want_to_delete_selected,
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: yes_delete,
                    cancelButtonText: no_cancel,
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        $('input[name="item_check"]:checked').each(function (index) {
                         
                            $("#remove"+this.value).remove();
                            $.ajax({
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content"),
                                },
                                url: route + "/" + this.value,
                                data: {
                                    _token: csrfToken,
                                    _method: "DELETE",
                                    id: this.value,
                                },
                            }).done(function (res) {

                                Swal.fire({
                                    text: "Deleting ",
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 1,
                                })
                                // Remove header checked box
                                const headerCheckbox =
                                    container.querySelectorAll(
                                        '[type="checkbox"]'
                                    )[0];
                                headerCheckbox.checked = false;
                            }).fail(function (res) {

                                Swal.fire({
                                    text: res.responseJSON.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: ok_got_it,
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    },
                                });
                            });

                            Swal.fire({
                                text: you_have_deleted_all_selected,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                // delete row data from server and re-draw datatable
                                $("#remove"+this.value).remove();
                            });

                        });

                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: was_not_deleted,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: ok_got_it,
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        });
                    }
                });
            });
        }
    };

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector("#kt_customers_table");

        const toolbarBase = document.querySelector(
            '[data-kt-customer-table-select="base"]'
        );
        const toolbarSelected = document.querySelector(
            '[data-kt-customer-table-select="selected"]'
        );
        const selectedCount = document.querySelector(
            '[data-kt-customer-table-select="selected_count"]'
        );

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll(
            'tbody [type="checkbox"]'
        );

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach((c) => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });
    };

    // Public methods
    return {
        init: function () {
           // initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleFilterDatatable();
           // handleDeleteRows();
            handleResetForm();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
