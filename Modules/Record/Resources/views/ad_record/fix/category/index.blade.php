@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('fix_category_ad'))

@section('content')
    <!--begin::Products-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_company_create" aria-expanded="true"
             aria-controls="kt_company_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                @can('export_ad_record')
                    <button type="button" class="btn btn-primary me-3" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end" id="export" style="display: none">
                <span class="svg-icon svg-icon-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                              transform="rotate(90 12.75 4.25)" fill="currentColor"/>
                        <path
                                d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                fill="currentColor"/>
                        <path opacity="0.3"
                              d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                              fill="currentColor"/>
                    </svg>
                </span>
                        {{getCustomTranslation('export')}}
                    </button>
                @endcan
                <!--begin::Menu-->
                <div id="kt_datatable_example_export_menu"
                     class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                     data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="copy" onclick="exportData('en')">
                            English
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="excel" onclick="exportData('ar')">
                            العربية
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
            </div>
            <!--end::Card title-->
        </div>
        @include('dashboard.error.error')
        <form id="kt_fix_form" class="form" method="post"
              action="{{route('ad_record.category.fixed')}}"
              enctype="multipart/form-data">
            @csrf
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->

                <div class="row">
                    <div class="card-body border-top p-9">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0 required">{{getCustomTranslation('target_company_category')}}</h3>
                            <br>
                        </div>
                        <select name="target_company_category"
                                aria-label="{{getCustomTranslation('select_a_category')}}" id="target_company_category"
                                data-control="select2"
                                data-placeholder="{{getCustomTranslation('select_a_category')}}..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">{{getCustomTranslation('select_a_category')}}...</option>
                            @foreach($categories as $value)
                                <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="card-body border-top p-9">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">{{getCustomTranslation('misclassified_category')}}</h3>
                                    <br>
                                </div>
                                <select name="misclassified_category[]"
                                        aria-label="{{getCustomTranslation('select_a_category')}}"
                                        id="misclassified_category"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_a_category')}}..." multiple
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_category')}}...</option>
                                    @foreach($categories as $value)
                                        <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="card-body border-top p-9">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0 required">{{getCustomTranslation('correct_category')}}</h3>
                                    <br>
                                </div>
                                <select name="correct_category"
                                        aria-label="{{getCustomTranslation('select_a_category')}}" id="correct_category"
                                        data-control="select2"
                                        data-placeholder="{{getCustomTranslation('select_a_category')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_category')}}...</option>
                                    @foreach($categories as $value)
                                        <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-body border-top p-9">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{getCustomTranslation('target_company')}}</h3>
                            <br>
                        </div>
                        <div id="target_company">

                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">

                    <button id='btn'  type="button" class="btn btn-primary" onclick="disableButton()">{{getCustomTranslation('fix')}}
                    </button>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </form>
        <!--end::Card header-->
    </div>
@endsection
@push('scripts')
    <script>
        function disableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = true;
            btn.innerText = '{{getCustomTranslation('sending')}}...';
            document.getElementById('kt_fix_form').submit();
        }
        $('#target_company_category').change(function () {
            $('#loading').css('display', 'flex');
            document.getElementById('export').style.display = 'none';
            $('#target_company').empty();
            $.ajax({
                type: "GET",
                url: "{{route('company.list')}}",
                data: {
                    "industry": $('#target_company_category').val(),
                },
                success: function (res) {
                    if (res.data.length) {
                        text = `<div class="row">`;
                        for (let x in res) {
                            for (let i in res[x]) {
                                text += `<div class="col-md-4">${res[x][i].id} : ${res[x][i].name_en} / ${res[x][i].name_ar} </div>`;
                            }
                        }
                        text += `</div>`;
                        $('#target_company').append(text);

                        document.getElementById('export').style.display = 'block';
                    }
                    $('#loading').css('display', 'none');
                }
            });
        });
        function exportData(lang) {
            var params = {
                target_company_category:  $('#target_company_category').val(),
                lang: lang,
            };
            location.href = "{{ route('ad_record.export' )}}?" + jQuery.param(params);
        }
    </script>
    {!! JsValidator::formRequest('Modules\Record\Http\Requests\AdRecord\FixCategoryRequest','#kt_fix_form') !!}
@endpush
