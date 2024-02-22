@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('external_user'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_user_create" aria-expanded="true"
             aria-controls="kt_user_create">
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
            <form id="kt_user_create_form" class="form" method="post" action="{{route('client.store')}}"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="1" disabled>
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    @if(in_array(user()->role_id, [1, 10]))
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Role</label>
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
                                            <option
                                                    value="{{$value->id}}"
                                                    data-type="{{$value->type}}"
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
                    @endif
                    <!--end::Input group-->
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
                                    <input type="text" name="name" value="{{Request::old('name')}}"
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
                                    <input type="email" name="email" value="{{Request::old('email')}}"
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('password')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="password" name="password" value="{{Request::old('password')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('password')}}"/>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('password_confirmation')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="password" name="password_confirmation"
                                           value="{{Request::old('password_confirmation')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('password_confirmation')}}"/>
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
                                    <select name="parent[]" id="parent"
                                            aria-label="{{getCustomTranslation('select_a_parent_category')}}"
                                            multiple="multiple"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_parent_category')}}"
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_parent_category')}}...
                                        </option>
                                        @foreach($category as $value)
                                            <option
                                                    @if(Request::old('parent'))
                                                        @if(in_array($value->id,Request::old('parent'))) selected
                                                    @endif @endif
                                                    value="{{$value->id}}">{{$value->{'name_'.$lang}  }}</option>
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
                                    <select name="category[]" id="category"
                                            aria-label="{{getCustomTranslation('select_a_child_category')}}"
                                            multiple="multiple"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_child_category')}}"
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
                                    <select name="company_id" id="company_id" disabled
                                            aria-label="{{getCustomTranslation('select_a_company')}}"
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
                                    <input type="text" name="website" value="{{Request::old('website')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('website')}}"
                                    />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->


                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6" id="company_size">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6 ">{{getCustomTranslation('company_size')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="company_size" value="{{Request::old('company_size')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('company_size')}}"/>
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
                                        <option value="ar" @if(old('lang') == "ar") selected @endif> العربية</option>
                                        <option value="en" @if(old('lang') == "en") selected @endif> English</option>
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
                                           @if(old('change_language') == 1) checked="true" @endif>
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
                                    <input name="competitive_analysis_pdf" class="form-check-input w-45px h-30px"
                                           type="checkbox"
                                           id="allowmarketing" value="1"
                                           @if(old('competitive_analysis_pdf')) checked="true" @endif>
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
                                           @if(old('access_media_ad') == 1) checked="true" @endif>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div id="access_media" style="display:block;">
                        <div class="row mb-6" id="unlimit_balance" >
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
                                               @if(Request::old('unlimit_balance')) checked="{{Request::old('unlimit_balance')}}" @endif>

                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6" id="balance" >
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 ">{{getCustomTranslation('balance')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="number" name="balance" value="{{Request::old('balance')}}"
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="{{getCustomTranslation('balance')}}"/>
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
                                           value="{{ old('start_access') ?? \Carbon\Carbon::parse('today')->format('Y-m-d')}}"
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
                                           value="{{ old('end_access') ?? \Carbon\Carbon::parse('today')->format('Y-m-d')}}"
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
                    <a href="{{  route('client.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary"
                            id="kt_user_create_submit">{{getCustomTranslation('save_changes')}}
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
    <script src="{{ asset('dashboard') }}/assets/jquery/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            let company_id = "{{Request::old('company_id')}}";

            function getcompany() {
                $('#company_id').attr('disabled', 'disabled');
                let get_files_url = "{{ route('company.InCategories') }}";
                if (company_id) {
                    $.ajax({
                        url: get_files_url,
                        method: 'GET',
                        data: {category_id: $("#category").val()},
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

            }

            getcompany();
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
                        $('#category').empty();
                        $.each(data, function (index, value) {
                            if (child.includes(`${value.id}`) || childOld.includes(`${value.id}`)) {
                                $('#category').append(`<option value="${value.id}" selected>${value['name_{{$lang}}']}</option>`);
                            } else {
                                $('#category').append(`<option value="${value.id}">${value['name_{{$lang}}']}</option>`);
                            }

                        });

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
    </script>
@endpush

