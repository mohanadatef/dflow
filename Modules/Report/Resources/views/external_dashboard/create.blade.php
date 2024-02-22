@extends('dashboard.layouts.app')
@section('title', getCustomTranslation('create_external_dashboard'))


@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_ad_record_create" aria-expanded="true"
             aria-controls="kt_ad_record_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('create_external_dashboard')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="form" class="form" method="post" action="{{route('external_dashboard.store')}}"
                  enctype="multipart/form-data">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
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
                            </div>
                            <!--end::Col-->

                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('start_date')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="date" name="start_date"
                                                   value="{{Request::old('start_date') ? \Carbon\Carbon::parse(Request::old('start_date'))->format('Y-m-d') :  \Carbon\Carbon::today()}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('start_date')}}"
                                                   id="start_date"
                                            />
                                        </div>
                                    </div>
                                    <!--end::Col-->

                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-6">

                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('end_date')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="date" name="end_date"
                                                   value="{{Request::old('end_date') ? \Carbon\Carbon::parse(Request::old('end_date'))->format('Y-m-d') :  \Carbon\Carbon::today()}}"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('end_date')}}"
                                                   id="end_date"
                                            />
                                        </div>
                                    </div>
                                    <!--end::Col-->

                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('category')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="category_id[]"
                                            multiple="multiple"
                                            data-placeholder="{{getCustomTranslation('select_a_category')}}"
                                            id="category"
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                    </select>
                                </div>
                            </div>
                            <!--end::Col-->

                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('company')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select id="search_company" name="company_id[]"
                                            class="form-select form-select-solid form-select-lg fw-semibold"
                                            data-mce-placeholder="" multiple="multiple"
                                    >

                                        @if(Request::old('company_id'))
                                            @php
                                                $companies = [];
                                                foreach (Request::old('company_id') as $company){
                                                    $companies [] = \Modules\Acl\Entities\Company::find($company);
                                                }
                                            @endphp
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}"
                                                        selected>{{$company->name_en ."/". $company->name_ar}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--end::Col-->

                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('assign_users')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select id="search_user" name="users[]"
                                            class="form-select form-select-solid form-select-lg fw-semibold"
                                            data-mce-placeholder="" multiple="multiple"
                                    >

                                        @if(Request::old('users'))
                                            @php
                                                $users = \App\Models\User::find(Request::old('users'));
                                            @endphp
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}"
                                                        selected>{{$user->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--end::Col-->

                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>

                </div>

                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('external_dashboard.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>

                    <button id='btn' type="submit" style="margin-left: 10px" class="btn btn-primary">
                        {{getCustomTranslation('save_changes')}}
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
        var path = "{{ route('reports.search_companies') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
                    return "{{getCustomTranslation('no_results_found')}}<br> " +
                        '<button   style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;" onclick="openCreateCompany()" class="select2-link">{{getCustomTranslation('add_new_company')}}</button>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        })


        url = '{{ route("category.list_search") }}';
        userUrl = '{{ route("external_dashboard.listAssign") }}';
        $('#category').select2({
            minimumInputLength: 0,
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
            },
        });

        $('#search_user').select2({
            minimumInputLength: 0,
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_user')}}...",
            ajax: {
                cacheDataSource: [],
                url: userUrl,
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {

                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        }),
                    };
                },
            },
        });

    </script>
    {!! JsValidator::formRequest('Modules\Report\Http\Requests\ExternalDashboard\CreateRequest','#form') !!}
@endpush
