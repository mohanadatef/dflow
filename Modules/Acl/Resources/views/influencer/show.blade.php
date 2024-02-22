@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer') . getCustomTranslation('details'))

@section('content')

    <script>
        let themeModeLogo;
        const defaultThemeMode = "system";
        const name = document.body.getAttribute("data-kt-name");
        let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");

        if (themeMode === null) {
            if (defaultThemeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            } else {
                themeMode = defaultThemeMode;
            }
            themeModeLogo = themeMode;
        }
    </script>
    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            /* position: absolute; */
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-xxl-6">
                <!--begin::Card widget 15-->
                <div class="card card-flush h-xl-60">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <!--begin::Row-->
                        <div class="row gx-9 h-60">
                            <!--begin::Col-->
                            <div class="col-sm-6 mb-10 mb-sm-0">
                                <!--begin::Overlay-->
                                <a class="d-block overlay h-100" data-fslightbox="lightbox-hot-sales" href="#"
                                   style="pointer-events: none; cursor: default;">
                                    <!--begin::Image-->
                                    <?php $image = $data->gender == 'Male' ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png') ?>
                                    <?php $snapchat_avatar = $data->influencer_follower_platform->where('platform_id',
                                        1)
                                        ->first() ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $data->influencer_follower_platform->where('platform_id',
                                            1)->first()->url . "&type=SVG&bitmoji=enable" : $image; ?>

                                    <div
                                            class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-200px h-100"
                                            style="background-image:url('{{$data->image ? getFile($data->image->file??null,pathType()['ip'],getFileNameServer($data->image)) : $snapchat_avatar }}')"></div>
                                    <!--end::Image-->
                                    <!--begin::Action-->
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                        <i class="bi bi-eye-fill fs-2x text-white"></i>
                                    </div>
                                    <!--end::Action-->
                                </a>
                                <!--end::Overlay-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-sm-6">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column h-100">
                                    <!--begin::Header-->
                                    <div class="mb-7">
                                        <!--begin::Title-->
                                        <div class="mb-6">
                                            @can('update_influencers')
                                                <span
                                                        class="text-gray-400 fs-7 fw-bold me-2 d-block lh-1 pb-1">{{getCustomTranslation('id')}}: {{ $data->id }}</span>
                                            @endcan
                                            <a href="{{ route('influencer.show', $data->id) }}"
                                               class="text-gray-800 text-hover-primary fs-1 fw-bold">{{ $data->{'name_'.$lang} }}</a> @if($data->mawthooq)
                                                <span title="{{$data->mawthooq_license ? getCustomTranslation('view') : getCustomTranslation('no_mawthooq_license')}}"
                                                      data-bs-custom-class="tooltip-inverse"
                                                      data-bs-toggle="tooltip"
                                                      onclick="openMawthooq()"
                                                      data-bs-placement="top"
                                                      data-bs-dismiss="click" style="cursor: pointer;"
                                                      data-bs-trigger="hover"
                                                      onmouseover="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                         viewBox="0 0 24 24">
                                                        <path
                                                                d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                                fill="green"/>
                                                        <path
                                                                d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                                fill="white"/>
                                                    </svg>
                                                                                                                                              </span>
                                            @endif
                                            @if($data->mawthooq)
                                                <span class="text-gray-400 fs-7 fw-bold me-2 d-block lh-1 pb-1">{{$data->mawthooq_license_number}}</span>
                                            @else
                                                <span class="text-danger-400 fs-7 fw-bold me-2 d-block lh-1 pb-1"
                                                      style="color: red">{{getCustomTranslation('empty_mawthooq_license_number')}}</span>
                                            @endif
                                        </div>
                                        <!--end::Title-->

                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="mb-5 px-9">
                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Section-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Icon-->
                                                <div class="symbol symbol-40px me-4">
                                                    <div
                                                            class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">
                                                        C
                                                    </div>
                                                </div>
                                                <!--end::Icon-->
                                                <!--begin::Section-->
                                                <div class="flex-grow-1">
                                                    <a
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">{{ implode(',',$data->country->pluck('name_'.$lang)->toArray())}}</a>
                                                    <span class="text-gray-400 fw-semibold d-block fs-6">{{getCustomTranslation('country')}}</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed my-4"></div>
                                        <!--end::Separator-->
                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Section-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Icon-->
                                                <div>
                                                    <i class="fa-solid fa-person-half-dress"
                                                       style="font-size: 32px;color: green;margin-right: 28px;margin-left: 10px;"></i>
                                                </div>
                                                <!--end::Icon-->
                                                <!--begin::Section-->
                                                <div class="flex-grow-1">
                                                    <a href="#"
                                                       class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">{{ getCustomTranslation($data->gender)}}</a>
                                                    <span class="text-gray-400 fw-semibold d-block fs-6">{{getCustomTranslation('gender')}}</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Section-->

                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed my-4"></div>

                                        <!--end::Separator-->
                                    </div>
                                    <!--end::Body-->
                                    <!--begin::Footer-->

                                    <div class="d-flex flex-stack mt-auto bd-highlight">
                                        <!--begin::Actions-->
                                        @can('update_influencers')
                                            <a href="{{route('influencer.edit', $data->id)}}"
                                               class="btn btn-primary btn-sm flex-shrink-0 me-3 w-10">{{getCustomTranslation('edit')}}</a>
                                        @endcan
                                        <a href="javascript:;"
                                           class="btn btn-light btn-active-light-primary btn-sm flex-shrink-0 me-3 w-10"
                                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                           onclick="copyContactN({{$data->contact_number}})"
                                           title="{{$data->contact_number ?? getCustomTranslation('no_contact_number')}}"
                                           data-bs-custom-class="tooltip-inverse"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-dismiss="click"
                                           data-bs-trigger="hover"
                                           onmouseover="" style="cursor: pointer;">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                            <svg aria-hidden="true" focusable="false" class="icon" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512" width="1em" height="1em"><!-- Font Awesome Free 5.15.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path
                                        d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"/></svg>
                                                </svg>
                        </span>
                                            <!--end::Svg Icon--></a>
                                        <a href="javascript:;"
                                           class="btn btn-light btn-active-light-primary btn-sm flex-shrink-0 me-3 w-10"
                                           title="{{$data->bio ? getCustomTranslation('view') : getCustomTranslation('no_bio')}}"
                                           data-bs-custom-class="tooltip-inverse"
                                           data-bs-toggle="tooltip"
                                           onclick="openBio()"
                                           data-bs-placement="top"
                                           data-bs-dismiss="click"
                                           data-bs-trigger="hover" style="cursor: pointer;"
                                           onmouseover="" data-kt-menu-trigger="click"
                                           data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
    <rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
    <rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)" fill="currentColor"/>
</svg>


                        </span>
                                            <!--end::Svg Icon--></a>
                                        <a href="javascript:;"
                                           class="btn btn-light btn-active-light-primary btn-sm flex-shrink-0 me-3 w-10"
                                           title="{{$data->contact_email ?? getCustomTranslation('no_contact_email')}}"
                                           onclick="copyContactE('{{$data->contact_email}}')"
                                           data-bs-custom-class="tooltip-inverse"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-dismiss="click"
                                           data-bs-trigger="hover"
                                           onmouseover="" style="cursor: pointer;"
                                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">

<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path opacity="0.3"
          d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
          fill="currentColor"/>
    <path
            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
            fill="currentColor"/>
</svg>

                        </span>
                                            <!--end::Svg Icon--></a>
                                        <!--end::Actions-->
                                    </div>

                                    <!--end::Footer-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 15-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 col-xxl-6">
                <!--begin::Card widget 14-->
                <div class="col-sm-12 col-xl-2" style="width:100%; margin-top:6rem">
                    <div class="me-md-5">
                        @if($data->influencer_follower_platform->count())

                            @foreach($data->influencer_follower_platform as $follower)

                                <!--begin::Item-->
                                <div class="d-flex border border-gray-300 border-dashed rounded p-4 mb-6"
                                     @if(!$loop->first) style="margin-top:-8px" @endif>
                                    <!--begin::Block-->
                                    <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label">

                                            <img style="width:40px"
                                                 src="{{ asset('dashboard/assets/media/svg/social-logos/' . Str::lower($follower->platform->name_en) . '.svg') }}"/>
                                            <!--end::Svg Icon-->
                                        </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Section-->
                                        <div class="me-2">
                                            <a href="{{urlType()[$follower->platform_id].$follower->url}}"
                                               target="_blank"
                                               class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $follower->platform->{'name_'.$lang} }}</a>
                                            <span class="text-gray-400 fw-bold d-block fs-7">{{getCustomTranslation('show_number_of_followers_in_platform')}}</span>
                                        </div>
                                        <!--end::Section-->
                                    </div>
                                    <!--end::Block-->
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">

                                        {{  ($follower->followers ==0)?'N/A':$follower->followers }}


                                        <span class="badge badge-lg badge-light-success align-self-center px-2">{{getCustomTranslation('followers')}}</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Item-->
                            @endforeach

                        @else
                            <div class="card bg-danger" style="margin-top:-6rem">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Heading-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                            {{getCustomTranslation('influencer_doesnt_have_platforms_registered')}}
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
                </div>
                <!--end::Card widget 14-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-10">
            <div class="col-xl-12">
                <!--begin::Table Widget 5-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Card header-->
                    <div class="card-header py-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{getCustomTranslation('influencer_insight')}}</span>
                            <span
                                    class="text-gray-400 mt-1 fw-semibold fs-6">{{getCustomTranslation('data_is_dependant_on_the_date_range')}}...</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Actions-->
                        <div class="card-toolbar">
                            <!--begin::Filters-->
                            <div class="d-flex flex-stack flex-wrap gap-4">
                                <input type="text" id="rang_data_analysis" name="rang_data_analysis"
                                       value="{{request()->rang_data_analysis}}"
                                       class="form-select mb-3 mb-lg-0"/>
                            </div>
                            <!--begin::Filters-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Card header-->

                </div>
                <!--end::Table Widget 5-->
            </div>
        </div>
        <!-- End::Row -->

        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xl-6">

                <div class="card bg-light mb-18 ">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-center">
                            <!--begin::Items-->
                            <div class="d-flex justify-content-center mb-10 mx-auto w-xl-900px">

                                <!--begin::Item-->
                                <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-2">
                                    <!--begin::Content-->
                                    <div class="text-center">
                                        <!--begin::Symbol-->
                                        <!--begin::Svg Icon | path: icons/duotune/graphs/gra008.svg-->
                                        <span class="svg-icon svg-icon-2tx svg-icon-success">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M13 10.9128V3.01281C13 2.41281 13.5 1.91281 14.1 2.01281C16.1 2.21281 17.9 3.11284 19.3 4.61284C20.7 6.01284 21.6 7.91285 21.9 9.81285C22 10.4129 21.5 10.9128 20.9 10.9128H13Z"
                                                fill="currentColor"></path>
                                        <path opacity="0.3"
                                              d="M13 12.9128V20.8129C13 21.4129 13.5 21.9129 14.1 21.8129C16.1 21.6129 17.9 20.7128 19.3 19.2128C20.7 17.8128 21.6 15.9128 21.9 14.0128C22 13.4128 21.5 12.9128 20.9 12.9128H13Z"
                                              fill="currentColor"></path>
                                        <path opacity="0.3"
                                              d="M11 19.8129C11 20.4129 10.5 20.9129 9.89999 20.8129C5.49999 20.2129 2 16.5128 2 11.9128C2 7.31283 5.39999 3.51281 9.89999 3.01281C10.5 2.91281 11 3.41281 11 4.01281V19.8129Z"
                                              fill="currentColor"></path>
                                    </svg>
                                </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="mt-1">
                                            <!--begin::Animation-->
                                            <div
                                                    class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                                <div class="min-w-50px counted" data-kt-countup="true"
                                                     data-kt-countup-value="80"
                                                     data-kt-initialized="1">{{
                                                      ($data->ad==0)?'N/A':$data->ad
                                                     }}</div>
                                            </div>
                                            <!--end::Animation-->
                                            <!--begin::Label-->
                                                <?php
                                                $search = '';
                                                foreach($data->category_all as $row)
                                                {
                                                    $search .= trim("category[]=$row&");
                                                }
                                                $search = trim($search);
                                                ?>
                                            @if($data->ad==0)
                                                <span class="text-gray-600 fw-semibold fs-5 lh-0"
                                                      id="kt_app_layout_builder_toggle"
                                                      title="{{getCustomTranslation('there_are_no_ads')}}"
                                                      data-bs-custom-class="tooltip-inverse"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-placement="top"
                                                      data-bs-dismiss="click"
                                                      data-bs-trigger="hover"
                                                      onmouseover="" style="cursor: pointer;">
                                          {{getCustomTranslation('ads')}}
                                         </span>
                                            @else
                                                <span class="text-gray-600 fw-semibold fs-5 lh-0"
                                                      onclick="redirectads()"
                                                      id="kt_app_layout_builder_toggle"
                                                      title="{{getCustomTranslation('view_industry_ads')}}"
                                                      data-bs-custom-class="tooltip-inverse"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-placement="top"
                                                      data-bs-dismiss="click"
                                                      data-bs-trigger="hover"
                                                      onmouseover="" style="cursor: pointer;"
                                                >

                                           {{getCustomTranslation('ads')}}
                                         </span>
                                            @endif


                                            <!--end::Label-->
                                        </div>
                                        <!--end::Text-->

                                    </div>
                                    <!--end::Content-->

                                </div>
                                <!--end::Item-->


                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Testimonial-->
                        <div class="fs-2 fw-semibold text-muted text-center mb-3">
                            <span class="fs-1 lh-1 text-gray-700"></span>{{getCustomTranslation('number_of_captured_ads')}}
                            <br>
                            <span class="text-gray-700 me-1">
                    {{getCustomTranslation('in_specified_date_range')}}
                </span>
                            <span class="fs-1 lh-1 text-gray-700"></span></div>
                        <!--end::Testimonial-->
                    </div>
                    <!--end::Body-->
                </div>

            </div>
            <!--end::Col-->


            <div class="col-xl-6">
                <div class="card card-flush">
                    <!--begin::Header-->
                    <div class="card-header ">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800"> {{getCustomTranslation('frequently_advertised_brands')}}</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6"> {{getCustomTranslation('display')}}</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar"></div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2">
                        <!--begin::Items-->
                        <div class="" style="overflow: scroll;height: 250px;">
                            @if(count($data->adDetails))
                                @foreach($data->adDetails as $key => $value)

                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-5">
                                            <!--begin::Flag-->
                                            <img src="{{asset('dashboard/assets/media/svg/brand-logos/atica.svg')}}"
                                                 class="me-4 w-30px" style="border-radius: 4px" alt="">
                                            <!--end::Flag-->
                                            <!--begin::Content-->
                                            <div class="me-5">
                                                <!--begin::Title-->

                                                @can('competitive_analysis_page')
                                                    <a href="javascript:redirect_competitive({{$value[1]}});"
                                                       id="kt_app_layout_builder_toggle"
                                                       title="{{getCustomTranslation('view_brand_page')}}"
                                                       data-bs-custom-class="tooltip-inverse"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       data-bs-dismiss="click"
                                                       data-bs-trigger="hover"

                                                       class="text-gray-800 fw-bold text-hover-primary fs-6">{{ $key }}</a>
                                                @else
                                                    <a href="#"
                                                       class="text-gray-800 fw-bold text-hover-primary fs-6">{{ $key }}</a>
                                                @endcan


                                                <!--end::Title-->
                                                <!--begin::Desc-->
                                                <!-- <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Community</span> -->
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Wrapper-->
                                        <div class="d-flex align-items-center"
                                             id="kt_app_layout_builder_toggle"
                                             title="{{getCustomTranslation('view_ads')}}"
                                             data-bs-custom-class="tooltip-inverse"
                                             data-bs-toggle="tooltip"
                                             data-bs-placement="top"
                                             data-bs-dismiss="click"
                                             data-bs-trigger="hover"
                                             onclick="redirect_adrecords({{$value[1]}}, <?php echo json_encode($value[2]); ?>);">
                                            <!--begin::Number-->
                                            <span class="text-gray-800 fw-bold fs-4 me-3" onmouseover=""
                                                  style="cursor: pointer;">{{ $value[0] }}


                                                </span>
                                            <!--end::Number-->
                                            <!--begin::Info-->
                                            <div class="m-0">
                                                <!--begin::Label-->
                                                <span class="badge badge-light-success fs-base">
                                            {{getCustomTranslation('ad')}}
                                            </span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-3"></div>
                                    <!--end::Separator-->

                                @endforeach
                            @else
                                <div class="card bg-success ">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex flex-column my-11">
                                        <!--begin::Heading-->
                                        <div class="m-0">
                                            <!--begin::Title-->
                                            <h3 class="fw-semibold text-white text-center lh-lg mb-5">
                                                {{getCustomTranslation('no_ad_details_to_display')}}
                                            </h3>
                                            <!--end::Title-->
                                            <!--begin::Illustration-->
                                            <div
                                                    class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-100px mh-200px my-5"
                                                    style="background-image:url({{ asset('dashboard/assets/media/svg/illustrations/easy/6.svg')}})"></div>
                                            <!--end::Illustration-->
                                        </div>
                                        <!--end::Heading-->

                                    </div>
                                    <!--end::Body-->
                                </div>
                            @endif
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end: Card Body-->
                </div>
            </div>

            <!--begin::Col-->

            <!--end::Col-->
        </div>
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xl-12">
                <div class="card card-flush">
                    @if(count($data->category_ad))

                            <?php
                            foreach($data->category_ad as $key => $value)
                            {
                                $content_category['keys'][] = $key;
                                $content_category['values'][] = $value;
                            }
                            ?>
                        @include('acl::influencer.chart.pie-chart',['category_ad'=>$data->category_ad])
                    @else
                        <div class="card bg-primary py-9">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column">
                                <!--begin::Heading-->
                                <div class="m-0">
                                    <!--begin::Title-->
                                    <h1 class="fw-semibold text-white text-center lh-lg mb-5">
                                        {{getCustomTranslation('no_category_ads_to_display')}}
                                    </h1>
                                    <!--end::Title-->
                                    <!--begin::Illustration-->
                                    <div
                                            class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 mb-lg-12"
                                            style="background-image:url({{ asset('dashboard/assets/media/auth/chart-graph-dark.png')}}); background-size:cover;"></div>
                                    <!--end::Illustration-->
                                </div>
                                <!--end::Heading-->

                            </div>
                            <!--end::Body-->
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Col-->
            <!--begin::Col-->

            <!--end::Col-->
        </div>
        <br>
        <!--end::Row-->


        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-10">
            <div class="col-xl-12">
                <div class="card card-xl-stretch mb-xl-12">
                    <!--begin::Header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800"> {{getCustomTranslation('latest_ads')}}</span>
                            <span
                                    class="text-gray-400 mt-1 fw-semibold fs-6">{{getCustomTranslation('we_found')}} {{($data->ad_record->count()==0)?'N/A':$data->ad_record->count()}} {{getCustomTranslation('ads')}}</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-3 pb-4">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed align-center gs-0 gy-4 my-0">
                                <!--begin::Table head-->
                                <thead>
                                <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                    <th class="p-0 w-200px">{{getCustomTranslation('date')}}</th>
                                    <th class="p-0">{{getCustomTranslation('company')}}</th>
                                    <th class="p-0">{{getCustomTranslation('promoted_products')}}</th>
                                    <th class="p-0">{{getCustomTranslation('category')}}</th>
                                    <th class="p-0 min-w-225px">{{getCustomTranslation('ad_type')}}</th>
                                </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    <?php
                                    $addrecordes = $data->ad_record()->limit(5)->orderby('date', 'desc')->get()
                                    ?>
                                @foreach($addrecordes as $ad)
                                        <?php $catgoriesstring = '';
                                        $allaray = [];
                                        $usecatgory = 0;
                                        if($userType == 0)
                                        {
                                            $usecatgory = 1;
                                        }
                                        ?>
                                    @foreach($ad->category as $category)
                                            <?php
                                            $catgoriesstring .= $category->{'name_' . $lang};
                                            array_push($allaray, $category->id);
                                            ?>

                                        @if(!$loop->last)
                                                <?php $catgoriesstring .= ','; ?>
                                        @endif
                                    @endforeach
                                    @foreach ($allaray as $row)
                                        @if (in_array($row, $data->clientcategory))

                                                <?php $usecatgory = 1; ?>
                                        @endif
                                    @endforeach

                                    <tr onclick="showads({{$ad->id}},{{$usecatgory}})"
                                        onmouseover="" style="cursor: pointer;"
                                    >
                                        <td class="text-gray-800 fw-bold d-block mb-1 fs-6">

                                            {{ Carbon\Carbon::parse($ad->date)->format('M d, Y') }}

                                        </td>
                                        <td class="text-gray-800 fw-bold text-hover-primary">
                                            <span>{{$ad->company->{'name_'.$lang} ?? "" }}</span>
                                        </td>
                                        <td>
                                            <span
                                                    class="text-gray-800 fw-bold text-hover-primary d-block mb-1 fs-6">{{$ad->promoted_products ? $ad->promoted_products : '-'}}</span>
                                        </td>
                                        <td class="text-gray-800 fw-bold text-hover-primary">
                                            {{$catgoriesstring}}

                                        </td>
                                        <td class="text-gray-800 fw-bold text-hover-primary">
                                            @if($ad->service)
                                                {{implode(',',$ad->service->pluck('name_'.$lang)->toArray()) }}
                                            @endif
                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end: Card Body-->
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="kt_modal_showads" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('unauthorized_access')}}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close"
                         onclick="closemodel()">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                  rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                  transform="rotate(45 7.41422 6)" fill="currentColor"/>
                        </svg>
                    </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-5">

                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <div class="row">

                            <label class="fs-5 fw-bold form-label mb-2">
                                {{getCustomTranslation('sorry_you_are_not_authorized_to_access_this_ad')}}
                            </label>


                        </div>
                        <!--end::Label-->
                        <!--begin::Input-->

                        <!--end::Input-->
                    </div>

                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_bio" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->

                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->

                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                             data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                             data-kt-scroll-max-height="auto"
                             data-kt-scroll-dependencies="#kt_modal_add_role_header"
                             data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{$data->bio}}
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->

                        <!--end::Actions-->

                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_mawthooq_license" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->

                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->

                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_role_header"
                         data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                           <img src="{{getFile($data->mawthooq_license->file??null,pathType()['ip'],getFileNameServer($data->mawthooq_license)) }}">
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->

                    <!--end::Actions-->

                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
@push('scripts')

    <script>
        function closemodel() {
            $('#kt_modal_showads').modal('toggle');
        }

        function showads(ads_id, usecatgory) {

            if (usecatgory == 1) {
                window.location.href = "{{url('record/ad_record')}}/" + ads_id;
            } else {
                $('#kt_modal_showads').modal('toggle');
            }


        }

        function redirectads() {
            var datere = $('#rang_data_analysis').val().split("-");
            var fullurl = "{{route('ad_record.index')}}?influencer_id[]=" + "{{$data->id}}&{{$search}}&start=" + datere[0] + "&end=" + datere[1];
            var url = fullurl.replace(/&amp;/g, '&');
            window.open(
                url,
                '_blank' // <- This is what makes it open in a new window.
            );

        }

        function redirect_competitive(company_id) {
            window.location.href = "{{route('reports.competitive_analysis')}}?company=" + company_id + "&ranges=" + $('#rang_data_analysis').val();

        }

        function redirect_adrecords(company_id, categories) {

            var datere = $('#rang_data_analysis').val().split("-");

            window.location.href = "{{route('ad_record.index')}}?company_id=" + company_id + "&influencer_id[]=" + "{{$data->id}}&category[]=" + categories + "&start=" + datere[0] + "&end=" + datere[1];
        }

        var route = "{{ route('influencer.index') }}";
        $('input[name="rang_data_analysis"]').daterangepicker({
            minDate: new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
            maxDate: new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
        });
        $('#rang_data_analysis').change(function () {
            window.location.href = "{{route('influencer.show',['id'=>$data->id])}}?rang_data_analysis=" + $(this).val();
        });
        async function copyContactN(text) {
            await navigator.clipboard.writeText(text);
            Swal.fire({
                position: 'center-center',
                icon: 'success',
                title: text,
                footer: "{{getCustomTranslation('copied_successfully')}}",
                showConfirmButton: false,
                timer: 1500
            })
        }
        async function copyContactE(text1) {
            await navigator.clipboard.writeText(text1);
            Swal.fire({
                position: 'center-center',
                icon: 'success',
                title: text1,
                footer: "{{getCustomTranslation('copied_successfully')}}",
                showConfirmButton: false,
                timer: 1500
            })
        }
        function openBio()
        {
            $('#kt_bio').modal('toggle');
        }
        function openMawthooq()
        {
            $('#kt_mawthooq_license').modal('toggle');
        }
    </script>

@endpush
