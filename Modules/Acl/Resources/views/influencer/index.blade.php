@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer'))

@section('content')
    <div class="container-xxl">
        <!--begin::Navbar-->
        <div class="card mb-8">
            <div class="card-body py-7">
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Title-->
                    <div class="d-flex flex-wrap align-items-center my-1">
                        <!--begin::Tab nav-->
                        <ul class="nav nav-pills me-6 mb-2 mb-sm-0" role="tablist">
                            <li class="nav-item m-0" role="presentation" onclick="changeLayout('card')">
                                <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary me-3 @if($userLogin->influencer_list == "card") active @endif"
                                   data-bs-toggle="tab" href="#kt_project_users_card_pane" aria-selected="true"
                                   role="tab" id="card_layout_button">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                    <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                         viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                        </g>
                                    </svg>
                                </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </li>
                            <li class="nav-item m-0" role="presentation" onclick="changeLayout('table')">
                                <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary @if($userLogin->influencer_list == "table") active @endif"
                                   data-bs-toggle="tab" href="#kt_project_users_table_pane" aria-selected="false"
                                   role="tab" tabindex="-1" id="table_layout_button">
                                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                                    <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                                fill="currentColor"></path>
                                        <path opacity="0.3"
                                              d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                              fill="currentColor"
                                        >
                                        </path>
                                    </svg>
                                </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </li>
                        </ul>
                        <!--end::Tab nav-->
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
                            <input type="text" id="search-input" name="search"
                                   class="form-control form-control-solid w-250px ps-15"
                                   placeholder="{{getCustomTranslation('search_influencer')}}"
                                   value="{{request('search')??""}}"
                            />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Controls-->
                    <div class="d-flex flex-wrap my-1">


                        <!--begin::Filter-->
                        {{-- <button type="button" class="btn btn-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                            <!--end::Svg Icon-->Filter
                        </button> --}}
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-primary me-3 dropdown-toggle" id="dropdownMenuClickable"
                                data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                        fill="currentColor"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->{{getCustomTranslation('filter')}}
                        </button>
                        <!--begin::Menu 1-->
                        <form method="GET" id="filterDataForm"
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
                                <input type="hidden" id="layout" name="layout" value="{{request('layout')}}"/>


                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('gender')}}
                                        :</label>
                                    <select name="gender" id="gender" class="form-select form-select-solid fw-bold"
                                            data-kt-select2="true"
                                            data-placeholder="{{getCustomTranslation('select_option')}}"
                                            data-allow-clear="true" data-kt-user-table-filter="role"
                                            data-hide-search="true">
                                        <option></option>
                                        <option value="male" {{ request('gender') == 'male' ? 'selected' : ''}}>{{getCustomTranslation('male')}}
                                        </option>
                                        <option value="female" {{request('gender') == 'female' ? 'selected' : ''}}>
                                            {{getCustomTranslation('female')}}
                                        </option>
                                        <option value="female" {{request('gender') == 'neutral' ? 'selected' : ''}}>
                                            {{getCustomTranslation('neutral')}}
                                        </option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('country')}}
                                        :</label>
                                    <select name="country_id[]" id="country_id"
                                            class="form-select form-select-solid fw-bold"
                                            data-kt-select2="true"
                                            data-placeholder="{{getCustomTranslation('select_option')}}" multiple
                                            data-allow-clear="true" data-kt-user-table-filter="role"
                                            data-hide-search="true">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}"
                                                    @if(request('country_id') && in_array($country->id,request('country_id'))) selected @endif>{{$country->{'name_'.$lang} }}</option>
                                            @endforeach
                                            </option>
                                    </select>
                                </div>
                                <input type="hidden" id="form_hidden_input" name="search" value="">
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('category')}}
                                        :</label>
                                    <select name="category[]" id="category"
                                            class="form-select form-select-solid fw-bold"
                                            data-kt-select2="true"
                                            data-placeholder="{{getCustomTranslation('select_option')}}" multiple
                                            data-allow-clear="true" data-kt-user-table-filter="role"
                                            data-hide-search="true">
                                        @foreach($category as $categ)
                                            <option value="{{$categ->id}}"
                                                    @if(request('category') && in_array($categ->id,request('category'))) selected @endif>{{$categ->{'name_'.$lang} }}</option>
                                            @endforeach
                                            </option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('power_type')}}
                                        :</label>
                                    <select name="size[]" id="size" class="form-select form-select-solid fw-bold"
                                            data-kt-select2="true"
                                            data-placeholder="{{getCustomTranslation('select_option')}}"
                                            multiple="multiple"
                                            data-allow-clear="true" data-kt-user-table-filter="role"
                                            data-hide-search="false">
                                        @foreach($size as $s)
                                            <option value="{{$s->id}}"
                                                    @if(request('size') && in_array($s->id,request('size'))) selected @endif>{{$s->{'name_'.$lang} }}</option>
                                            @endforeach
                                            </option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" id="reset_filter"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                    </button>
                                    <span class="btn btn-primary fw-semibold px-6 filterDataForm"

                                    >{{getCustomTranslation('apply')}}
                                    </span>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </form>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        @can('export_influencers')
                        <button
                                type="button"
                                class="btn btn-primary me-3" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_export_users"
                                onclick="exportData()"
                        >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
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
                            <!--end::Svg Icon-->{{getCustomTranslation('export')}}
                        </button>
                        @endcan
                        <!--end::Export-->

                        @can('create_influencers')
                        <!--begin::Add influencer-->
                        <a href="{{ route('influencer.create') }}" class="btn btn-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                      transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->{{getCustomTranslation('add')}} {{getCustomTranslation('influencer')}}
                        </a>
                        <!--end::Add influencer-->
                        @endcan

                        @can('delete_influencers')
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-influencer-table-select="delete_selected">
                            {{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan

                    </div>
                    <!--end::Controls-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>


        <!--begin::Tab Content-->
        <div class="tab-content" id="data-table">
            <!--begin::Tab pane-->
            {{-- <div id="data-table"> --}}

            @include('acl::influencer.table')


        </div>


    </div>
    <!--end::Tab Content-->



@endsection
@push('scripts')
    <script>
        var route = "{{ route('influencer.index') }}";
        var routeAll = "{{ route('influencer.index',Request()->all()) }}";
        var toggleActiveRoute = "{{ route('influencer.toggleActive') }}";
        var csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/influencer/list.js?v=1"></script>


    <script>
        $('#reset_filter').on('click', function () {
            $('#country_id').val('').trigger('change');
            $('#gender').val('').trigger('change');
            window.location = route;
        })
    </script>

    <script>

        $(document).ready(function () {
            const url = new URL(window.location.href);
            var layout = url.searchParams.get('layout')

            if (layout == 'table') {
                var el = $('#kt_project_users_table_pane');
                el.addClass('active show')
                $('#table_layout_button').addClass('active');

                var element = $('#kt_project_users_card_pane');
                element.removeClass('active show')
                $('#card_layout_button').removeClass('active');
            } else {
                var el = $('#kt_project_users_card_pane');
                el.addClass('active show')
                $('#card_layout_button').addClass('active');

                var element = $('#kt_project_users_table_pane');
                element.removeClass('active show')
                $('#table_layout_button').removeClass('active');

            }

            if (!layout) {

                var layout = @json(auth()->user()->influencer_list);

                if (layout == 'table') {

                    var el = $('#kt_project_users_table_pane');
                    el.addClass('active show')
                    $('#table_layout_button').addClass('active')

                    var element = $('#kt_project_users_card_pane');
                    element.removeClass('active show')
                    $('#card_layout_button').removeClass('active')
                }
            }
        });

        $(".page-link").on("click", function (e) {
            // e.preventDefault();
            var pageUrl = $(this).attr("href");
            var url = new URL(pageUrl);
            var params = new URLSearchParams();
            url.search = params.toString();
            url.searchParams.forEach(function (value, key) {
                if (key !== 'page') {
                    params.append(key, value); // Add non-'page' parameters to the new URL
                }
            });
            var fullUrl = url.toString() + '&' + filterValues;
            loadTableData(fullUrl);
        });


        function changeLayout(name) {
            let hasAlready = false;
            const url = new URL(window.location.href);
            if (url.searchParams.get('layout')) {
                hasAlready = true
            }


            url.searchParams.set('layout', name);

            if (hasAlready) {
                $(".page-link").attr('href', function (i, a) {
                    return a.replace(/(layout=)[a-z]+/ig, '$1' + name);
                });
            } else {
                $(".page-link").attr('href', function (i, h) {
                    return h + (h.indexOf('?') != -1 ? "&layout=" + name : "?layout=" + name);
                });
            }

            updateUserLayout(name);

            // url.searchParams.delete('param2');
            window.history.replaceState(null, null, url);
        }

        function updateUserLayout(name) {
            url = '{{ route("user.update_user_layout") }}';
            $.ajax({
                type: "POST",
                url: url,
                data: {'name': name},
            });
        }
    </script>

    <script>
        // Delete influencer
        // Delete influencer
        function handleDeleteRows() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-influencer-table-filter="delete_row"]'
            );
            if (deleteButtons) {
                deleteButtons.forEach((d) => {

                    // Delete button on click
                    d.addEventListener("click", function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest("tr");

                        // Get influencer name
                        const influencerName = parent.querySelectorAll("td")[2].innerText;
                        const influencerId = parent.querySelectorAll("td div input")[0].value;

                        // SweetAlert2 pop up --- official influencer reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text:
                                are_you_sure_you_want_to_delete +
                                influencerName +
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
                                    url: route + "/" + influencerId,
                                    data: {
                                        _token: csrfToken,
                                        _method: "DELETE",
                                        id: influencerId,
                                    },
                                })
                                    .done(function (res) {
                                        // Simulate delete request -- for demo purpose only
                                        Swal.fire({
                                            text:
                                                you_have_deleted +
                                                influencerName +
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
                                            // dt.draw();
                                            location.reload();
                                        });
                                    })
                                    .fail(function (res) {
                                        Swal.fire({
                                            text:
                                                influencerName + was_not_deleted,
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
                                    text: influencerName + was_not_deleted,
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


        function loadTableData(url) {
            $.get({
                url: url,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {
                    $('#data-table').html("");
                    $('#data-table').html(data);
                    const url = new URL(window.location.href);
                    var layout = url.searchParams.get('layout')

                    if (layout == 'table') {
                        var el = $('#kt_project_users_table_pane');
                        el.addClass('active show')
                        $('#table_layout_button').addClass('active')

                        var element = $('#kt_project_users_card_pane');
                        element.removeClass('active show')
                        $('#card_layout_button').removeClass('active')
                    }

                    if (!layout) {
                        var layout = @json(auth()->user()->influencer_list);

                        if (layout == 'table') {
                            var el = $('#kt_project_users_table_pane');
                            el.addClass('active show')
                            $('#table_layout_button').addClass('active')

                            var element = $('#kt_project_users_card_pane');
                            element.removeClass('active show')
                            $('#card_layout_button').removeClass('active')
                        }
                    }
                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        }

        $(".filterDataForm").on("click", function (e) {
            e.preventDefault();

            var url = "{{ (request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&' }}" + $("#filterDataForm").serialize();
            url = updatePageParam(url, 1);

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            $('#filterDataForm').removeClass('show');
            loadTableData(url);
        });

        function updatePageParam(url, page) {
            var hasPageParam = url.includes('page=');

            if (hasPageParam) {
                // Update the 'page' parameter in the URL
                url = url.replace(/([?&])page=[^&]*(&|$)/, '$1page=' + page + '$2');
            } else {
                // Add the 'page' parameter to the URL
                url += (url.includes('?') ? '&' : '?') + 'page=' + page;
            }

            return url;
        }

        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
        var input = $('#search-input');

        input.on('keyup', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            var full = "{!! url()->full() !!}";
            var searchVal = $("#search-input").val().trim();
            var hasSearchParam = full.includes('search=');

            if (searchVal === '') {
                if (hasSearchParam) {
                    // Remove the 'search' parameter from the URL
                    full = full.replace(/([?&])search=[^&]*(&|$)/, '$1');
                }
            } else {
                // Add or update the 'search' parameter in the URL
                if (hasSearchParam) {
                    full = full.replace(/([?&])search=[^&]*(&|$)/, '$1search=' + searchVal + '$2');
                } else {
                    full += (full.includes('?') ? '&' : '?') + 'search=' + searchVal;
                }
                // Set the page parameter to 1 when performing a new search
                full = updatePageParam(full, 1);
            }

            $.get({
                url: full,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {
                    $('#data-table').html(data);

                    // Rest of the code...

                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        });

        $(document).on('change', '#limit', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();


            var searchVal = $("#search-input").val().trim();
            var url = route + "?perPage=" + limit + "&search=" + searchVal + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        function updatePageParam(url, page) {
            var hasPageParam = url.includes('page=');

            if (hasPageParam) {
                // Update the 'page' parameter in the URL
                url = url.replace(/([?&])page=[^&]*(&|$)/, '$1page=' + page + '$2');
            } else {
                // Add the 'page' parameter to the URL
                url += (url.includes('?') ? '&' : '?') + 'page=' + page;
            }

            return url;
        }


        function doneTyping() {
            let val = $("#search-input").val();
            var country_id = @json(request('country_id') ?? '' );
            var category = @json(request('category') ?? '' );
            var size = @json(request('size') ?? '' );
            var fullUrl = route + "?gender=" + "{{ request('gender') ?? '' }}" + "&country_id=" + JSON.stringify(country_id)
                + "&category=" + JSON.stringify(category)
                + "&size=" + JSON.stringify(size)
                + "&name_en=" + val;

            window.location = fullUrl;
        }

        // $('#search-input').prop("disabled", false);

        function filterData() {
            $("#form_hidden_input").val($("#search-input").val());
            let params = (new URL(document.location)).searchParams;
            let layout = params.get("layout");
            $('#layout').val(layout);
            $('#filterForm').submit();
        }

        function exportData() {
            var params = {
                gender: $("#gender").val(),
                // name:$("#name").val(),
            };
            if ($("#search-input").val()) {
                params.name = $("#search-input").val();
            }

            if ($("#country_id").val()) {
                params.country_id = $("#country_id").val();
            }
            if ($("#category").val()) {
                params.category = $("#category").val();
            }
            if ($("#size").val()) {
                params.size = $("#size").val();
            }


            location.href = "{{ route('influencer.export' )}}?" + jQuery.param(params);
        }
    </script>
@endpush
