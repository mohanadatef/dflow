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
        dt = $("#kt_users_table").DataTable({
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
                url: routeAll,
            },
            columns: [
                {data: null},
                {data: "name"},
                {data: "email"},
                {data: null},
                {data: null},
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="item_check" value="${data.id}" />
                            </div>`;
                    },
                },
                {
                    targets: 3,
                    orderable: false,
                    render: function (data) {
                        return data.role ? data.role.role.name : "";
                    },
                },
                {
                    targets: 4,
                    orderable: false,
                    render: function (data) {
                        return data.today_records !=null ? data.today_records.length : 0;
                    },
                },
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (data, type, row) {
                        return `<span class="badge badge-success" >online</span>`;
                    },
                },

            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row)
                    .find("td:eq(4)")
                    .attr("data-filter", data.CreditCardType);
            },
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on("draw", function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            KTMenu.createInstances();
        });
    };

    // Search Datatable --- official users reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector(
            '[data-kt-users-table-filter="search"]'
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
            '[data-kt-users-table-filter="group"] [name="group"]'
        );
        const filterButton = document.querySelector(
            '[data-kt-users-table-filter="filter"]'
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

                // Filter datatable --- official users reference: https://datatables.net/reference/api/search()
                dt.search(paymentValue).draw();
            });
        }
    };

    // Delete customer
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll(
            '[data-kt-users-table-filter="delete_row"]'
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

                    // SweetAlert2 pop up --- official users reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text:
                            "Are you sure you want to delete " +
                            customerName +
                            "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
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
                                            "You have deleted " +
                                            customerName +
                                            "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton:
                                                "btn fw-bold btn-primary",
                                        },
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });
                                })
                                .fail(function (res) {
                                    Swal.fire({
                                        text:
                                            customerName + " was not deleted.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton:
                                                "btn fw-bold btn-primary",
                                        },
                                    });
                                });
                        } else if (result.dismiss === "cancel") {
                            Swal.fire({
                                text: customerName + " was not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
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
            '[data-kt-users-table-filter="reset"]'
        );
        if (resetButton) {
            // Reset datatable
            resetButton.addEventListener("click", function () {
                // Reset payment type
                filterPayment[0].checked = true;

                // Reset datatable --- official users reference: https://datatables.net/reference/api/search()
                dt.search("").draw();
            });
        }
    };

    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector("#kt_users_table");
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

                // SweetAlert2 pop up --- official users reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete selected users?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        $('input[name="item_check"]:checked').each(function (index) {

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
                                    text: "Deleting " + customerName,
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
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    },
                                });
                            });

                            Swal.fire({
                                text: "You have deleted all selected users!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                // delete row data from server and re-draw datatable
                                dt.draw();
                            });

                        });

                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: "Selected users was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
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
        const container = document.querySelector("#kt_users_table");
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
    setInterval(function() {
        dt.draw();
    },50000);
    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleFilterDatatable();
            handleDeleteRows();
            handleResetForm();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

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
            var labelItem = $('#active-label-' + id)
            var label = data.status == 'true' ? 'Active' : 'Inactive';
            labelItem.html(label);
        }
    });
}

;