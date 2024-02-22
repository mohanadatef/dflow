@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('ad_records'))

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
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search_in_ad_records')}}"
                           value="{{request('search')}}"/>
                </div>
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                @if($userType)
                    <!--end::Search-->
                    <div class="d-flex justify-content-end" >
                    <a href="#" id="modalLimitation" class="btn btn-primary"> <i
                                class="fa fa-eye" ></i> {{getCustomTranslation('view_page_limitation')}}</a>
                    </div>
                    &nbsp
                @endif
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
                    <!--end::Svg Icon-->{{getCustomTranslation('filter_ads')}}
                </button>
                <!--begin::Menu 1-->
                <form method="GET" id="filterDataForm" action="{{route('ad_record.index')}}"
                      class="dropdown-menu w-400px w-md-325px" data-kt-menu="true"
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
                    <input type="hidden" name="company_id" value="{{request('company_id')}}">
                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('ad_date')}}:</label>

                        <div class="mb-10 d-flex justify-content-between">
                            <div class="mx-2">
                                <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('from')}}:</label>

                                <input
                                        type="text"
                                        name="start"
                                        id="start"
                                        min="{{user()->start_access ?? ""}}"
                                        max="{{user()->end_access ?? ""}}"
                                        autocomplete="off"
                                        @if(request('start'))
                                            value="{{ $range_start->format('Y-m-d') }}"
                                        @endif
                                        style="margin-right:5px"
                                        class="form-select"
                                />


                            </div>

                            <div>
                                <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('to')}}:</label>

                                <input
                                        type="text"
                                        name="end"
                                        id="end"
                                        min="{{user()->start_access ?? ""}}"
                                        max="{{user()->end_access ?? ""}}"
                                        autocomplete="off"
                                        @if(request('end'))
                                            value="{{$range_end->format('Y-m-d') }}"
                                        @endif
                                        style="margin-right:5px"
                                        class="form-select"
                                />
                            </div>

                        </div>
                        @if(! $userType)

                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('created_at')}}:</label>
                            <div class="mb-10 d-flex justify-content-between">


                                <div class="mx-2">

                                    <label class="form-label fs-6 fw-semibold"> {{getCustomTranslation('from')}}:</label>

                                    <input
                                            type="text"
                                            name="creation_start"
                                            id="creation_start"
                                            autocomplete="off"
                                            @if(request('creation_start'))
                                                value="{{ $range_creation_start->format('Y-m-d') }}"
                                            @endif
                                            style="margin-right:5px"
                                            class="form-select"
                                    />
                                </div>

                                <div>
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('to')}}:</label>

                                    <input
                                            type="text"
                                            name="creation_end"
                                            id="creation_end"
                                            autocomplete="off"
                                            @if(request('creation_end'))
                                                value="{{$range_creation_end->format('Y-m-d') }}"
                                            @endif
                                            style="margin-right:5px"
                                            class="form-select"
                                    />
                                </div>


                            </div>

                        @endif


                        @if(!$userType)
                            @can('update_ad_record')
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('creator')}}:</label>
                                <select name="user_id[]" multiple="multiple" id="researcher"
                                        class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                        data-placeholder="{{getCustomTranslation('select_option')}}" data-allow-clear="true"
                                        data-kt-user-table-filter="role" data-hide-search="false">
                                    @foreach($researchers as $researcher)
                                        <option value="{{$researcher->id}}"
                                                @if(in_array($researcher->id , request('user_id') ?: [])) selected @endif>{{$researcher->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endcan
                        @endif


                        <!--begin::Input group-->
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('influencer')}}:</label>
                            <!--begin::Input-->
                            <select id="influencer" name="influencer_id[]"
                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                    data-mce-placeholder="" multiple>
                                @if( request('influencer_id'))
                                    @foreach($influencers_data as $influencer_data)
                                        <option value="{{$influencer_data->id}}"
                                                @if(in_array($influencer_data->id , request('influencer_id') ?: [])) selected @endif>{{$influencer_data->{'name_'.$lang} }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('company')}}:</label>
                            <!--begin::Input-->
                            <select id="company" name="company_ids[]"
                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                    data-mce-placeholder="" multiple>
                                @if( request('company_ids'))
                                    @foreach($companys_data as $company_data)
                                        <option value="{{$company_data->id}}"
                                                @if(in_array($company_data->id , request('company_ids') ?: [])) selected @endif>{{$company_data->{'name_'.$lang} }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!--end::Input group-->
                        @if(!$userType)
                            <!--beguser()->role->role->in::Input group-->
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
                        @else
                            {{-- <input type="hidden" name="category[]" value="{{json_encode(request('category'))}}"> --}}

                        @endif
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('platform')}}:</label>
                            <select name="platform_id[]" multiple="multiple" id="platform"
                                    class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="{{getCustomTranslation('select_platform')}}" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="false">
                                @foreach($platforms as $platform)
                                    <option value="{{$platform->id}}"
                                            @if(in_array($platform->id , request('platform_id') ?: [])) selected @endif>{{$platform->{'name_'.$lang} }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('red_flag')}}:</label>
                            <select name="red_flag"  id="red_flag"
                                    class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="{{getCustomTranslation('select_red_flag')}}" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="false">
                                <option value=""
                                        @if(request('red_flag') == null) selected @endif>{{getCustomTranslation('select_red_flag') }}</option>
                                    <option value="0"
                                            @if(request('red_flag') === "0") selected @endif>{{getCustomTranslation('no') }}</option>
                                <option value="1"
                                        @if(request('red_flag') == 1) selected @endif>{{getCustomTranslation('yes') }}</option>
                            </select>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            @if(!$userType)
                                <a href="{{ route('ad_record.index') }}" id="reset_filter"
                                   class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                   data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                </a>
                            @else
                                <a href="javascript:my_fun_reset();" id="reset_filter"
                                   class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                >{{getCustomTranslation('reset')}}
                                </a>

                            @endif
                            {{-- <button type="reset" id="reset_filter" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}</button>  --}}
                            <button type="button" class="btn btn-primary fw-semibold px-6 filterDataForm"
                                    data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </form>
                <!--end::Menu 1-->
                <!--end::Filter-->
                <!--begin::Export dropdown-->
                @can('export_ad_record')
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
                <!--begin::Menu-->
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
                <!--end::Menu-->

                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-ad_record-table-select="base">
                    @can('create_ad_record')
                    <!--begin::Add ad_record-->
                    <a href="{{ route('ad_record.create') }}" class="btn btn-primary">{{getCustomTranslation('add_ad_record')}} </a>
                    <!--end::Add ad_record-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-ad_record-table-select="selected">
                    <div class="fw-bold me-5">
                        @can('delete_ad_record')
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-ad_record-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="listAdRecord" style="width: 100%">
                @include('record::ad_record.table')
            </div>

            <!--end::Datatable-->
        </div>
        <!--end::Products-->
    </div>
    @if($userType)
    <div class="modal fade" id="modalLimitationM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p> {{getCustomTranslation('this_page_views_only_the_industry_ads')}} ({{$categoriesClient}})</p>
                </div>

            </div>
        </div>
    </div>
    @endif

    <div class="modal fade" id="kt_modal_timbrally" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('create_error')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_timbrally_form" class="form" method="post" action=""  enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                             data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                             data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                             data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">{{getCustomTranslation('error_message')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="message" class="form-control form-conrtol-lg"></textarea>
                                <input type="hidden" name="ad_record_id" id="ad_record_id">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                    onclick="closeTimbrallyModel()">{{getCustomTranslation('discard')}}
                            </button>
                            <button type="submit" class="btn btn-light me-3">{{getCustomTranslation('submit')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>


@endsection

@push('scripts')
    <script>
        var route = "{{ route('ad_record.index') }}";
        var routeAll = "{{ route('ad_record.index',Request()->all()) }}";
        var csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/ad_record/list.js?v=1"></script>


    <script>


        $(function () {
            $(document).on('click', '#modalLimitation', function (event) {
                event.preventDefault();
                $('#modalLimitationM').modal('toggle');
            });

            $('input[name="start"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
            $('input[name="end"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
            $('input[name="creation_start"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
            $('input[name="creation_end"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });


            $('input[name="start"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate:new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                maxDate:new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
                locale: {

                    format: 'YYYY/MM/DD',
                }
            });

            $('input[name="start"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });


            $('input[name="end"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate:new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                maxDate:new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
                //  startDate: '{{$range_end}}', // after open picker you'll see this dates as picked
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });

            $('input[name="end"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            $('input[name="creation_start"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate:new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                maxDate:new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });
            $('input[name="creation_start"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $('input[name="creation_end"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate:new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                maxDate:new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });
            $('input[name="creation_end"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

        });

        var filterValues = $("#filterDataForm").serialize();
        $(document).ready(function () {
            var form = $("#filterDataForm");
            // form.deserialize(filterValues);
        });


        function handleDeleteRows() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-ad_record-table-filter="delete_row"]'
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

        var input = $('#search');
        var limit = "{{Request::get('perPage') ?? $datas->perPage()}}";
        //on keyup, start the countdown
        input.on('keyup', function () {

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            var searchVal = $("#search").val().trim();
            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&search=" + searchVal + "&" + "perPage=" + limit + "&" + $("#filterDataForm").serialize();


            $.get({
                url: full,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {

                    $('#listAdRecord').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        });


        function my_fun_reset() {

            $('#influencer').val('');
            $('#company').val('');
            $('#start').val('');
            $('#end').val('');
            $('#red_flag').val('');

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            var searchVal = $("#search").val().trim();
            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&search=" + searchVal + "&" + "perPage=" + limit + "&" + $("#filterDataForm").serialize();

            $('#filterDataForm').removeClass('show');


            $.get({
                url: full,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {

                    $('#listAdRecord').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        $(".filterDataForm").on("click", function (e) {
            e.preventDefault();
            var searchVal = $("#search").val().trim();//?search="+searchVal+"&"+ "perPage=" + limit +"&"
            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&search=" + searchVal + "&" + "perPage=" + limit + "&" + $("#filterDataForm").serialize();


            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            $('#filterDataForm').removeClass('show');
            loadTableData(full);
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

        $(document).on('click', '.pagination a', function (event) {

            event.preventDefault();
            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            var searchVal = $("#search").val().trim();
            var url = $(this).attr('href') + "&perPage=" + limit + "&search=" + searchVal + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        $(document).on('change', '#limit', function () {

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();

            var searchVal = $("#search").val().trim();
            var url = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}"  + "&perPage=" + limit + "&search=" + searchVal + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        function loadTableData(url) {
            $.get({
                url: url,
                success: function (data) {

                    $('#listAdRecord').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        $("#dropdownMenuClickable").on("click", function (e) {
            //$('#filterDataForm').show();
        });

        function exportData(lang) {

            var params = {
                influencer_id: $("#influencer").val(),
                company_ids: $("#company").val(),
                user: $("#researcher").val(),
                category: $("#category").val(),
                platform_id: $("#platform").val(),
                lang: lang,
            };
            if ($("#end").val()) {
                params.end = $("#end").val();
            }
            if ($("#search").val()) {
                params.search = $("#search").val();
            }
            if ($("#start").val()) {
                params.start = $("#start").val();
            }
            if ($("#red_flag").val()) {
                params.red_flag = $("#red_flag").val();
            }
            if ($("#creation_start").val()) {
                params.creation_start = $("#creation_start").val();
            }
            params.creationD_start = "{{Request('creationD_start')}}";
            if ($("#creation_end").val()) {
                params.creation_end = $("#creation_end").val();
            }
            params.creationD_end = "{{Request('creationD_end')}}";
            if ($("#company_ids").val()) {
                params.company_ids = $("#company_ids").val();
            }

            location.href = "{{ route('ad_record.export' )}}?" + jQuery.param(params);
        }

        let search_influencer_url = "{{ route('influencer.search') }}";
        $('#influencer').select2({
            minimumInputLength: 1,
            delay: 900,
            placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: search_influencer_url,
                method: 'get',
                dataType: 'json',
                delay: 900,
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
            }
        });

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
        function closeTimbrallyModel() {
            $('#kt_modal_timbrally').modal('toggle');
            $('#kt_modal_timbrally').modal({backdrop: true})
            $('#loading').css('display', 'none');
        }

        function getTimbrallyData(ad_id) {
            $('#loading').css('display', 'flex');
            $('#kt_modal_timbrally').modal({backdrop: false})
            $('#kt_modal_timbrally').modal('show');
            $("#created_by_id").val({{user()->id}});
            $("#ad_record_id").val(ad_id);
            $('#loading').css('display', 'none');
        }

        $("#kt_modal_timbrally_form").on("submit", function (event) {

            event.preventDefault();
            $('#loading').css('display', 'flex');
            url = "{{route('ad_record_errors.store')}}";
            form = new FormData(this)
            $.ajax({
                type: "post",
                url: url,
                data: form,
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#kt_modal_timbrally').modal('toggle');
                    $('#kt_modal_timbrally').modal({backdrop: true});
                    $('#kt_modal_timbrally_form').trigger("reset");
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });

    </script>

@endpush
