@extends('dashboard.layouts.app')

@section('title', 'Interest')

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
                    <input type="text" data-kt-interest-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="Search Interest"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base">
                    @permission('create_interests')
                    <!--begin::Add customer-->
                    <a href="{{ route('interest.create') }}" class="btn btn-primary"> Add Interest</a>
                    <!--end::Add customer-->
                    @endpermission
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-customer-table-select="selected">
                    <div class="fw-bold me-5">
                        @permission('delete_interests')
                        {{-- <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div> --}}
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-customer-table-select="delete_selected">Delete Selected
                        </button>
                        @endpermission
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
                        <th class="min-w-125px">Name En</th>
                        <th class="min-w-125px">Name Ar</th>
                        <th class="text-end min-w-70px">Actions</th>
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
    </div>
    <!--end::Products-->
@endsection
@push('scripts')

    <script>
        var route = "{{ route('interest.index') }}";
        var routeAll = "{{ route('interest.index',Request()->all()) }}";
        var csrfToken = "{{ csrf_token() }}";
        var deletePermission = {{permissionShow('delete_interests') ? 1 : 0}};
        var updatePermission = {{permissionShow('update_interests') ? 1 : 0}};
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/interest/list.js?v=1"></script>
@endpush
