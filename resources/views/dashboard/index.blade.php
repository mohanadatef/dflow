@extends('dashboard.layouts.app')

@section('content')

    <form action="{{route('home')}}" method="GET" id="filterForm">
        <div class="row" style="margin-bottom:50px;">
            <div class="col-md-4" style="display:flex;">
                <h2 class="text-white mt-2">Industry: </h2>
                &nbsp;&nbsp;&nbsp;
                <select id="category_select" name="category"
                        data-control="select2" data-placeholder="Select a category..."
                        class="form-select form-select-solid  fw-semibold">

                    @if( user()->role->role->type)
                        @foreach($client_categories['parent'] as $category)
                            <?php //$category =json_encode($category);?>
                            <optgroup label="{{$category->name_en}}">
                                <?php $onlyparent = 1; ?>
                                @foreach ($client_categories['all'] as $row)
                                    @if($category->id == $row->parent_id)
                                        <?php $onlyparent = 0; ?>
                                        @if(request('category'))
                                            <option
                                                {{$current_category->id == $row->id ? 'selected' : '' }} value="{{$row->id}}">{{$row->name_en}}</option>
                                        @else
                                            <option value="{{$row->id}}">{{$row->name_en}}</option>
                                        @endif
                                    @endif
                                @endforeach
                                @if ($onlyparent)
                                    @if(request('category'))
                                        <option
                                            {{$current_category->id == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->name_en}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->name_en}}</option>
                                    @endif
                                @endif


                            </optgroup>

                        @endforeach
                    @else
                        @foreach($client_categories as $category)
                            @if(request('category'))
                                <option
                                    value="{{$category->id}}" {{$current_category->id == $category->id ? 'selected' : '' }}>{{ $category->name_en }}</option>
                            @else
                                <option value="{{$category->id}}">{{ $category->name_en }}</option>
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

    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="javascript:ShowBrands();" class="card bg-body hoverable card-xl-stretch mb-xl-8"
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
                        {{
                            (count($number_of_brands)==0) ?'N/A' : number_format(count($number_of_brands))
                            }}
                    </div>
                    <div class="fw-semibold text-gray-400">

                        Number Of Brands
                        <span class="card-label fw-bold fs-3 mb-1 marketoverview" style="padding:5px; ">View</span>

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="javascript:ShowAds();" class="card bg-dark hoverable card-xl-stretch mb-xl-8"
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
                    <div class="fw-semibold text-gray-400">Number Of Ads
                        <span class="card-label fw-bold fs-3 mb-1" style="padding:5px; ">View</span>

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="javascript:ShowInfluencers();" class="card bg-warning hoverable card-xl-stretch mb-xl-8"
               id="kt_app_layout_builder_toggle"
               title="VIEW Influencers"
               data-bs-custom-class="tooltip-inverse"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               data-bs-dismiss="click"
               data-bs-trigger="hover"

               onmouseover="" style="cursor: pointer;"
            >
                <!--begin::Body-->
                <div class="card-body">

                    <i class="fas fa-users text-white" style="font-size:30px"></i>
                    <div class="text-white fw-bold fs-2 mb-2 mt-5">
                        {{
                            $number_of_influencers==0 ?'N/A' : number_format($number_of_influencers)
                            }}
                    </div>
                    <div class="fw-semibold text-white">Number of influencers
                        <span class="card-label fw-bold fs-3 mb-1" style="padding:5px; ">View</span>

                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="javascript:Showestmate();" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8"
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
                    <div class="fw-semibold text-gray-400">Estimated Spent
                        <span class="card-label fw-bold fs-3 mb-1" style="padding:5px; " id="vieworhide">View</span>

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
                    @include('dashboard.charts.basic_chart_price')
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
                    @include('dashboard.charts.basic_chart')
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
                        <span class="card-label fw-bold fs-3 mb-1">Top 5 Brands</span>

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
                                    <th class="p-0 min-w-150px">Ads</th>
                                </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                @foreach($top_brands as $brand)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-50px me-2">
                                    <span class="symbol-label bg-light-info">
                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                        <span class="svg-icon svg-icon-2x svg-icon-info">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                      d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                      fill="currentColor"></path>
                                                <path
                                                    d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('competitive_analysis',['company'=>$brand->company->id,'ranges'=>Request()->ranges])}}"
                                               class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$brand->company->name_en}}</a>
                                        </td>
                                        <td>
                                            {{$brand->total}}
                                        </td>
                                        <td>
                                            @if($brand->company->link)
                                                <a href="{{$brand->company->link}}" target="_blank" type="button"
                                                   class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                            @else
                                                <a disabled="disabled" title="no link" target="_blank" type="button"
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
                                            No Top Brands in selected range
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
                        <span class="card-label fw-bold fs-3 mb-1">Top 5 Influencers</span>

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
                                    <th class="p-0 w-50px"></th>
                                    <th class="p-0 min-w-150px"></th>
                                    <th class="p-0 min-w-150px"> Ads</th>
                                    <th class="p-0 min-w-150px"> influencer size</th>
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
                                            <a href="{{route('influencer.show', $influencer->influencer->id)}}"
                                               class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$influencer->influencer->name_en}}</a>
                                        </td>
                                        <td>
                                            {{$influencer->ad_record_count}}
                                        </td>
                                        <td>
                                               <?php  $s= $influencer->influencer->influencer_follower_platform->pluck('size.name_en','size.power')->toArray(); ?>
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
                                            No Top influencers in selected range
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
                    let companyids = @json($number_of_brands);
                    window.location.href = "{{route('company.companyByid')}}?companyids=" + JSON.stringify(companyids);
                }

                function ShowAds() {
                    var datere = $('#ranges').val().split("-");
                    var category = $('#category_select').val();
                    window.location.href = "{{route('ad_record.index')}}?category_from_index[]=" + category + "&start=" + datere[0] + "&end=" + datere[1];

                }

                function ShowInfluencers() {

                    window.location.href = "{{route('influencer.InfluencersByids')}}?category=" + $('#category_select').val() +  "&ranges=" + datere +'&sorting=desc';

                }

                function Showestmate() {

                    setTimeout(function () {
                        $('#estmateprice').toggle('slow');

                    }, 1000);

                    //var t=setTimeout(openPopUp,3000);

                    if ($("#vieworhide").text() == 'View') {
                        $("#vieworhide").text("Hide");

                    } else {

                        $("#vieworhide").text("View");
                    }

                }


                $(function () {
                    $('input[name="ranges"]').daterangepicker({
                        opens: 'left',
                    }, function (start, end, label) {
                    });

                    $('#ranges').change(function () {
                        document.getElementById('filterForm').submit()
                    });
                    $('#category_select').change(function () {
                        document.getElementById('filterForm').submit()
                    });
                });


            </script>
    @endpush
