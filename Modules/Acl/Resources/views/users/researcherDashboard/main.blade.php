<!--begin::Card header-->

    <!--begin::Card title-->
    <div class="row card-title" style="width: 100%">
        <div class="col-md-4 d-flex align-items-center position-relative my-1">
            <input id="search_day" type="date" name="search_day"
                   value="{{ request('search_day') ?? \Carbon\Carbon::parse('today')->format('Y-m-d')}}"
                   max="{{\Carbon\Carbon::today()->format('Y-m-d')}}"
                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                   placeholder="{{getCustomTranslation('search_day')}}"/>
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <div class="col-md-4 d-flex align-items-center position-relative my-1">
            <select name="platform_id" id="platform_id"
                    class="form-select form-select-solid fw-bold" data-kt-select2="true"
                    data-placeholder="{{getCustomTranslation('select_platform')}}" data-allow-clear="true"
                    data-kt-user-table-filter="role" data-hide-search="false">
                <option value="">{{getCustomTranslation('all')}}</option>
                @foreach($platforms as $platform)
                    <option value="{{$platform->id}}"
                            @if($platform->id == request('platform_id')) selected @endif>{{$platform->{'name_'.$lang} }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row g-5 g-xl-8" style="width: 100%">
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="{{route('ad_record.index')}}?user_id[]={{request('user_id') ?? user()->id}}"
               class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8"
            >
                <!--begin::Body-->
                <div class="card-body">
                    <div class="text-white fw-bold fs-2 mb-2 mt-5"
                         id="allTimeRecords">0</div>
                    <div class="fw-semibold text-white">{{getCustomTranslation('total_recorded_ads')}}</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="{{route('ad_record.index')}}?creationD_start={{$range_start}}&creationD_end={{$range_end}}&user_id[]={{request('user_id') ?? user()->id}}"
               class="card bg-warning hoverable card-xl-stretch mb-xl-8"
               style=" cursor: pointer;">
                <!--begin::Body-->
                <div class="card-body">
                    <div class="text-white fw-bold fs-2 mb-2 mt-5"
                         id="todayRecords">0</div>
                    <div class="fw-semibold text-white">{{getCustomTranslation('todays_recorded_ads')}}</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="{{route('ad_record_draft.index')}}?user_id[]={{request('user_id') ?? user()->id}}"
               class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8"
            >
                <!--begin::Body-->
                <div class="card-body">
                    <div class="text-white fw-bold fs-2 mb-2 mt-5"
                         id="allTimeDrafts">0</div>
                    <div class="fw-semibold text-white">{{getCustomTranslation('total_recorded_ad_drafts')}}</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="{{route('ad_record_draft.index')}}?creationD_start={{$range_start}}&creationD_end={{$range_end}}&user_id[]={{request('user_id') ?? user()->id}}"
               class="card bg-warning hoverable card-xl-stretch mb-xl-8"
               style=" cursor: pointer;">
                <!--begin::Body-->
                <div class="card-body">
                    <div class="text-white fw-bold fs-2 mb-2 mt-5"
                         id="todayDrafts">0</div>
                    <div class="fw-semibold text-white">{{getCustomTranslation('todays_recorded_ad_drafts')}}</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->

            <!--begin::Body-->
            <a href="{{route('ad_record_errors.index')}}?ad_record_owner_id={{request('user_id') ?? user()->id}}"
               class="card bg-warning hoverable card-xl-stretch mb-xl-8"
               style=" cursor: pointer;">
                <div class="card-body">
                    <div class="text-white fw-bold fs-2 mb-2 mt-5"
                         id="todayErrors">0</div>
                    <div class="fw-semibold text-white">{{getCustomTranslation('recorded_errors')}}</div>
                </div>
            </a>
            <!--end::Body-->
            <!--end::Statistics Widget 5-->
        </div>

    </div>





<div id="data-table" style="width: 100%">
    <div class="row g-5 g-xl-8">
        <div class="col-xl-6">
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div id="basic_chart">
                </div>


                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-3">
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div id="completed_ads_chart">
                </div>


                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
        <div class="col-xl-3">
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div id="media_seen_chart">

                </div>


                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>
    </div>

    <!-- HERE COPY THE DIV STRUCTURE ABOVE AND INCLUDE TABLE VIEW-->
    <div class="row g-5 g-xl-8">
        <h3 class="text-center text-gray">{{getCustomTranslation('influencer_daily')}}</h3>
        <div class="col-xl-12">
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div id="main-table">
                    @include('acl::users.researcherDashboard.table')
                </div>


                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>

    </div>

    <!-- Here goes the log table -->
    @can('log_ad_record')
        <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <h3 class="text-center text-gray">{{getCustomTranslation('log_ad_record')}}</h3>
            <!--begin: Statistics Widget 6-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div id="log_researcher_dashboard">
                </div>
                <!--end:: Body-->
            </div>
            <!--end: Statistics Widget 6-->
        </div>

    </div>
    @endcan
</div>
<div class="modal fade" id="kt_modal_media" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <!--begin::Form-->
                <!--begin::Scroll-->
                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                     data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                     data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                     data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-md-4">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span id="influencer-name"></span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <!--begin::Label-->

                        </div>
                        <div class="col-md-4 text-end">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span id="platform-name"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <a class="prev" onclick="plusSlides(-1)" style="cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            border-radius: 0 3px 3px 0;
            user-select: none;">❮</a>
                        </div>
                        <div class="col-md-8" >
                            <div id="media-file" class="slideshow-container" style="margin-left: 150px;" >

                            </div>
                        </div>
                        <div class="col-md-2">
                            <a class="next" onclick="plusSlides(1)" style="cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            border-radius: 0 3px 3px 0;
            user-select: none;">❯</a>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <button type="reset" class="btn btn-light me-3"
                            onclick="closeModel()">{{getCustomTranslation('discard')}}
                    </button>
                    <a class="btn btn-primary" id="ad-link" target="_blank">
                        <span class="indicator-label">{{getCustomTranslation('new_record')}}</span>
                    </a>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<div class="modal fade" id="kt_modal_showads" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold"> {{getCustomTranslation('ads')}}</h2>
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
            <div class="modal-body scroll-y mx-lg-5 my-7">

                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <div class="row">

                        <label class="fs-5 fw-bold form-label mb-2">
                            <span>{{getCustomTranslation('date')}}  <span id="date">{{getCustomTranslation('date')}}</span></span>
                        </label>

                        <label class="fs-5 fw-bold form-label mb-2">
                            <span>{{getCustomTranslation('count')}}  <span id="count"></span></span>
                        </label>

                    </div>
                    <div id="listAdRecord" style="width: 100%">

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
</div>
    <!--end::Modal dialog-->

