@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('external_user'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                      transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"/>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                    <input type="text" id="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search')}}{{getCustomTranslation('external_user')}}"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                @can('export_clients')
                <button type="button" class="btn btn-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                              transform="rotate(90 12.75 4.25)" fill="currentColor"/>
                        <path
                                d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                fill="currentColor"/>
                        <path opacity="0.3"
                              d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                              fill="currentColor"/>
                    </svg>
                </span>
          {{getCustomTranslation('export')}}
                </button>
                @endcan
                <div id="kt_datatable_example_export_menu"
                     class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                     data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="copy" onclick="exportData('en')">
                            English
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="excel" onclick="exportData('ar')">
                            العربية
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <div class="d-flex justify-content-end" data-kt-clients-table-select="base">
                    @can('create_clients')
                    <!--begin::Add clients-->
                    <a href="{{ route('client.create') }}" class="btn btn-primary">{{getCustomTranslation('add')}}
                        {{getCustomTranslation('external_user')}}</a>
                    <!--end::Add clients-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-clients-table-select="selected">
                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-clients-table-select="selected_count"></span>Selected</div> --}}
                        @can('delete_clients')
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-clients-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="data-table" style="width: 100%">
                @include('acl::clients.table')
            </div>
            <!--end::Datatable-->
        </div>
        <!--end::Products-->
        @endsection
        @push('scripts')
            <script>
                var routeAll = "{{ route('client.index',Request()->all()) }}";
                var route = "{{ route('client.index') }}";
                var toggleActiveRoute = "{{ route('client.toggleActive') }}";
                var csrfToken = "{{ csrf_token() }}";
                var deletePermission = {{permissionShow('delete_clients') ? 1 : 0}};
                var updatePermission = {{permissionShow('update_clients') ? 1 : 0}};
                var showPermission = {{permissionShow('view_clients') ? 1 : 0}};
                var passwordPermission = {{permissionShow('change_password_users') ? 1 : 0}};

                handleDeleteRows();

                function handleDeleteRows() {
                    // Select all delete buttons
                    const deleteButtons = document.querySelectorAll(
                        '[data-kt-clients-table-filter="delete_row"]'
                    );
                    if (deleteButtons) {

                        deleteButtons.forEach((d) => {

                            // Delete button on click
                            d.addEventListener("click", function (e) {
                                e.preventDefault();

                                // Select parent row
                                const parent = e.target.closest("tr");

                                // Get clients name
                                const clientsName = parent.querySelectorAll("td")[1].innerText;
                                const clientsId = parent.querySelectorAll("td div input")[0].value;

                                // SweetAlert2 pop up --- official users reference: https://sweetalert2.github.io/
                                Swal.fire({
                                    text:
                                        are_you_sure_you_want_to_delete +
                                        clientsName +
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
                                            url: route + "/" + clientsId,
                                            data: {
                                                _token: csrfToken,
                                                _method: "DELETE",
                                                id: clientsId,
                                            },
                                        })
                                            .done(function (res) {
                                                // Simulate delete request -- for demo purpose only
                                                Swal.fire({
                                                    text:
                                                        you_have_deleted +
                                                        clientsName +
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
                                                    $("#remove" + clientsId).remove();
                                                });
                                            })
                                            .fail(function (res) {
                                                Swal.fire({
                                                    text:
                                                        clientsName + was_not_deleted,
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
                                            text: clientsName + was_not_deleted,
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


                var input = $('#search');

                //on keyup, start the countdown
                input.on('keyup', function () {

                    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

                    let searchVal = "?search=" + $("#search").val();

                    var fullSearchLink = route + searchVal;

                    $.get({
                        url: fullSearchLink,
                        data: "{{ json_encode(request()->all()) }}",
                        success: function (data) {

                            $('#data-table').html(data);
                            KTMenu.createInstances();
                            handleDeleteRows();
                        }
                    });


                });
                function exportData(lang) {
                    var params = {
                        lang: lang,
                    };
                    location.href = "{{ route('client.export' )}}?" + jQuery.param(params);
                }
            </script>
            <script src="{{ asset('dashboard') }}/assets/js/clients/list.js?v=1"></script>
    @endpush
