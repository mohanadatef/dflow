@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer'))

@section('content')

        @include('dashboard.error.error')


        <div class="row">
            <div class="col-md-6">
                <form id="kt_influencer_edit_form" class="form" method="post" action="{{route('influencer.merge.merge',$data->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                <!--begin::Basic info-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->

                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                         data-bs-target="#kt_influencer_edit" aria-expanded="true"
                         aria-controls="kt_influencer_edit">
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
                                        <div>
                                            <input type="text" name="name_en" value="{{$data->name_en}}"
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
                                        <div>
                                            <input type="text" name="name_ar" value="{{$data->name_ar}}"
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
                                        <div>
                                            <select name="category[]"
                                                    aria-label="{{getCustomTranslation('select_a_category')}}"
                                                    multiple="multiple"
                                                    data-control="select2"
                                                    data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                                <option value="">{{getCustomTranslation('select_a_category')}}</option>
                                                @foreach($category as $value)
                                                    <option value="{{$value->id}}"
                                                            @if(in_array($value->id,$data->category->pluck('id')->toArray())) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                                        <div>
                                            <select name="nationality_id"
                                                    aria-label="{{getCustomTranslation('select_a_nationality')}}"
                                                    id="nationality"
                                                    data-control="select2"
                                                    data-placeholder="{{getCustomTranslation('select_a_nationality')}}..."
                                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                                <option value="">{{getCustomTranslation('select_a_nationality')}}...
                                                </option>
                                                @foreach($country as $value)
                                                    <option value="{{$value->id}}"
                                                            @if($value->id == $data->nationality_id) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                                        <div>
                                            <select name="country_id[]"
                                                    aria-label="{{getCustomTranslation('select_a_country')}}"
                                                    id="country" multiple
                                                    data-control="select2"
                                                    data-placeholder="{{getCustomTranslation('select_a_country')}}..."
                                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                                <option value="">{{getCustomTranslation('select_a_country')}}...
                                                </option>
                                                @foreach($country as $value)
                                                    <option value="{{$value->id}}"
                                                            @if(in_array($value->id , $data->country->pluck('id')->toArray())) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                                        <div>
                                            <select name="city_id[]"
                                                    aria-label="{{getCustomTranslation('select_a_city')}}" id="city"
                                                    data-control="select2" multiple
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
                                        <div>
                                            <select name="gender" aria-label="Gender"
                                                    data-control="select2"
                                                    data-placeholder="{{getCustomTranslation('select_a_gender')}}..."
                                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                                <option value="">{{getCustomTranslation('select_a_gender')}}...</option>
                                                @foreach(genderType() as $value)
                                                    <option value="{{$value}}"
                                                            @if($value == $data->gender) selected @endif>{{getCustomTranslation($value)}}</option>
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
                                        <div>
                                            <input type="date" name="birthdate" value="{{$data->birthdate}}"
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
                                        <!--begin::Preview existing image-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                             style="background-image: url('{{getFile($data->image->file??null,pathType()['ip'],getFileNameServer($data->image)) }}')"></div>
                                        <!--end::Preview existing image-->
                                        <!--begin::Label-->
                                        <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change icon">
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
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                title="Cancel image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                title="Remove image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <!--begin::Hint-->
                                    <div class="form-text">{{getCustomTranslation('allowed_file_types')}}: png, jpg,
                                        jpeg.
                                    </div>
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
                                              placeholder="{{getCustomTranslation('bio')}}">{{$data->bio}}</textarea>
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
                                                <input type="text" name="contact_number" value="{{$data->contact_number}}"
                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
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
                                                <input type="email" name="contact_email" value="{{$data->contact_email}}"
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
                                               @if($data->mawthooq) checked="{{$data->mawthooq}}" @endif>
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
                                                <input type="text" name="mawthooq_license_number" value="{{$data->mawthooq_license_number}}"
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
                         data-bs-target="#kt_influencer_edit" aria-expanded="true"
                         aria-controls="kt_influencer_edit">
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
                                        <div>
                                            <select name="platform[]"
                                                    aria-label="{{getCustomTranslation('select_a_platform')}}"
                                                    id="platform"
                                                    multiple="multiple" data-control="select2"
                                                    data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                                <option value="">{{getCustomTranslation('select_a_platform')}}...
                                                </option>
                                                @foreach($platform as $value)
                                                    <option value="{{$value->id}}"
                                                            @if(in_array($value->id,$data->platform->pluck('id')->toArray())) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                                        <div id="service">
                                            @foreach($data->influencer_service_platform as $service)
                                                <div class="row" id="service-{{$service->platform_id}}">
                                                    <div>
                                                        <label class="col-lg-4 col-form-label w-100 required fw-semibold fs-6">{{getCustomTranslation('service_name')}}</label>
                                                        <input type="text"
                                                               name="service[{{$service->platform_id}}][{{$service->id}}][platform_id]"
                                                               class="form-control form-control-lg form-control-solid mb-3 "
                                                               style="display: none" value="{{$service->platform_id}}"/>
                                                        <input type="text" name="platform_name" disabled
                                                               value="{{$service->platform->name_en.'/'.$service->platform->{'name_'.$lang} }}"
                                                               class="form-control form-control-lg form-control-solid mb-3 "/>
                                                        <input type="text" name="service_name" disabled
                                                               value="{{$service->service->{'name_'.$lang} }}"
                                                               class="form-control form-control-lg form-control-solid mb-3 "/>
                                                        <input type="text"
                                                               name="service[{{$service->platform_id}}][{{$service->id}}][service_id]"
                                                               class="form-control form-control-lg form-control-solid mb-3 "
                                                               style="display: none" value="{{$service->service_id}}"/>
                                                    </div>
                                                    <div>
                                                        <label class="col-lg-4 col-form-label w-100 required fw-semibold fs-6">{{getCustomTranslation('service_price')}}
                                                        </label>
                                                        <input type="text"
                                                               name="service[{{$service->platform_id}}][{{$service->id}}][price]"
                                                               value="{{$service->price}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @foreach($data->platform as $p)
                                                @foreach($p->service as $service)
                                                    @if(!in_array($service->id,$data->influencer_service_platform->pluck('service_id')->toArray()))
                                                        <div class="row" id="service-{{$p->id}}">
                                                            <div>
                                                                <label class="col-lg-4 col-form-label w-100 required fw-semibold fs-6">{{getCustomTranslation('service_name')}}</label>
                                                                <input type="text"
                                                                       name="service[{{$p->id}}][{{$service->id}}][platform_id]"
                                                                       class="form-control form-control-lg form-control-solid mb-3 "
                                                                       style="display: none" value="{{$p->id}}"/>
                                                                <input type="text" name="platform_name" disabled
                                                                       value="{{$p->name_en.'/'.$p->name_ar}}"
                                                                       class="form-control form-control-lg form-control-solid mb-3 "/>
                                                                <input type="text" name="service_name" disabled
                                                                       value="{{$service->{'name_'.$lang} }}"
                                                                       class="form-control form-control-lg form-control-solid mb-3 "/>
                                                                <input type="text"
                                                                       name="service[{{$p->id}}][{{$service->id}}][service_id]"
                                                                       class="form-control form-control-lg form-control-solid mb-3 "
                                                                       style="display: none" value="{{$service->id}}"/>
                                                            </div>
                                                            <div>
                                                                <label class="col-lg-4 col-form-label w-100 required fw-semibold fs-6">{{getCustomTranslation('service_price')}}
                                                                </label>
                                                                <input type="text"
                                                                       name="service[{{$p->id}}][{{$service->id}}][price]"
                                                                       value="0"
                                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
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
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('follower')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div id="follower">
                                            @foreach($data->influencer_follower_platform as $follower)
                                                <div class="row" id="follower-{{$follower->platform_id}}">
                                                    <div>
                                                        <label class="col-lg-6 col-form-label w-100 fw-semibold fs-6">{{getCustomTranslation('platform_name')}}
                                                        </label>
                                                        <input type="text"
                                                               name="follower[{{$follower->platform_id}}][platform_id]"
                                                               class="form-control form-control-lg form-control-solid mb-3 "
                                                               style="display: none"
                                                               value="{{$follower->platform_id}}"/>
                                                        <input type="text" name="platform_name" disabled
                                                               value="{{$follower->platform->{'name_'.$lang} }}"
                                                               class="form-control form-control-lg form-control-solid mb-3 "/>
                                                    </div>
                                                    <div>
                                                        <label class="col-lg-6 col-form-label w-100 fw-semibold fs-6">{{getCustomTranslation('platform_url')}}</label>
                                                        <input type="text"
                                                               name="follower[{{$follower->platform_id}}][url]"
                                                               value="{{$follower->url}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                                                    </div>
                                                    <div>
                                                        <label class="col-lg-6 col-form-label w-100 fw-semibold fs-6">{{getCustomTranslation('follower_size')}}
                                                        </label>
                                                        <select name="follower[{{$follower->platform_id}}][size_id]"
                                                                aria-label="{{getCustomTranslation('follower_size')}}"
                                                                data-control="select2"
                                                                data-placeholder="{{getCustomTranslation('follower_size')}}..."
                                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                                            <option value="">{{getCustomTranslation('follower_size')}}
                                                                ...
                                                            </option>
                                                            @foreach($size as $value)
                                                                <option value="{{$value->id}}"
                                                                        @if($value->id == $follower->size_id) selected @endif>{{$value->{'name_'.$lang} }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="col-lg-6 col-form-label  fw-semibold fs-6">{{getCustomTranslation('followers')}}</label>
                                                        <input type="text"
                                                               name="follower[{{$follower->platform_id}}][followers]"
                                                               value="{{$follower->followers}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                                                    </div>
                                                </div>
                                            @endforeach
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
                         data-bs-target="#kt_influencer_edit" aria-expanded="true"
                         aria-controls="kt_influencer_edit">
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
                                <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('gender_percentage')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        @foreach(genderType() as $value)
                                            <div>
                                                <label
                                                        class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation($value)}}</label>
                                                <input type="text" name="genderPercentage[{{$value}}][gender]"
                                                       class="form-control form-control-lg form-control-solid mb-3 "
                                                       style="display: none" value="{{getCustomTranslation($value)}}"/>
                                                <input type="text" name="genderPercentage[{{$value}}][rate]"
                                                       onchange="countGenderPercentage()"
                                                       class="form-control form-control-lg form-control-solid mb-3"
                                                       id="genderPercentage-{{$value}}"
                                                       value="{{$data->influencer_gender()->where('gender',$value)->first()->rate ?? 0}}"/>
                                            </div>
                                        @endforeach
                                        <!--end::Col-->
                                        <div id="error-genderPercentage" style="color: red"></div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('audience_country_info')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <div class="col-md-6">
                                                <button type="button"
                                                        class="btn btn-light btn-active-light-primary me-2"
                                                        onclick="addCountry()">{{getCustomTranslation('add')}}
                                                </button>
                                                <button type="button"
                                                        class="btn btn-light btn-active-light-primary me-2"
                                                        onclick="removeCountry()">{{getCustomTranslation('remove')}}
                                                </button>
                                                <div id="country_audience">
                                                    @php
                                                        $count = 2;
                                                    @endphp
                                                    @foreach($data->influencer_country_audience as $country_audience)
                                                        <div id='new_{{$count}}'>
                                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('country')}}</label>
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-12 fv-row">
                                                                        <select name="audienceCountry[{{$count}}][country_id]"
                                                                                aria-label="{{getCustomTranslation('select_a_country')}}"
                                                                                id="country_{{$count}}"
                                                                                data-control="select2"
                                                                                data-placeholder="{{getCustomTranslation('select_a_country')}}..."
                                                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                                                            <option value="">{{getCustomTranslation('select_a_country')}}
                                                                                ...
                                                                            </option>
                                                                            @foreach($country as $value)
                                                                                <option value="{{$value->id}}"
                                                                                        @if($value->id == $country_audience->country_id) selected @endif>{{$value->{'name_'.$lang} }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label
                                                                        class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('rate')}}</label>
                                                                <input type="text"
                                                                       name="audienceCountry[{{$count}}][rate]"
                                                                       value="{{$country_audience->rate}}"
                                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                                <input type="hidden" value="{{$count-1}}" id="total_country_audience">
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
                                <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('audience_category_info')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <div class="col-md-6">
                                                <button type="button"
                                                        class="btn btn-light btn-active-light-primary me-2"
                                                        onclick="addCategory()">{{getCustomTranslation('add')}}
                                                </button>
                                                <button type="button"
                                                        class="btn btn-light btn-active-light-primary me-2"
                                                        onclick="removeCategory()">{{getCustomTranslation('remove')}}
                                                </button>
                                                <div id="category_audience">
                                                    @php
                                                        $count = 2;
                                                    @endphp
                                                    @foreach($data->influencer_category_audience as $category_audience)
                                                        <div id='new_{{$count}}'>
                                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('category')}}</label>
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-12 fv-row">
                                                                        <select name="audienceCategory[{{$count}}][category_id]"
                                                                                aria-label="{{getCustomTranslation('select_a_category')}}"
                                                                                id="category_{{$count}}"
                                                                                data-control="select2"
                                                                                data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                                                            <option value="">{{getCustomTranslation('select_a_category')}}</option>
                                                                            @foreach($industry as $value)
                                                                                <option value="{{$value->id}}"
                                                                                        @if($value->id == $category_audience->category_id) selected @endif>{{$value->{'name_'.$lang} }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label
                                                                        class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('rate')}}</label>
                                                                <input type="text"
                                                                       name="audienceCategory[{{$count}}][rate]"
                                                                       value="{{$category_audience->rate}}"
                                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                                <input type="hidden" value="{{$count-1}}" id="total_category_audience">
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
                            <a href="{{  route('influencer.index') }}"
                               class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                            <button type="submit" class="btn btn-primary"
                                    id="kt_influencer_edit_submit">{{getCustomTranslation('save_changes')}}
                            </button>
                        </div>
                        <!--end::Actions-->

                    </div>
                    <!--end::Content-->

                </div>

            </div>
            <div class="col-md-6">
                <div>
                    <select id="search_influencer" name="influencer_id"
                            class="form-select form-select-solid form-select-lg fw-semibold"></select>
                </div>
                </form>
                <div id="influencer"></div>
            </div>
        </div>
        <!--end::Basic info-->

    <!--end::Form-->
@endsection
@push('scripts')

    <script>
        var route = "{{ route('influencer.index') }}";
        GetCity({{json_encode($data->country->pluck('id')->toArray())}}, {{json_encode($data->city->pluck('id')->toArray())}});
        var route = "{{ route('influencer.index') }}";
        countGenderPercentage();
        //city list for country
        function GetCity(country, city) {
            url = '{{ route("location.city.list") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {'parent_id': country},
                success: function (res) {
                    cityVal = $(`#city`).val();
                    $(`#city`).empty();
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (res[x][i].id == city || cityVal.includes(`${res[x][i].id}`)) {
                                $(`#city`).append(`<option value="${res[x][i].id}" selected>${res[x][i].name_en}/${res[x][i].name_ar}</option>`);
                            } else {
                                $(`#city`).append(`<option value="${res[x][i].id}">${res[x][i].name_en}/${res[x][i].name_ar}</option>`);
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

        platform_array = $('#platform').val();
        //service list & followers for platform
        $('#platform').change(function () {
            result_add = $(this).val().filter(x => !platform_array.includes(x));
            result_remove = platform_array.filter(x => !$(this).val().includes(x));
            platform_array = $(this).val();
            GetService($(this).val(), result_remove);
            GetFollower($(this).val(), result_remove);
        });

        function GetService(add, remove) {
            url = '{{ route("platform.list") }}';
            if (remove[0] !== undefined) {
                $(`#service #service-${remove[0]}`).remove();
            }
            if (add.length != 0) {
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {'id': add},
                    success: function (res) {
                        for (let x in res) {
                            for (let i in res[x]) {
                                var myEle = document.getElementById(`service-${res[x][i].id}`);
                                if (myEle == null) {
                                    $(`#service`).append(`<div class="row" id="service-${res[x][i].id}"></div>`);
                                    for (let y in res[x][i].service) {
                                        $(`#service #service-${res[x][i].id}`).append(`
                                <div>
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Service Name</label>
                                    <input type="text" name="service[${res[x][i].id}][${res[x][i].service[y].id}][platform_id]" class="form-control form-control-lg form-control-solid mb-3 " style="display: none" value="${res[x][i].id}"/>
                                    <input type="text" name="platform_name" disabled value="${res[x][i].name_en}/${res[x][i].name_ar}"
                                           class="form-control form-control-lg form-control-solid mb-3 "/>

                                    <input type="text" name="service_name" disabled value="${res[x][i].service[y].name_en}/${res[x][i].service[y].name_ar}"
                                           class="form-control form-control-lg form-control-solid mb-3 "/>
                                    <input type="text" name="service[${res[x][i].id}][${res[x][i].service[y].id}][service_id]"  class="form-control form-control-lg form-control-solid mb-3 " style="display: none" value="${res[x][i].service[y].id}"/>
                                </div>
                                <div>
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Service Price</label>
                                    <input type="text" name="service[${res[x][i].id}][${res[x][i].service[y].id}][price]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                           </div>`);
                                    }
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

        function GetFollower(add, remove) {
            url = '{{ route("platform.list") }}';
            if (remove[0] !== undefined) {
                $(`#follower #follower-${remove[0]}`).remove();
            }
            if (add.length != 0) {
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {'id': add},
                    success: function (res) {
                        for (let x in res) {
                            for (let i in res[x]) {
                                var myEle = document.getElementById(`follower-${res[x][i].id}`);
                                if (myEle == null) {
                                    $(`#follower`).append(`<div class="row" id="follower-${res[x][i].id}"></div>`);
                                    $(`#follower #follower-${res[x][i].id}`).append(`
                                <div>
                                    <label class="col-lg-6 col-form-label w-100 fw-semibold fs-6">Platform Name</label>
                                    <input type="text" name="follower[${res[x][i].id}][platform_id]" class="form-control form-control-lg form-control-solid mb-3 " style="display: none" value="${res[x][i].id}"/>
                                    <input type="text" name="platform_name" disabled value="${res[x][i].name_en}/${res[x][i].name_ar}"
                                           class="form-control form-control-lg form-control-solid mb-3 "/>
                                </div>
                            <div>
                                    <label class="col-lg-6 col-form-label  fw-semibold fs-6">PLatform Url</label>
                                    <input type="text" name="follower[${res[x][i].id}][url]"  value="0"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-6"/>
                           </div>
                            <div>
                                    <label class="col-lg-6 col-form-label  fw-semibold fs-6">Follower Size</label>
                                    <select name="follower[${res[x][i].id}][size_id]" aria-label="Select a Size"  data-control="select2"
                                            data-placeholder="Select a Size..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">Select a Size...</option>
                                        @foreach($size as $value)
                                    <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                        @endforeach
                                    </select>
                               </div>
                                <div>
                                        <label class="col-lg-6 col-form-label  fw-semibold fs-6">Followers</label>
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
            <label class=" col-form-label required fw-semibold fs-6">Country</label>
                        <select name="audienceCountry[${total_country_audience}][country_id]" aria-label="Select a Country" id="country_${total_country_audience}"
                                data-control="select2" data-placeholder="Select a Country..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">Select a Country...</option>
                            @foreach($country as $value)
            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                            @endforeach
            </select>
        </div>
        <div class="col-md-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Rate</label>
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
            <label class=" col-form-label required fw-semibold fs-6">Country</label>
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
                document.getElementById('kt_influencer_edit_submit').disabled = true;
            } else {
                $('#error-genderPercentage').empty();
                document.getElementById('kt_influencer_edit_submit').disabled = false;
            }
        }
        let path = "{{ route('influencer.merge.search') }}";
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#search_influencer').select2({
            minimumInputLength: 1,
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: path,
                method: 'get',
                dataType: 'json',
                delay: 1000,
                data: function (params) {
                    return {
                        term: params.term,
                        id: params.id,
                        influencer_id: {{$data->id}},
                    };
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_'+"{{$lang}}"],
                            }
                        }),
                    };
                },
            } ,
            escapeMarkup: function (markup) {
                return markup;
            }
        }).on('select2:select', function (e) {
            loadMainCompany(e.params.data.id);
        });

        function loadMainCompany(data) {
            $.ajax({
                type: "GET",
                url: "{{route('influencer.merge.get')}}",
                data: {
                    "id": data,
                },
                success: function (res) {
                    $('#influencer').empty();
                    $('#influencer').html(res);
                }
            });
        }
    </script>

    {!! JsValidator::formRequest('Modules\Acl\Http\Requests\Influencer\CreateRequest','#kt_influencer_edit_form') !!}
@endpush
