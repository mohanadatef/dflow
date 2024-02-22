@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer_trend'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_influencer_trend_create" aria-expanded="true"
             aria-controls="kt_influencer_trend_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('influencer_trend')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_influencer_trend_create_form" class="form" method="post"
                  action="{{route('influencer_trend.store')}}">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('subject')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="subject" value="{{Request::old('subject')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('subject')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('brief')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="brief" value="{{Request::old('brief')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('brief')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('audience_impression')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="audience_impression" aria-label="audience_impression"
                                            data-control="select2" data-placeholder="{{getCustomTranslation('select_a_audience_impression')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_audience_impression')}}...</option>
                                        @foreach(audienceImpressionType() as $value)
                                            <option value="{{$value}}">{{getCustomTranslation($value)}}</option>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('country')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="country_id" aria-label="{{getCustomTranslation('select_a_country')}}"
                                            id="country"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_country')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_country')}}...</option>
                                        @foreach($country as $value)
                                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
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
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                            <span>{{getCustomTranslation('tag')}}</span>
                        </label>
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Input group-->

                            <!--begin::Label-->

                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <!--end::Label-->
                                    <div style="text-align:right">
                                        <button onclick="removeCreateTag()" id="closeTagFormBtn" type="button"
                                                class="btn-close d-none" aria-label="Close"></button>
                                    </div>
                                    <div id="selectTag">
                                        <select id="tag" name="tag_id" aria-label="{{getCustomTranslation('select_a_tag')}}"
                                                data-control="select2"
                                                data-placeholder="{{getCustomTranslation('select_a_tag')}}..."
                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                            <option value="">{{getCustomTranslation('select_a_tag')}}...</option>
                                            @foreach($tag as $value)
                                                <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;"
                                                onclick="openCreateTag()"
                                                class="select2-link">{{getCustomTranslation('add_new_tag')}}</button>
                                        <div id="tag_selected" class="d-none alert alert-success"></div>

                                        <div class="d-flex align-items-center position-relative my-1 select_tag">

                                        </div>

                                    </div>
                                    <div id="createTag" class="d-none bg-primary p-4">
                                        <h3 class="text-white py-4">{{getCustomTranslation('add_new_tag')}}</h3>
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Col-->
                                            <div class="col-lg-12">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="fv-row">
                                                        <input id="name_en" type="text" name="name_en"
                                                               value="{{Request::old('name_en')}}"
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
                                            <!--begin::Col-->
                                            <div class="col-lg-12">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="fv-row">
                                                        <input id="name_ar" type="text" name="name_ar"
                                                               value="{{Request::old('name_ar')}}"
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
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="fv-row">
                                                    <span onClick="tagSubmitted()"
                                                          class="btn btn-info mt-6 w-100">{{getCustomTranslation('done')}}</span>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div id="tagSubmittedView" class="d-none">
                                        <div class="w-100 d-flex justify-content-between py-4 ">
                                            <span id="tagEnglishName"></span>
                                            <div class="d-flex">
                                                <i onclick="showCreateTag()"
                                                   class="fa-regular fa-pen-to-square mx-4"></i>
                                                <i onclick="removeCreateTag()" class="fa-solid fa-x"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end::Input group-->
                                </div>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('platform')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="platform[]" aria-label="{{getCustomTranslation('select_a_platform')}}"
                                            multiple="multiple"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_platform')}}...</option>
                                        @foreach($platform as $value)
                                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('date_from')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="date" name="date_from" value="{{Request::old('date_from')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('date_from')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('date_to')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="date" name="date_to" value="{{Request::old('date_to')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('date_to')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('influencer')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select id="influencer" name="influencer_id"
                                            class="form-select form-select-solid form-select-lg fw-semibold"
                                            data-mce-placeholder=""
                                    >
                                        @php $influencer_data = \Modules\Acl\Entities\Influencer::find(Request::old('influencer_id')); @endphp
                                        @if($influencer_data)
                                                <option value="{{$influencer_data->id}}"
                                                        selected>{{$influencer_data->name_en ."/". $influencer_data->name_ar}}
                                                </option>
                                        @endif

                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>

                </div>
                <!--end::Input group-->
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('influencer_trend.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary"
                            id="kt_influencer_trend_create_submit">{{getCustomTranslation('save_changes')}}
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
        var route = "{{ route('influencer_trend.index') }}";

        function openCreateTag(b) {
            showCreateTag();
        }

        function removeCreateTag() {
            $('#new_tag').removeClass('d-none')

            $('#closeTagFormBtn').addClass('d-none');
            $('#openTagFormBtn').removeClass('d-none');
            $('#selectTag').removeClass('d-none');
            $('#createTag').addClass('d-none');
            $("#tag").val(null).trigger("change");
            //GetCategory($('#tag').val());

            // show preserved new tag
            $('#tagSubmittedView').addClass('d-none');
        }

        function showCreateTag() {
            $('#closeTagFormBtn').removeClass('d-none');
            $('#openTagFormBtn').addClass('d-none');
            $('#new_tag').addClass('d-none')

            $('#selectTag').addClass('d-none');
            $('#createTag').removeClass('d-none');

            $('#tagSubmittedView').addClass('d-none');
        }

        let search_influencer_url = "{{ route('influencer.search') }}";
        $('#influencer').select2({
            delay: 900,
            placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: search_influencer_url,
                method: 'get',
                dataType: 'json',
                delay: 900,
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
            }
        });

        function tagSubmitted() {

            url = '{{ route("tag.check") }}';
            name_en = $('#name_en').val();
            name_ar = $('#name_ar').val();

            $.ajax({
                type: "get",
                url: url,
                data: {
                    'name_en': name_en,
                    'name_ar': name_ar,
                },
                success: function () {
                    var tag_name = $("input[name=name_en]").val();
                    if (tag_name !== '' ) {
                        // reverse show create company
                        $('#closeTagFormBtn').addClass('d-none');
                        $('#openTagFormBtn').removeClass('d-none');
                        $('#new_tag').removeClass('d-none')
                        $('#createTag').addClass('d-none');

                        $('#tagSubmittedView').removeClass('d-none');
                        var tag_name = $("input[name=name_en]").val();
                        $('#tagEnglishName').html(tag_name)
                        document.getElementById("name_ar").reset();
                        document.getElementById("name_en").reset();
                    }

                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });

        }
    </script>

@endpush
