@extends('dashboard.layouts.app')
@section('title',  getCustomTranslation('link_tracking'))
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"><br></div>
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Details-->
                        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <!--begin::Title-->
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                    <!--begin::User-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                                                {{$tracker->title}}
                                            </a>
                                            <a href="#">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                                <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                        <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
                                                        <path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </div>
                                        <!--end::Name-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="currentColor" />
                                                        <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                {{$tracker->influencer->{'name_'.$lang} }}
                                            </a>
                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
																	<path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
																</svg>
															</span>
                                                <!--end::Svg Icon-->
{{--                                                Destination--}}
                                                {{$tracker->destination}}
                                            </a>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </div>
                                <!--end::Title-->
                                @if($tracker->note)
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap flex-stack">
                                        <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2 class="fw-bolder">{{getCustomTranslation('notes')}}</h2>
                                                </div>
                                                <!--end::Card title-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <div class="fw-bolder fs-2">
                                                    <div class="fs-7 fw-normal text-muted">
                                                        {{$tracker->note}}
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                    </div>
                                    <!--end::Stats-->
                                @endif

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                            <!--begin::Nav item-->
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="">{{getCustomTranslation('overview')}}</a>
                            </li>
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::details View-->
                <!--end::details View-->
                <!--begin::Row-->
                <div class="row gy-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-4 mb-xl-10">
                        <!--begin::Chart widget 5-->
                        <div class="card card-flush h-lg-100">
                            <!--begin::Header-->
                            <div class="card-header flex-nowrap pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder text-dark">{{getCustomTranslation('clicks')}} {{getCustomTranslation('count')}}</span>
                                    <span class="text-gray-400 pt-2 fw-bold fs-6">{{$total_clicks_count}} {{getCustomTranslation('clicks')}}</span>
                                </h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-5 ps-6">
                                <div id="clicks_count_chart" class="min-h-auto"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Chart widget 5-->
                    </div>
                    <!--end::Col-->
                    <div class="col-xl-8 mb-5 mb-xl-10">
                        <div class="card card-bordered">
                            <div class="card-body">
                                <div id="kt_docs_flot_pie" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                </div><!--end::Row-->

                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <div class="card card-flush h-lg-100">
                            <div class="card-header pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">{{getCustomTranslation('target_market')}}</span>
                                    <span class="text-gray-400 pt-2 fw-semibold fs-6">{{getCustomTranslation('map_showing_target_market')}}</span>
                                </h3>
                            </div>
                            <div class="card-body d-flex align-items-end">
                                <div id="kt_maps_widget_2_maps" class="w-100 h-250px"></div>
                                <div>
                                    <!--begin::Card widget 19-->
                                    <div class="card card-flush h-lg-100">
                                        <!--begin::Header-->
                                        <div class="card-header pt-5">
                                            <!--begin::Title-->
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold text-dark">
                                                    {{ $countries_clicks_count?count($countries_clicks_count):"0" }} {{getCustomTranslation('countries_tracked')}}</span>
                                                </span>
                                            </h3>
                                            <!--end::Title-->
                                            <!--begin::Toolbar-->
                                            <div class="card-toolbar">
                                                <!--begin::Label-->
                                                <span class="badge badge-light-primary fs-base mt-n3">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                                    <!-- <span class="svg-icon svg-icon-5 svg-icon-danger ms-n1"> -->
                                            <i class="fas fa-flag text-primary" style="font-size:30px"></i>
                                                    <!-- </span> -->
                                                    <!--end::Svg Icon-->
                                    </span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                        <!--end::Header-->
                                        @if("true")
                                            <div class="card-body pt-6">
                                                <!--begin::Table container-->
                                                <div class="table-responsive">
                                                    <!--begin::Table-->
                                                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                                            <th class="p-0 pb-3 min-w-80px text-start">{{getCustomTranslation('flag')}}</th>
                                                            <th class="p-0 pb-3 min-w-175px text-start">{{getCustomTranslation('name')}}</th>
                                                            <th class="p-0 pb-3 min-w-100px">{{getCustomTranslation('count')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody>
                                                        @foreach($countries_clicks_count as $item)
                                                            @if($item->category != "Others")
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">

                                                                        <img alt="{{$item->value}}"
                                                                             src="{{asset('dashboard') . '/assets/media/flags/' . Str::slug(strtolower($item->category)) . '.svg'}}"
                                                                             style="width:30px"
                                                                        />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">

                                                                        <div
                                                                            class="d-flex justify-content-start flex-column">
                                                                        <span href=""
                                                                              class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$item->category}}</span>
                                                                            <!-- <span class="text-gray-400 fw-semibold d-block fs-7">Haiti</span> -->
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                                <td class="pe-12">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        {{$item->value}}
                                                                    </span>
                                                                    <!--end::Label-->
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                </div>
                                                <!--end::Table-->
                                            </div>
                                        @else
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <!--begin::Row-->
                                                <div class="row align-items-center">
                                                    <!--begin::Col-->
                                                    <div class="col-sm-7 pe-0 mb-5 mb-sm-0">
                                                        <!--begin::Wrapper-->
                                                        <div
                                                            class="d-flex justify-content-between h-100 flex-column pt-xl-5 pb-xl-2 ps-xl-7">
                                                            <!--begin::Container-->
                                                            <div class="mb-7">
                                                                <!--begin::Title-->
                                                                <div class="mb-6">
                                                                    <h3 class="fs-2x fw-semibold text-grey">{{getCustomTranslation('no_categories')}}
                                                                        </h3>
                                                                    <span class="fw-semibold text-grey opacity-75">{{getCustomTranslation('need_more_data_for_a_better_ad_record')}}</span>
                                                                </div>
                                                                <!--end::Title-->

                                                            </div>
                                                            <!--end::Container-->

                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--begin::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-sm-5">
                                                        <!--begin::Illustration-->
                                                        <img
                                                            src="{{asset('dashboard/assets/media/svg/illustrations/easy/7.svg')}}"
                                                            class="h-200px h-lg-250px my-n6" alt=""/>
                                                        <!--end::Illustration-->
                                                    </div>
                                                    <!--begin::Col-->
                                                </div>
                                                <!--begin::Row-->
                                            </div>
                                            <!--end::Body-->
                                        @endif
                                    </div>
                                    <!--end::Card widget 19-->
                                </div>
                            </div>
                        </div>
                    </div><!--end::Col-->
                </div>
                <!--end::Row-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">{{getCustomTranslation('operating_system')}}</h3>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Action-->
                        <!--end::Action-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <div class="card card-bordered">
                            <div class="card-body">
                                <div id="kt_amcharts_1" style="height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

@endsection
@push('scripts')
    <script src="{{asset('dashboard/assets/js/amcharts/v4/core.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/v4/maps.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/geodata/worldLow.js')}}"></script>
    <script src="{{ asset('dashboard') }}/assets/js/custom/documentation/charts/flotcharts/pie.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('dashboard') }}/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{ asset('dashboard') }}/assets/plugins/custom/flotcharts/flotcharts.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('dashboard') }}/assets/js/custom/documentation/documentation.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/custom/documentation/search.js"></script>
    <script>
        let countries_clicks = @json($countries_clicks_count);
        let platform_clicks_count = @json($platform_clicks_count);//OS
        let device_clicks_count = @json($device_clicks_count);//device
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/linktracking/chart.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/linktracking/pie.js"></script>
    <script>
        var chart = am4core.create("kt_maps_widget_2_maps", am4maps.MapChart);
        // Set map definition
        chart.geodata = am4geodata_worldLow;
        // Set projection
        chart.projection = new am4maps.projections.Miller();
        // Create map polygon series
        var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
        // Make map load polygon (like country names) data from GeoJSON
        polygonSeries.useGeodata = true;
        // Configure series
        var polygonTemplate = polygonSeries.mapPolygons.template;
        polygonTemplate.tooltipText = "{name}";
        polygonTemplate.fill = am4core.color("#74B266");
        // Create hover state and set alternative fill color
        var hs = polygonTemplate.states.create("hover");
        hs.properties.fill = am4core.color("#367B25");
        // Remove Antarctica
        polygonSeries.exclude = ["AQ"];
        var fromPHP = @json($countries_clicks_count);
        var test = [];
        var zoomTo = [];
        for (var i = 0; i < fromPHP.length; i++) {
            if(fromPHP[i].country_code){
                test[i] = {
                    'id': (fromPHP[i].country_code).toUpperCase(),
                    'name': fromPHP[i].category,
                    'value': 100,
                    "fill": am4core.color("#F05C5C")
                }
                zoomTo.push((fromPHP[i].country_code).toUpperCase());
            }
        }
        // Add some data
        polygonSeries.data = test;
        chart.events.on("ready", function (ev) {
            // Init extremes
            var north, south, west, east;

            // Find extreme coordinates for all pre-zoom countries
            for (var i = 0; i < zoomTo.length; i++) {
                var country = polygonSeries.getPolygonById(zoomTo[i]);
                if (north == undefined || (country.north > north)) {
                    north = country.north;
                }
                if (south == undefined || (country.south < south)) {
                    south = country.south;
                }
                if (west == undefined || (country.west < west)) {
                    west = country.west;
                }
                if (east == undefined || (country.east > east)) {
                    east = country.east;
                }
                country.isActive = true
            }

            // Pre-zoom
            chart.zoomToRectangle(north, east, south, west, 1, true);
        });
        // Bind "fill" property to "fill" key in data
        polygonTemplate.propertyFields.fill = "fill";
    </script
@endpush
