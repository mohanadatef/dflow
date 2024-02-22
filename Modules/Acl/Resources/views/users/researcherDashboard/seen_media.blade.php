@foreach($request['files'] as $file)
    @php
        $pieces = explode('.', $file['file']);
        $exe = array_pop($pieces);
        $pieces = explode('/', $file['file']);
        $name = array_pop($pieces);
         $pieces = explode(']_', $file['file']);
        $names = array_pop($pieces);
    @endphp
    @if($request['user_id'] == user()->id)
        @if($file['seen'])
            @continue
        @endif
        @if($exe == 'mp4')
            <div class="mySlidesSeen">
            </div>
            <div class="mySlides" id="{{$file['file']}}">
                <video height="300px" controls preload="metadata">
                    <source src="{{Storage::disk('s3')->url($file['file'])}}" type="video/mp4">
                    <source src="{{Storage::disk('s3')->url($file['file'])}}" type="video/ogg">
                    {{getCustomTranslation('your_browser_does_not_support_html_video')}}
                </video>
            </div>
            <div class="mySlidesDate">
                {{ $names }}
            </div>
        @else
            <div class="mySlidesSeen">
            </div>
            <div class="mySlides" id="{{$file['file']}}">
                <img data-enlargable src="{{Storage::disk('s3')->url($file['file'])}}" alt="{{ $name }}"
                     style="height: 300px">
            </div>
            <div class="mySlidesDate">
                {{ $names }}
            </div>
        @endif
    @else
        @if($exe == 'mp4')
            <div class="mySlidesSeen">
                @if($file['seen'])
                    seen
                @else
                    unseen
                @endif
            </div>
            <div class="mySlides" id="{{$file['file']}}">
                <video height="300px" controls preload="metadata">
                    <source src="{{Storage::disk('s3')->url($file['file'])}}" type="video/mp4">
                    <source src="{{Storage::disk('s3')->url($file['file'])}}" type="video/ogg">
                    {{getCustomTranslation('your_browser_does_not_support_html_video')}}
                </video>
            </div>
            <div class="mySlidesDate">
                {{ $names }}
            </div>
        @else
            <div class="mySlidesSeen">
                @if($file['seen'])
                    seen
                @else
                    unseen
                @endif
            </div>
            <div class="mySlides" id="{{$file['file']}}">
                <img data-enlargable src="{{Storage::disk('s3')->url($file['file'])}}" alt="{{ $name }}"
                     style="height: 300px">
            </div>
            <div class="mySlidesDate">
                {{ $names }}
            </div>
        @endif

    @endif
@endforeach

