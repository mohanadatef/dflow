@extends('dashboard.layouts.app')

@section('title',getCustomTranslation( 'question'))
@section('content')

    <!--begin::Card-->
    <div class="card card-flush mb-10">
        <!--begin::Card header-->
        <div class="card-header pt-9">
            <!--begin::Author-->
            <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo"
                         src="{{(user()->avatar->file ?? 0) ? getFile(user()->avatar->file??null,pathType()['ip'],getFileNameServer(user()->avatar)) :  asset('dashboard') .'/assets/media/svg/avatars/blank.svg' }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Name-->
                    <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">{{$data->user->name}}</a>
                    <!--end::Name-->
                    <!--begin::Date-->
                    <span class="text-gray-400 fw-semibold d-block">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)}}</span>
                    <!--end::Date-->
                </div>
                @can('status_support_center')
                    <div class="position-absolute end-0 translate-middle-x mt-1">
                        <a href="#"
                           class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                           onclick="toggleActive({{$data->id}})">
                            {{ $data->active ? getCustomTranslation('inactive') : getCustomTranslation('active') }}
                            <i class="fas fa-toggle-{{$data->active ? 'off' : 'on' }} text-primary ms-2 fs-7"
                               data-bs-toggle="tooltip"
                               aria-label="Specify a target name for future usage and reference"
                               data-kt-initialized="1"></i>
                        </a>
                    </div>
                @endcan
                <!--end::Info-->
            </div>
            <!--end::Author-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Post content-->
            <div class="fs-6 fw-normal text-gray-700 mb-5">{{$data->question}}</div>
            <!--end::Post content-->
            <!--begin::Post media-->
            <div class="row g-7 ">
                <!--begin::Col-->
                @if(count($data->medias))
                <div class="row">
                    @if(count($data->medias) > 1)
                        <div class="col-md-1">
                            <a class="prev" onclick="plusSlides(-1)" style="cursor: pointer;
            position: absolute;
            bottom: 70%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            border-radius: 0 3px 3px 0;
            user-select: none;">❮</a>
                        </div>
                    @endif

                    <div class="col-md-10">
                        <div id="media-file" class="slideshow-container">
                            <div class="row">
                                @foreach($data->medias as $file)
                                    @php
                                        $pieces = explode('.', $file->file);
                                        $exe = array_pop($pieces);
                                    @endphp
                                    <div class="col-md-12 mySlides" id="{{$file->id}}">
                                        <div class="card">

                                            <div class="card-body">
                                                @if(in_array(strtolower($exe), ['gif', 'png', 'jpg', 'jpeg', 'svg', 'webp', 'bmp', 'ico']))
                                                    <img style="height: 50%"
                                                         src="{{getFile($file->file??null,pathType()['ip'],getFileNameServer($file))}}"
                                                         class="card-rounded mw-100" alt=""/>
                                                @elseif(in_array(strtolower($exe), ['mp4', 'quicktime', 'ogg']))
                                                    <video style="width:100%;height: 50%" controls
                                                           src="{{getFile($file->file??null,pathType()['ip'],getFileNameServer($file))}}"></video>
                                                @elseif(in_array(strtolower($exe), ['pdf', 'doc', 'docx','xls','xlsx','csv']))

                                                    <a download href = "{{getFile($file->file??null,pathType()['ip'],getFileNameServer($file))}}" style="margin-left: 300px;">
                                                    <svg  width="250" height="250" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                                              fill="currentColor"/>
                                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                                                    </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if(count($data->medias) > 1)
                            <div class="col-md-1">
                                <a class="next" onclick="plusSlides(1)" style="cursor: pointer;
            position: absolute;
            bottom: 70%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            border-radius: 0 3px 3px 0;
            user-select: none;">❯</a>
                            </div>
                    @endif
                </div>
                @endif
                <!--end::Col-->
            </div>
            <!--end::Post media-->
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer pt-0">
            <!--begin::Info-->
            <div class="mb-6">
                <!--begin::Separator-->
                <div class="separator separator-solid"></div>
                <!--end::Separator-->
                <!--begin::Nav-->
                <ul class="nav py-3">
                    <!--begin::Item-->
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-color-gray-600 btn-active-color-primary btn-active-light-primary fw-bold px-4 me-1 collapsible active"
                           data-bs-toggle="collapse" href="#kt_social_feeds_comments_1">
                            <i class="ki-outline ki-message-text-2 fs-2 me-1"></i>{{count($data->answers)}} Answers</a>
                    </li>
                    <!--end::Item-->
                </ul>
                <!--end::Nav-->
                <!--begin::Separator-->
                <div class="separator separator-solid mb-1"></div>
                <!--end::Separator-->
                <!--begin::Comments-->

                <div id="answersDiv">
                </div>
                <!--end::Collapse-->
            </div>
            <!--end::Info-->
            <!--begin::Comment form-->
            <div class="d-flex align-items-center">
                <!--begin::Author-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo"
                         src="{{(user()->avatar->file ?? 0) ? getFile(user()->avatar->file??null,pathType()['ip'],getFileNameServer(user()->avatar)) :  asset('dashboard') .'/assets/media/svg/avatars/blank.svg' }}"/>
                </div>
                <!--end::Author-->
                @can('create_answer_support_center')
                    <!--begin::Input group-->
                    <div class="position-relative w-100">
                        <form enctype="multipart/form-data" id="answerForm" action="#">
                            <!--begin::Input-->
                            <textarea id="answer" type="text" class="form-control form-control-solid border ps-5" rows="1"
                                      name="answer" value="" data-kt-autosize="true"
                                      placeholder="Write your answer.."></textarea>
                            <!--end::Input-->
                            <!--begin::Actions-->
                            <input type="hidden" name="support_center_question_id" value="{{$data->id}}">
                            <div class="position-absolute top-0 end-0 translate-middle-x mt-1">
                                <!--begin::Btn-->
                                <label for="fileInput" class="upload-icon"> <input type="file" id="fileInput" name="image"
                                                                                   style="display: none;"> <i
                                            class="fas fa-upload"></i>
                                </label>
                                <!--end::Btn-->
                                <!--begin::Btn-->
                                <button type="submit"
                                        class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-primary w-25px p-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                              d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z"
                                              fill="currentColor"/>
                                        <path
                                                d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z"
                                                fill="currentColor"/>
                                    </svg>
                                </button>
                                <!--end::Btn-->
                            </div>
                        </form>
                        <!--end::Actions-->
                    </div>
                    <!--end::Input group-->
                @endcan
            </div>
            <!--end::Comment form-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card-->

@endsection

@push('scripts')
    <script>
        var toggleActiveRoute = "{{route('question.toggleActive')}}";
        var csrfToken = "{{ csrf_token() }}";

        function toggleActive(id) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: toggleActiveRoute,
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                data: {
                    _token: csrfToken,
                    'id': id
                },
                success: function (data) {
                    if (data.status == 'true') {
                        window.location.reload();
                    }
                }
            });
        }

        getAnswers();

        function getAnswers() {
            $('#loading').css('display', 'flex');
            url = "{{route('answers.index')}}" + '?support_center_question_id=' + {{$data->id}};
            $.ajax({
                type: "get",
                url: url,
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#loading').css('display', 'none');
                    $('#answersDiv').empty();
                    $('#answersDiv').html(res);

                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        }

        $("#answerForm").on("submit", function (event) {

            event.preventDefault();
            $('#loading').css('display', 'flex');
            url = "{{route('answers.store')}}";
            form = new FormData(this)
            $.ajax({
                type: "post",
                url: url,
                data: form,
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#loading').css('display', 'none');
                    $('#answersDiv').empty();
                    $('#answersDiv').html(res);
                    document.getElementById("answerForm").reset();
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                    $('#loading').css('display', 'none');
                }
            });
        });


        function deleteAnswer(id) {
            $('#loading').css('display', 'flex');
            url = "{{route('answers.delete')}}" + '?id=' + id;
            $.ajax({
                type: "get",
                url: url,
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#loading').css('display', 'none');
                    $(`#answer-${id}`).empty();

                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                    $('#loading').css('display', 'none');
                }
            });
        }


        let slideIndex = 1;

        function mediaSlider() {
            showSlides(slideIndex);
        }

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndexI = slides[slideIndex - 1]
            slideIndexI.style.display = "block";
        }

        mediaSlider()
    </script>
@endpush
