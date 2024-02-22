@extends('dashboard.layouts.app')

@section('title', 'Merge Company')

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_company_create" aria-expanded="true"
             aria-controls="kt_company_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0"> Main Company</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        @include('dashboard.error.error')
        <form id="kt_company_create_form" class="form" method="post"
              action="{{route('company.merge.merge')}}"
              enctype="multipart/form-data">
            @csrf
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->

            <div class="row">
                <div class="card-body border-top p-9">
                    <select id="search_company" name="company_id"
                            class="form-select form-select-solid form-select-lg fw-semibold"
                            data-mce-placeholder=""
                    ></select>
                </div>
                <div id="owner-company" style="display:none">

                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name En</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="id_company" id="id_company"
                                                   value="{{Request::old('id_company')}}" hidden>
                                            <input type="text" name="name_en" id="name_en"
                                                   value="{{Request::old('name_en')}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="Name En"/>
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
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name Ar</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="name_ar" id="name_ar"
                                                   value="{{Request::old('name_ar')}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="Name Ar"/>
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
                                <label class="col-lg-4 col-form-label  fw-semibold fs-6">Link</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="link" id="link" value="{{Request::old('link')}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="Link"/>
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
                                <label class="col-lg-4 col-form-label  fw-semibold fs-6">Contact Info</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="contact_info" id="contact_info"
                                                   value="{{Request::old('contact_info')}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="contact info"/>
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
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Industry</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <select name="industry[]" aria-label="Select a industry" id="industry"
                                                    multiple="multiple"
                                                    data-control="select2" data-placeholder="Select a industry..."
                                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                                <option value="">Select a industry...</option>
                                                @foreach($industry as $value)
                                                    <option value="{{$value->id}}">{{$value->name_en}}</option>
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

                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{  route('company.index') }}"
                                   class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                <button type="submit" class="btn btn-primary" id="kt_company_create_submit">Merge
                                </button>
                            </div>
                        </div>
                        <!--end::Actions-->

                </div>
            </div>
            <div class="row" id="merge-company" style="display:none">
                <div class="card-body border-top p-9">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Merge Company</h3>
                        <br>
                    </div>
                    <select id="search_company_merge" name="company__merge_id"
                            class="form-select form-select-solid form-select-lg fw-semibold"
                            data-mce-placeholder=""
                    ></select>
                </div>
                <div id="merge_company" class="card-body border-top p-9" ></div>
            </div>

            <!--end::Form-->
        </div>
        <!--end::Content-->
        </form>
    </div>
    <!--end::Basic info-->
    <div class="modal fade" id="kt_modal_show" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Company info</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-merge-modal-action="close">
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

                    <!--begin::Form-->
                    <div class="card-body border-top p-9" id="show">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name En</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="text" name="name_en" disabled id="name_en"
                                               value="{{Request::old('name_en')}}"
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="Name En"/>
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
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name Ar</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="text" name="name_ar" disabled id="name_ar"
                                               value="{{Request::old('name_ar')}}"
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="Name Ar"/>
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
                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Link</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="text" name="link" id="link" value="{{Request::old('link')}}" disabled
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="Link"/>
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
                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Contact Info</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="text" name="contact_info" id="contact_info"
                                               value="{{Request::old('contact_info')}}" disabled
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="contact info"/>
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
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Industry</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <select name="industry1[]" aria-label="Select a industry" id="industry1" disabled
                                                multiple="multiple"
                                                data-control="select2" data-placeholder="Select a industry..."
                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                            <option value="">Select a industry...</option>
                                            @foreach($industry as $value)
                                                <option value="{{$value->id}}">{{$value->name_en}}</option>
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

                        <!--end::Card body-->

                    </div>


                    <!--end::Form-->

                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('dashboard') }}/assets/jquery/jquery-ui.min.js" >
    </script>
    <script src="{{ asset('dashboard/') }}/assets/js/company/merge.js"></script>
    <script>
        let path = "{{ route('company.merge.search') }}";
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#search_company').select2({
            minimumInputLength: 3,
            delay: 1000,
            placeholder: "Select a Company...",
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
                    };
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                },
            } ,templateResult: template,
            templateSelection: template,language: {
                "noResults": function () {
                    return "No Results Found <br> " +
                        '<button   style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;" onclick="openCreateCompany()" class="select2-link">Add New Company</button>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }).on('select2:select', function (e) {
            loadMainCompany(e.params.data.id);
        });

        function loadMainCompany(data) {
            $.ajax({
                type: "GET",
                url: "{{route('company.merge.get')}}",
                data: {
                    "id": data,
                },
                success: function (res) {
                    $('#name_en').val(res.name_en);
                    $('#name_ar').val(res.name_ar);
                    $('#link').val(res.link);
                    $("#industry").select2("val", [res.industry_id]);
                    $('#contact_info').val(res.contact_info);
                }
            });

            document.getElementById("owner-company").style.display = "block"
            document.getElementById("merge-company").style.display = "block"
        }
        function template(data) {
            if ($(data.html).length === 0) {
                return data.text;
            }
            return $(data.html);
        }
        $('#search_company_merge').select2({
            minimumInputLength: 3,
            delay: 1000,
            placeholder: "Select a Company...",
            ajax: {
                cacheDataSource: [],
                url: "{{ route('company.merge.search') }}",
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                },
            } ,templateResult: template,
            templateSelection: template,language: {
                "noResults": function () {
                    return "No Results Found <br> " +
                        '<button   style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;" onclick="openCreateCompany()" class="select2-link">Add New Company</button>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }).on('select2:select', function (e) {
            loadMergeCompany(e.params.data.id);
            $('#search_company_merge').empty();
        });

        function loadMergeCompany(data) {
            $.ajax({
                type: "GET",
                url: "{{route('company.merge.get')}}",
                data: {
                    "id": data,
                },
                success: function (res) {
                    $('#merge_company').append(`<div class="row mb-6" id="${res.id}">
                                            <input type="text" name="merge_company[]" hidden
                                                   value="${res.id}"
                                                  />
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name En</label>
                                <div class="col-lg-4">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="name_en"
                                                   value="${res.name_en}" disabled
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                  />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4"><a type="button"
                                       class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-bs-toggle="modal"
                                onclick="loadModal(${res.id})"
                                data-bs-target="#kt_modal_update_role">
                                        <span class="svg-icon svg-icon-5 m-0">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    </a>
                                        <a type="button" onclick="companyDelete(${res.id})"
                                       class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-5 m-0">
                                        <i class="fa fa-x"></i>
                                    </span>
                                    </a></div>
                            </div>`)
                }
            });


        }

        function companyDelete(id)
        {
            $(`#${id}`).remove()
        }
        function loadModal(id) {

            $.ajax({
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "{{route('company.merge.get')}}",
                data: {
                    "id": id,
                },
            }).
            done(function (res) {
                $('#show #name_en').val(res.name_en);
                $('#show #name_ar').val(res.name_ar);
                $('#show #link').val(res.link);
                $('#show #contact_info').val(res.contact_info);
                $("#show #industry1").select2("val", [res.industry_id]);
                $('#kt_modal_show').modal('show');
            })
        }
    </script>
    {!! JsValidator::formRequest('Modules\Acl\Http\Requests\Company\MergeRequest') !!}
@endpush
