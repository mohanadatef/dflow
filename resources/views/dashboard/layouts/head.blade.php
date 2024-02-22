<!--begin::Head-->
<head>
    <base href="">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{getCustomTranslation('home')}}
        @endif
        - {{getCustomTranslation('dflow')}}
    </title>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/dflowlogo-2-1.png"/>
    <!--begin::Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('dashboard') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('dashboard') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
          type="text/css"/>
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/plugins/custom/prismjs/prismjs.bundle.css">
    <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/jquery-ui.min.css"/>
    @stack('styles')


    <style>
        body {
            font-family: 'Cairo';
            font-family: Inter, Helvetica, "sans-serif";
            font-weight: 600 !important;
            font-size: 1.25rem !important;
        }

        #kt_ad_record_table_wrapper .row {
            display: none;
        }

        #kt_company_table_wrapper .row {
            display: none;
        }
        [data-theme="dark"] .select2-results__option {
            color: white !important;
            background-color: #31186f !important;
             }
             [data-theme="dark"] .select2-results__option[aria-selected="true"] {
                color: #31186f !important;
            background-color: white !important;
             }


             [data-theme="light"] .select2-results__option {
                color: #6b04ac !important;
            background-color: white !important;
             }
             [data-theme="light"] .select2-results__option[aria-selected="true"] {
                color: white !important;
            background-color: #6b04ac !important;
             }



             [data-theme="dark"] .marketoverview {
            color: white !important;

             }
             [data-theme="light"] .marketoverview {
                color: #31186f !important;

             }


    </style>
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
