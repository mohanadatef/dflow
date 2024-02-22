@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('company'))
@push('styles')
    <style>
        .dropdown-content {
            position: absolute;
        }
    </style>
@endpush
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
                    <input type="text" id="search-input" data-kt-company-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" autocomplete="off"
                           placeholder="{{getCustomTranslation('search_company_name')}}"
                           value="{{$request->name??""}}" disabled
                    />
                </div>
                <div class="d-flex align-items-center position-relative my-1" style="padding-left: 5px">
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
                    <input type="text" id="link-input" data-kt-company-table-filter="link"
                           class="form-control form-control-solid w-250px ps-15" autocomplete="off"
                           placeholder="{{getCustomTranslation('search_company_link')}}"
                           value="{{$request->link??""}}" disabled
                    />
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
                <form method="GET" id="filterDataForm" action="{{route('company.index')}}"
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

                        <input type="hidden" name="name" id="name" value="{{request('name')}}"/>

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('industries')}}:</label>
                            <select name="industry" id="industry_id" class="form-select form-select-solid fw-bold"
                                    data-kt-select2="false" data-placeholder="{{getCustomTranslation('select_option')}}" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="false">

                                <option value="{{request('industry')}}" selected>{{request('industry_name')}}</option>
                            </select>
                        </div>
                        <!--end::Input group-->

                        <input type="hidden" name="industry_name" id="industry_name"
                               value="{{request('industry_name')}}"/>


                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <a href="{{route('company.index')}}" id="reset_filter"
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
                @can('export_companies')
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
                @endcan
                @canany('merge_companies','merge_template_companies')
                    <div class="dropdown">
                        <button onclick="merge()" class="dropbtn btn btn-primary me-3">{{getCustomTranslation('merge')}}</button>
                        <div id="myDropdown"
                             class="dropdown-content menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4">
                            @can('merge_companies')
                            <div class="menu-item px-3">
                                <a href="{{ route('company.merge.info') }}" class="menu-link px-3"
                                   data-kt-export="excel">
                                    {{getCustomTranslation('merge_company')}}
                                </a>
                            </div>
                            @endcan
                            @can('merge_template_companies')
                            <div class="menu-item px-3">
                                <a href="{{ route('company_merge_template.import-view') }}" class="menu-link px-3"
                                   data-kt-export="excel">
                                       {{getCustomTranslation('merge_company_by_template')}}
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                @endcanany
                <!--end::Filter-->
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-company-table-select="base">
                    @can('create_companies')
                    <!--begin::Add company-->
                    <a href="{{ route('company.create') }}" class="btn btn-primary">{{getCustomTranslation('add')}} {{getCustomTranslation('company')}}</a>
                    <!--end::Add company-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-company-table-select="selected">
                    <div class="fw-bold me-5">
                        @can('delete_companies')
                        {{-- <span class="me-2" data-kt-company-table-select="selected_count"></span>Selected</div> --}}
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-company-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
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
            @include('acl::company.table')
        </div>


    <!--end::Products-->
    </div>
@endsection
@push('scripts')
    <script>
        let route = "{{ route('company.index') }}";
        let routeAll = "{{ route('company.index',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
        let toggleActiveRoute = "{{ route('company.toggleActive') }}";
        let categoryListSearchRoute = "{{route('category.list_search') }}";

        $('#industry_id').select2({
            // dropdownParent: $("#exampleModal"),
            // delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_industry')}}...",
            ajax: {
                cacheDataSource: [],
                url: categoryListSearchRoute,
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_'+"{{$lang}}"],
                            }
                        }),
                    };
                },
            },
        });
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/company/list.js?v=1"></script>
    <script>
        //data-kt-company-table-filter
        function handleDeleteRows() {

            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-company-table-filter="delete_row"]'
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
        var input = $('#search-input');
        var inputLink = $('#link-input');

        //on keyup, start the countdown
        input.on('keyup', function () {
            doneTyping();
        });
        inputLink.on('keyup', function () {
            doneTyping();
        });
        //user is "finished typing," do something
        function doneTyping() {
            let val = $("#search-input").val();
            let valLink = $("#link-input").val();
            var routeAll =
                "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" +
                $("#filterDataForm").serialize();
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            $.get({
                url: routeAll,
                data: {
                    name: val,
                    link: valLink,
                },
                success: function (data) {
                    jQuery(document).ready(function () {
                        $('#data-table').html(data);
                        KTMenu.createInstances();
                        handleDeleteRows();
                    });
                },
            });
        }

        $(document).on('change', '#limit', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();

            var searchVal = $("#search-input").val().trim();
            var linkVal = $("#link-input").val().trim();
            var url = route + "?perPage=" + limit + "&search=" + searchVal + "&link=" + linkVal + "&" + $("#filterDataForm").serialize();


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

        $("#industry_id").on("select2:select", function () {
            let name = $('#industry_id :selected').text(); //for getting text from selected option
            $("#industry_name").val(name);
        });

        $(".filterDataForm").on("click", function (e) {
            e.preventDefault();
            let val = $("#search-input").val();
            let valLink = $("#link-input").val();
            var routeAll =
                "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" +
                $("#filterDataForm").serialize();
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            $('#filterDataForm').removeClass('show');
            $.get({
                url: routeAll,
                data: {
                    name: val,
                    link: valLink,
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
            $('#industry_id').val('').trigger('change');
            window.location = route;
        });
        $('#search-input').prop("disabled", false); // Element(s) are now enabled.
        $('#link-input').prop("disabled", false); // Element(s) are now enabled.
        function exportData(lang) {
            var params = {
                lang: lang,
                industry: $('#industry_id').val(),
                name: $('#search-input').val(),
                link: $('#link-input').val(),
            };
            location.href = "{{ route('company.export' )}}?" + jQuery.param(params);
        }

        /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
        function merge() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

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
    </script>
@endpush
