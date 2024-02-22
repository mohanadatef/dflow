@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('ad_record_errors'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
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
                <form method="GET" id="filterDataForm" action="{{route('ad_record_errors.index')}}"
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
                    <div class="px-7 py-5" data-kt-user-table-filter="form">
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
                        @can('create_errors_ad_record')
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('creator')}}:</label>
                            <select name="ad_record_owner_id[]" multiple="multiple" id="researcher"
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
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('ad_record_errors.index') }}" id="reset_filter"
                               class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                               data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                            </a>
                            <button type="button" class="btn btn-primary fw-semibold px-6 filterDataForm"
                                    data-kt-menu-dismiss="true"
                                    data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </form>
                <!--end::Menu 1-->
                <!--end::Filter-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="listAdRecord" style="width: 100%">
                @include('record::ad_record_errors.table')
            </div>

            <!--end::Datatable-->
        </div>
        <!--end::Products-->
    </div>
@endsection

@push('scripts')
    <script>
        var route = "{{ route('ad_record_errors.index') }}";
        var routeAll = "{{ route('ad_record_errors.index',Request()->all()) }}";
        var csrfToken = "{{ csrf_token() }}";

        var filterValues = $("#filterDataForm").serialize();
        $(document).ready(function () {
            var form = $("#filterDataForm");
            // form.deserialize(filterValues);
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
            var url = $(this).attr('href') + "&perPage=10" + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        $(document).on('change', '#limit', function () {

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();

            var url = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&perPage=" + limit + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        function loadTableData(url) {
            $.get({
                url: url,
                success: function (data) {

                    $('#listAdRecord').html(data);
                    KTMenu.createInstances();
                }
            });
        }

        var filterValues = $("#filterDataForm").serialize();

        $(document).ready(function () {
            var form = $("#filterDataForm");
            // form.deserialize(filterValues);
        });
        var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "perPage=10" + "&" + $("#filterDataForm").serialize();

        $('#filterDataForm').removeClass('show');

        $(".filterDataForm").on("click", function (e) {
            e.preventDefault();
            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "perPage=10" + "&" + $("#filterDataForm").serialize();


            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            $('#filterDataForm').removeClass('show');
            loadTableData(full);
        });

        $('input[name="creation_start"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });
        $('input[name="creation_end"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });

        $('input[name="creation_start"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            maxDate: new Date("{{\Carbon\Carbon::today()}}"),
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
            maxDate: new Date("{{\Carbon\Carbon::today()}}"),
            locale: {
                format: 'YYYY/MM/DD',
            }
        });
        $('input[name="creation_end"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    </script>
@endpush
