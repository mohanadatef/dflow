@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('details')." ".getCustomTranslation('external_user'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_user_edit" aria-expanded="true"
             aria-controls="kt_user_edit">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('details')." ".getCustomTranslation('external_user')}}</h3>
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
                                <input type="text" disabled name="role" value="{{$data->role->name}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('role')}}"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('parent_category')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <select name="category1[]" disabled id="category1" aria-label="{{getCustomTranslation('select_a_category')}}"
                                        multiple="multiple"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_category')}}</option>
                                    @foreach($data->category->pluck('parents.name_'.$lang,'parents.id') as $key => $value)
                                        <option value="{{$key}}" selected>{{getCustomTranslation($value)}}</option>
                                    @endforeach
                                </select>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('child_category')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <select name="category[]" disabled id="category" aria-label="{{getCustomTranslation('select_a_category')}}"
                                        multiple="multiple"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_category')}}</option>
                                    @foreach($data->category as $value)
                                        <option value="{{$value->id}}"
                                                selected>{{$value->{'name_'.$lang} }}</option>
                                    @endforeach
                                </select>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('company')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <select name="company_id" disabled id="company_id"

                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    @if($data->company_id)
                                    <option value="{{$data->company_id}}"
                                            selected>{{$data->company->{'name_'.$lang}  }}</option>
                                    @endif
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('website')}}</label>
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
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('company_size')}}
                    </label>
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
                <div class="row mb-6" >
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('access_media_ad')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="menu-item px-5 fw-semibold text-muted text-hover-primary fs-7 form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input name="access_media_ad" disabled class="form-check-input w-45px h-30px" type="checkbox"
                                       id="access_media_ad" value="1" onclick="showHidn('access_media')"
                                       @if($data->access_media_ad == 1) checked="true" @endif>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <div id="access_media">
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
                                    <input name="unlimit_balance" disabled class="form-check-input w-45px h-30px" type="checkbox"
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
                                    <input type="number" name="balance" disabled value="{{$data->balance}}" min="{{$data->request_ad_media_access_approve_balance()}}"
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
                <div class="row mb-6" id="start_access">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('start_access_date')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input disabled type="date" name="start_access"
                                       value="{{ $data->start_access ? \Carbon\Carbon::parse($data->start_access)->format('Y-m-d') : "" }}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('start_access_date')}}"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6" id="end_access">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('end_access_date')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input disabled type="date" name="end_access"
                                       value="{{ $data->end_access  ? \Carbon\Carbon::parse($data->end_access)->format('Y-m-d') : "" }}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('end_access_date')}}"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
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
                                <input name="competitive_analysis_pdf" disabled class="form-check-input w-45px h-30px" type="checkbox"
                                       id="allowmarketing" value="1"
                                       @if($data->competitive_analysis_pdf) checked="true" @endif>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
            </div>
                <!--end::Input group-->

            <!--begin::Input group-->

            <!--end::Input group-->

            </div>
            <!--end::Input group-->
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{  route('client.index') }}" class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                <a href="{{  route('client.edit',$data->id) }}"
                   class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('go_to_update')}}</a>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Content-->

    <!--end::Basic info-->

@endsection
@push('scripts')

    <script>
        var route = "{{ route('client.index') }}";
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
