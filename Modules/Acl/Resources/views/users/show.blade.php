@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('details')." ".getCustomTranslation('user') )

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_user_edit" aria-expanded="true"
             aria-controls="kt_user_edit">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('details')." ".getCustomTranslation('user')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('name')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" disabled name="name" value="{{$data->name}}"
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
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('email')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="email" disabled name="email" value="{{$data->email}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('email')}}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                @if($data->role->type)
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('website')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" disabled name="website" value="{{$data->website}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('website')}}"/>
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
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('conatact_person_name')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" disabled name="conatact_person_name"
                                       value="{{$data->conatact_person_name}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('conatact_person_name')}}"/>
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
                    <label class="col-lg-4 disabled col-form-label fw-semibold fs-6">{{getCustomTranslation('conatact_person_email')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="email" disabled name="conatact_person_email"
                                       value="{{$data->conatact_person_email}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('conatact_person_email')}}"/>
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
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('company_size')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" disabled name="company_size" value="{{$data->company_size}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('company_size')}}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                @endif
                @if(in_array(user()->role_id, [1, 10]))
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
                                <input type="text" disabled name="company_size" value="{{$data->role->name}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('role')}}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                @endif
                <!--end::Input group-->
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
                        </div>
                        <!--end::Image input-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>

            <!--end::Input group-->
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{  route('user.index') }}" class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                <a href="{{  route('user.edit',$data->id) }}"
                   class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('go_to_update')}}</a>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

@endsection
@push('scripts')

    <script>
        var route = "{{ route('user.index') }}";
        function showHidn(id) {
            const btn = document.getElementById(id);
            const display = window.getComputedStyle(btn).display;
            if (display == 'block') {
                document.getElementById(id).style.display = "none";
            } else {
                document.getElementById(id).style.display = "block";
            }
        }
    </script>
@endpush
