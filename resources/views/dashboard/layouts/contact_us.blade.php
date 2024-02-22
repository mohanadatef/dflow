<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/dflowlogo-2-1.png"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dashboard') }}/assets/plugins/custom/leaflet/leaflet.bundle.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('dashboard') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
</head>
<style>
    .users-list-actions {
        width: 160px !important;
    }
</style>
<!--begin::Body-->
<body data-kt-name="metronic" id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Aside-->
        @include('dashboard.layouts.aside')
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('dashboard.layouts.mobile_header')
            <!--end::Header tablet and mobile-->
            <!--begin::Header-->
            @include('dashboard.layouts.header')
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Container-->
                <div class="container-xxl" id="kt_content_container">
                    <!--begin::Row-->
                    @yield('content')
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Content-->
            @include('dashboard.layouts.footer')
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>

@yield('footer_content')
<!--end::Root-->
<!--end::Main-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                          fill="currentColor"/>
					<path
                        d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                        fill="currentColor"/>
				</svg>
			</span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->

<!--end::Modal - Invite Friend-->
<!--end::Modals-->
{{--@include('dashboard.layouts.script')--}}

<script>var hostUrl = "{{ asset('dashboard') }}/assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('dashboard') }}/assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('dashboard') }}/assets/js/custom/apps/support-center/tickets/create.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/documentation/documentation.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/pages/general/contact.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/widgets.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/widgets.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/apps/chat/chat.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/utilities/modals/create-app.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/utilities/modals/users-search.js"></script>

@stack('scripts')

</body>
<!--end::Body-->
</html>

