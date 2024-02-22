<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="{{url('/')}}">
    <title>{{getCustomTranslation('dflow')}} - {{getCustomTranslation('404_not_found')}}</title>
    <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/dflowlogo-2-1.png"/>

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <link href="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/plugins/custom/prismjs/prismjs.bundle.css">
    <style>
        body {
            background-image: url('{{asset('dashboard')}}/assets/media/auth/bg1.jpg');
        }

        [data-theme="dark"] body {
            background-image: url('{{asset('dashboard')}}/assets/media/auth/bg1-dark.jpg');
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body data-kt-name="metronic" id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
<!--begin::Theme mode setup on page load-->
<script>if (document.documentElement) {
        const defaultThemeMode = "system";
        const name = document.body.getAttribute("data-kt-name");
        let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
        if (themeMode === null) {
            if (defaultThemeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            } else {
                themeMode = defaultThemeMode;
            }
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page bg image-->
    <!--end::Page bg image-->
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center text-center p-10">
            <!--begin::Wrapper-->
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <!--begin::Title-->
                    <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">{{getCustomTranslation('oops')}}</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">{{getCustomTranslation('we_can_t_find_that_page')}}</div>
                    <!--end::Text-->
                    <!--begin::Illustration-->
                    <div class="mb-3">
                        <img src="{{asset('dashboard')}}/assets/media/auth/404-error.png"
                             class="mw-100 mh-300px theme-light-show" alt="ops">
                        <!--
                                <img src="{{asset('dashboard')}}/assets/media/auth/404-error-dark.png" class="mw-100 mh-300px theme-dark-show" alt="">
                                -->
                    </div>
                    <!--end::Illustration-->
                    <!--begin::Link-->
                    <div class="mb-0">
                        <a href="{{url('/')}}" class="btn btn-sm btn-primary">{{getCustomTranslation('return_home')}}</a>
                    </div>
                    <!--end::Link-->
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
</div>
<!--end::Root-->
<!--end::Main-->


<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->

<script src="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
