@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('admin_dashboard'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="row card-title" style="width: 100%">
                <!--begin::Search-->
                <div class="col-md-4 d-flex align-items-center position-relative my-1">
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
                    <div type="text" id="is_online" data-is-online="{{$is_online}}"></div>
                    <!--end::Svg Icon-->
                    <input type="text" id="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search_users')}}"/>
                </div>
                <div class="col-md-4 d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <select id="role" name="role" class="form-select form-select-solid form-select-lg fw-semibold">
                        <option disabled selected>{{getCustomTranslation('select_role')}}</option>
                        <option value="" selected>{{getCustomTranslation('all')}}</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <!--end::Search-->
                <div class="col-md-3 d-flex align-items-center position-relative my-1">
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
                </div>
            </div>
            <div class="row g-5 g-xl-8" style="width: 100%">
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{route('ad_record.index')}}?creationD_start={{$range_start}}&creationD_end={{$range_end}}"
                       class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8"
                    >
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="text-white fw-bold fs-2 mb-2 mt-5"
                                 id="totalAds">{{ $data['cards']['totalAds'] }}</div>
                            <div class="fw-semibold text-white">{{getCustomTranslation('total_recorded_ads')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3" onclick="isOnline(1)">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8"
                       style=" cursor: pointer;">
                        <!--begin::Body-->
                        <div class="card-body" >
                            <div class="text-white fw-bold fs-2 mb-2 mt-5"
                                 id="onlineUsersCount">{{ $data['cards']['onlineUsersCount'] }}</div>
                            <div class="fw-semibold text-white">{{getCustomTranslation('online_user')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3" onclick="isOnline(3)">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8"
                       style=" cursor: pointer;">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5"
                                 id="awayUsersCount">{{ $data['cards']['awayUsersCount'] }}</div>
                            <div class="fw-semibold text-gray-100">{{getCustomTranslation('away_user')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3" onclick="isOnline(2)">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8"
                       style="cursor: pointer;">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                            <!--end::Svg Icon-->
                            <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5"
                                 id="offlineUsersCount">{{ $data['cards']['offlineUsersCount'] }}</div>
                            <div class="fw-semibold text-gray-400">{{getCustomTranslation('offline_user')}} </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>

            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="data-table" style="width: 100%">
                @include('acl::users.adminDashboard.table')
            </div>
            <!--end::Datatable-->
        </div>
    </div>
    <!--end::Products-->
@endsection
@push('scripts')
    <script>
        var limit = "{{Request::get('perPage') ?? 10}}";
        var input = $('#search');
        //on keyup, start the countdown
        input.on('keyup', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            getData(window.location.href);
        });
        $(document).on('change', '#role', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            var url = window.location.href + "?role=" + $("#role").val();
            getData(url);
        });
        function isOnline(isOnline) {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            online = $("#is_online").attr('data-is-online');
            if (online != isOnline) {
                document.getElementById("is_online").setAttribute('data-is-online', isOnline)
            } else {
                document.getElementById("is_online").setAttribute('data-is-online', 0)
            }
            var url = window.location.href;
            getData(url);
        }

        var now = new Date();
        var delay = 30 * 1000; // 1 min in msec
        var start = delay - (now.getSeconds()) * 1000 + now.getMilliseconds();


        setTimeout(function setTimer() {
            getData(window.location.href + "?perPage=" + $("#limit").val());
            setTimeout(setTimer, delay);
        }, start);

        function getData(url) {
            $.ajax({
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                url: url,
                data: {
                    "search": $("#search").val(),
                    "role": $("#role").val(),
                    "is_online": $("#is_online").attr('data-is-online'),
                },
                success: function (data) {
                    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
                    $("#data-table").empty();
                    $('#data-table').html(data);
                },
            })
        }

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
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            var searchVal = $("#search").val();
            var url = $(this).attr('href') + "&perPage=" + limit + "&search=" + searchVal;
            getData(url);
        });

        $(document).on('change', '#limit', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            limit = $(this).val();
            var searchVal = $("#search").val().trim();
            var url = window.location.href + "?perPage=" + limit + "&search=" + searchVal;
            getData(url);
        });
        function exportData(lang) {
            var params = {
                lang: lang,
                creationDL_start: "{{$range_start}}",
                creationDL_end: "{{$range_end}}",
                role: $("#role").val(),
                search_admin: $("#search").val(),
            };
            location.href = "{{ route('ad_record.export' )}}?" + jQuery.param(params);
        }
    </script>
@endpush
