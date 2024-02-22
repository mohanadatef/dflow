@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('user'))

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
                           class="form-control form-control-solid w-250px ps-15"
                           placeholder="{{getCustomTranslation('search_users')}}"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                @can('export_users')
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
                <div class="d-flex justify-content-end" data-kt-users-table-select="base">
                    @can('create_users')
                    <!--begin::Add users-->
                    <a href="{{ route('user.create') }}"
                       class="btn btn-primary">{{getCustomTranslation('add')}} {{getCustomTranslation('user')}}</a>
                    <!--end::Add users-->
                    @endcan
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="data-table" style="width: 100%">
                @include('acl::users.table')
            </div>
            <!--end::Datatable-->
        </div>
    </div>
    <!--end::Products-->
@endsection
@push('scripts')
    <script>
        var routeAll = "{{ route('user.index',Request()->all()) }}";
        var route = "{{ route('user.index') }}";
        var toggleActiveRoute = "{{ route('user.toggleActive') }}";
        var userExport = "{{ route('user.export' )}}";
        var csrfToken = "{{ csrf_token() }}";
        var input = $('#search');
        input.on('keyup', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            full = "{!! url()->full() !!}";

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
        $(document).on('change', '#limit', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            limit = $(this).val();
            var searchVal = $("#search").val().trim();
            var fullSearchLink = route + "?perPage=" + limit + "&search=" + searchVal;
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
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/users/list.js?v=1"></script>
@endpush
