@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('merge_company'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_company_create" aria-expanded="true"
             aria-controls="kt_company_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0"> {{getCustomTranslation('main_company')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        @include('dashboard.error.error')
        <form id="kt_company_create_form" class="form" method="get"
              action="#"
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

                </div>
            </div>
            <div class="row" id="merge-company" style="display:none">
                <div class="card-body border-top p-9">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{getCustomTranslation('merge_company')}}</h3>
                        <br>
                    </div>
                    <select id="search_company_merge" name="merge_company"
                            class="form-select form-select-solid form-select-lg fw-semibold"
                            data-mce-placeholder=""
                    ></select>
                </div>
                <input type="hidden" name="companies[]" id="companies">
                <div id="merge_company" class="card-body border-top px-9" style="overflow: scroll"></div>
            </div>

            <!--end::Form-->
        </div>
        <!--end::Content-->
        </form>
    </div>
    <!--end::Basic info-->
@endsection
@push('scripts')
    <script src="{{ asset('dashboard') }}/assets/jquery/jquery-ui.min.js" >
    </script>
    <script src="{{ asset('dashboard/') }}/assets/js/company/merge.js"></script>
    <script>
        let path = "{{ route('company.merge.search') }}";
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#search_company').select2({
            minimumInputLength: 1,
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_company')}}...",
            ajax: {
                cacheDataSource: [],
                url: path,
                method: 'get',
                dataType: 'json',
                delay: 1000,
                data: function (params) {
                    company_id  = [];
                    c = document.getElementsByClassName('id_company');
                    for(let i in c) {
                        company_id.push(c[i].value)
                    }
                    return {
                        term: params.term,
                        id: params.id,
                        company_id: company_id,
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
                    return "{{getCustomTranslation('no_results_found')}}"
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
                    $('#owner-company').empty();
                    $('#owner-company').html(res);
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
            minimumInputLength: 1,
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_a_company')}}...",
            ajax: {
                cacheDataSource: [],
                url: "{{ route('company.merge.search') }}",
                method: 'get',
                dataType: 'json',
                delay: 1000,
                data: function (params) {
                    company_id  = [];
                    c = document.getElementsByClassName('id_company');
                    for(let i in c) {
                        company_id.push(c[i].value)
                    }
                    return {
                        term: params.term,
                        id: params.id,
                        company_id: company_id,
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
                    return "{{getCustomTranslation('no_results_found')}}"
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
            company_id  = [data];
            c = document.getElementsByClassName('id_company');
            for(let i in c) {
                company_id.push(c[i].value)
            }
            $.ajax({
                type: "GET",
                url: "{{route('company.merge.get.company')}}",
                data: {
                    "id": company_id,
                },
                success: function (res) {
                    $('#merge_company').empty();
                    $('#merge_company').html(res);
                }
            });

        }
        function removeCampnay(id) {
            $(`#company-${id}`).remove();
        }

    </script>
    {!! JsValidator::formRequest('Modules\Acl\Http\Requests\Company\MergeRequest') !!}
@endpush
