@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('ad_record_drafts'))

@push('styles')

    <style>
        .createdCompany {
            padding: 10px;
            border: solid 2px grey;
            border-radius: 10px;
            box-shadow: 5px 5px #888888;
        }

        .createdCompany i {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')

    <script src="{{ asset('dashboard') }}/assets/jquery/jquery-ui.min.js"></script>

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_ad_record_create" aria-expanded="true"
             aria-controls="kt_ad_record_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('edit_ad_record')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form class="form" method="post" id="form"
                  action=""
                  enctype="multipart/form-data">
                @csrf

                <!--begin::Card body-->
                <div class="card-body border-top p-9">

                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('date')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="date"
                                       id="date"
                                       max="{{\Carbon\Carbon::today()->format('Y-m-d')}}"
                                       onchange="getInfluencerDataFromS3()"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('date')}}"
                                       value="{{ $data->date != null ? date('Y-m-d',strtotime($data->date)) : "" }}"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('influencer')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="influencer" name="influencer_id" onchange="getInfluencerDataFromS3()"
                                        class="form-select form-select-solid form-select-lg fw-semibold"
                                >
                                    <option value="{{$data->influencer_id}}" selected>
                                        @if($data->influencer)
                                            {{$data->influencer->name_en .'/'.$data->influencer->name_ar }}
                                        @endif
                                    </option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">

                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3 d-flex justify-content-between">
                                    <span class="required">{{getCustomTranslation('company')}}</span>
                                    <div style='display: none' id="edit-company-action">
                                        <a onclick="editCompany()">{{getCustomTranslation('edit')}}</a>
                                    </div>
                                </label>
                                <!--end::Label-->
                                <div style="text-align:right">
                                    <button onclick="removeCreateCompany()" id="closeCompanyFormBtn" type="button"
                                            class="btn-close d-none" aria-label="Close"></button>
                                </div>
                                <div id="selectCompany">
                                    <div class="d-flex align-items-center position-relative my-1 select_company">
                                        <select id="search_company" name="company_id"
                                                class="form-select form-select-solid form-select-lg fw-semibold"
                                                data-mce-placeholder=""
                                        >
                                            <option value="{{$data->company_id}}" selected>
                                                @if($data->company)
                                                    {{$data->company->name_en .'/'.$data->company->name_ar}}
                                                @endif
                                            </option>
                                        </select>

                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span
                                                class="svg-icon svg-icon-1 d-flex position-static position-left search-icon">
                                            <i class="fas fa-search" style="font-size:20px"></i>
                                        </span>

                                        <!--end::Svg Icon-->
                                    </div>
                                    <div id="company-link">
                                        @if($data->company)
                                            @if(count($data->company->company_website) > 0)
                                                <!--begin::Menu item-->
                                                <div id="company-link1">
                                                    @foreach($data->company->company_website as $site)
                                                        <a href="{{$site['url']}}" target="_blank"
                                                           class="menu-link px-3">{{$site->website->name_en .'/'.$site->website->name_ar}}</a>
                                                    @endforeach
                                                </div>
                                                <!--end::Menu item-->
                                                <!--end::Menu-->
                                            @endif
                                        @endif
                                        <div id="company-link2" style="display: none">
                                            <a target="_blank" href="javascript:void(0)"
                                               style="pointer-events: none"
                                               id="link-company-a">{{getCustomTranslation("no_link")}}</a>
                                        </div>
                                    </div>

                                </div>
                                <div id="createCompany" class="d-none bg-primary p-4">
                                    <h3 class="text-white py-4">{{getCustomTranslation('add_new_company')}}</h3>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-lg-12">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="fv-row">
                                                    <input type="text" name="name_en" id="c_name_en"
                                                           value="{{Request::old('name_en')}}"
                                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="{{getCustomTranslation('name_en')}}"/>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-lg-12">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="fv-row">
                                                    <input type="text" name="name_ar" id="c_name_ar"
                                                           value="{{Request::old('name_ar')}}"
                                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="{{getCustomTranslation('name_ar')}}"/>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-lg-12">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="fv-row">
                                                    <select name="websites[]"
                                                            aria-label="{{getCustomTranslation('select_a_platform')}}"
                                                            id="websites"
                                                            multiple="multiple" data-control="select2"
                                                            data-placeholder="{{getCustomTranslation('select_a_website')}}..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="">{{getCustomTranslation('select_a_website')}}
                                                            ...
                                                        </option>
                                                        @foreach($sites as $value)
                                                            <option value="{{$value->id}}">{{$value->name_en ."/". $value->name_ar}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="link">

                                                    </div>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="fv-row">
                                                    <select name="industry[]" id="c_industry"
                                                            aria-label="{{getCustomTranslation('select_a_industry')}}"
                                                            multiple="multiple"
                                                            data-control="select2"
                                                            data-placeholder="{{getCustomTranslation('select_a_industry')}}..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="">{{getCustomTranslation('select_a_industry')}}
                                                            ...
                                                        </option>
                                                        @foreach($industry as $value)
                                                            <option value="{{$value->id}}">{{$value->name_en .'/'.$value->name_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->


                                    <!--begin::Input group-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="fv-row">
                                                    <span onClick="companySubmitted()"
                                                          class="btn btn-info mt-6 w-100">{{getCustomTranslation('done')}}</span>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                </div>

                                <div id="companySubmittedView" class="d-none">
                                    <div class="w-100 d-flex justify-content-between py-4 ">
                                        <span id="companyEnglishName"></span>
                                        <div class="d-flex">
                                            <i onclick="showCreateCompany()"
                                               class="fa-regular fa-pen-to-square mx-4"></i>
                                            <i onclick="removeCreateCompany()" class="fa-solid fa-x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div id="edit-company" style="display:none;"></div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('ad_category')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="category[]"
                                        multiple="multiple"
                                        data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                        id="category"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_category')}}</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('platform')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="platform_id" aria-label="{{getCustomTranslation('select_a_platform')}}"
                                        id="platform"
                                        onchange="getInfluencerDataFromS3()"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_platform')}}...</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('ad_type')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="service_id[]" multiple="multiple"
                                        aria-label="{{getCustomTranslation('select_services')}}"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_services')}}..." id="service"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_services')}}...</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>


                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('target_market')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="target_market[]" multiple="multiple" aria-label="Select an target market"
                                        id="target_market"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_an_target_market')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_an_target_market')}}...</option>
                                    <option value="-1">{{getCustomTranslation('other')}}</option>
                                    <option value="allGCC">{{getCustomTranslation('all_gcc')}}</option>
                                    @foreach($country as $value)
                                        @if(in_array($value->id , $data->target_market->pluck('id')->toArray()))
                                            <option value="{{$value->id}}"
                                                    selected>{{$value->name_en.'/'.$value->name_ar}}</option>
                                        @endif
                                    @endforeach
                                    @foreach($countrygcc as $valuegcc)
                                        <option value="{{$valuegcc->id}}"
                                                @if(in_array($valuegcc->id , $data->target_market->pluck('id')->toArray())) selected @endif>{{$valuegcc->name_en.'/'.$valuegcc->name_ar}}</option>
                                    @endforeach


                                </select>
                                <input type="hidden" name="selector" id="selector">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('promotion_type')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="promotion_type[]"
                                        aria-label="{{getCustomTranslation('select_a_promotion_type')}}"
                                        id="promotion_type"
                                        multiple="multiple" data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_a_promotion_type')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_promotion_type')}}...</option>
                                    @foreach($promotion_type as $value)
                                        <option value="{{$value->id}}"
                                                @if(in_array($value->id,$data->promotion_type->pluck('id')->toArray())) selected @endif>{{$value->name_en.'/'.$value->name_ar}}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>


                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <div class="fv-row mb-7 d-flex">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3 col-md-6">
                                    <span>{{getCustomTranslation('is_there_any_promoted_products')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input name="is_promoted_products" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="allowmarketing" value="1"  onclick="showHidn('promoted_products')"
                                           @if(Request::old('is_promoted_products') || $data->promoted_products) checked="{{Request::old('is_promoted_products')}}" @endif>
                                    <label class="form-check-label" for="allowmarketing"></label>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3" id="promoted_products" @if(empty($data->promoted_products)) style="display:none;" @else style="display:block;" @endif>
                                    <span class="required">{{getCustomTranslation('promoted_products')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control" name="promoted_products"
                                       value="{{ $data->promoted_products }}"
                                       placeholder="{{getCustomTranslation('enter_promoted_product')}}"/>

                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <div class="fv-row mb-7 d-flex">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3 col-md-6">
                                    <span>{{getCustomTranslation('is_there_any_promoted_offer')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input name="is_promoted_offer" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="allowmarketing" value="1"  onclick="showHidn('promoted_offer')"
                                           @if(Request::old('is_promoted_offer') || $data->promoted_offer) checked="{{Request::old('is_promoted_offer')}}" @endif>
                                    <label class="form-check-label" for="allowmarketing"></label>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7" id="promoted_offer" @if(empty($data->promoted_offer)) style="display:none;" @else style="display:block;" @endif>
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>{{getCustomTranslation('promoted_offer')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control" name="promoted_offer"
                                       value="{{$data->promoted_offer}}"
                                       placeholder="{{getCustomTranslation('enter_promoted_offer')}}"/>

                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7 d-flex">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3 col-md-6">
                                    <span class="required">{{getCustomTranslation('does_ad_word_mentioned')}} ?</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input name="mention_ad" @if($data->mention_ad) checked="true"
                                           @endif value="1" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="allowmarketing">
                                    <label class="form-check-label" for="allowmarketing"></label>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7 d-flex">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3 col-md-6">
                                    <span class="required">{{getCustomTranslation('government_entity')}} ?</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input name="gov_ad" @if($data->gov_ad) checked="true"
                                           @endif value="1" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="allowmarketing">
                                    <label class="form-check-label" for="allowmarketing"></label>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>{{getCustomTranslation('notes')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="notes" class="form-control">{{$data->notes}}</textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    {{getCustomTranslation('upload_file')}}:
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">{{getCustomTranslation('loading')}}...</span>
                                    </div>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div id="images-inputs"></div>
                                <div class="col-lg-8">
                                    <div class="dropzone" id="kt_modal_create_project_settings_logo">
                                        <!--begin::Message-->
                                        <div class="dz-message needsclick">
                                            <!--begin::Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/files/fil010.svg-->
                                            <span class="svg-icon svg-icon-3hx svg-icon-primary">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3"
                                                                      d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM14.5 12L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L10 12H11.5V17C11.5 17.6 11.4 18 12 18C12.6 18 12.5 17.6 12.5 17V12H14.5Z"
                                                                      fill="currentColor"/>
																<path d="M13 11.5V17.9355C13 18.2742 12.6 19 12 19C11.4 19 11 18.2742 11 17.9355V11.5H13Z"
                                                                      fill="currentColor"/>
																<path d="M8.2575 11.4411C7.82942 11.8015 8.08434 12.5 8.64398 12.5H15.356C15.9157 12.5 16.1706 11.8015 15.7425 11.4411L12.4375 8.65789C12.1875 8.44737 11.8125 8.44737 11.5625 8.65789L8.2575 11.4411Z"
                                                                      fill="currentColor"/>
																<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z"
                                                                      fill="currentColor"/>
															</svg>
														</span>
                                            <!--end::Svg Icon-->
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="ms-4">
                                                <h3 class="dfs-3 fw-bolder text-gray-900 mb-1">{{getCustomTranslation('drop_files_here_or_click_to_upload')}}
                                                    .</h3>
                                                <span class="fw-bold fs-4 text-muted">{{getCustomTranslation('upload_up_to_10_files')}}</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                    </div>
                                    <div class="form-text">{{getCustomTranslation('allowed_file_types')}}: png, jpg,
                                        jpeg,mp4,mov,ogg
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('url_post')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="url_post"
                                                   value="{{ $data->url_post ?? Request::old('url_post') ?? "" }}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('url_post')}}"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="fv-row mb-7 d-flex">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3 col-md-6">
                                    <span class="required">{{getCustomTranslation('red_flag')}}</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input name="red_flag" @if($data->red_flag) checked="true"
                                           @endif value="1" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="allowmarketing">
                                    <label class="form-check-label" for="allowmarketing"></label>
                                </div>
                                <!--end::Input-->
                            </div>

                        </div>


                        <!--end::Col-->
                    </div>

                </div>

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('ad_record_draft.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button id='draft_btn' type="button" style="margin-left: 10px" onclick="actionButton('draft')"
                            class="btn btn-primary">{{getCustomTranslation('edit_draft')}}
                    </button>
                    <button id='btn' type="button" class="btn btn-primary"  style="margin-left: 10px"
                            onclick="checkDuplicates()">{{getCustomTranslation('convert_to_ad')}}
                    </button>

                </div>
                <!--end::Actions-->
                <!--end::Card body-->
                <div id="files">
                    <div class="text-center">
                        @include('basic::loadind_snipper')
                    </div>
                </div>

            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
    <div class="modal fade" id="kt_modal_showads" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('registered_ad')}}</h2>
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
        <!--end::Modal dialog-->
    </div>

    <div id="listAdRecord" style="width: 100%">

    </div>
@endsection
@push('scripts')
    <script>
        function disableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = true;
            var draft_btn = document.getElementById('draft_btn');
            draft_btn.disabled = true;
            btn.innerText = '{{getCustomTranslation('sending')}}...'
            draft_btn.innerText = '{{getCustomTranslation('sending')}}...'
        }

        function showCreateCompany() {
            $('#closeCompanyFormBtn').removeClass('d-none');
            $('#openCompanyFormBtn').addClass('d-none');
            $('#new_company').addClass('d-none')

            $('#selectCompany').addClass('d-none');
            $('#createCompany').removeClass('d-none');
            //GetCategoryAll();

            // hide preserved new company
            $('#companySubmittedView').addClass('d-none');
            document.getElementById("edit-company-action").style.display = "none";
            document.getElementById('edit-company').style.display = "none";
        }
        function companySubmitted() {

            url = '{{ route("company.check") }}';
            name_en = $('#c_name_en').val();
            name_ar = $('#c_name_ar').val();
            websites = $('#websites').val();
            industry = $('#c_industry').val();

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    'name_en': name_en,
                    'name_ar': name_ar,
                    'websites': websites,
                    'industry': industry,
                },
                success: function () {
                    var company_name = $("input[name=name_en]").val();
                    var industry = $("input[name=industry]").val();
                    if (company_name !== '' && industry !== '') {
                        // reverse show create company
                        $('#closeCompanyFormBtn').addClass('d-none');
                        $('#openCompanyFormBtn').removeClass('d-none');
                        $('#new_company').removeClass('d-none')
                        // $('#selectCompany').removeClass('d-none');
                        $('#createCompany').addClass('d-none');
                        // hide preserved new company
                        $('#companySubmittedView').removeClass('d-none');
                        $('#companyEnglishName').html(company_name)
                    }
                    document.getElementById("edit-company-action").style.display = "none";
                    document.getElementById('edit-company').style.display = "none";

                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });

        }
        function removeCreateCompany() {
            $('#new_company').removeClass('d-none')

            $('#closeCompanyFormBtn').addClass('d-none');
            $('#openCompanyFormBtn').removeClass('d-none');
            $('#selectCompany').removeClass('d-none');
            $('#createCompany').addClass('d-none');
            $("#company_id").val(null).trigger("change");
            //GetCategory($('#company_id').val());

            // show preserved new company
            $('#companySubmittedView').addClass('d-none');
            document.getElementById("edit-company-action").style.display = "block";
            document.getElementById('edit-company').style.display = "none";
        }

        function GetCategoryAll() {
            url = '{{ route("category.list.industry") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    'status': "{{activeType()['as']}}"
                },
                success: function (res) {
                    $(`#category`).empty();
                    for (let x in res) {
                        for (let i in res[x]) {
                            $(`#category`).append(`<option value="${res[x][i].id}">${res[x][i].name_en} / ${res[x][i].name_ar}</option>`);
                        }
                    }
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        var route = "{{ route('ad_record_draft.index') }}";
        GetPlatform({{$data->influencer_id}}, {{$data->platform_id}})
        GetCategory({{$data->company_id??0}}, {{$data->category->pluck('id')??[]}})
        $('#influencer').change(function () {
            GetPlatform($(this).val());
            GetCategory($(this).val());
        });

        function GetPlatform(influencer, platform) {

            url = '{{ route("platform.list") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {'influencer': influencer},
                success: function (res) {
                    $(`#platform`).empty();
                    $(`#platform`).append(`<option value="">{{getCustomTranslation('select_a_platform')}}...</option>`);
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (platform == res[x][i].id) {
                                $(`#platform`).append(`<option selected value="${res[x][i].id}">${res[x][i].name_en}/ ${res[x][i].name_ar}</option>`);
                            } else {
                                $(`#platform`).append(`<option value="${res[x][i].id}">${res[x][i].name_en}/ ${res[x][i].name_ar}</option>`);
                            }
                        }
                    }
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        function GetCategory(company, category) {
            let url = '{{ route("category.list.industry") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: "",
                success: function (res) {
                    $(`#category`).empty();
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (category && category.includes(res[x][i].id)) {
                                $(`#category`).append(`<option value="${res[x][i].id}" selected>${res[x][i].name_en}/ ${res[x][i].name_ar}</option>`);
                            } else {
                                $(`#category`).append(`<option value="${res[x][i].id}">${res[x][i].name_en}/ ${res[x][i].name_ar}</option>`);
                            }
                        }
                    }
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        GetService({{$data->platform_id ?? 0}}, {{json_encode($data->service->pluck('id')->toArray() ?? [])}})
        //service list for platform
        $('#platform').change(function () {
            platform_id = $(this).val();
            getInfluencerDataFromS3(platform_id)
            GetService($(this).val());
        });

        function GetService(platform_id, services) {
            url = '{{ route("service.list") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {'platform': platform_id},
                success: function (res) {
                    $(`#service`).empty();
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (services && services.includes(res[x][i].id)) {
                                $(`#service`).append(`<option value="${res[x][i].id}" selected>${res[x][i].name_en}/ ${res[x][i].name_ar}</option>`);
                            } else {
                                $(`#service`).append(`<option value="${res[x][i].id}">${res[x][i].name_en}/ ${res[x][i].name_ar}</option>`);
                            }
                        }
                    }
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }
    </script>
    <script src="{{ asset('dashboard') }}/assets/jquery/jquery-ui.min.js"></script>
    <script>
        var path = "{{ route('reports.search_companies') }}";

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var companyLabel = @json($data->company->name_en ?? "");
        var companyValue = @json($data->company_id ?? 0);

        window.onload = function () {
            //todo remove this and refactor code
            //GetCategory(companyValue);
            GetCategory({{$data->company_id??0}}, {{$data->category->pluck('id')??[]}});
        }

        function openSearchCompany() {
            $('#company_selected').addClass('d-none');
            $('#company').val('');
            $('.select_company').removeClass('d-none');
            $('#new_company').removeClass('d-none');
        }

        function template(data) {
            if ($(data.html).length === 0) {
                return data.text;
            }
            return $(data.html);
        }

        $('#search_company').select2({
            minimumInputLength: 1,
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_company')}}...",
            ajax: {
                cacheDataSource: [],
                url: path,
                method: 'post',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            },
            templateResult: template,
            templateSelection: template,
            language: {
                "noResults": function () {
                    return "{{getCustomTranslation('no_results_found')}} <br> " +
                        '<button ' +
                        ' style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;" onclick="openCreateCompany()" class="select2-link">{{getCustomTranslation('add_new_company')}}</button>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }).on('select2:select', function (e) {
            let id = e.params.data.id
            GetCategory(id);
            if (e.params.data.link) {
                document.getElementById("company-link2").style.display = "none";
                $('#company-link1').empty();
                $('#company-link1').html(e.params.data.link);
            } else {
                $('#company-link1').empty();
                document.getElementById("company-link2").style.display = "block";
            }
        });

        function openCreateCompany(b) {
            let a = $('#search_company').data('select2');
            a.trigger('close');
            showCreateCompany();
        }

        let search_influencer_url = "{{ route('influencer.search') }}";
        $('#influencer').select2({
            delay: 900,
            placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: search_influencer_url,
                method: 'get',
                dataType: 'json',
                delay: 900,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item.name_en + '/' + item.name_ar,
                            }
                        }),
                    };
                },
            }
        });
        url = '{{ route("category.list_search") }}';
        $('#category').select2({
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_category')}}...",
            ajax: {
                cacheDataSource: [],
                url: url,
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item.name_en + '/' + item.name_ar,
                            }
                        }),
                    };
                },
            }
        });

        function deleteMadie(id) {
            $.ajax({
                type: "DELETE",
                url: '{{route("media.remove")}}',
                data: {'id': id},
                success: function () {
                    $(`#media-${id}`).remove();
                }
            });
        }

        let myDropzone = new Dropzone("#kt_modal_create_project_settings_logo", {
            init: function () {
                this.on("removedfile", function (file) {
                    $(`input[value="${file.name}"]`).prop('disabled', true);
                    $.ajax({
                        type: "DELETE",
                        url: '{{route("media.removeByName")}}?id=' + {{$data->id}},
                        data: {'name': file.name},
                        success: function () {
                        }
                    });
                });
                let dropzone = this;
                $.ajax({
                    url: "{{ route('ad_record_draft.read_files')}}?id=" + {{$data->id}},
                    type: 'get',
                    data: {request: 'fetch'},
                    dataType: 'json',
                    success: function (response) {
                        $.each(response, function (key, value) {
                            $('<input>').attr({
                                type: 'hidden',
                                id: value.name.replace(/[ .]+/g, ''),
                                name: 'images[]',
                                value: value.name
                            }).appendTo('form');
                            let mockFile = {name: value.name, dataURL: value.path, size: value.size};
                            dropzone.files.push(mockFile);
                            dropzone.emit("addedfile", mockFile);
                            dropzone.emit('complete', mockFile);
                            dropzone.createThumbnailFromUrl(mockFile,
                                dropzone.options.thumbnailWidth,
                                dropzone.options.thumbnailHeight,
                                dropzone.options.thumbnailMethod, true, function (thumbnail) {
                                    if (typeof thumbnail === 'string' || thumbnail instanceof String)
                                        dropzone.emit('thumbnail', mockFile, thumbnail);
                                    ;
                                }
                            );
                        });
                        //spinner-border
                        $(".spinner-border").hide();
                    }
                });
            },
            url: "{{ route('ad_record_draft.upload')}}", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            sending: function (file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
            accept: function (file, done) {
                let allowed_array = [
                    'image/png', 'image/jpg', 'image/jpeg', 'video/mp4', 'video/quicktime', 'audio/ogg'
                ];
                if (allowed_array.includes(file.type)) {
                    let name = file.name;
                    $('<input>').attr({
                        type: 'hidden',
                        id: name.replace(/[ .]+/g, ''),
                        name: 'images[]',
                        value: file.name
                    }).appendTo('form');
                    done();
                } else {
                    done("{{getCustomTranslation('file_type_is_not_allowed')}}");
                }
            },
        });
        Dropzone.options.myDropzone = {
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
        };

    </script>
    {!! JsValidator::formRequest('Modules\Record\Http\Requests\AdRecord\EditRequest','#kt_ad_record_edit_form') !!}

    <script>

        let get_files_url = "{{ route('ad_record_draft.get_files') }}";

        function getInfluencerDataFromS3(platform = null) {
            if (platform == null) {
                platform = $('#platform').val();
            }
            var influencer = $('#influencer').val();
            if (platform == 1 && $("#date").val() != "" && influencer != null) {
                document.getElementById('date').disabled = true;
                $('#loading').css('display', 'flex');
                $('#files').html('<div class="text-center mb-5"><img src="{{asset('loading.gif')}}" alt=""></div>');
                var date = new Date($("#date").val());
                var day = date.getDate();
                var month = date.getMonth() + 1;
                month = month < 10 ? '0' + month : month;
                day = day < 10 ? '0' + day : day;
                var year = date.getFullYear();
                var fullDate = year + '-' + month + '-' + day;
                $.ajax({
                    type: "GET",
                    url: get_files_url,
                    data: {
                        'date': fullDate,
                        'influencer_id': influencer,
                        'ad_record_id': "{{$data->id}}"
                    },
                    success: function (res) {
                        if (res) {
                            $('#files').html(res);
                        } else {
                            $('#files').html('<div class="alert alert-danger text-center">{{getCustomTranslation('influencer_havet_store')}}</div>');
                        }
                        $('#loading').css('display', 'none');
                        document.getElementById('date').disabled = false;
                    }, error: function (res) {
                        $('#loading').css('display', 'none');
                        for (let err in res.responseJSON.errors) {
                            toastr.error(res.responseJSON.errors[err]);
                        }
                        document.getElementById('date').disabled = false;
                    }
                });
            } else {
                $('#files').empty()
                document.getElementById('date').disabled = false;
            }
        }

        $(document).ready(function () {
            getInfluencerDataFromS3({{$data->platform_id}});
            let oldselect = [];
            var selectedValues = [];
            var idsallGCC = {};
            var idsallother = {};
            var is_disa = '';
            var startall = false;
            getidsgcc();
            getidsother();

            function getidsgcc() {
                $.ajax({
                    url: '{{route('location.country.listSpecific')}}',
                    method: 'GET',
                    data: {selector: 'GCC'},
                    success: function (data) {
                        idsallGCC = data.data;

                    },
                    error: function (error) {
                    }
                })
            }

            function hideSelected(value) {
                if (value && !value.selected) {
                    return $('<span>' + value.text + '</span>');
                }
            }

            $(document).ready(function () {
                $('#target_market').select2({
                    allowClear: true,
                    placeholder: {
                        id: "",
                        placeholder: "{{getCustomTranslation('leave_blank_to')}} ..."
                    },
                    minimumResultsForSearch: -1,
                    width: 600,
                    templateResult: hideSelected,
                });
            });

            function getidsother() {
                $.ajax({
                    url: '{{route('location.country.listSpecific')}}',
                    method: 'GET',
                    data: {selector: '-1'},
                    success: function (data) {
                        idsallother = data.data;


                    },
                    error: function (error) {
                    }
                })
            }

            function populateCountries(selector, data, old) {
                $('#target_market').empty();
                if (selector !== "GCC") {
                    $('#target_market').append(`<option value="GCC">GCC</option>`)
                } else {
                    $('#target_market').append(`<option value="-1">Other</option>`)
                }
                $.each(data.data, function (index, value) {
                    if ((old.length < 2)) {
                        $('#target_market').append(`<option value="${value.id}">${value.name_en}/ ${value.name_ar}</option>`)
                    } else {
                        if ((old[1].id != value.id)) {
                            $('#target_market').append(`<option value="${value.id}">${value.name_en}/ ${value.name_ar}</option>`)
                        }
                    }
                });
                $.each(oldselect, function (index, value) {
                    if (value.id != -1 && value.id != 'GCC') {
                        $('#target_market').append(`<option value="${value.id}" selected>${value.text}/ ${value.name_ar}</option>`);
                    }
                });
            }


            $('#target_market').change(function () {

                oldselect = $('#target_market').select2('data');
                $('#selector').val($(this).val());

                var myArray = $('#selector').val().split(",");
                if ($('#selector').val().includes("allGCC") || $(this).val() == 'allGCC') {


                    idsallGCC.forEach(function (item) {
                        if (!$("#target_market").find("option[value='" + item.id + "']:selected").length) {
                            $("#target_market").find("option[value='" + item.id + "']").prop('selected', true);
                            $('#target_market').select2({
                                templateResult: hideSelected,
                            });
                        }

                    });
                    $("#target_market").find("option[value='allGCC']").remove();
                    startall = true;
                    $("#target_market").find("option[value='allGCC']").prop('selected', false);
                    $("#target_market").find("option[value='allGCC']").attr('disabled', 'disabled');
                    is_disa = 'disabled';
                    $("#target_market").trigger("change");

                } else {
                    $("#target_market").find("option[value='allGCC']").remove();
                    if ($('#target_market').find("option[value='-1']").length) {
                        $("#target_market").find("option[value='allGCC']").remove();
                        $.each(idsallother, function (index, value) {
                            if (!$("#target_market").find("option[value='" + value.id + "']:selected").length) {

                                $("#target_market").find("option[value='" + value.id + "']").remove();
                            }

                        });

                    }

                    if ($('#target_market').find("option[value='GCC']").length) {

                        $.each(idsallGCC, function (index, value) {
                            if (!$("#target_market").find("option[value='" + value.id + "']:selected").length) {

                                $("#target_market").find("option[value='" + value.id + "']").remove();
                            }

                        });

                    }

                    if (startall == true) {
                        $("#target_market").find("option[value='allGCC']").remove();
                        idsallGCC.forEach(function (item) {

                            if (!myArray.includes(item.id.toString())) {
                                is_disa = '';
                                $("#target_market").find("option[value='allGCC']").prop('disabled', false);
                                $("#target_market").find("option[value='allGCC']").remove();

                                $('#target_market').append(`<option value="allGCC" ` + is_disa + `>{{getCustomTranslation('all_gcc')}}</option>`);
                            }

                        });


                    }
                }


                if ($('#selector').val().includes(-1) || $('#selector').val().includes("GCC")) {
                    if ($('#selector').val().includes(-1)) {
                        selector = -1;
                        $("#target_market").find("option[value='-1']").remove();
                        $("#target_market").find("option[value='allGCC']").remove();
                        idsallGCC.forEach(function (item) {
                            if (!myArray.includes(item.id.toString())) {
                                $("#target_market").find("option[value='" + item.id + "']").remove();
                            }

                        });
                        $.each(idsallother, function (index, value) {

                            if (!myArray.includes(value.id.toString())) {

                                $('#target_market').append(`<option value="${value.id}">${value.name_en}/ ${value.name_ar}</option>`);
                            }
                        });
                        $('#target_market').append(`<option value="GCC">{{getCustomTranslation('gcc')}}</option>`);


                    } else {
                        selector = "GCC";
                        $("#target_market").find("option[value='allGCC']").remove();
                        $('#target_market').append(`<option value="allGCC" ` + is_disa + `>{{getCustomTranslation('all_gcc')}}</option>`);

                        $("#target_market").find("option[value='GCC']").remove();
                        $('#target_market').append(`<option value="-1">{{getCustomTranslation('other')}}</option>`);
                        idsallother.forEach(function (item) {

                            if (!myArray.includes(item.id.toString())) {

                                $("#target_market").find("option[value='" + item.id + "']").remove();
                            }

                        });
                        $.each(idsallGCC, function (index, value) {

                            if (!myArray.includes(value.id.toString())) {

                                $('#target_market').append(`<option value="${value.id}">${value.name_en}/ ${value.name_ar}</option>`);
                            }
                        });
                    }
                }
            });

        });
        site_array = [];
        $('#websites').change(function () {
            result_add = $(this).val().filter(x => !site_array.includes(x));
            result_remove = site_array.filter(x => !$(this).val().includes(x));
            site_array = $(this).val();
            GetWebsites($(this).val(), result_remove);
        });

        function GetWebsites(add, remove) {
            url = '{{ route("website.list") }}';
            if (result_remove[0] !== undefined) {
                $(`#link #link-${result_remove[0]}`).remove();
            }
            $.ajax({
                type: "GET",
                url: url,
                data: {'id': result_add[0]},
                success: function (res) {
                    $(`#link`).append(`<div id="link-${result_add[0]}"></div>`);
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (result_add[0] !== undefined) {
                                $(`#link #link-${result_add[0]}`).append(`
                                <div >
                                   ${res[x][i].name_en} <input type="text" name="link[${result_add[0]}]" class="form-control form-control-lg form-control-solid mb-3 "/>
                                </div>`);
                            }
                        }
                    }

                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        function actionButton(type, url = null) {
            disableButton()
            if (type == 'new') {
                document.getElementById('form').action = "{{route('ad_record_draft.convert',$data->id)}}";
            }
            if (type == 'draft') {
                document.getElementById('form').action = "{{route('ad_record_draft.update', $data->id)}}";
            }
            if (type == 'edit') {
                document.getElementById('form').action = url;
            }
            this.form.submit();
        }

        function closemodel() {
            $('#kt_modal_showads').modal('toggle');
            enableButton();
        }

        function checkDuplicates() {
            disableButton();
            url = '{{ route("ad_record_draft.checkDuplicates") }}';
            form = document.getElementById('form');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(form),
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.length > 0) {
                        $('#listAdRecord').html(res);
                    } else {
                        actionButton('new');
                    }
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                    enableButton()
                }
            });
        }
        function enableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = false;
            btn.innerText = '{{getCustomTranslation('create_draft')}}'
            var draft_btn = document.getElementById('draft_btn');
            draft_btn.disabled = false;
            draft_btn.innerText = '{{getCustomTranslation('edit_draft')}}'
        }
        function showHidn(id) {
            const btn = document.getElementById(id);

            const display = window.getComputedStyle(btn).display;
            if(display == 'block')
            {
                document.getElementById(id).style.display = "none";
            }else{
                document.getElementById(id).style.display = "block";
            }
        }
        let slideIndex = 3;

        function mediaSlider() {
            showSlides(slideIndex);
        }

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndexI = slides[slideIndex - 1]
            slideIndexI.style.display = "block";
            slideIndexI = slides[slideIndex - 2]
            slideIndexI.style.display = "block";
            slideIndexI = slides[slideIndex - 3]
            slideIndexI.style.display = "block";
            slideIndexI = slides[slideIndex - 4]
            slideIndexI.style.display = "block";

        }
        function editCompany() {
            const btn = document.getElementById('edit-company');

            const display = window.getComputedStyle(btn).display;
            if (display == 'block') {
                document.getElementById('edit-company').style.display = "none";
            } else {
                document.getElementById('edit-company').style.display = "block";
                $.ajax({
                    type: "get",
                    url: "{{route('company.getEdit')}}"+"?id="+$("#search_company").val(),
                    success: function (res) {
                        $('#edit-company').html(res);
                    }, error: function (res) {
                        for (let err in res.responseJSON.errors) {
                            toastr.error(res.responseJSON.errors[err]);
                        }
                    }
                });
            }
        }
        function editCompanyAction(url) {
            form = document.getElementById('kt_company_edit_form');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(form),
                contentType: false,
                processData: false,
                success: function (res) {
                    document.getElementById('edit-company').style.display = "none";
                    $("#search_company").val([res.data.id]).trigger("change");
                    document.getElementById("company-link2").style.display = "none";
                    document.getElementById("edit-company-action").style.display = "none";
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }
    </script>

@endpush
