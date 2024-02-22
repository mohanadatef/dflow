handleDeleteRows()

function handleDeleteRows() {
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
                                    $("#remove" + usersId).remove();
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
}

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


//on keyup, start the countdown


function exportData(lang) {
    var params = {
        lang: lang,
    };
    location.href = userExport+"?" + jQuery.param(params);
}