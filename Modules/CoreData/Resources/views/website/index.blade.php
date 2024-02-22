@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('links'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                      transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                    <input type="text"
                           id="search"
                           data-kt-website-table-filter="search" class="form-control form-control-solid w-250px ps-15"
                           placeholder="{{getCustomTranslation('search_link')}}"
                           value="{{ request()->search }}"
                    />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-website-table-select="base">
                    @can('create_websites')
                    <!--begin::Add customer-->
                    <a href="{{ route('website.create') }}" class="btn btn-primary">{{getCustomTranslation('add')}} {{getCustomTranslation('link')}} </a>
                    <!--end::Add customer-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-website-table-select="selected">
                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div> --}}
                        @can('delete_websites')
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-website-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->

        </div>
        <div class="card-body pt-0" id="data">
            <!--begin::Table-->
            @include('coredata::website.table')
        </div><!--end::Datatable-->
    </div><!--end::Products-->
@endsection
@push('scripts')
    <script>
        let route = "{{ route('website.index') }}";
        let request_params_string = "";
        request_params = @json(Request()->all());
        for (let key in request_params) {
            if (request_params.hasOwnProperty(key)) {
                if (request_params[key] instanceof Array) {
                    for (let i in request_params[key]) {
                        request_params_string += key + "[]=" + request_params[key][i] + "&";
                    }
                } else {
                    request_params_string += key + "[]=" + request_params[key] + "&";
                }
            }
        }
        request_params_string = request_params_string.trim().replace(/\&$/, '');
        let routeAll = "{{ route('website.index') }}?" + request_params_string;
        let csrfToken = "{{ csrf_token() }}";
        let toggleActiveRoute = "{{ route('website.toggleActive') }}";

    </script>
    <script src="{{ asset('dashboard') }}/assets/js/website/list.js?v=12"></script>
    <script>
        $('#reset_filter').on('click', function () {
            window.location = route;
        })

        $(document).ready(function () {
            $('#searchSelect').select2({
                placeholder: 'All',
                minimumInputLength: 0
            });
        });
    </script>


    <script>
        function handleDeleteRows() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-website-table-filter="delete_row"]'
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

                        // SweetAlert2 pop up --- official customer reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: are_you_sure_you_want_to_delete +
                                customerId +
                                "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: yes_delete,
                            cancelButtonText: no_cancel,
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary",
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
                                            text: you_have_deleted +
                                                customerId +
                                                "!.",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: ok_got_it,
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            },
                                        }).then(function () {
                                            // delete row data from server and re-draw datatable
                                            loadTableData();
                                        });
                                    })
                                    .fail(function (res) {
                                        Swal.fire({
                                            text: customerId + was_not_deleted,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: ok_got_it,
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            },
                                        });
                                    });
                            } else if (result.dismiss === "cancel") {
                                Swal.fire({
                                    text: customerId + was_not_deleted,
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

        //setup before functions
        var typingTimer; //timer identifier
        var doneTypingInterval = 1000; //time in ms, 5 seconds for example
        var input = $('#search');

        //on keyup, start the countdown
        input.on('keyup', function () {
            loadTableData()
        });
        $(".filterDataForm").on("click", function (e) {
            loadTableData();
        });


        function loadTableData() {
            $('#filterDataForm').removeClass('show');
            $.get({
                url: routeAll,
                data: {
                    "group": $('#searchSelect').val(),
                    "search": $("#search").val()
                },
                success: function (data) {

                    $('#data').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        }

        handleDeleteRows();
    </script>

@endpush
