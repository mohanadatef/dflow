@extends('dashboard.layouts.app')

@section('title',getCustomTranslation('content_record') )

@push('styles')
    <link href="{{ asset('dashboard') }}/assets/css/video.css" rel="stylesheet" type="text/css"/>

@endpush

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_content_record_edit" aria-expanded="true"
             aria-controls="kt_content_record_edit">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('content_record')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_content_record_edit_form" class="form" method="post"
                  action="{{route('content_record.update',$data->id)}}"
                  enctype="multipart/form-data">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">


                    <!--begin::Input group-->
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
                                    <select name="platform_id"
                                            aria-label="{{getCustomTranslation('select_a_platform')}}"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_platform')}}...</option>
                                        @foreach($platform as $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $data->id) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('influencer')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="influencer_id"
                                            aria-label="{{getCustomTranslation('select_an_influencer')}}"
                                            id="influencer"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_an_influencer')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_an_influencer')}}...</option>
                                        @foreach($influencer as $value)
                                            <option value="{{$value->id}}"
                                                    @if($value->id == $data->influencer_id) selected @endif>{{$value->{'name_'.$lang} }}</option>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('company')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">

                                    <select id="search_company" name="company_id"
                                            class="form-select form-select-solid form-select-lg fw-semibold"
                                            data-mce-placeholder=""
                                    >
                                        <option value="{{$data->company_id}}"
                                                selected>{{$data->company->{'name_'.$lang} }}</option>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('date')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="date" name="date" value="{{ date('Y-m-d',strtotime($data->date)) }}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('date')}}"/>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('video')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-4">

                            <div class="video-input-container">
                                <label for="video-input video-input col-form-label">{{getCustomTranslation('select_a_video_from_your_computer')}}
                                    <br> {{getCustomTranslation('allowed_file_types')}}: mp4,mov,ogg </label>
                                <input type="file" id="video-input" class="video" name="video"
                                       value="{{getFile($data->video->file??null,pathType()['ip'],getFileNameServer($data->video))}}"
                                       accept="video/mp4">
                            </div>

                            <div class="player">
                                <video controls autoplay loop
                                       src="{{getFile($data->video->file??null,pathType()['ip'],getFileNameServer($data->video))}}"
                                       class="player-video-viewer"></video>

                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{  route('content_record.index') }}"
                           class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                        <button type="submit" class="btn btn-primary"
                                id="kt_content_record_edit_submit">{{getCustomTranslation('save_changes')}}
                        </button>
                    </div>
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

        var path = "{{ route('reports.search_companies') }}";

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_' + "{{$lang}}"],
                            }
                        }),
                    };
                },
            }
        })
            .on('select2:select', function (e) {
                let id = e.params.data.id
            });
    </script>

    <script src="{{ asset('dashboard') }}/assets/js/video.js"></script>

    <script>
        setTimeout(() => {
            buildPlayer();
        }, 1500)
    </script>

    {!! JsValidator::formRequest('Modules\Record\Http\Requests\ContentRecord\EditRequest','#kt_content_record_edit_form') !!}
@endpush
