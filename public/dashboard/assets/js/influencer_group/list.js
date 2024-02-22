$(document).on('change', '#limit', function () {
    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">'+loadingText+'...</span></div></div>');
    limit = $(this).val();
    var searchVal = $("#search").val();
    var fullSearchLink = route + "?perPage=" + limit + "&search=" + searchVal;
    $.get({
        url: fullSearchLink,
        data: {
            "searchVal": $("#search").val()
        },
        success: function (data) {

            $('#data-table').html(data);
            KTMenu.createInstances();
            handleDeleteRows();
        }
    });
});
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
        dt = $("#kt_users_table").DataTable(/*{
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
                { data: null },
                { data: null },
                { data: "name_en" },
                { data: null },
                { data: null },
                { data: null },
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
                    targets: 1,
                    orderable: false,
                    render: function (data) {
                        if(data.iconUrl)
                        {
                            return `
                            <div class="symbol symbol-40px me-4">
                            <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">
                                <img src="${data.iconUrl}" style="width: 100px;height: 100px">
                            </div>
                        </div>`;
                        }else{
                        return `
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">${data.name_en[0]}</div>
                        </div>`;
                        }
                    },
                },
                {
                    targets: 3,
                    data: null,
                    orderable: false,
                    className: "",
                    render: function (data, type, row) {
                        var industries = []
                        data.industry.forEach(element => {
                            industries.push(element.name_en)
                        });
                        return `<div class="symbol symbol-40px me-4" style="text-align:left !important">
                            ${industries}
                        </div>`;
                    },
                },

                {
                    targets: 4,
                    data: null,
                    orderable: false,
                    className: "text-end",
                    render: function (data, type, row) {
                        var label = data.active ? activeText : inactiveText;
                        var checked = data.active ? 'checked' : '';
                        var activeBtn = `<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" >
                        <input class="form-check-input" type="checkbox" value="" name="notifications" ` + checked +` onclick="toggleActive(`+ data.id +`)">
                        <label class="form-check-label" id="active-label-`+ data.id+`">` + label + `</label>
                    </div>`;

                        return (
                            activeBtn
                        );
                    },
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: "text-end",
                    render: function (data, type, row) {
                        var deletePermissio =   deletePermission  ? `<a href="#" data-kt-users-table-filter="delete_row" class="menu-link px-3">Delete</a>` : "";
                        var updatePermissio =   updatePermission  ? `<a href="` +route +`/` +data.id + `/edit" class="menu-link px-3">Edit</a>` : "";
                        return (
                            `
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon--></a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                 `+ updatePermissio +`
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                              `+ deletePermissio +`
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        `
                        );
                    },
                },
            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row)
                    .find("td:eq(4)")
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
        }*/);

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
    // var handleSearchDatatable = function () {
    //     const filterSearch = document.querySelector(
    //         '[data-kt-users-table-filter="search"]'
    //     );
    //     if (filterSearch) {
    //         filterSearch.addEventListener("keyup", function (e) {
    //             dt = $("#kt_users_table").DataTable();
    //             dt.search(e.target.value).draw();
    //
    //         });
    //     }
    // };

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

    // Delete users
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

                    // Get users name
                    const usersName = parent.querySelectorAll("td")[1].innerText;
                    const usersId = parent.querySelectorAll("td div input")[0].value;

                    // SweetAlert2 pop up --- official users reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text:
                            are_you_sure_you_want_to_delete +
                            usersName +
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
                                url: route + "/" + usersId,
                                data: {
                                    _token: csrfToken,
                                    _method: "DELETE",
                                    id: usersId,
                                },
                            })
                                .done(function (res) {
                                    // Simulate delete request -- for demo purpose only
                                    Swal.fire({
                                        text:
                                            you_have_deleted +
                                            usersName +
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
                                        location.reload();
                                    });
                                })
                                .fail(function (res) {
                                    Swal.fire({
                                        text:
                                            usersName + was_not_deleted,
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
                                text: usersName + was_not_deleted,
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
            '[data-kt-users-table-select="delete_selected"]'
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
                                    text: "Deleting " + usersName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 1,
                                })
                                // Remove header checked box
                                const headerCheckbox =
                                    container.querySelectorAll(
                                        '[name="item_check"]'
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
                                location.reload();
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
        const container = document.querySelector("#kt_users_table");
        const toolbarBase = document.querySelector(
            '[data-kt-users-table-select="base"]'
        );
        const toolbarSelected = document.querySelector(
            '[data-kt-users-table-select="selected"]'
        );
        const selectedCount = document.querySelector(
            '[data-kt-users-table-select="selected_count"]'
        );

        // Select refreshed checkbox DOM elements
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
            /*initDatatable();*/
            //handleSearchDatatable();
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
                var label = data.status == 'true' ? activeText : inactiveText;
                labelItem.html(label);
            }
        });
    }
;


input.on('keyup', function () {

    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">'+loadingText+'...</span></div></div>');


    let searchVal = "?search=" + $("#search").val();

    var fullSearchLink = route + searchVal;

    $.get({
        url: fullSearchLink,
        success: function (data) {

            $('#data-table').html(data);
            KTMenu.createInstances();
            handleDeleteRows();
        }
    });


});

//on keyup, start the countdown


function exportData(lang) {
    var params = {
        lang: lang,
    };
    location.href = userExport + "?" + jQuery.param(params);
}