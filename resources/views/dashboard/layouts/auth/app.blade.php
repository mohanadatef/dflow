<!DOCTYPE html>
<html lang="en">
<head>
    <base href="../../../">
    <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/dflowlogo-2-1.png"/>
    <title>{{getCustomTranslation('dflow')}} - {{getCustomTranslation('login')}}</title>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('dashboard/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard/') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="metronic" id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
<!--begin::Theme mode setup on page load-->
<script>
    if (document.documentElement) {
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
    }
</script>
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('{{ asset('dashboard/') }}/assets/media/auth/hosting3-slider-cloud.png');
            background-color: #0a0541;
        }

        [data-theme="dark"] body {
            background-image: url('{{ asset('dashboard/') }}/assets/media/auth/hosting3-slider-cloud.png');
        }
    </style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-column" style="margin-bottom: 300px;">
                <!--begin::Logo-->
                <a href="{{url('/login')}}" class="mb-7">
                    <img alt="Logo" width="350px"
                         src="{{ asset('dashboard/') }}/assets/logosbySI-03-2-1.png"/>
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                {{--<h2 class="text-white fw-normal m-0">{{getCustomTranslation('branding_tools_designed_for_your_business')}}</h2>--}}
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-center w-lg-50 p-10">
            <!--begin::Card-->
            <div class="card rounded-3 w-md-550px">
                <!--begin::Card body-->
                <div class="card-body p-10 p-lg-20">

                    @yield('content')

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--end::Main-->
<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('dashboard/') }}/assets/";
</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('dashboard/') }}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('dashboard/') }}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
@stack('scripts')
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>
