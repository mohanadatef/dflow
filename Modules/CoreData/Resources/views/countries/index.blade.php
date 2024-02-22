@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('countries'))

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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                  transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-docs-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search')}}"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base">
                    @can('create_countries')
                    <!--begin::Add country-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_country">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                      rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                      fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->{{getCustomTranslation('add')}} {{getCustomTranslation('country')}}
                    </button>
                    <!--end::Add country-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-customer-table-select="selected">
                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div> --}}
                        @can('delete_countries')
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-customer-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                       data-kt-check-target="#kt_customers_table .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th class="min-w-125px">{{getCustomTranslation('name_ar')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('name_en')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('code')}}</th>
                        <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600">
                    </tbody>
                </table>
            </div>
            <!--end::Datatable-->
        </div>
        <!--end::Products-->
        @include('coredata::countries.create')
        @include('coredata::countries.edit')

        @endsection
        @push('scripts')
            <script>
                var routeAll = "{{ route('country.index',Request()->all()) }}";
                var route = "{{ route('country.index') }}";
                var csrfToken = "{{ csrf_token() }}";
            </script>

            <script src="{{ asset('dashboard') }}/assets/js/countries/list.js?v=1"></script>
            <script src="{{ asset('dashboard') }}/assets/js/countries/add.js"></script>
            <script src="{{ asset('dashboard') }}/assets/js/countries/update.js"></script>

    @endpush
