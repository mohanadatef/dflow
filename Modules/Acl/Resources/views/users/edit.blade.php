@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('user'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_user_edit" aria-expanded="true"
             aria-controls="kt_user_edit">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('user')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_user_edit_form" class="form" method="post" action="{{route('user.update',$data->id)}}"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="suspended" value="0">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    @if($userLogin->can('update_users'))
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('role')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <select name="role_id" id="role"
                                                aria-label="{{getCustomTranslation('select_a_role')}}"
                                                data-control="select2"
                                                data-placeholder="{{getCustomTranslation('select_a_role')}}..."
                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                            <option value="">{{getCustomTranslation('select_a_role')}}...</option>
                                            @foreach($role as $value)
                                                <option value="{{$value->id}}"
                                                        data-type="{{$value->type}}"
                                                        @if($value->id==$data->role_id) selected @endif
                                                >
                                                    {{$value->name}}
                                                </option>
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
                    @else
                        <input type="hidden" name="role_id" value="{{$data->role_id}}">
                    @endif
                    <input
                            type="hidden" name="type" value="1"
                            @if($data->role->type != 1)
                                disabled
                            @endif
                    >
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="name" value="{{$data->name}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('name')}}"/>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('email')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="email" name="email" value="{{$data->email}}"
                                           @if(!in_array(user()->role_id,[1,10])) disabled @endif
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('email')}}"/>
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
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('avatar')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                 style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"
                                     style="background-image: url('{{getFile($data->avatar->file??null,pathType()['ip'],getFileNameServer($data->avatar)) }}')"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change icon">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove avatar">
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
                    @if(in_array(user()->role_id, [1, 10]))
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('language')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <select name="lang" aria-label="{{getCustomTranslation('language')}}"
                                                data-control="select2"
                                                data-placeholder="{{getCustomTranslation('language')}}"
                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                            <option value="ar" @if($data->lang == "ar") selected @endif> العربية
                                            </option>
                                            <option value="en" @if($data->lang == "en") selected @endif> English
                                            </option>
                                        </select>
                                        <!--end::Col-->
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('change_language')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="menu-item px-5 fw-semibold text-muted text-hover-primary fs-7 form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input name="change_language" class="form-check-input w-45px h-30px"
                                               type="checkbox"
                                               id="change_language" value="1"
                                               @if($data->change_language) checked="true" @endif>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('access_media_ad')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="menu-item px-5 fw-semibold text-muted text-hover-primary fs-7 form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input name="access_media_ad" class="form-check-input w-45px h-30px"
                                               type="checkbox"
                                               id="access_media_ad" value="1" onclick="showHidn('access_media')"
                                               @if($data->access_media_ad == 1) checked="true" @endif>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div id="access_media" style="display:block;">
                            <div class="row mb-6" id="unlimit_balance">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 ">{{getCustomTranslation('unlimit')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="menu-item px-5 fw-semibold text-muted text-hover-primary fs-7 form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input name="unlimit_balance" class="form-check-input w-45px h-30px"
                                                   type="checkbox"
                                                   id="allowmarketing" value="1"
                                                   @if($data->unlimit_balance) checked="true" @endif>
                                        </div>
                                        <span>{{getCustomTranslation('unlimit_used')}} : {{$data->request_ad_media_access_approve_unlimit()}}</span>

                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>

                            <div class="row mb-6" id="balance">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 ">{{getCustomTranslation('balance')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="number" name="balance" value="{{$data->balance}}"
                                                   min="{{$data->request_ad_media_access_approve_balance()}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('balance')}}"/>
                                            <span>{{getCustomTranslation('used')}} : {{$data->request_ad_media_access_approve_balance()}} <br>
                                        {{getCustomTranslation('available')}} : {{$data->balance - $data->request_ad_media_access_approve_balance()}}</span>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <div class="row mb-6" id="competitive_analysis_pdf">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 ">{{getCustomTranslation('competitive_analysis_pdf')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="menu-item px-5 fw-semibold text-muted text-hover-primary fs-7 form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input name="competitive_analysis_pdf" class="form-check-input w-45px h-30px"
                                               type="checkbox"
                                               id="allowmarketing" value="1"
                                               @if($data->competitive_analysis_pdf) checked="true" @endif>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                    @endif
                    <!--end::Input group-->
                </div>
                <!--end::Input group-->
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="@if($userLogin->can('view_users')){{ route('user.index') }} @else {{ route('dashboard') }}@endif"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary"
                            id="kt_user_edit_submit">{{getCustomTranslation('save_changes')}}
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

@endsection
@push('scripts')
    <script>
        let suspended = {{user()->suspended}};
        if (suspended) {
            alert("{{getCustomTranslation('please_add_the_missing_data_to_be_able_to_access_the_dashboard')}}");
        }
        let route = "{{ route('user.index') }}";

        function showHidn(id) {
            const btn = document.getElementById(id);
            const display = window.getComputedStyle(btn).display;
            if (display == 'block') {
                document.getElementById(id).style.display = "none";
            } else {
                document.getElementById(id).style.display = "block";
            }
        }

        if ({{$data->access_media_ad}}) {
            showHidn('access_media')
        }
    </script>
@endpush
