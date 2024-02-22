@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('external_user'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_user_edit" aria-expanded="true"
             aria-controls="kt_user_edit">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('external_user')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_user_edit_form" class="form" method="post" action="{{route('client.update',$data->id)}}"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="suspended" value="0">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">

                    <!--begin::Input group-->

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
                                        <select name="role_id" id="role" aria-label="{{getCustomTranslation('select_a_role')}}"
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
                    <!--end::Input group-->
                    <!--begin::Input group-->
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
                                    <select name="parent[]" id="parent" aria-label="{{getCustomTranslation('select_a_parent_category')}}"
                                            multiple="multiple"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_parent_category')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value=""> {{getCustomTranslation('select_a_parent_category')}}...</option>
                                        @foreach($category as $value)
                                            <option value="{{$value->id}}"
                                                    @if(in_array($value->id,$data->category->pluck('parents.id')->toArray())) selected @endif>{{$value->{'name_'.$lang} }}</option>
                                        @endforeach
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('child_category')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="category[]" id="category" aria-label="{{getCustomTranslation('select_a_child_category')}}"
                                            multiple="multiple"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_child_category')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_child_category')}}...</option>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('company')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="company_id" id="company_id" aria-label="{{getCustomTranslation('select_a_company')}}"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_company')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_company')}}...</option>

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
                    <div class="row mb-6" id="website">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('website')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="website" value="{{$data->website}}"
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
                    <div class="row mb-6" id="company_size">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('company_size')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="company_size" value="{{$data->company_size}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('company_size')}}"
                                    />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
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
                                <div class="col-lg-6 fv-row">
                                    <!--begin::Col-->
                                    <select name="lang" aria-label="{{getCustomTranslation('language')}}"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('language')}}"
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="ar" @if($data->lang == "ar") selected @endif> العربية </option>
                                        <option value="en" @if($data->lang == "en") selected @endif> English </option>
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
                                    <input name="change_language" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="change_language" value="1"
                                           @if($data->change_language) checked="true" @endif>
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
                                    <input name="competitive_analysis_pdf" class="form-check-input w-45px h-30px" type="checkbox"
                                           id="allowmarketing" value="1"
                                           @if($data->competitive_analysis_pdf) checked="true" @endif>
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
                                    <input name="access_media_ad" class="form-check-input w-45px h-30px" type="checkbox"
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
                                    <input name="unlimit_balance" class="form-check-input w-45px h-30px" type="checkbox"
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
                                    <input type="number" name="balance" value="{{$data->balance}}" min="{{$data->request_ad_media_access_approve_balance()}}"
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
                    <!--begin::Input group-->
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
                                    <input type="date" name="start_access"
                                           value="{{ $data->start_access ? \Carbon\Carbon::parse($data->start_access)->format('Y-m-d') : ""}}"
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
                                    <input type="date" name="end_access"
                                           value="{{ $data->end_access ? \Carbon\Carbon::parse($data->end_access)->format('Y-m-d') : ""}}"
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
                    @endif
                    <!--end::Input group-->
                </div>
                <!--end::Input group-->
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="@if($userLogin->can('view_clients')){{ route('client.index') }} @else {{ route('dashboard') }}@endif"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary" id="kt_user_edit_submit">{{getCustomTranslation('save_changes')}}
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

        $(document).ready(function () {
            let company_id = "{{$data->company_id}}";

            function getcompany() {
                $('#company_id').attr('disabled', 'disabled');
                let get_files_url = "{{ route('company.InCategories') }}";
                $.ajax({
                    url: get_files_url,
                    method: 'GET',
                    data: {category_id: $('#category').val()},
                    success: function (data) {
                        $('#company_id').removeAttr('disabled');
                        $('#company_id').append(`<option value="">{{getCustomTranslation('select_a_company')}}...</option>`);
                        $.each(data, function (index, value) {
                            if (company_id == value.id) {
                                $('#company_id').append(`<option value="${value.id}" selected>${value['name_{{$lang}}']}</option>`);
                            } else {
                                $('#company_id').append(`<option value="${value.id}">${value['name_{{$lang}}']}</option>`);
                            }

                        });

                    },
                    error: function (error) {
                    }
                })
            }


            $('#category').change(function () {
                $('#company_id').attr('disabled', 'disabled');
                $('#company_id').empty();
                let get_files_url = "{{ route('company.InCategories') }}";
                $.ajax({
                    url: get_files_url,
                    method: 'GET',
                    data: {category_id: $(this).val()},
                    success: function (data) {
                        $('#company_id').removeAttr('disabled');
                        $('#company_id').append(`<option value="">{{getCustomTranslation('select_a_company')}}...</option>`);
                        $.each(data, function (index, value) {
                            if (company_id == value.id) {
                                $('#company_id').append(`<option value="${value.id}" selected>${value['name_{{$lang}}']}</option>`);
                            } else {
                                $('#company_id').append(`<option value="${value.id}">${value['name_{{$lang}}']}</option>`);
                            }

                        });

                    },
                    error: function (error) {
                    }
                })

            });
            $('#parent').change(function () {
                let get_files_url = "{{ route('category.child') }}";
                $.ajax({
                    url: get_files_url,
                    method: 'GET',
                    data: {parent_id: $('#parent').val()},
                    success: function (data) {
                        child = $('#category').val();
                        $('#category').empty();
                        $.each(data, function (index, value) {
                            if (child.includes(`${value.id}`)) {
                                $('#category').append(`<option value="${value.id}" selected>${value['name_{{$lang}}']}</option>`);
                            } else {
                                $('#category').append(`<option value="${value.id}">${value['name_{{$lang}}']}</option>`);
                            }

                        });

                    },
                    error: function (error) {
                    }
                })

            });

            function childCategory() {
                let get_files_url = "{{ route('category.child') }}";
                $.ajax({
                    url: get_files_url,
                    method: 'GET',
                    data: {parent_id: $('#parent').val()},
                    success: function (data) {
                        child = $('#category').val();
                        childOld = "{{json_encode(Request::old('category'))}}";
                        childData = "{{json_encode($data->category->pluck('id'))}}";
                        $('#category').empty();
                        $.each(data, function (index, value) {
                            if (child.includes(`${value.id}`) || childOld.includes(`${value.id}`) || childData.includes(`${value.id}`)) {
                                $('#category').append(`<option value="${value.id}" selected>${value['name_{{$lang}}']}</option>`);
                            } else {
                                $('#category').append(`<option value="${value.id}">${value['name_{{$lang}}']}</option>`);
                            }

                        });
                        getcompany();
                    },
                    error: function (error) {
                    }
                })
            }

            childCategory();

        });

        function showHidn(id) {
            const btn = document.getElementById(id);
            const display = window.getComputedStyle(btn).display;
            if (display == 'block') {
                document.getElementById(id).style.display = "none";
            } else {
                document.getElementById(id).style.display = "block";
            }
        }
        if({{$data->access_media_ad}})
        {
            showHidn('access_media')
        }
    </script>
@endpush

