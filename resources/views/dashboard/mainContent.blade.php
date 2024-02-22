<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4 mb-xl-10">
        <!--begin::Lists Widget 19-->
        <div class="card card-flush">
            <!--begin::Heading-->
            <div
                    class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                    style="background-image:url('{{ asset('dashboard') }}/assets/media/svg/shapes/top-green.png')"
                    data-theme="light">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column text-white pt-15">
                    <span class="fw-bold fs-2x mb-3">{{ $current_company->name_en }}</span>
                    <div class="fs-4 text-white">
                        <span class="opacity-75">You can download company analysis</span>
                        <span class="position-relative d-inline-block">
                            @if(user()->role->role->id == 1)
                                <a href="{{route('competitive_analysis.prepare',['company_id'=>$current_company->id, 'ranges' => request('ranges')])}}"
                                   class="link-white opacity-75-hover fw-bold d-block mb-1">by clicking here</a>
                            @else
                                <a href="{{route('competitive_analysis.view',['company_id'=>$current_company->id, 'ranges' => request('ranges')])}}"
                                   class="link-white opacity-75-hover fw-bold d-block mb-1">by clicking here</a>
                            @endif
                            <!--begin::Separator-->
                            <span
                                    class="position-absolute opacity-50 bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
                            <!--end::Separator-->
                        </span>
                        <!-- <span class="opacity-75">to view</span> -->
                    </div>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar pt-5">
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Heading-->

            <div class="card-body mt-n20">
                <!--begin::Stats-->
                <div class="mt-n20 position-relative">
                    <!--begin::Row-->
                    <div class="row g-3 g-lg-6">
                        <!--begin::Col-->
                        <div class="col-12">
                            <!--begin::Items-->
                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <!--begin::Svg Icon | path: icons/duotune/medicine/med005.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                      d="M17.9061 13H11.2061C11.2061 12.4 10.8061 12 10.2061 12C9.60605 12 9.20605 12.4 9.20605 13H6.50606L9.20605 8.40002V4C8.60605 4 8.20605 3.6 8.20605 3C8.20605 2.4 8.60605 2 9.20605 2H15.2061C15.8061 2 16.2061 2.4 16.2061 3C16.2061 3.6 15.8061 4 15.2061 4V8.40002L17.9061 13ZM13.2061 9C12.6061 9 12.2061 9.4 12.2061 10C12.2061 10.6 12.6061 11 13.2061 11C13.8061 11 14.2061 10.6 14.2061 10C14.2061 9.4 13.8061 9 13.2061 9Z"
                                                      fill="currentColor"></path>
                                                <path
                                                        d="M18.9061 22H5.40605C3.60605 22 2.40606 20 3.30606 18.4L6.40605 13H9.10605C9.10605 13.6 9.50605 14 10.106 14C10.706 14 11.106 13.6 11.106 13H17.8061L20.9061 18.4C21.9061 20 20.8061 22 18.9061 22ZM14.2061 15C13.1061 15 12.2061 15.9 12.2061 17C12.2061 18.1 13.1061 19 14.2061 19C15.3061 19 16.2061 18.1 16.2061 17C16.2061 15.9 15.3061 15 14.2061 15Z"
                                                        fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">

                                            {{  ($estimated_cost==0)?'N/A':number_format($estimated_cost) }}
                                        </span>
                                    <!--end::Number-->
                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Campaing estimated cost</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Items-->
                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin001.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                        d="M20 19.725V18.725C20 18.125 19.6 17.725 19 17.725H5C4.4 17.725 4 18.125 4 18.725V19.725H3C2.4 19.725 2 20.125 2 20.725V21.725H22V20.725C22 20.125 21.6 19.725 21 19.725H20Z"
                                                        fill="currentColor"></path>
                                                <path opacity="0.3"
                                                      d="M22 6.725V7.725C22 8.325 21.6 8.725 21 8.725H18C18.6 8.725 19 9.125 19 9.725C19 10.325 18.6 10.725 18 10.725V15.725C18.6 15.725 19 16.125 19 16.725V17.725H15V16.725C15 16.125 15.4 15.725 16 15.725V10.725C15.4 10.725 15 10.325 15 9.725C15 9.125 15.4 8.725 16 8.725H13C13.6 8.725 14 9.125 14 9.725C14 10.325 13.6 10.725 13 10.725V15.725C13.6 15.725 14 16.125 14 16.725V17.725H10V16.725C10 16.125 10.4 15.725 11 15.725V10.725C10.4 10.725 10 10.325 10 9.725C10 9.125 10.4 8.725 11 8.725H8C8.6 8.725 9 9.125 9 9.725C9 10.325 8.6 10.725 8 10.725V15.725C8.6 15.725 9 16.125 9 16.725V17.725H5V16.725C5 16.125 5.4 15.725 6 15.725V10.725C5.4 10.725 5 10.325 5 9.725C5 9.125 5.4 8.725 6 8.725H3C2.4 8.725 2 8.325 2 7.725V6.725L11 2.225C11.6 1.925 12.4 1.925 13.1 2.225L22 6.725ZM12 3.725C11.2 3.725 10.5 4.425 10.5 5.225C10.5 6.025 11.2 6.725 12 6.725C12.8 6.725 13.5 6.025 13.5 5.225C13.5 4.425 12.8 3.725 12 3.725Z"
                                                      fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{  ($total_ads==0)?'N/A':$total_ads }}</span>
                                    <!--end::Number-->
                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Total Ads</span>
                                    @if(user()->role->role->type == 1)
                                            <?php
                                            $categories = Modules\CoreData\Entities\Category::getonlybyCategoriesIdsByUserId();

                                            $search = '';
                                            foreach($categories as $row)
                                            {
                                                $search .= trim("category[]=$row&");
                                            }
                                            $search = trim($search);
                                            ?>
                                        <a href="{{route('ad_record.index', ['company_id' => $current_company->id,'start'=>$range_start->format('m/d/Y') ,'end'=>$range_end->format('m/d/Y')]).'&'.$search}}">View</a>

                                    @else
                                        <a href="{{route('ad_record.index', ['company_id' => $current_company->id,'start'=>$range_start->format('m/d/Y') ,'end'=>$range_end->format('m/d/Y')])}}">View</a>

                                    @endif
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Items-->
                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen020.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor"></path>
                                                <path opacity="0.3"
                                                      d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z"
                                                      fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">
                                            {{  ($unique_influencers ==0)?'N/A':$unique_influencers }}
                                        </span>
                                    <!--end::Number-->
                                    <div style="display:flex; justify-content:space-between">
                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-semibold fs-6">Unique Influencers</span>
                                        <!--end::Desc-->

                                        <a href="{{route('influencer.uniqueInfluencers', ['company_id' => $current_company->id,'ranges'=>$range_start->format('m/d/Y') .'-'.$range_end->format('m/d/Y')])}}">View</a>
                                    </div>

                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Stats-->
            </div>

        </div>
        <!--end::Lists Widget 19-->
    </div>
    <!--end::Col-->

    <div class="col-xl-4 mb-5 mb-xl-10">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12 mb-xl-10">
                <!--begin::List widget 20-->
                <div class="card">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Top Direct Brands</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Top brands based on ads count</span>
                        </h3>
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            @php $company = request('company') != null ? request('company') :$current_company->id  @endphp
                            <a href="{{ route('company.allBrands') . '?company=' . $company}}"
                               class="btn btn-sm btn-light">All Brands</a>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->

                    <div class="card-body pt-3">
                        @if(count($top_companies_direct) > 0)

                                <?php
                                $search = '';
                                foreach($get_cruent_categories as $row)
                                {
                                    $search .= trim("category[]=$row&");
                                }
                                $search = trim($search);
                                ?>
                                    <!--begin::Carousel-->
                            @foreach($top_companies_direct as $index => $top_company)
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-danger">
                                            {{ mb_substr(trim($top_company->name_en), 0, 1, 'utf8') }}
                                        </div>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <!--begin:Author-->
                                        <div class="flex-grow-1 me-2">
                                            <a href="{{route('competitive_analysis',['company'=>$top_company->id,'ranges'=>Request()->ranges])}}"
                                               class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $top_company->name_en}}</a>
                                            <span
                                                    class="text-muted fw-semibold d-block fs-7">{{ $top_company->ad_count }} {{Str::plural('Ad', $top_company->ad_count) }}</span>
                                        </div>
                                        <!--end:Author-->
                                        <div class="flex-grow-2 me-2">
                                            @if($top_company->link)

                                                <a href="{{$top_company->link}}" target="_blank" type="button"
                                                   class="btn btn-light btn-active-light-primary"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0"
                                                    >
                                                <i class="fa fa-eye"></i>
                                            </span>
                                                </a>
                                            @else
                                                <a disabled="disabled" title="no link" target="_blank" type="button"
                                                   data-bs-custom-class="tooltip-inverse"
                                                   id="kt_app_layout_builder_toggle"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-dismiss="click"
                                                   data-bs-trigger="hover"
                                                   class="btn btn-light btn-active-light-primary"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                >
                                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0"
                                                    >
                                                <i class="fa fa-eye"></i>
                                                        </span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="flex-grow-2 me-2">
                                        </div>
                                        <div class="flex-grow-2 me-2">
                                        </div>
                                        <div class="flex-grow-2 me-2">
                                        </div>
                                        <!--begin::Actions-->
                                        <a
                                                target="_blank"
                                                id="kt_app_layout_builder_toggle"
                                                title="View Brand Ads"
                                                data-bs-custom-class="tooltip-inverse"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-dismiss="click"
                                                data-bs-trigger="hover"
                                                onmouseover="" style="cursor: pointer;"
                                                href="{{route('ad_record.index')}}?company_id={{$top_company->id}}&start={{$range_start->format('m/d/Y')}}&end={{$range_end->format('m/d/Y')}}&{{$search}}&clientauth=1"
                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                              transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                        <path
                                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <!--begin::Actions-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-4"></div>
                                <!--end::Separator-->
                            @endforeach
                        @else
                            <div class="card bg-primary my-6" style="margin-top:-6rem;">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            No Brands were found
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
                    <!--end::Body-->
                </div>
                <!--end::List widget 20-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Row-->
    </div>
    <div class="col-xl-4 mb-5 mb-xl-10">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12 mb-xl-10">
                <!--begin::List widget 20-->
                <div class="card">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Top Indirect Brands</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Top brands based on ads count</span>
                        </h3>
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            @php $company = request('company') != null ? request('company') :$current_company->id  @endphp
                            <a href="{{ route('company.allBrands') . '?company=' . $company}}"
                               class="btn btn-sm btn-light">All Brands</a>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->

                    <div class="card-body pt-3">
                        @if(count($top_companies_indirect) > 0)

                                <?php
                                $search = '';
                                foreach($get_cruent_categories as $row)
                                {
                                    $search .= trim("category[]=$row&");
                                }
                                $search = trim($search);
                                ?>
                                    <!--begin::Carousel-->
                            @foreach($top_companies_indirect as $index => $top_company)
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-danger">
                                            {{ mb_substr(trim($top_company->name_en), 0, 1, 'utf8') }}
                                        </div>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                        <!--begin:Author-->
                                        <div class="flex-grow-1 me-2">
                                            <a href="{{route('competitive_analysis',['company'=>$top_company->id,'ranges'=>Request()->ranges])}}"
                                               class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $top_company->name_en}}</a>
                                            <span
                                                    class="text-muted fw-semibold d-block fs-7">{{ $top_company->ad_count }} {{Str::plural('Ad', $top_company->ad_count) }}</span>
                                        </div>
                                        <!--end:Author-->
                                        <div class="flex-grow-2 me-2">
                                            @if($top_company->link)

                                                <a href="{{$top_company->link}}" target="_blank" type="button"
                                                   class="btn btn-light btn-active-light-primary"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0"
                                                    >
                                                <i class="fa fa-eye"></i>
                                            </span>
                                                </a>
                                            @else
                                                <a disabled="disabled" title="no link" target="_blank" type="button"
                                                   data-bs-custom-class="tooltip-inverse"
                                                   id="kt_app_layout_builder_toggle"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-dismiss="click"
                                                   data-bs-trigger="hover"
                                                   class="btn btn-light btn-active-light-primary"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                >
                                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0"
                                                    >
                                                <i class="fa fa-eye"></i>
                                                        </span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="flex-grow-2 me-2">
                                        </div>
                                        <div class="flex-grow-2 me-2">
                                        </div>
                                        <div class="flex-grow-2 me-2">
                                        </div>
                                        <!--begin::Actions-->
                                        <a
                                                target="_blank"
                                                id="kt_app_layout_builder_toggle"
                                                title="View Brand Ads"
                                                data-bs-custom-class="tooltip-inverse"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-dismiss="click"
                                                data-bs-trigger="hover"
                                                onmouseover="" style="cursor: pointer;"
                                                href="{{route('ad_record.index')}}?company_id={{$top_company->id}}&start={{$range_start->format('m/d/Y')}}&end={{$range_end->format('m/d/Y')}}&{{$search}}&clientauth=1"
                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                              transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                        <path
                                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <!--begin::Actions-->
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-4"></div>
                                <!--end::Separator-->
                            @endforeach
                        @else
                            <div class="card bg-primary my-6" style="margin-top:-6rem;">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            No Brands were found
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
                    <!--end::Body-->
                </div>
                <!--end::List widget 20-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Row-->
    </div>

</div>
<div class="row ">
    <!--begin::Col-->
    <div class="col-xl-12 mb-xl-12">
        <div class="col-xl-12 mb-12 mb-xl-12">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <!--begin::Col-->
                <div class="col-xl-12 mb-xl-10">
                    <!--begin::List widget 20-->
                    <div class="card">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Influencers Insights</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Top Influencers :</span>
                            </h3>
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-6">
                            @if(count($influencers) > 0)
                                <!--begin::Carousel-->
                                @foreach($influencers as $influencer)
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack" style="height: 80px;">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px me-4">
                                            <a class="d-block overlay h-100" data-fslightbox="lightbox-hot-sales"
                                               href="#"
                                               style="pointer-events: none; cursor: default;">
                                                <!--begin::Image-->


                                                <div
                                                        class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-200px h-100"
                                                        style="background-image:url('{{ $influencer->image ? getFile( $influencer->image->file??null,pathType()['ip'],getFileNameServer( $influencer->image)) : $influencer->snapchat_avatar }}');    width: 50px;
                                                  background-size: contain;"></div>
                                                <!--end::Image-->
                                                <!--begin::Action-->
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="bi bi-eye-fill fs-2x text-white"></i>
                                                </div>
                                                <!--end::Action-->
                                            </a>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                            <!--begin:Author-->
                                            <div class="col-lg-2">
                                                <div class="flex-grow-1 ">
                                                    <a href="{{ route('influencer.show',[$influencer->id])}}"
                                                       class="text-gray-800 text-hover-primary fs-6 fw-bold">{{  $influencer->name_en}}</a>
                                                    <span
                                                            class="text-muted fw-semibold d-block fs-7">{{ $influencer->ad_count }} {{Str::plural('Ad', $influencer->ad_count) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="flex-grow-1 ">
                                                    @foreach($influencer->category as $category)
                                                        {{$category->name_en}},
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="flex-grow-1 ">
                                                    {{$influencer->gender}}
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="flex-grow-1 ">
                                                    {{ $influencer->country ? $influencer->country->name_en : '' }}
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="flex-grow-1 ">
                                                    @if($influencer->platform->count() > 0)

                                                        @foreach($influencer->influencer_service_platform as $follower)
                                                            <!--begin::Item-->
                                                            <!--begin::Symbol-->
                                                            <div class="symbol symbol-50px me-4">
                                                            <span class="symbol-label">
                                                                <a href="{{urlType()[$follower->platform_id].$follower->url}}"
                                                                   target="_blank"
                                                                   class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                                                <img style="width:40px"
                                                                     src="{{ asset('dashboard/assets/media/svg/social-logos/' . Str::lower($follower->platform->name_en) . '.svg') }}"/>
                                                                </a>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            </div>
                                                            <!--end::Symbol-->


                                                            <!--end::Item-->
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <!--end::Section-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed"></div>
                                    <!--end::Separator-->
                                @endforeach
                            @else
                                <div class="card bg-primary my-6" style="margin-top:-6rem;">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex flex-column">
                                        <!--begin::Heading-->
                                        <div class="m-0">
                                            <!--begin::Title-->
                                            <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                                No influencer were found
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
                        <!--end::Body-->
                    </div>
                    <!--end::List widget 20-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->
        </div>

    </div>
</div>
<!--begin::Row-->
<div class="row g-5 g-xl-8">
    <div class="col-xl-12">
        <!--begin::Tables Widget 2-->
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Discount</span>
                    <!-- <span class="text-muted mt-1 fw-semibold fs-7">Top 5 Brands based on selected category ...</span> -->
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body ">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <figure class="">
                        @if($discount_cloud)
                            @include('dashboard.charts.discount_cloud')
                        @else
                            <!-- <p class="text-center" style="margin:100px 0; font-size:32px">No Current Data ...</p> -->
                            <div class="card bg-primary my-6" style="margin-top:-6rem;">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            No Current data
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
                    </figure>
                </div>
                <!--end::Table container-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Tables Widget 2-->
    </div>
    <div class="col-xl-12">
        <!--begin::Tables Widget 2-->
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Promoted Products</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <figure class="">
                        @if($promoted_products_cloud)
                            @include('dashboard.charts.promoted_products')
                        @else
                            <div class="card bg-primary my-6" style="margin-top:-6rem;">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            No Current data
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
                    </figure>
                </div>
                <!--end::Table container-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Tables Widget 2-->
    </div>
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row g-5 g-xl-8">
    <div class="col-xl-6">
        <!--begin::Tables Widget 2-->
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Ad Type</span>
                    <!-- <span class="text-muted mt-1 fw-semibold fs-7">Top 5 Brands based on selected category ...</span> -->
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    @if(count($ad_type_chart) !== 0)
                        @include('dashboard.charts.ad_type_chart')
                    @else
                        <div class="card bg-primary my-6" style="margin-top:-6rem;">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column">
                                <!--begin::Heading-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                        No Current data
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
                    <span class="card-label fw-bold fs-3 mb-1">Promotion Type</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    @if(count($promotion_type_chart))
                        @include('dashboard.charts.promotion_type_chart')
                    @else
                        <div class="card bg-primary my-6" style="margin-top:-6rem;">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column">
                                <!--begin::Heading-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                        No Current data
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
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row g-5 g-xl-8">
    <div class="col-xl-12">
        <!--begin: Statistics Widget 6-->
        <div class="card card-xl-stretch mb-xl-12">
            <!--begin::Body-->
            <div class="card-body my-3">
                @include('dashboard.charts.ads_count_chart')
            </div>
            <!--end:: Body-->
        </div>
        <!--end: Statistics Widget 6-->
    </div>
    <!--begin::Row-->
    <div class="row g-10">
        <!--begin::Col-->
        <div class="col-md-4">
            @include('dashboard.charts.influencer_size')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-4">
            @include('dashboard.charts.influencer_gender')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-4">
            @include('dashboard.charts.content_category')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Row-->


