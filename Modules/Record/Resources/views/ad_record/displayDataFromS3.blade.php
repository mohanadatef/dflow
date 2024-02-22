{{--
@if($files)
    <div class="row">
        <div class="col-md-1">
            <a class="prev" onclick="plusSlides(-1)" style="cursor: pointer;
            position: absolute;
            bottom: 80%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            border-radius: 0 3px 3px 0;
            user-select: none;">❮</a>
        </div>
        <div class="col-md-10">
            <div id="media-file" class="slideshow-container" >
                <div class="row">
                    @foreach($files as $file)
                        @php
                            $pieces = explode('.', $file);
                            $exe = array_pop($pieces);
                            $pieces = explode('/', $file);
                            $name = array_pop($pieces);
                            $id= \Modules\Basic\Entities\Media::where('file',$file)->pluck('id')->toArray() ?? [] ;
                        @endphp
                        <div class="col-md-3 mySlides" id="{{$file}}">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <input class="form-check-input s3-check-input"
                                               style="height: 40px;width: 40px; margin-right: 20px; border: 2px solid gray;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);"
                                               id="{{ $file }}" @if(in_array($file,$mediaS3)) checked
                                               @endif type="checkbox" name="file[]" value="{{$file}}">
                                        <label class="form-check-label" for="{{ $file }}">{{ $name }}</label>
                                    </div>
                                </div>
                                <div class="card-body" @if(count($id)) style="background-color: rgba(0,0,0,0.5);padding:0 !important;" @else style="padding:0 !important" @endif>
                                    @if($exe == 'mp4')
                                        <video height="500px" controls preload="metadata" width="100%">
                                            <source src="{{Storage::disk('s3')->url($file)}}" type="video/mp4">
                                            <source src="{{Storage::disk('s3')->url($file)}}" type="video/ogg">
                                            {{getCustomTranslation('your_browser_does_not_support_html_video')}}
                                        </video>
                                    @else
                                        <img data-enlargable src="{{Storage::disk('s3')->url($file)}}" alt="{{ $name }}"
                                             style="height: 500px   ; width: 100%;">
                                    @endif
                                    {{count($id) ? getCustomTranslation('regesterd_for_ad').' : '. implode(',',$id) : ''}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <a class="next" onclick="plusSlides(1)" style="cursor: pointer;
            position: absolute;
            bottom: 80%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            border-radius: 0 3px 3px 0;
            user-select: none;">❯</a>
        </div>
    </div>
    <script>
        $('img[data-enlargable]').addClass('img-enlargable').click(function () {
            var src = $(this).attr('src');
            $('<div>').css({
                background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%', height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0', left: '0',
                cursor: 'zoom-out'
            }).click(function () {
                $(this).remove();
            }).appendTo('body');
        });
        mediaSlider();
    </script>
@endif


--}}

@if($files)
    <div class="container">
        <div class="row">
            @foreach($files as $file)
                @php
                    $pieces = explode('.', $file);
                    $exe = array_pop($pieces);
                    $pieces = explode('/', $file);
                    $name = array_pop($pieces);
                    $id= \Modules\Basic\Entities\Media::where('file',$file)->pluck('id')->toArray() ?? [] ;
                @endphp
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <div class="card-title">

                                <input class="form-check-input s3-check-input" style="height: 40px;width: 40px; margin-right: 20px; border: 2px solid gray;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);" id="{{ $file }}" @if(in_array($file,$mediaS3)) checked @endif type="checkbox" name="file[]" value="{{$file}}">
                                <label class="form-check-label" for="{{ $file }}">{{ $name }}</label>
                            </div>
                        </div>
                        <div class="card-body" @if(count($id)) style="background-color: rgba(0,0,0,0.5);padding:0 !important;" @else style="padding:0 !important" @endif>

                            @if($exe == 'mp4')
                                <video width="100%" controls preload="metadata">
                                    <source src="{{Storage::disk('s3')->url($file)}}" type="video/mp4">
                                    <source src="{{Storage::disk('s3')->url($file)}}" type="video/ogg">
                                    {{getCustomTranslation('your_browser_does_not_support_html_video')}}
                                </video>
                            @else
                                <img data-enlargable src="{{Storage::disk('s3')->url($file)}}" alt="{{ $name }}" style="height: 590px">
                            @endif
                                {{count($id) ? getCustomTranslation('regesterd_for_ad').' : '. implode(',',$id) : ''}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        $('img[data-enlargable]').addClass('img-enlargable').click(function(){
            var src = $(this).attr('src');
            $('<div>').css({
                background: 'RGBA(0,0,0,.5) url('+src+') no-repeat center',
                backgroundSize: 'contain',
                width:'100%', height:'100%',
                position:'fixed',
                zIndex:'10000',
                top:'0', left:'0',
                cursor: 'zoom-out'
            }).click(function(){
                $(this).remove();
            }).appendTo('body');
        });
    </script>
@endif


