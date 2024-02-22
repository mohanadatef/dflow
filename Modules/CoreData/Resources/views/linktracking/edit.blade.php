@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('link_tracking'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_linktracking_create" aria-expanded="true" aria-controls="kt_linktracking_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('link_tracking')}} {{getCustomTranslation('details')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <form id="kt_linktracking_edit_form" class="form" method="post"
                  action="{{ route('linktracking.update', $linktracking->id) }}">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('destination')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-10 fv-row">
                                    <input type="url" name="destination"
                                           value="{{ Request::old('destination') ?? $linktracking->destination }}"
                                           class="form-control  form-control-solid mb-3 mb-lg-0"
                                           placeholder="https://www.example.com"/>
                                    @if ($errors->has('destination'))
                                        <div>
                                            <p class="invalid-input">{{ $errors->first('destination') }}</p>
                                        </div>
                                    @endif
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('title')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-10 fv-row">
                                    <input type="text" name="title"
                                           value="{{ Request::old('title') ?? $linktracking->title }}"
                                           class="form-control  form-control-solid mb-3 mb-lg-0" placeholder="{{getCustomTranslation('title')}}"/>
                                    @if ($errors->has('title'))
                                        <div>
                                            <p class="invalid-input">{{ $errors->first('title') }}</p>
                                        </div>
                                    @endif
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
                                <div class="col-lg-10 fv-row">
                                    <select id="influencer" name="influencer_id"
                                            class="form-select form-select-solid form-select-lg fw-semibold"
                                            data-mce-placeholder=""
                                    >
                                        @if($linktracking->influencer)
                                            <option value="{{$linktracking->influencer_id}}" selected>{{$linktracking->influencer->name_en}}</option>
                                        @endif
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <!--end::Input group-->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="none-tab" data-bs-toggle="tab" data-bs-target="#none"
                                    type="button" role="tab" aria-controls="none" aria-selected="true">{{getCustomTranslation('none')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="country-tab" data-bs-toggle="tab" data-bs-target="#country"
                                    type="button" role="tab" aria-controls="country" aria-selected="false">{{getCustomTranslation('country')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="device-tab" data-bs-toggle="tab" data-bs-target="#device"
                                    type="button" role="tab" aria-controls="device" aria-selected="false">{{getCustomTranslation('device')}}
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="none" role="tabpanel" aria-labelledby="none-tab">
                        </div>
                        <div class="tab-pane fade" id="country" role="tabpanel" aria-labelledby="country-tab">
                            <!--begin::Repeater-->
                            <div id="kt_docs_repeater_basic">
                                @if( !empty($tracking_countries))
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="countries">
                                            @foreach ($tracking_countries as $oldCountry)
                                                <div data-repeater-item class="mt-5">
                                                    <div class="form-group row">
                                                        <div class="col-md-4">
                                                            <label class="form-label">{{getCustomTranslation('country')}}:</label>
                                                            <select class="form-control mb-2 mb-md-0" name="country_id"
                                                                    id="">
                                                                @foreach ($countries as $country)
                                                                    <option
                                                                        {{ $oldCountry['country_id'] == $country->id ? 'selected' : '' }}
                                                                        value="{{ $country->id }}"
                                                                    >
                                                                        {{ $country->{'name_'.$lang} }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">{{getCustomTranslation('destination')}}:</label>
                                                            <input type="url" name="destination"
                                                                   value="{{ $oldCountry['destination'] }}"
                                                                   class="form-control mb-2 mb-md-0"
                                                                   placeholder="https://www.example.cpm"/>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="javascript:;" data-repeater-delete
                                                               class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                <i class="la la-trash-o"></i>{{getCustomTranslation('delete')}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!--end::Form group-->
                                @else
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="countries">
                                            <div data-repeater-item class="mt-5">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">{{getCustomTranslation('country')}}:</label>
                                                        <select class="form-control mb-2 mb-md-0" name="country_id"
                                                                id="">
                                                            @foreach ($countries as $country)
                                                                <option
                                                                    value="{{ $country->id }}">{{ $country->{'name_'.$lang} }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">{{getCustomTranslation('destination')}}:</label>
                                                        <input type="url" name="destination"
                                                               class="form-control mb-2 mb-md-0"
                                                               placeholder="https://www.example.cpm"/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete
                                                           class="btn btn-sm btn-light-danger mt-3 mt-md-8"><i
                                                                class="la la-trash-o"></i>{{getCustomTranslation('delete')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->
                                @endif
                                <!--begin::Form group-->
                                <div class="form-group mt-5">
                                    <a href="javascript:;" data-repeater-create class="btn btn-primary">
                                        <i class="la la-plus"></i>{{getCustomTranslation('add')}}
                                    </a>
                                </div>
                                <!--end::Form group-->
                            </div>
                            <!--end::Repeater-->
                        </div>
                        <div class="tab-pane fade" id="device" role="tabpanel" aria-labelledby="device-tab">
                            <!--begin::Input group-->
                            <div class="row mb-6 mt-5">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{getCustomTranslation('ios')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-10 fv-row">
                                            <input type="url" name="ios_url"
                                                   value="{{ Request::old('ios_url') ?? $linktracking->ios_url }}"
                                                   class="form-control  form-control-solid mb-3 mb-lg-0"
                                                   placeholder="https://www.example.com"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6 mt-5">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{getCustomTranslation('android')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-10 fv-row">
                                            <input type="url" name="android_url"
                                                   value="{{ Request::old('android_url') ?? $linktracking->android_url }}"
                                                   class="form-control  form-control-solid mb-3 mb-lg-0"
                                                   placeholder="https://www.example.com"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6 mt-5">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{getCustomTranslation('windows')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-10 fv-row">
                                            <input type="url" name="windows_url"
                                                   value="{{ Request::old('windows_url') ?? $linktracking->windows_url }}"
                                                   class="form-control  form-control-solid mb-3 mb-lg-0"
                                                   placeholder="https://www.example.com"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6 mt-5">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{getCustomTranslation('linux')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-10 fv-row">
                                            <input type="url" name="linux_url"
                                                   value="{{ Request::old('linux_url') ?? $linktracking->linux_url }}"
                                                   class="form-control  form-control-solid mb-3 mb-lg-0"
                                                   placeholder="https://www.example.com"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6 mt-5">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">{{getCustomTranslation('mac')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-10 fv-row">
                                            <input type="url" name="mac_url"
                                                   value="{{ Request::old('mac_url') ?? $linktracking->mac_url }}"
                                                   class="form-control  form-control-solid mb-3 mb-lg-0"
                                                   placeholder="https://www.example.com"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>

                    <div class="row mb-6 mt-5">
                        <!--begin::Label-->
                        <label class="col-lg-2 col-form-label fw-semibold fs-6">{{getCustomTranslation('note')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-10">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-10 fv-row">
                                    <textarea type="text" name="note" class="form-control  form-control-solid mb-3 mb-lg-0">{{ Request::old('note') ?? $linktracking->note}}</textarea>
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
                    <a href="{{ route('linktracking.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary" id="kt_linktracking_create_submit">{{getCustomTranslation('save_changes')}}
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
        let route = "{{ route('linktracking.index') }}";
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
                                text: item['name_'+"{{$lang}}"],
                            }
                        }),
                    };
                },
            }
        });
    </script>
    {!! JsValidator::formRequest('Modules\CoreData\Http\Requests\Linktracking\EditRequest', '#kt_linktracking_edit_form') !!}
    <script src="{{ asset('dashboard') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/custom/documentation/forms/formrepeater/basic.js"></script>
@endpush
