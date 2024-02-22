@extends('dashboard.layouts.app')

@section('title',getCustomTranslation( 'ad_record'))
@push('styles')
    <style>
        .sub-dev-menu {
            padding: 20px 40px;
            background: #31186f;
            border-radius: 50px;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid mt-20" id="kt_content" style="margin-top:35px !important ">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Row-->
            @if($userLogin->can('update_ad_record'))
                <h5 class="h3 mb-20 text-white"> {{getCustomTranslation('ad_id')}}: {{ $data->id }}</h5>
            @endif
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">

                @if(count($data->ad_record_errors->where('action',0)) > 0)
                    <div class="card mb-5 mb-xl-10">
                        @if($userLogin->id == $data->user_id || user()->can('create_errors_ad_record'))
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span >{{getCustomTranslation('ads_errors')}}</span>
                            </label>
                            @foreach($data->ad_record_errors->where('action',0) as $error)
                                <div class="row">
                                    <div class="col-md-6"><p>{{ $error->created_by['name'] }} Created an error that
                                            says : {{$error->message}} ,
                                            Created at : {{$error->created_at}}</p></div>
                                    <div class="col-md-6">
                                        <div class="col-2">
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                               data-kt-menu-trigger="click"
                                               data-kt-menu-placement="bottom-end">{{getCustomTranslation('actions')}}
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                    fill="currentColor"/>
                        </svg>
                    </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--begin::Menu-->
                                            <div
                                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">

                                                    <a id="create-error"
                                                       href="{{route('ad_record.edit', $data->id)}}"
                                                       class="menu-link px-3">{{getCustomTranslation('solve_error')}}</a>
                                                    <a id="create-error"
                                                       href="{{route('ad_record_errors.cancel') .'?error_id='. $error->id}}"
                                                       class="menu-link px-3">{{getCustomTranslation('cancel_error')}}</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif

                <div class="sub-dev-menu">
                    <div class="row">
                        <div class="col-3">{{getCustomTranslation('influncer')}} : {{ $data->influencer->{'name_'.$lang} }}</div>
                        <div class="col-2">{{getCustomTranslation('brand')}} : {{ $data->company->{'name_'.$lang} }}</div>
                        <div class="col-3">{{getCustomTranslation('ad_category')}} : @forelse ($data->category as $category)
                                {{ $category->{'name_'.$lang} }}
                            @empty
                                N/A
                            @endforelse</div>
                        <div class="col-2">{{getCustomTranslation('date')}} : {{ $data->date }}</div>
                        @canany('update_ad_record','delete_ad_record','log_ad_record')
                            <div class="col-2">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{getCustomTranslation('actions')}}
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                    fill="currentColor"/>
                        </svg>
                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Menu-->
                                <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    @can('update_ad_record')
                                    <div class="menu-item px-3">
                                        <a href="{{route('ad_record.edit',$data->id)}}"
                                           class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                    </div>
                                    @endcan
                                    @can('delete_ad_record')
                                    <div class="menu-item px-3">
                                        <a href="#" onclick="deleteAc()"
                                           class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                                    </div>
                                    @endcan
                                    @can('create_errors_ad_record')
                                    <div class="menu-item px-3">
                                        <a id="create-error" href="#" onclick="getTimbrallyData({{$data->id}})"
                                           class="menu-link px-3">{{getCustomTranslation('create_error')}}</a>
                                    </div>
                                    @endcan
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    @can('log_ad_record')
                                    <div class="menu-item px-3">
                                        <a href="{{route('ad_record_log.index',['ad_record_id'=>$data->id])}}"
                                           class="menu-link px-3">{{getCustomTranslation('log')}}</a>
                                    </div>
                                    @endcan
                                    <!--end::Menu item-->
                                </div>
                            </div>
                        @endcanany
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 ">
                    <div class="card card-flush">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                {{getCustomTranslation('media_ad')}}:
                            </h3>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        @if($data->accessMediaUser())
                            @if(count($data->medias) || count($data->mediasS3))
                                <div class="tns tns-default" style="direction: ltr;height: 500px">

                                    <!--begin::Slider-->
                                    <div
                                            data-tns="true"
                                            data-tns-loop="false"
                                            data-tns-swipe-angle="false"
                                            data-tns-speed="2000"
                                            data-tns-autoplay="true"
                                            data-tns-autoplay-timeout="18000"
                                            data-tns-controls="true"
                                            data-tns-nav="false"
                                            data-tns-items="2"
                                            data-tns-center="false"
                                            data-tns-dots="false"
                                            data-tns-prev-button="#kt_team_slider_prev1"
                                            data-tns-next-button="#kt_team_slider_next1">
                                        @if(count($data->medias))

                                            @foreach($data->medias as $media)
                                                @php

                                                    $ext = pathinfo($media->file, PATHINFO_EXTENSION);
                                                @endphp
                                                        <!--begin::Item-->
                                                <div class="text-center px-5 py-5 slider-item ">
                                                    @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'svg', 'webp', 'bmp', 'ico', 'jfif']))
                                                        <img style="height: 50%" data-enlargable
                                                             src="{{getFile($media->file??null,pathType()['ip'],getFileNameServer($media))}}"
                                                             class="card-rounded mw-100" alt=""/>
                                                    @else
                                                        <video style="width:100%;height: 50%" controls
                                                               src="{{getFile($media->file??null,pathType()['ip'],getFileNameServer($media))}}"></video>
                                                    @endif
                                                </div>
                                                <!--end::Item-->
                                            @endforeach
                                        @endif

                                        @if(count($data->mediasS3))
                                            @foreach($data->mediasS3->pluck('file') as $file)
                                                @php
                                                    $pieces = explode('.', $file);
                                                    $exe = array_pop($pieces);
                                                    $pieces = explode('/', $file);
                                                    $name = array_pop($pieces);
                                                @endphp
                                                        <!--begin::Item-->
                                                <div class="text-center px-5 py-5 slider-item">
                                                    @if($exe == 'mp4')
                                                        <video style="width:100%;height: 50%" controls
                                                               src="{{Storage::disk('s3')->url($file)}}"></video>
                                                    @else
                                                        <img style="height: 50%" data-enlargable
                                                             src="{{Storage::disk('s3')->url($file)}}"
                                                             class="card-rounded mw-100" alt=""/>
                                                    @endif
                                                </div>
                                                <!--end::Item-->
                                            @endforeach
                                        @endif

                                    </div>
                                    <!--end::Slider-->

                                    <!--begin::Slider button-->
                                    <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev1">
                                <span class="svg-icon fs-3x">
                                    <i class="fa-solid fa-left-long fs-1 text-dark"></i>
                                </span>
                                    </button>
                                    <!--end::Slider button-->

                                    <!--begin::Slider button-->
                                    <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next1">
                                <span class="svg-icon fs-3x">
                                    <i class="fa-solid fa-right-long fs-1 text-dark"></i>
                                </span>
                                    </button>
                                    <!--end::Slider button-->
                                </div>
                            @elseif(count($data->mediasS3) == 0 && count($data->medias) == 0)
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
                                                        <h3 class="fs-2x fw-semibold text-grey">{{getCustomTranslation('no_media')}}</h3>
                                                        <span class="fw-semibold text-grey opacity-75">{{getCustomTranslation('upload_media_with_ad_record')}}</span>
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
                                            <img src="{{asset('dashboard/assets/media/svg/illustrations/easy/7.svg')}}"
                                                 class="h-200px h-lg-250px my-n6" alt=""/>
                                            <!--end::Illustration-->
                                        </div>
                                        <!--begin::Col-->
                                    </div>
                                    <!--begin::Row-->
                                </div>
                                <!--end::Body-->

                            @endif
                        @else
                            <div class="tns tns-default row" style="height: 200px;text-align: center"
                                 id="request-ad-media-access">
                                @if($data->accessMediaUserInfo())
                                    @if($data->accessMediaUserInfo()->status == 1)
                                        <p>{{getCustomTranslation('your_request_has_been_sent_successfully')}}</p>
                                        <div class="col-md-7 text-end">
                                            <p class="btn btn-primary" id="request-access-cancellation">{{getCustomTranslation('cancel_your_request')}}</p>
                                        </div>
                                        <div class="col-md-5 text-end" style="padding-right: 50px">
                                            <a href="{{Route('request_ad_media_access_log.client',['ad_record_id'=>$data->id])}}"
                                               class="btn btn-primary" target="_blank">{{getCustomTranslation('history')}}</a>
                                        </div>
                                    @elseif($data->accessMediaUserInfo()->status == 3)
                                        <div class="col-md-12">
                                            <p>{{getCustomTranslation('sorry_media_unavailable')}}<br>
                                                {{getCustomTranslation('please_do_not_hesitate_to_contact_your_account_manager_for_assistance')}}
                                            </p>
                                            <p class="btn btn-primary" id="request-access-create">{{getCustomTranslation("request_ads_media_access_again")}}</p>
                                        </div>
                                        <div class="col-md-12 text-end" style="padding-right: 50px">
                                            <a href="{{Route('request_ad_media_access_log.client',['ad_record_id'=>$data->id])}}"
                                               class="btn btn-primary" target="_blank">{{getCustomTranslation('history')}}</a>
                                        </div>
                                    @elseif(in_array($data->accessMediaUserInfo()->status,[requestAccessType()['car'],requestAccessType()['cur']]))
                                        <p>Your request has been {{requestAccessTextMessge()[$data->accessMediaUserInfo()->status]}} </p>
                                        <div class="col-md-7 text-end">
                                        <p class="btn btn-primary" id="request-access-create">{{getCustomTranslation('request_ads_media_access')}}</p>
                                        </div>
                                        <div class="col-md-5 text-end" style="padding-right: 50px">
                                            <a href="{{Route('request_ad_media_access_log.client',['ad_record_id'=>$data->id])}}"
                                               class="btn btn-primary" target="_blank">{{getCustomTranslation('history')}}</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-md-12">
                                    <p class="btn btn-primary" id="request-access-create">{{getCustomTranslation('request_ads_media_access')}}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="sub-dev-menu">
                    <div class="row">
                        <div class="col-3">{{getCustomTranslation("platform")}} : {{ $data->platform->{'name_'.$lang} }}</div>
                        <div class="col-3">{{getCustomTranslation("service")}} : @forelse ($data->service as $category)
                                {{ $category->{'name_'.$lang} }}
                            @empty
                                N/A
                            @endforelse</div>
                        <div class="col-3">{{getCustomTranslation("estimate_cost")}}
                            : {{  $data->price == 0 || $data->price == null ? 'N/A' : $data->price }}</div>
                        @if($userType)
                            <div class="col-3"></div>
                        @else
                            <div class="col-3">{{getCustomTranslation("url")}} :
                                @if($data->url_post)
                                    <a href="{{$data->url_post}}" type="button" target="_blank"
                                       class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                <i class="fa fa-eye"></i>
                            </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                @else
                                    <a disabled="disabled" title="{{getCustomTranslation('no_link')}}" target="_blank" type="button"
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
                                        </span></a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">

                <div class="col-xl-4">
                    <!--begin::Card widget 3-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end align-items-center text-center"
                         style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                        <!--begin::Header-->
                        <div class="card-header pt-5 mb-3 align-items-center">
                            <!--begin::Icon-->
                            <h3 class="text-white text-center">{{getCustomTranslation("promoted_products")}}</h3>
                            <!--end::Icon-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-center mb-3">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <span class="text-white fw-bold me-6">
                                    {{  $data->promoted_products ?? 'N/A' }}
                                </span>

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 3-->
                </div>

                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Card widget 3-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end align-items-center text-center"
                         style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                        <!--begin::Header-->
                        <div class="card-header pt-5 mb-3 align-items-center">
                            <!--begin::Icon-->
                            <h3 class="text-white text-center">{{getCustomTranslation("promotion_type")}}</h3>
                            <!--end::Icon-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-center mb-3">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <span class="text-white fw-bold me-6">
                                    @forelse ($data->promotion_type as $type)
                                        <span>{{ $type->{'name_'.$lang} }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </span>

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 3-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Card widget 3-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end align-items-center text-center"
                         style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                        <!--begin::Header-->
                        <div class="card-header pt-5 mb-3 align-items-center">
                            <!--begin::Icon-->
                            <h3 class="text-white text-center">{{getCustomTranslation("promoted_offer")}}</h3>
                            <!--end::Icon-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-center mb-3">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <span class="text-white fw-bold me-6">
                                    {{  $data->promoted_offer ?? 'N/A' }}
                                </span>

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card widget 3-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class="col-xl-12">
                    <div class="card card-flush h-lg-100">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">{{getCustomTranslation("target_market")}}</span>
                                <span class="text-gray-400 pt-2 fw-semibold fs-6">{{getCustomTranslation("map_showing_target_market")}}</span>
                            </h3>
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div id="kt_maps_widget_2_maps" class="w-100 h-250px"></div>
                            <div>
                                <!--begin::Card widget 19-->
                                <div class="card card-flush h-lg-100">
                                    @if(count($data->target_market))
                                        <div class="card-body pt-6">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                                    <!--begin::Table head-->
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody>
                                                    @foreach($data->target_market as $market)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">

                                                                    <img alt="{{$market->code}}"
                                                                         src="{{asset('dashboard') . '/assets/media/flags/' . Str::slug(strtolower($market->name_en)) . '.svg'}}"
                                                                         style="width:30px"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">

                                                                    <div
                                                                            class="d-flex justify-content-start flex-column">
                                                                        <span href=""
                                                                              class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$market->{'name_'.$lang} }}</span>
                                                                        <!-- <span class="text-gray-400 fw-semibold d-block fs-7">Haiti</span> -->
                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>
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
                                                                <h3 class="fs-2x fw-semibold text-grey">{{getCustomTranslation("no_categories")}}</h3>
                                                                <span class="fw-semibold text-grey opacity-75">{{getCustomTranslation("need_more_data_for_a_better_ad_record")}}</span>
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
            @if($userLogin->can('update_ad_record') || user()->can('delete_ad_record'))
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end align-items-center text-center"
                             style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3 align-items-center">
                                <!--begin::Icon-->
                                <h3 class="text-white text-center">{{getCustomTranslation("creation_details")}}</h3>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div>
                                <!--begin::Info-->
                                <div class="">
                                    <p class="text-white fw-bold">
                                        {{getCustomTranslation("created_by")}} : {{ $data->user->name }}
                                    </p>
                                    <p class="text-white fw-bold">
                                        {{getCustomTranslation("creation_date")}} : {{ $data->created_at->format('m/d/Y') }}
                                    </p>
                                    <p class="text-white fw-bold">
                                        {{getCustomTranslation("creation_time")}}  : {{ $data->created_at->format('g:i A') }}
                                    </p>

                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end align-items-center text-center"
                             style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3 align-items-center">
                                <!--begin::Icon-->
                                <h3 class="text-white text-center">{{getCustomTranslation("ad_word_mentioned")}}</h3>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-center mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                <span class="fs-2hx text-white fw-bold me-6">
                                    {{ $data->mention_ad ? getCustomTranslation("yes") : getCustomTranslation("no") }}
                                </span>

                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end align-items-center text-center"
                             style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3 align-items-center">
                                <!--begin::Icon-->
                                <h3 class="text-white text-center">{{getCustomTranslation("government_entity")}}</h3>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-center mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                <span class="fs-2hx text-white fw-bold me-6">
                                    {{  $data->gov_ad ? getCustomTranslation("yes") : getCustomTranslation("no") }}
                                </span>

                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end "
                             style="background-color: #31186f;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3 ">
                                <!--begin::Icon-->
                                <h3 class="text-white">{{getCustomTranslation("ad_note")}}</h3>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex  mb-3">
                                <!--begin::Info-->
                                <div class="d-flex ">
                                <span class=" text-white fw-bold me-6">
                                    {{  $data->notes ?? 'N/A'}}
                                </span>

                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            @endif

        </div>
        <!--end::Container-->
        <div class="modal fade" id="kt_modal_timbrally" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">{{getCustomTranslation('create_error')}}</h2>
                        <!--end::Modal title-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-lg-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_timbrally_form" class="form" method="post" action=""  enctype="multipart/form-data">
                            @csrf
                            <!--begin::Scroll-->
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                                 data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                 data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                                 data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">{{getCustomTranslation('error_message')}}</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea name="message" class="form-control form-conrtol-lg"></textarea>
                                    <input type="hidden" name="ad_record_id" id="ad_record_id">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3"
                                        onclick="closeTimbrallyModel()">{{getCustomTranslation('discard')}}
                                </button>
                                <button type="submit" class="btn btn-light me-3">{{getCustomTranslation('submit')}}
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>

    </div>
    <!--end::Content-->

@endsection
@push('scripts')
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
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
        var fromPHP = @json($data->target_market);
        var test = [];
        var zoomTo = [];
        for (var i = 0; i < fromPHP.length; i++) {
            test[i] = {
                'id': (fromPHP[i].code).toUpperCase(),
                'name': fromPHP[i]['name_{{$lang}}'],
                'value': 100,
                "fill": am4core.color("#F05C5C")
            }
            zoomTo.push((fromPHP[i].code).toUpperCase());
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

        function deleteAc() {
            // Delete button on click

            // SweetAlert2 pop up --- official ad_record reference: https://sweetalert2.github.io/
            Swal.fire({
                text:
                    are_you_sure_you_want_to_delete +
                        {{$data->id}} +
                    "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: yes_delete,
                cancelButtonText: no_cancel,
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton:
                        "btn fw-bold btn-active-light-primary",
                },
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        method: "get",
                        url: "{{route('ad_record.delete_one',$data->id)}}",
                    })
                        .done(function (res) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text:
                                    you_have_deleted +
                                        {{$data->id}} +
                                    "!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton:
                                        "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                // delete row data from server and re-draw datatable
                                location.reload();
                            });
                        })
                        .fail(function (res) {
                            Swal.fire({
                                text:
                                        {{$data->id}} + was_not_deleted,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton:
                                        "btn fw-bold btn-primary",
                                },
                            });
                        });
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: {{$data->id}} + was_not_deleted,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: ok_got_it,
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                }
            });
        }

        $(document).on('click', '#request-access-create', function () {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "POST",
                url: "{{route('request_ad_media_access.store')}}",
                data: {
                    'ad_record_id': "{{$data->id}}",
                },
                success: function (res) {
                    $('#loading').css('display', 'none');
                    $('#request-ad-media-access').empty();
                    $('#request-ad-media-access').append(`<p>${res.message}</p>`);
                    $('#request-ad-media-access').append(`<div class="col-md-7 text-end"><p class="btn btn-primary" id="request-access-cancellation">{{getCustomTranslation('cancel_your_request')}}</p></div>`);
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    window.location.href
                }
            });
        });
        $(document).on('click', '#request-access-cancellation', function () {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "POST",
                url: "{{route('request_ad_media_access.cancellation')}}",
                data: {
                    'ad_record_id': "{{$data->id}}",
                    'status': 4,
                },
                success: function (res) {
                    $('#loading').css('display', 'none');
                    $('#request-ad-media-access').empty();
                    $('#request-ad-media-access').append(`<p>${res.message}</p>`);
                    $('#request-ad-media-access').append(`<div class="col-md-7 text-end"><p class="btn btn-primary" id="request-access-create">{{getCustomTranslation("request_ads_media_access")}}</p></div>`);
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    window.location.href
                }
            });
        });
    </script>
    <script>
        function closeTimbrallyModel() {
            $('#kt_modal_timbrally').modal('toggle');
            $('#kt_modal_timbrally').modal({backdrop: true})
            $('#loading').css('display', 'none');
        }

        function getTimbrallyData(ad_id) {
            $('#loading').css('display', 'flex');
            $('#kt_modal_timbrally').modal({backdrop: false})
            $('#kt_modal_timbrally').modal('show');
            $("#created_by_id").val({{user()->id}});
            $("#ad_record_id").val(ad_id);
            $('#loading').css('display', 'none');
        }

        $("#kt_modal_timbrally_form").on("submit", function (event) {

            event.preventDefault();
            $('#loading').css('display', 'flex');
            url = "{{route('ad_record_errors.store')}}";
            form = new FormData(this)
            $.ajax({
                type: "post",
                url: url,
                data: form,
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#kt_modal_timbrally').modal('toggle');
                    $('#kt_modal_timbrally').modal({backdrop: true});
                    $('#kt_modal_timbrally_form').trigger("reset");
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });
        $('img[data-enlargable]').addClass('img-enlargable').click(function(){
            var src = $(this).attr('src');
            $('<div>').css({
                background: 'RGBA(0,0,0,.5) url('+src+') no-repeat center',
                backgroundSize: 'contain',
                width:'100%', height:'100%',
                position:'fixed',
                zIndex:'10000',
                top:'0', left:'0',
                cursor: 'zoom-out'
            }).click(function(){
                $(this).remove();
            }).appendTo('body');
        });
    </script>

@endpush
