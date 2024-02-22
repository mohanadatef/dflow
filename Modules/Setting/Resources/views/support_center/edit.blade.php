@extends('dashboard.layouts.app')
@section('title', getCustomTranslation('create_question'))


@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_ad_record_create" aria-expanded="true"
             aria-controls="kt_ad_record_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('create_question')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="form" class="form" method="post" action="{{route('question.update', [$data->id])}}"
                  enctype="multipart/form-data">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row row-cols-1 row-cols-sm-1 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('question')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->

                                    <input type="text" name="question" value="{{$data->question}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('question')}}"/>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('answered')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select name="is_answered" id="is_answered" aria-label="{{getCustomTranslation('answered')}}"
                                            data-control="select2"
                                            data-placeholder="{{getCustomTranslation('answered')}}"
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option @if($data->is_answered) selected @endif value="1">{{getCustomTranslation('answered')}}</option>
                                        <option value="0" @if(!$data->is_answered) selected @endif>{{getCustomTranslation('not_answered')}}</option>

                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div id="images-inputs"></div>
                    <div class="col-lg-8">
                        <div class="dropzone" id="kt_modal_create_project_settings_logo">
                            <!--begin::Message-->
                            <div class="dz-message needsclick">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/files/fil010.svg-->
                                <span class="svg-icon svg-icon-3hx svg-icon-primary">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3"
                                                                      d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM14.5 12L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L10 12H11.5V17C11.5 17.6 11.4 18 12 18C12.6 18 12.5 17.6 12.5 17V12H14.5Z"
                                                                      fill="currentColor"/>
																<path d="M13 11.5V17.9355C13 18.2742 12.6 19 12 19C11.4 19 11 18.2742 11 17.9355V11.5H13Z"
                                                                      fill="currentColor"/>
																<path d="M8.2575 11.4411C7.82942 11.8015 8.08434 12.5 8.64398 12.5H15.356C15.9157 12.5 16.1706 11.8015 15.7425 11.4411L12.4375 8.65789C12.1875 8.44737 11.8125 8.44737 11.5625 8.65789L8.2575 11.4411Z"
                                                                      fill="currentColor"/>
																<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z"
                                                                      fill="currentColor"/>
															</svg>
														</span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Info-->
                                <div class="ms-4">
                                    <h3 class="dfs-3 fw-bolder text-gray-900 mb-1">{{getCustomTranslation('drop_files_here_or_click_to_upload')}}
                                        .</h3>
                                    <span class="fw-bold fs-4 text-muted">{{getCustomTranslation('upload_up_to_10_files')}}</span>
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <div class="form-text">{{getCustomTranslation('allowed_file_types')}}: png, jpg,
                            jpeg,mp4,mov,ogg
                        </div>
                    </div>
                </div>

                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('support_center.index') }}"
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
        let get_files_url = "{{ route('question.get_files') }}";

        let myDropzone = new Dropzone("#kt_modal_create_project_settings_logo", {
            init: function () {
                this.on("removedfile", function (file) {
                    $(`input[value="${file.name}"]`).prop('disabled', true);
                    $.ajax({
                        type: "DELETE",
                        url: '{{route("media.removeByName")}}?id=' + {{$data->id}},
                        data: {'name': file.name},
                        success: function () {
                        }
                    });
                });
                let dropzone = this;
                $.ajax({
                    url: "{{ route('question.read_files')}}?id=" + {{$data->id}},
                    type: 'get',
                    data: {request: 'fetch'},
                    dataType: 'json',
                    success: function (response) {
                        $.each(response, function (key, value) {
                            $('<input>').attr({
                                type: 'hidden',
                                id: value.name.replace(/[ .]+/g, ''),
                                name: 'images[]',
                                value: value.name
                            }).appendTo('form');
                            let mockFile = {name: value.name, dataURL: value.path, size: value.size};
                            dropzone.files.push(mockFile);
                            dropzone.emit("addedfile", mockFile);
                            dropzone.emit('complete', mockFile);
                            dropzone.createThumbnailFromUrl(mockFile,
                                dropzone.options.thumbnailWidth,
                                dropzone.options.thumbnailHeight,
                                dropzone.options.thumbnailMethod, true, function (thumbnail) {
                                    if (typeof thumbnail === 'string' || thumbnail instanceof String)
                                        dropzone.emit('thumbnail', mockFile, thumbnail);
                                    ;
                                }
                            );
                        });
                        //spinner-border
                        $(".spinner-border").hide();
                    }
                });
            },
            url: "{{ route('question.upload')}}", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            sending: function (file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
            accept: function (file, done) {
                let allowed_array = [
                    'image/png', 'image/jpg', 'image/jpeg', 'video/mp4', 'video/quicktime', 'audio/ogg' ,'application/pdf','application/doc','application/docx','application/xls','application/xlsx','application/csv'
                ];
                if (allowed_array.includes(file.type)) {
                    let name = file.name;
                    $('<input>').attr({
                        type: 'hidden',
                        id: name.replace(/[ .]+/g, ''),
                        name: 'images[]',
                        value: file.name
                    }).appendTo('form');
                    done();
                } else {
                    done("{{getCustomTranslation('file_type_is_not_allowed')}}");
                }
            },
        });
        Dropzone.options.myDropzone = {
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
        };

    </script>
@endpush
