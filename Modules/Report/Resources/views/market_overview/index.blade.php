@extends('dashboard.layouts.app')

@section('content')

    <form action="{{route('dashboard')}}" method="GET" id="filterForm">
        <div class="row" style="margin-bottom:50px;">
            <div class="col-md-4" style="display:flex;@if($lang == 'ar')flex-direction: row-reverse @endif">
                <h2 class="text-white mt-2">{{getCustomTranslation('industry')}} </h2>
                &nbsp;&nbsp;&nbsp;
                <select id="category_select" name="category"
                        data-control="select2" data-placeholder="{{getCustomTranslation('select_a_category')}}"
                        class="form-select form-select-solid  fw-semibold">

                    @if( $userType)
                        @foreach($client_categories['parent'] as $category)
                                <option
                                    {{$current_category->id == $category->id ? 'selected' : '' }} value="{{$category->id}}"
                                >{{$category->{'name_'.$lang} }}</option>
                                    <?php $onlyparent = 1; ?>

                                @foreach ($client_categories['all'] as $row)
                                    @if($category->id == $row->parent_id)
                                            <?php $onlyparent = 0; ?>
                                        <option
                                            {{$current_category->id == $row->id ? 'selected' : '' }} value="{{$row->id}}">{{$row->{'name_'.$lang} }}</option>
                                    @endif
                                @endforeach
                                @if ($onlyparent)
                                    <option
                                        {{$current_category->id == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->{'name_'.$lang} }}</option>
                                @endif



                        @endforeach
                    @else
                        @foreach($client_categories as $category)
                            @if(request('category'))
                                <option
                                    value="{{$category->id}}" {{$current_category->id == $category->id ? 'selected' : '' }}>{{ $category->{'name_'.$lang} }}</option>
                            @else
                                <option
                                    value="{{$category->id}}">{{ $category->{'name_'.$lang} }}</option>
                            @endif
                        @endforeach
                    @endif

                </select>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div style="display:flex">
                    <input
                        type="text"
                        name="ranges"
                        value="{{ $range_start->format('m/d/Y') . ' - ' . $range_end->format('m/d/Y') }}"
                        style="margin-right:5px"
                        class="form-select"
                        id="ranges"
                    />
                </div>
            </div>
        </div>
    </form>
    @include('dashboard.error.error')
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a  class="card bg-body hoverable card-xl-stretch mb-xl-8" onclick="ShowBrands()"
               id="kt_app_layout_builder_toggle"
               title="VIEW Brands"
               data-bs-custom-class="tooltip-inverse"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               data-bs-dismiss="click"
               data-bs-trigger="hover"
               onmouseover="" style="cursor: pointer;"
            >
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->


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
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">
                        {{$number_of_brands==0 ?'N/A' : number_format($number_of_brands)}}
                    </div>
                    <div class="fw-semibold text-gray-400">

                        {{getCustomTranslation('number_of_brands')}}
                        <span class="card-label fw-bold fs-3 mb-1 marketoverview" style="padding:5px; ">{{getCustomTranslation('view')}}</span>

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a onclick="ShowAds()" class="card bg-dark hoverable card-xl-stretch mb-xl-8"
               id="kt_app_layout_builder_toggle"
               title="VIEW Ads"
               data-bs-custom-class="tooltip-inverse"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               data-bs-dismiss="click"
               data-bs-trigger="hover"
               onmouseover="" style="cursor: pointer;"
            >
                <!--begin::Body-->
                <div class="card-body">
                    <i class="fa-solid fa-rectangle-ad text-gray-100" style="font-size:30px"></i>
                    <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">{{
                    ($number_of_ads==0) ?'N/A' : number_format($number_of_ads)
                    }}


                    </div>
                    <div class="fw-semibold text-gray-400">{{getCustomTranslation('number_of_ads')}}
                        <span class="card-label fw-bold fs-3 mb-1" style="padding:5px; ">{{getCustomTranslation('view')}}</span>

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a  class="card bg-warning hoverable card-xl-stretch mb-xl-8" @can('view_influencers') onclick="ShowInfluencers()"
               id="kt_app_layout_builder_toggle"
               title="VIEW Influencers"
               data-bs-custom-class="tooltip-inverse"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               data-bs-dismiss="click"
               data-bs-trigger="hover"

               onmouseover="" style="cursor: pointer;" @endcan
            >
                <!--begin::Body-->
                <div class="card-body">

                    <i class="fas fa-users text-white" style="font-size:30px"></i>
                    <div class="text-white fw-bold fs-2 mb-2 mt-5">
                        {{
                            $number_of_influencers==0 ?'N/A' : number_format($number_of_influencers)
                            }}
                    </div>
                    <div class="fw-semibold text-white">{{getCustomTranslation('number_of_influencers')}}
                        @can('view_influencers')  <span class="card-label fw-bold fs-3 mb-1" style="padding:5px; ">{{getCustomTranslation('view')}}</span> @endcan

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a onclick="Showestmate()" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8"
               id="kt_app_layout_builder_toggle_priceestmatin"
               title="VIEW Estimated Spent"
               data-bs-custom-class="tooltip-inverse"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               data-bs-dismiss="click"
               data-bs-trigger="hover"
               data-id="1"
               onmouseover="" style="cursor: pointer;">
                <!--begin::Body-->
                <div class="card-body">
                    <i class="fas fa-dollar-sign text-white" style="font-size:30px"></i>
                    <div class="text-white fw-bold fs-2 mb-2 mt-5">
                        {{
                            ($estimated_spent==0) ?'N/A' : number_format($estimated_spent)
                            }}
                    </div>
                    <div class="fw-semibold text-gray-400">{{getCustomTranslation('estimated_spent')}}
                        <span class="card-label fw-bold fs-3 mb-1" style="padding:5px; " id="vieworhide" data-vieworhide="0">{{getCustomTranslation('view')}}</span>

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
    </div>
    <!--end::Row-->

    <!--begin::Row-->

    <!--end::Row-->
    <!--begin::Row-->
    <div class="row g-5 g-xl-8" style="display: none" id="estmateprice">
        <div class="col-xl-12">
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    @include('report::market_overview.charts.basic_chart_price')
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>

    </div>
    <!--end::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body my-3">
                    @include('report::market_overview.charts.basic_chart')
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>

    </div>

    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-xl-6">
            <!--begin::Tables Widget 2-->
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">{{getCustomTranslation('top_5_brands')}}</span>

                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        @if(count($top_brands))
                            <!--begin::Table-->
                            <table class="table align-middle gs-0 gy-5">
                                <!--begin::Table head-->
                                <thead>
                                <tr>
                                    <th class="p-0 w-50px"></th>
                                    <th class="p-0 min-w-150px"></th>
                                    <th class="p-0 min-w-150px">{{getCustomTranslation('number_of_ads')}}</th>
                                </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                @foreach($top_brands as $brand)
                                    <tr>
                                        <td>
                                            @if($brand->company->iconUrl)

                                                <div class="symbol symbol-50px me-2">
                                                    <div
                                                        class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">
                                                        <img src="{{$brand->company->iconUrl}}"
                                                             style="width: 50px;height: 50px">
                                                    </div>
                                                </div>
                                            @else

                                                <div class="symbol symbol-50px me-2">
                                                    <div
                                                        class="symbol-label fs-2 fw-semibold bg-primary text-inverse-danger">
                                                        {{ mb_substr(trim($brand->company->{'name_'.$lang}), 0, 1, 'utf8') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </td>

                                        <td>


                                            <a  @can('competitive_analysis_page') href="{{route('reports.competitive_analysis',['company'=>$brand->company->id,'ranges'=>Request()->ranges])}}" @endcan
                                               class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$brand->company->{'name_'.$lang} }}</a>


                                        </td>

                                        <td>
                                            {{$brand->total}}
                                        </td>
                                        <td>
                                            @if(count($brand->company->company_website) > 0)
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0"
                                                    >
                                                    <i class="fa fa-eye"></i>
                                                            </span>

                                                    <!--end::Svg Icon-->
                                                </a>
                                                <!--begin::Menu-->
                                                <div
                                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    @foreach($brand->company->company_website as $site)
                                                        <div class="menu-item px-3">
                                                            <a href="{{$site['url']}}" target="_blank"
                                                               class="menu-link px-3">{{$site->website->{'name_'.$lang} }}</a>
                                                        </div>
                                                    @endforeach
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            @else
                                                <a disabled="disabled" title="{{getCustomTranslation("no_link")}}" target="_blank" type="button"
                                                   data-bs-custom-class="tooltip-inverse"
                                                   id="kt_app_layout_builder_toggle"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-dismiss="click"
                                                   data-bs-trigger="hover"
                                                   class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                >
                                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0"
                                                    >
                                                <i class="fa fa-eye"></i>
                                            </span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        @else
                            <div class="card bg-primary">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            {{getCustomTranslation('no_top_brands_in_selected_range')}}
                                        </h1>
                                        <!--end::Title-->
                                        <!--begin::Illustration-->
                                        <div
                                            class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 mb-lg-12"
                                            style="background-image:url({{ asset('dashboard/assets/media/svg/illustrations/easy/6.svg')}})"></div>
                                        <!--end::Illustration-->
                                    </div>
                                    <!--end::Heading-->

                                </div>
                                <!--end::Body-->
                            </div>
                        @endif
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tables Widget 2-->
        </div>
        <div class="col-xl-6">
            <!--begin::Tables Widget 2-->
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">{{getCustomTranslation('top_5_influencers')}}</span>

                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        @if(count($top_influencers))
                            <!--begin::Table-->
                            <table class="table align-middle gs-0 gy-5">
                                <!--begin::Table head-->
                                <thead>
                                <tr>
                                    <th ></th>
                                    <th class="p-0 min-w-100px"></th>
                                    <th class="p-0 min-w-50px">{{getCustomTranslation('mawthooq')}}</th>
                                    <th class="p-0 min-w-100px">{{getCustomTranslation('number_of_ads')}}</th>
                                    <th class="p-0 min-w-100px"> {{getCustomTranslation('influencer_size')}}</th>
                                </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                @foreach($top_influencers as $influencer)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-50px me-2">
                                                    <span class="symbol-label">
                                            <?php $image = $influencer->influencer->gender == 'Male' ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png') ?>
                                                            <?php $snapchat_avatar = $influencer->influencer->influencer_follower_platform->where('platform_id',
                                                            1)
                                                            ->first() ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $influencer->influencer->influencer_follower_platform->where('platform_id',
                                                                1)
                                                                ->first()->url . "&type=SVG&bitmoji=enable" : $image; ?>
                                                        <img src="{{$snapchat_avatar}}"
                                                             class="h-100" alt="">

                                        </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a  @can('view_influencers') href="{{route('influencer.show', $influencer->influencer->id)}}" @endcan
                                               class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$influencer->influencer->{'name_'.$lang} }}</a>
                                        </td>
                                        <td>
                                            @if($influencer->influencer->mawthooq)
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                    <path
                                                        d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                        fill="green"/>
                                                    <path
                                                        d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                        fill="white"/>
                                                </svg>
                                            </div>
                                                @endif
                                        </td>
                                        <td>
                                            {{$influencer->ad_record_count}}
                                        </td>
                                        <td>
                                                <?php $s = $influencer->influencer->influencer_follower_platform->pluck('size.name_'.$lang,
                                                'size.power')->toArray(); ?>
                                            {{$s[max(array_keys($s))]}}

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        @else
                            <div class="card bg-primary">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            {{getCustomTranslation('no_top_influencers_in_selected_range')}}
                                        </h1>
                                        <!--end::Title-->
                                        <!--begin::Illustration-->
                                        <div
                                            class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 mb-lg-12"
                                            style="background-image:url({{ asset('dashboard/assets/media/svg/illustrations/easy/6.svg')}})"></div>
                                        <!--end::Illustration-->
                                    </div>
                                    <!--end::Heading-->

                                </div>
                                <!--end::Body-->
                                @endif
                            </div>

                            <!--end::Table container-->


                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Tables Widget 2-->
            </div>
        </div>
        <!--end::Row-->

        @endsection
        @push('scripts')
            <script>
                function ShowBrands() {
                    var datere = $('#ranges').val().split("-");
                    window.open( "{{route('company.companyByid')}}?category=" + $('#category_select').val() + "&start=" + datere[0] + "&end=" + datere[1], '_blank');
                }

                function ShowAds() {
                    datere = $('#ranges').val().split(" - ");
                    date = new Date(datere[0]);
                    day = date.getDate();
                    month = date.getMonth() + 1;
                    month = month < 10 ? '0' + month : month;
                    day = day < 10 ? '0' + day : day;
                    year = date.getFullYear();
                    fullDateStart = year + '-' + month + '-' + day;
                    date = new Date(datere[1]);
                    day = date.getDate();
                    month = date.getMonth() + 1;
                    month = month < 10 ? '0' + month : month;
                    day = day < 10 ? '0' + day : day;
                    year = date.getFullYear();
                    fullDateEnd = year + '-' + month + '-' + day;
                    category = $('#category_select').val();
                    window.open( "{{route('ad_record.index')}}?category[]=" + category + "&start=" + fullDateStart + "&end=" + fullDateEnd, '_blank');

                }

                function ShowInfluencers() {

                    window.open("{{route('influencer.InfluencersByids')}}?category=" + $('#category_select').val() + "&ranges=" + datere + '&sorting=desc', '_blank');

                }

                function Showestmate() {

                    setTimeout(function () {
                        $('#estmateprice').toggle('slow');

                    }, 1000);

                    //var t=setTimeout(openPopUp,3000);
                    vieworhide = $("#vieworhide").attr('data-vieworhide');
                    if ( vieworhide == 0) {
                        $("#vieworhide").text("{{getCustomTranslation('hide')}}");
                        $("#vieworhide").attr('data-vieworhide',1)
                    } else {

                        $("#vieworhide").text("{{getCustomTranslation('view')}}");
                        $("#vieworhide").attr('data-vieworhide',0)
                    }

                }


                $(function () {
                    $('input[name="ranges"]').daterangepicker({
                        monthNames: ["Test1", "Test2", "Test3", "Test4", "Test5", "Test6", "Test7", "Test8", "Test9", "Test10", "Test11", "Test12"],
                        opens: 'left',
                        minDate:new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                        maxDate:new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}")
                    }, function (start, end, label) {
                    });

                    $('#ranges').change(function () {
                        window.location.href = "{{route('dashboard')}}?category=" + $('#category_select').val() + "&ranges=" + $('#ranges').val();

                    });
                    $('#category_select').change(function () {
                        window.location.href = "{{route('dashboard')}}?category=" + $('#category_select').val() + "&ranges=" + $('#ranges').val();
                    });
                });


            </script>
    @endpush
