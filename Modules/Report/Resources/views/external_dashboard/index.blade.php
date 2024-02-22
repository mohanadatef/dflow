@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('external_dashboards'))
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
                    <input id="search" type="text"
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search_external_dashboard')}}"
                           value="{{request('name')}}"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Filter-->
                <button type="button" class="btn btn-primary me-3 dropdown-toggle" id="dropdownMenuClickable"
                        data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->{{getCustomTranslation('filter')}}
                </button>
                <!--begin::Menu 1-->
                <form method="GET" id="filterDataForm" action="{{route('external_dashboard.index')}}"
                      class="dropdown-menu w-300px w-md-325px" data-kt-menu="true"
                      aria-labelledby="dropdownMenuClickable">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">{{getCustomTranslation('filter')}}</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Content-->
                    <div class="px-7 py-5" data-kt-user-table-filter="form">

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('category')}}:</label>
                            <select name="category[]" multiple="multiple" id="category"
                                    class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="{{getCustomTranslation('select_option')}}" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="false">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                            @if(in_array($category->id , request('category') ?: [])) selected @endif>{{$category->{'name_'.$lang} }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('company')}}:</label>
                            <!--begin::Input-->
                            <select id="company" name="company[]"
                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                    data-mce-placeholder="" multiple>
                            </select>
                        </div>

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <a href="{{route('external_dashboard.index')}}" id="reset_filter"
                               class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                               data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                            </a>
                            <!-- <button type="reset" id="reset_filter" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}</button> -->
                            <button type="button" class="btn btn-primary fw-semibold px-6 filterDataForm"
                                    data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </form>
                <!--end::Filter-->
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-external-dashboard-table-select="base">
                    @can('create_external_dashboard')
                        <!--begin::Add company-->
                        <a href="{{ route('external_dashboard.create') }}" class="btn btn-primary">{{getCustomTranslation('create_external_dashboard')}}</a>
                        <!--end::Add company-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-external-dashboard-table-select="selected">
                    <div class="fw-bold me-5">
                        @can('delete_external_dashboard')
                            {{-- <span class="me-2" data-kt-external-dashboard-table-select="selected_count"></span>Selected</div> --}}
                            <button type="button" class="btn btn-danger ms-1 "
                                    data-kt-external-dashboard-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
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
        <div class="card-body pt-0" id="data-table">
            @include('report::external_dashboard.table')
        </div>


        <!--end::Products-->
    </div>
@endsection
@push('scripts')
    <script>
        let route = "{{ route('external_dashboard.index') }}";
        let routeAll = "{{ route('external_dashboard.index',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
        let toggleActiveRoute = "{{ route('external_dashboard.toggleActive') }}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/external_dashboard/list.js"></script>

    <script>
        //data-kt-external-dashboard-table-filter
        function handleDeleteRows() {

            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-external-dashboard-table-filter="delete_row"]'
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

                        // SweetAlert2 pop up --- official ad_record reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text:
                                are_you_sure_you_want_to_delete +
                                customerId +
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
                                                customerId +
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
                                                customerId + was_not_deleted,
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
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
        var limit = "{{Request::get('perPage') ?? $datas->perPage()}}";
        var input = $('#search');

        //on keyup, start the countdown
        input.on('keyup', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            var searchVal = $("#search").val();
            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "name=" + searchVal + "&" + "perPage=" + limit + "&" + $("#filterDataForm").serialize();


            $.get({
                url: full,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {

                    $('#data-table').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        });
        //user is "finished typing," do something

        $(document).on('change', '#limit', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();

            var searchVal = $("#search").val().trim();
            var url = route + "?perPage=" + limit + "&name=" + searchVal  + "&" + $("#filterDataForm").serialize();


            $.get({
                url: url,
                success: function (data) {
                    jQuery(document).ready(function () {
                        $('#data-table').html(data);
                        KTMenu.createInstances();
                        handleDeleteRows();
                    });
                },
            });
        });


        $(".filterDataForm").on("click", function (e) {
            e.preventDefault();
            let val = $("#search").val();
            var routeAll =
                "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" +
                $("#filterDataForm").serialize();
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            $('#filterDataForm').removeClass('show');
            $.get({
                url: routeAll,
                data: {
                    name: val,
                },
                success: function (data) {
                    jQuery(document).ready(function () {
                        $('#data-table').html(data);
                        KTMenu.createInstances();
                        handleDeleteRows();
                    });
                },
            });
        });


        $('#reset_filter').on('click', function () {
            $('#category_id').val('').trigger('change');
            $('#company').val('');
            window.location = route;
        });

     /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */

        // Close the dropdown if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
        function template(data) {
            if ($(data.html).length === 0) {
                return data.text;
            }
            return $(data.html);
        }
        let search_company_url = "{{ route('reports.search_companies') }}";
        $('#company').select2({
            minimumInputLength: 1,
            delay: 900,
            placeholder: "{{getCustomTranslation('select_a_company')}}...",
            ajax: {
                cacheDataSource: [],
                url: search_company_url,
                method: 'POST',
                dataType: 'json',
                delay: 900,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                },

            }, templateResult: template,
            templateSelection: template, language: {
                "noResults": function () {
                    return "{{getCustomTranslation('no_results_found')}} <br> " +
                        '<button   style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;" onclick="openCreateCompany()" class="select2-link">{{getCustomTranslation('add_new_company')}}</button>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    </script>
@endpush
