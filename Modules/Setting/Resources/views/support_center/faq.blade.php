@extends('dashboard.layouts.app')

@section('title',getCustomTranslation('fq'))

@section('content')
    <div class="container-xxl mt-6" id="kt_content_container">
        <!--begin::Hero card-->
        <div class="card mb-12">
            <!--begin::Hero body-->
            <div class="card-body flex-column p-5">
                <!--begin::Hero content-->
                <div class="d-flex align-items-center h-lg-300px p-5 p-lg-15">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5">
                        <!--begin::Title-->
                        <h1 class="fw-bold fs-4 fs-lg-1 text-gray-800 mb-5 mb-lg-5 mt-6">{{getCustomTranslation('how_can_we_help_you')}}</h1>
                        <!--end::Title-->
                        <!--begin::Input group-->

                        <!--end::Input group-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Wrapper-->
                    <div class="flex-equal d-flex justify-content-center align-items-end ms-5">
                        <!--begin::Illustration-->
                        <img src="{{asset('dashboard')}}/assets/media/illustrations/sigma-1/20.png" alt=""
                             class="mw-100 mh-125px mh-lg-275px mb-lg-n12">
                        <!--end::Illustration-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Hero content-->
                <!--begin::Hero nav-->
                <div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
                    <!--begin::Nav-->
                    <ul class="nav flex-wrap border-transparent fw-bold">

                        <!--begin::Nav item-->
                        <li class="nav-item my-1">
                            <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active"
                               href="{{route('supportCenter.faq')}}">{{getCustomTranslation('faq')}}</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item my-1">
                            <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase"
                               href="{{route('contact.create')}}">{{getCustomTranslation('contact_us')}}</a>
                        </li>
                        <!--end::Nav item-->
                    </ul>
                    <!--end::Nav-->
                </div>
                <!--end::Hero nav-->
            </div>
            <!--end::Hero body-->
        </div>
        <!--end::Hero card-->

        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Classic content-->
                <div class="mb-13">
                    <!--begin::Intro-->
                    <div class="mb-15">
                        <!--begin::Title-->
                        <h4 class="fs-2x text-gray-800 w-bolder mb-6">{{getCustomTranslation('asked_questions')}}</h4>
                        <!--end::Title-->
                    </div>
                    <!--end::Intro-->
                    <!--begin::Row-->
                    <div class="row mb-12">
                        <!--begin::Col-->
                        @foreach($data as $d)
                            <div class="col-md-6 pe-md-10 mb-10 mb-md-0">
                                <!--begin::Accordion-->
                                <!--begin::Section-->
                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle mb-0 collapsed"
                                         data-bs-toggle="collapse" data-bs-target="#kt_{{$d->id}}">
                                        <!--begin::Icon-->
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                            <span class="svg-icon toggle-on svg-icon-primary svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                  fill="currentColor"></rect>
                                            <rect x="6.0104" y="10.9247" width="12" height="2" rx="1"
                                                  fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                            <span class="svg-icon toggle-off svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5"
                                                  fill="currentColor"></rect>
                                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                                  transform="rotate(-90 10.8891 17.8033)" fill="currentColor"></rect>
                                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                                  fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{$d->question}}</h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_{{$d->id}}" class="collapse fs-6 ms-1">
                                        <!--begin::Text-->
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{{$d->answer}}</div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed"></div>
                                    <!--end::Separator-->
                                </div>
                                <!--end::Section-->
                                <!--end::Accordion-->
                            </div>
                        @endforeach
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>

                <!-end::Card-->
            </div>
            <!--end::Body-->
        </div>
    </div>
@endsection
