<!--begin::Card-->
    <div class="collapse show" id="kt_social_feeds_comments_1">
        <!--begin::Comment-->
        @foreach($answers as $answer)
            <div class="d-flex pt-6" id="answer-{{$answer->id}}">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo"
                         src="{{(user()->avatar->file ?? 0) ? getFile(user()->avatar->file??null,pathType()['ip'],getFileNameServer(user()->avatar)) :  asset('dashboard') .'/assets/media/svg/avatars/blank.svg' }}"/>
                </div>
                <!--end::Avatar-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mb-0">
                        <!--begin::Name-->
                        <a href="#" class="text-gray-800 text-hover-primary fw-bold me-6">{{$answer->user->name}}</a>
                        <!--end::Name-->
                        <!--begin::Date-->
                        <span class="text-gray-400 fw-semibold fs-7 me-5">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$answer->created_at)}}</span>
                        <!--end::Date-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Text-->
                    <span class="text-gray-800 fs-7 fw-normal pt-1">{{$answer->answer}}</span>
                    <!--end::Text-->
                    @if(count($answer->media) > 0)
                        <div class="symbol symbol-50px me-5">
                            @foreach($answer->media as $file)
                            @php
                                $pieces = explode('.', $file->file);
                                  $exe = array_pop($pieces);
                            @endphp
                            @if(in_array(strtolower($exe), ['gif', 'png', 'jpg', 'jpeg', 'svg', 'webp', 'bmp', 'ico', 'jfif']))
                                <img
                                     src="{{getFile($file->file??null,pathType()['ip'],getFileNameServer($file))}}"
                                     class="card-rounded mw-100" alt=""/>
                            @elseif(in_array(strtolower($exe), ['mp4', 'quicktime', 'ogg']))
                                <video style="width:100%;height: 50%" controls
                                       src="{{getFile($file->file??null,pathType()['ip'],getFileNameServer($file))}}"></video>
                            @elseif(in_array(strtolower($exe), ['pdf', 'doc', 'docx','xls','xlsx','csv']))
                                <a download href = "{{getFile($file->file??null,pathType()['ip'],getFileNameServer($file))}}">
                                    <svg  width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z"
                                              fill="currentColor"/>
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                                    </svg>
                                </a>
                            @endif
                            @endforeach
                        </div>
                    @endif


                    @if($userLogin->id == $answer->user_id || in_array(user()->role_id, [1, 10]))
                        <div class="position-absolute end-0 translate-middle-x mt-1">
                            <button onclick="deleteAnswer({{$answer->id}})" class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-primary w-25px p-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                        fill="currentColor"/>
                                    <path opacity="0.5"
                                          d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                          fill="currentColor"/>
                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                </div>
                <!--end::Wrapper-->
            </div>

        @endforeach
        <!--end::Comment-->
    </div>






<!--end::Card-->


