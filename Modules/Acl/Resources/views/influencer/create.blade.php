@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer'))

@section('content')
    <form id="kt_influencer_create_form" class="form" method="post" action="{{route('influencer.store')}}"
          enctype="multipart/form-data">
        @include('dashboard.error.error')

        @csrf
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->

            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                 data-bs-target="#kt_influencer_create" aria-expanded="true"
                 aria-controls="kt_influencer_create">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{getCustomTranslation('personal_info')}}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Content-->

            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->

                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_en')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="name_en" value="{{Request::old('name_en')}}"
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
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_ar')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="name_ar" value="{{Request::old('name_ar')}}"
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
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('category')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="category[]" aria-label="{{getCustomTranslation('select_a_category')}}" multiple="multiple"
                                            data-control="select2" data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_category')}}</option>
                                        @foreach($category as $value)
                                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('nationality')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="nationality_id" aria-label="{{getCustomTranslation('select_a_nationality')}}" id="nationality"
                                            data-control="select2" data-placeholder="{{getCustomTranslation('select_a_nationality')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_nationality')}}...</option>
                                        @foreach($country as $value)
                                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('country')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="country_id[]" aria-label="{{getCustomTranslation('select_a_country')}}" multiple id="country"
                                            data-control="select2" data-placeholder="{{getCustomTranslation('select_a_country')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_country')}}...</option>
                                        @foreach($country as $value)
                                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('city')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="city_id[]" aria-label="{{getCustomTranslation('select_a_city')}}" multiple id="city" data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_city')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_city')}}...</option>
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('gender')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="gender" aria-label="Gender"
                                            data-control="select2" data-placeholder="{{getCustomTranslation('select_a_gender')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_gender')}}...</option>
                                        @foreach(genderType() as $value)
                                            <option value="{{$value}}">{{getCustomTranslation($value)}}</option>
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('birthdate')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="date" name="birthdate" value="{{Request::old('birthdate')}}"
                                           max="{{\Carbon\Carbon::today()->format('Y-m-d')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('birthdate')}}"/>
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
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('image')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                 style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"
                                     style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change icon">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="image_remove"/>
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">{{getCustomTranslation('allowed_file_types')}}: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Input group-->

                <!--end::Card body-->
            </div>
            <!--end::Content-->
        </div>
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->

            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                 data-bs-target="#kt_influencer_create" aria-expanded="true"
                 aria-controls="kt_influencer_create">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{getCustomTranslation('contact_information')}}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Content-->

            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->

                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('bio')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <textarea type="text" name="bio" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                              placeholder="{{getCustomTranslation('bio')}}">{{Request::old('bio')}}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('contact_number')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="contact_number" value="{{Request::old('contact_number')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" maxlength="14"
                                           placeholder="{{getCustomTranslation('contact_number')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('contact_email')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="email" name="contact_email" value="{{Request::old('contact_email')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('contact_email')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <div class="fv-row mb-7 d-flex">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mt-3 col-md-6">
                            <span>{{getCustomTranslation('mawthooq')}} ?</span>

                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                            <input name="mawthooq" class="form-check-input w-45px h-30px" type="checkbox"
                                   id="mawthooq" value="1"
                                   @if(Request::old('mawthooq')) checked="{{Request::old('mawthooq')}}" @endif>
                            <label class="form-check-label" for="mawthooq"></label>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('mawthooq_license_number')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="mawthooq_license_number" value="{{Request::old('mawthooq_license_number')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('mawthooq_license_number')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('mawthooq_license')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                 style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"
                                     style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change icon">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="mawthooq_license" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="mawthooq_license_remove"/>
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">{{getCustomTranslation('allowed_file_types')}}: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Input group-->

                <!--end::Card body-->
            </div>
            <!--end::Content-->
        </div>
        <!--begin::Card header-->
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                 data-bs-target="#kt_influencer_create" aria-expanded="true"
                 aria-controls="kt_influencer_create">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{getCustomTranslation('platform_info')}}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('platform')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="platform[]" aria-label="{{getCustomTranslation('select_a_platform')}}" id="platform"
                                            multiple="multiple" data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_platform')}}...</option>
                                        @foreach($platform as $value)
                                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('service')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row" id="service">

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
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('follower')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row" id="follower">

                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Input group-->
                <!--end::Card body-->

            </div>
            <!--end::Content-->

        </div>
        <!--end::Basic info-->
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">

            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                 data-bs-target="#kt_influencer_create" aria-expanded="true"
                 aria-controls="kt_influencer_create">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{getCustomTranslation('audience_info')}}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('gender_percentage')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->

                                @foreach(genderType() as $value)
                                    <div class="col-lg-6 fv-row">
                                        <label
                                            class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation($value)}}</label>
                                        <input type="text" name="genderPercentage[{{$value}}][gender]"
                                               class="form-control form-control-lg form-control-solid mb-3 "
                                               style="display: none" value="{{getCustomTranslation($value)}}"/>
                                        <input type="text" name="genderPercentage[{{$value}}][rate]"
                                               id="genderPercentage-{{$value}}" onchange="countGenderPercentage()"
                                               class="form-control form-control-lg form-control-solid mb-3 " value="0"/>
                                    </div>
                                @endforeach
                                <div id="error-genderPercentage" style="color: red"></div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('audience_country_info')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-12 fv-row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-light btn-active-light-primary me-2"
                                                onclick="addCountry()">{{getCustomTranslation('add')}}
                                        </button>
                                        <button type="button" class="btn btn-light btn-active-light-primary me-2"
                                                onclick="removeCountry()">{{getCustomTranslation('remove')}}
                                        </button>
                                        <div id="country_audience"></div>
                                        <input type="hidden" value="1" id="total_country_audience">
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
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('audience_category_info')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-12 fv-row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-light btn-active-light-primary me-2"
                                                onclick="addCategory()">{{getCustomTranslation('add')}}
                                        </button>
                                        <button type="button" class="btn btn-light btn-active-light-primary me-2"
                                                onclick="removeCategory()">{{getCustomTranslation('remove')}}
                                        </button>
                                        <div id="category_audience"></div>
                                        <input type="hidden" value="1" id="total_category_audience">
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>

                <!--end::Input group-->
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('influencer.index') }}" class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary" id="kt_influencer_create_submit">{{getCustomTranslation('save_changes')}}
                    </button>
                </div>
                <!--end::Actions-->

            </div>
            <!--end::Content-->

        </div>
        <!--end::Basic info-->
    </form>
    <!--end::Form-->
@endsection
@push('scripts')

    <script>
        var route = "{{ route('influencer.index') }}";

        //city list for country
        $('#country').change(function () {
            GetCity($(this).val());
        });

        function GetCity(country) {
            url = '{{ route("location.city.list") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {'parent_id': country},
                success: function (res) {
                    city = $(`#city`).val();
                    $(`#city`).empty();
                    for (let x in res) {
                        for (let i in res[x]) {
                            if(city.includes(`${res[x][i].id}`))
                            {
                                $(`#city`).append(`<option selected value="${res[x][i].id}">${res[x][i]['name_{{$lang}}']}</option>`);
                            }else{
                                $(`#city`).append(`<option value="${res[x][i].id}">${res[x][i]['name_{{$lang}}']}</option>`);
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

        platform_array = [];
        //service list & followers for platform
        $('#platform').change(function () {
            result_add = $(this).val().filter(x => !platform_array.includes(x));
            result_remove = platform_array.filter(x => !$(this).val().includes(x));
            platform_array = $(this).val();
            GetService($(this).val(), result_remove);
            GetFollower($(this).val(), result_remove);
        });

        function GetService(add, remove) {
            url = '{{ route("service.list") }}';
            if (result_remove[0] !== undefined) {
                $(`#service #service-${result_remove[0]}`).remove();
            }
            $.ajax({
                type: "GET",
                url: url,
                data: {'platform': result_add[0]},
                success: function (res) {
                    $(`#service`).append(`<div class="row" id="service-${result_add[0]}"></div>`);
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (result_add[0] !== undefined) {
                                $(`#service #service-${result_add[0]}`).append(`
                                <div class="col-lg-6 fv-row">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('service_name')}}</label>
                                    <input type="text" name="service[${result_add[0]}][${res[x][i].id}][platform_id]" class="form-control form-control-lg form-control-solid mb-3 " style="display: none" value="${result_add[0]}"/>
                                    <input type="text" name="service_name" disabled value="${res[x][i]['name_{{$lang}}']}"
                                           class="form-control form-control-lg form-control-solid mb-3 "/>
                                    <input type="text" name="service[${result_add[0]}][${res[x][i].id}][service_id]"  class="form-control form-control-lg form-control-solid mb-3 " style="display: none" value="${res[x][i].id}"/>
                                </div>
                                <div class="col-lg-6 fv-row">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Service Price</label>
                                    <input type="text" name="service[${result_add[0]}][${res[x][i].id}][price]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
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

        function GetFollower(add, remove) {
            url = '{{ route("platform.list") }}';

            if (remove[0] !== undefined) {
                $(`#follower #follower-${remove[0]}`).remove();
            }
            if(add.length != 0)
            {
            $.ajax({
                type: "GET",
                url: url,
                data: {'id': add},
                success: function (res) {

                    for (let x in res) {
                        for (let i in res[x]) {
                            var myEle = document.getElementById(`follower-${res[x][i].id}`);
                            if(myEle == null){
                                $(`#follower`).append(`<div class="row" id="follower-${res[x][i].id}"></div>`);
                                $(`#follower #follower-${res[x][i].id}`).append(`
                                <div class="col-lg-6 fv-row">
                                    <label class="col-lg-6 col-form-label  fw-semibold fs-6">{{getCustomTranslation('platform_name')}}</label>
                                    <input type="text" name="follower[${res[x][i].id}][platform_id]" class="form-control form-control-lg form-control-solid mb-3 " style="display: none" value="${res[x][i].id}"/>
                                    <input type="text" name="platform_name" disabled value="${res[x][i]['name_{{$lang}}']}"
                                           class="form-control form-control-lg form-control-solid mb-3 "/>
                                </div>
                           <div class="col-lg-6 fv-row">
                                    <label class="col-lg-6 col-form-label  fw-semibold fs-6">{{getCustomTranslation('platform_url')}}</label>
                                    <input type="text" name="follower[${res[x][i].id}][url]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                           </div>
                            <div class="col-lg-6 fv-row">
                                    <label class="col-lg-6 col-form-label  fw-semibold fs-6">{{getCustomTranslation('follower_size')}}</label>
                                    <select name="follower[${res[x][i].id}][size_id]" aria-label="Select a Size"  data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_size')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_size')}}...</option>
                                        @foreach($size as $value)
                                <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                        @endforeach
                                </select>
                           </div>
                            <div class="col-lg-6 fv-row">
                                    <label class="col-lg-6 col-form-label required fw-semibold fs-6">{{getCustomTranslation('followers')}}</label>
                                    <input type="text" name="follower[${res[x][i].id}][followers]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
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
        }

        function addCountry() {
            var total_country_audience = parseInt($('#total_country_audience').val()) + 1;
            var new_input = `<div class="row" id='new_${total_country_audience}' >
            <div class="col-md-6">
            <label class=" col-form-label required fw-semibold fs-6">{{getCustomTranslation('country')}}</label>
                        <select name="audienceCountry[${total_country_audience}][country_id]" aria-label="{{getCustomTranslation('select_a_country')}}" id="country_${total_country_audience}"
                                data-control="select2" data-placeholder="{{getCustomTranslation('select_a_country')}}..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">{{getCustomTranslation('select_a_country')}}...</option>
                            @foreach($country as $value)
            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                            @endforeach
            </select>
        </div>
        <div class="col-md-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('rate')}}</label>
                        <input type="text" name="audienceCountry[${total_country_audience}][rate]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                           </div>
                </div>`;
            $('#country_audience').append(new_input);
            $('#total_country_audience').val(total_country_audience)
        }

        function removeCountry() {
            var last_chq_no = $('#total_country_audience').val();
            if (last_chq_no > 1) {
                $('#new_' + last_chq_no).remove();
                $('#total_country_audience').val(last_chq_no - 1);
            }
        }

        function addCategory() {
            var total_category_audience = parseInt($('#total_category_audience').val()) + 1;
            var new_input = `<div class="row" id='new_${total_category_audience}' >
            <div class="col-md-6">
            <label class=" col-form-label required fw-semibold fs-6">{{getCustomTranslation('category')}}</label>
                        <select name="audienceCategory[${total_category_audience}][category_id]" aria-label="{{getCustomTranslation('select_a_category')}}" id="category_${total_category_audience}"
                                data-control="select2" data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">{{getCustomTranslation('select_a_category')}}</option>
                            @foreach($industry as $value)
            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                            @endforeach
            </select>
        </div>
        <div class="col-md-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Rate</label>
                        <input type="text" name="audienceCategory[${total_category_audience}][rate]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                           </div>
                </div>`;
            $('#category_audience').append(new_input);
            $('#total_category_audience').val(total_category_audience)
        }

        function removeCategory() {
            var last_chq_no = $('#total_category_audience').val();
            if (last_chq_no > 1) {
                $('#new_' + last_chq_no).remove();
                $('#total_category_audience').val(last_chq_no - 1);
            }
        }

        function countGenderPercentage() {
            $('#error-genderPercentage').empty();
            var count = 0;
            @foreach(genderType() as $value)
                count += parseInt(document.getElementById('genderPercentage-{{$value}}').value);
            @endforeach
            if (count !== 100 && count !== 0) {
                $('#error-genderPercentage').append('must count equal 100');
                document.getElementById('kt_influencer_create_submit').disabled = true;
            } else {
                $('#error-genderPercentage').empty();
                document.getElementById('kt_influencer_create_submit').disabled = false;
            }
        }
    </script>

    {!! JsValidator::formRequest('Modules\Acl\Http\Requests\Influencer\CreateRequest','#kt_influencer_create_form') !!}
@endpush
