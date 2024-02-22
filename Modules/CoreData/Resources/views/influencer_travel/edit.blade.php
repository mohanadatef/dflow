@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer_travel'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_influencer_travel_edit" aria-expanded="true"
             aria-controls="kt_influencer_travel_edit">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('influencer_travel')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_influencer_travel_edit_form" class="form" method="post"
                  action="{{route('influencer_travel.update',$data->id)}}">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">

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
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $data->country_id) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('city')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="city_id" aria-label="{{getCustomTranslation('select_a_city')}}"
                                            id="city" data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_city')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_city')}}...</option>
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
                                    <input type="date" name="date_from" value="{{date('Y-m-d',strtotime($data->date_from)) }}"
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
                                    <input type="date" name="date_to" value="{{date('Y-m-d',strtotime($data->date_to)) }}"
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
                                        <option value="{{$data->influencer_id}}" selected>
                                            @if($data->influencer)
                                                {{$data->influencer->name_en .'/'.$data->influencer->name_ar }}
                                            @endif
                                        </option>

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
                    <a href="{{  route('influencer_travel.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary"
                            id="kt_influencer_travel_edit_submit">{{getCustomTranslation('save_changes')}}
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
        GetCity({{$data->country_id}}, {{$data->city_id}});
        var route = "{{ route('influencer_travel.index') }}";
        //city list for country
        $('#country').change(function () {
            GetCity($(this).val(),0);
        });

        function GetCity(country) {
            url = '{{ route("location.city.list") }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {'parent_id': country},
                success: function (res) {
                    $(`#city`).empty();
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (res[x][i].id == city) {
                                $(`#city`).append(`<option value="${res[x][i].id}" selected>${res[x][i].name_en}/${res[x][i].name_ar}</option>`);
                            } else {
                                $(`#city`).append(`<option value="${res[x][i].id}">${res[x][i].name_en}/${res[x][i].name_ar}</option>`);
                            }
                        }

                    }

                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
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
    </script>
    {!! JsValidator::formRequest('Modules\CoreData\Http\Requests\InfluencerTravel\CreateRequest','#kt_influencer_travel_edit_form') !!}
@endpush
