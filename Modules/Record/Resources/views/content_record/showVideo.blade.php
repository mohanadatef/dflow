<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{getCustomTranslation('show_video')}}</title>
</head>
<body>
<video width="400" controls autoplay>
  <source src="{{$shortLink->link}}" type="video/mp4">
  <source src="{{$shortLink->link}}" type="video/ogg">
    {{getCustomTranslation('your_browser_does_not_support_html_video')}}
</video>
</body>
</html>