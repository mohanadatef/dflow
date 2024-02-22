@extends('dashboard.layouts.app')

@section('title', 'Users log')
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
                    <input type="text" data-kt-users-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="Search Users"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
            </div>
            <!--end::Card toolbar-->
            </div>
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
            <div class="col-xl-3">
                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8"
                   style="pointer-events: none; cursor: default;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                        <span class="svg-icon svg-icon svg-icon-3x ms-n1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3"
                              d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                              fill="currentColor"/>
                        <path
                            d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                            fill="currentColor"/>
                    </svg>
                </span>
                        <!--end::Svg Icon-->
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">{{ \Illuminate\Support\Facades\Session::get('logged-in-data')['offlineUsersCount'] }}</div>
                        <div class="fw-semibold text-gray-400">Offline Users</div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>
            <div class="col-xl-3">
                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8"
                   style="pointer-events: none; cursor: default;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <i class="fa-solid fa-rectangle-ad text-gray-100" style="font-size:30px"></i>
                        <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">{{ \Illuminate\Support\Facades\Session::get('logged-in-data')['awayUsersCount'] }}</div>
                        <div class="fw-semibold text-gray-100">Away Users</div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>
            <div class="col-xl-3">
                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8"
                   style="pointer-events: none; cursor: default;">
                    <!--begin::Body-->
                    <div class="card-body">

                        <i class="fas fa-users text-white" style="font-size:30px"></i>
                        <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ \Illuminate\Support\Facades\Session::get('logged-in-data')['onlineUsersCount'] }}</div>
                        <div class="fw-semibold text-white">Online Users</div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>
            <div class="col-xl-3">
                <!--begin::Statistics Widget 5-->
                <a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8"
                   style="pointer-events: none; cursor: default;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <i class="fas fa-dollar-sign text-white" style="font-size:30px"></i>
                        <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ \Illuminate\Support\Facades\Session::get('logged-in-data')['totalAds'] }}</div>
                        <div class="fw-semibold text-white">Total recorded ads</div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Statistics Widget 5-->
            </div>
        </div>
        <!--end::Row-->
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_users_table">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                       data-kt-check-target="#kt_users_table .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th class="min-w-125px">Name</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Role</th>
                        <th class="min-w-125px">Total Records</th>
                        <th class="min-w-125px" style="text-align:start !important">Statusß</th>
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
        @endsection
        @push('scripts')
            <script>
                var routeAll = "{{ route('user.loggedIn',Request()->all()) }}";
                var route = "{{ route('user.loggedIn') }}";
                var toggleActiveRoute = "{{ route('user.toggleActive') }}";
                var csrfToken = "{{ csrf_token() }}";
                var deletePermission = {{permissionShow('delete_users') ? 1 : 0}};
                var updatePermission = {{permissionShow('update_users') ? 1 : 0}};
                var showPermission = {{permissionShow('view_users') ? 1 : 0}};
                var passwordPermission = {{permissionShow('change_password_users') ? 1 : 0}};
            </script>
            <script src="{{ asset('dashboard') }}/assets/js/users/logged-in.js?v=3"></script>
    @endpush
