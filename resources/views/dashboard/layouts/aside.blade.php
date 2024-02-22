<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->

    <div class="aside-logo flex-column-auto pt-10 pt-lg-20" id="kt_aside_logo">
        <a href="{{url('/')}}">
            <img alt="Logo" src="{{ asset('dashboard') }}/assets/logo.png" class="h-70px" id="lightImage"
                 style="display: none;"/>
            <img alt="Logo" src="{{ asset('dashboard') }}/assets/logosbySI-03-2-1.png" class="h-70px" id="darkImage"
                 style="display: none;"/>
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-menu flex-column-fluid pt-0 pb-7 py-lg-10" id="kt_aside_menu">
        <!--begin::Aside menu-->
        <div id="kt_aside_menu_wrapper" class="w-100 hover-scroll-overlay-y scroll-ps d-flex" data-kt-scroll="true"
             data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
             data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0"
        >
            <div id="kt_aside_menu"
                 class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-400 menu-arrow-gray-400 fw-semibold fs-6 my-auto"
                 data-kt-menu="true"
            >
                @canany('market_overview_page' , 'competitive_analysis_page')
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item here show py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2x">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"/>
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"/>
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"/>
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                            <!--begin:Menu item-->

                            <div class="menu-item">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('competitor_discovery')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>

                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @can('market_overview_page')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{route('dashboard')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">{{getCustomTranslation('market_overview')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @can('competitive_analysis_page')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{route('reports.competitive_analysis')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">{{getCustomTranslation('competitive_analysis')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan

                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endcanany
                @canany('discover_influencers','view_linktracking','view_calender')
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
<span class="menu-icon me-0">
    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
    <span class="svg-icon svg-icon-2x">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                    fill="currentColor"/>
            <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                  fill="currentColor"/>
            <path opacity="0.3"
                  d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                  fill="currentColor"/>
        </svg>
    </span>
    <!--end::Svg Icon-->
</span>
</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('dflow_planner')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            @can('discover_influencers')
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{Route('influencer.discover')}}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
                                    <span class="menu-title">{{getCustomTranslation('discover_influencers')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
@endcan
                            @can('view_linktracking')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{Route('linktracking.index')}}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
                                    <span class="menu-title">{{getCustomTranslation('link_tracker')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
@endcan
                            @can('view_calender')
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{Route('calendar.index')}}">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
                                    <span class="menu-title">{{getCustomTranslation('calendar')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            @endcan
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>

                @endcanany
                <!--begin:Menu item-->

                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                     class="menu-item py-2">
                    <!--begin:Menu link-->
                    <span class="menu-link menu-center">
<span class="menu-icon me-0">
    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
    <span class="svg-icon svg-icon-2x">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.3"
                  d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                  fill="currentColor"/>
            <path
                    d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                    fill="currentColor"/>
        </svg>
    </span>
    <!--end::Svg Icon-->
</span>
</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('web_performance')}}</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="#">
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
                                <span class="menu-title">{{getCustomTranslation('coming_soon')}}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                @canany(['view_users','view_roles','view_influencers','view_companies','view_external_dashboard'])
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <!--begin::Svg Icon | path: icons/duotune/abstract/abs037.svg-->
        <span class="svg-icon svg-icon-2x">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3"
                      d="M2.10001 10C3.00001 5.6 6.69998 2.3 11.2 2L8.79999 4.39999L11.1 7C9.60001 7.3 8.30001 8.19999 7.60001 9.59999L4.5 12.4L2.10001 10ZM19.3 11.5L16.4 14C15.7 15.5 14.4 16.6 12.7 16.9L15 19.5L12.6 21.9C17.1 21.6 20.8 18.2 21.7 13.9L19.3 11.5Z"
                      fill="currentColor"/>
                <path
                        d="M13.8 2.09998C18.2 2.99998 21.5 6.69998 21.8 11.2L19.4 8.79997L16.8 11C16.5 9.39998 15.5 8.09998 14 7.39998L11.4 4.39998L13.8 2.09998ZM12.3 19.4L9.69998 16.4C8.29998 15.7 7.3 14.4 7 12.8L4.39999 15.1L2 12.7C2.3 17.2 5.7 20.9 10 21.8L12.3 19.4Z"
                        fill="currentColor"/>
            </svg>
        </span>
        <!--end::Svg Icon-->
    </span>
</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-200px w-lg-225px">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('settings')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            @canany(['view_users','view_roles'])
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">{{getCustomTranslation('user_management')}}</span>
            <span class="menu-arrow"></span>
        </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        @can('view_users')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{ route('user.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                                                    <span class="menu-title">{{getCustomTranslation('users')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endcan
                                        @can('view_clients')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{ route('client.index') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                                                    <span class="menu-title">{{getCustomTranslation('external_user')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endcan

                                        @can('view_roles')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{ route('role.index') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                                    <span class="menu-title">{{getCustomTranslation('roles')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endcan

                                        @can('view_users')

                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{ route('user.import') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                                                    <span class="menu-title">{{getCustomTranslation('upload_users')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endcan
                                        @canany(['admin_dashboard_users','log_admin_dashboard_users'])
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <span class="menu-link">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">{{getCustomTranslation('admin_dashboard_management')}}</span>
                            <span class="menu-arrow"></span>
                        </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion menu-active-bg">
                                                    @can('admin_dashboard_users')
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item">
                                                            <!--begin:Menu link-->
                                                            <a class="menu-link" href="{{ route('admin.dashboard') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                                <span class="menu-title">{{getCustomTranslation('admin_dashboard')}}</span>
                                                            </a>
                                                            <!--end:Menu link-->
                                                        </div>
                                                        <!--end:Menu item-->
                                                    @endcan
                                                    @can('log_admin_dashboard_users')
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item">
                                                            <!--begin:Menu link-->
                                                            <a class="menu-link"
                                                               href="{{ route('admin.dashboard.log') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                                <span class="menu-title">{{getCustomTranslation('log_admin_dashboard')}}</span>
                                                            </a>
                                                            <!--end:Menu link-->
                                                        </div>
                                                        <!--end:Menu item-->
                                                    @endcan

                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endcanany
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                            @endcanany

                            @can('view_influencers')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('influencer.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('influencer')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div><!--end:Menu item-->
                            @endcan
                            @can('view_companies')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('company.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('companies')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div><!--end:Menu item-->
                            @endcan
                            @can('view_external_dashboard')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('external_dashboard.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('external_dashboards')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div><!--end:Menu item-->
                            @endcan
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endcanany

                @canany(['view_ad_record','view_ad_record_draft','view_content_record','view_campaigns','log_ad_record','fix_category_ad_record','view_request_ad_media_access','log_request_ad_media_access','view_errors_ad_record'])
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
        <span class="svg-icon svg-icon-2x">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3"
                      d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                      fill="currentColor"/>
                <path
                        d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                        fill="currentColor"/>
            </svg>
        </span>
        <!--end::Svg Icon-->
    </span>
</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('records')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            @canany(['view_ad_record','log_ad_record','view_errors_ad_record','view_ad_record_draft','fix_category_ad_record'])
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">{{getCustomTranslation('ads')}}</span>
            <span class="menu-arrow"></span>
        </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        @can('view_ad_record')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{Route('ad_record.index')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                    <span class="menu-title">{{getCustomTranslation('ads')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        @can('duplicate_ad_record')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{route('ad_record.duplicate_ad')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                    <span class="menu-title">{{getCustomTranslation('duplicate_ad')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        @can('view_errors_ad_record')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{route('ad_record_errors.index')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                    <span class="menu-title">{{getCustomTranslation('ads_errors')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        @can('log_ad_record')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{Route('ad_record_log.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                                    <span class="menu-title">{{getCustomTranslation('history_ad')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        @can('view_ad_record_draft')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{Route('ad_record_draft.index')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                    <span class="menu-title">{{getCustomTranslation('ad_record_drafts')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        @can('fix_category_ad_record')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{Route('ad_record.category.fix')}}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                                                    <span class="menu-title">{{getCustomTranslation('categories_fix')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                            @endcanany
                            @if($userLogin->role->type)
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title">{{getCustomTranslation('media')}}</span>
            <span class="menu-arrow"></span>
        </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="{{Route('request_ad_media_access.myRequest')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                                <span class="menu-title">{{getCustomTranslation('requests')}}</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link"
                                               href="{{Route('request_ad_media_access.myRequestِAvailable')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                                <span class="menu-title">{{getCustomTranslation('available_media')}}</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                            @endif

                            @canany(['view_request_ad_media_access','log_request_ad_media_access'])
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">{{getCustomTranslation('request_ad_media_access')}}</span>
                            <span class="menu-arrow"></span>
                        </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!--begin:Menu item-->
                                        <!--end:Menu item-->
                                        @can('view_request_ad_media_access')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{Route('request_ad_media_access.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                                    <span class="menu-title">{{getCustomTranslation('request_ad_media_access')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        @can('log_request_ad_media_access')
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link"
                                                   href="{{Route('request_ad_media_access_log.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                                    <span class="menu-title">{{getCustomTranslation('log_request_ad_media_access')}}</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        @endcan
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                            @endcanany
                            @can('view_content_record')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('content_record.index')}}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
                                        <span class="menu-title">{{getCustomTranslation('content_record')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endcanany

                @canany(['view_categories','view_platforms','view_services','view_interests','view_promotions','view_influencer_group','view_tag','view_location',
                'view_influencer_travel','view_event','view_brand_activity','view_influencer_trend'])
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
        <span class="svg-icon svg-icon-2x">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3"
                      d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                      fill="currentColor"/>
                <path
                        d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                        fill="currentColor"/>
            </svg>
        </span>
        <!--end::Svg Icon-->
    </span>
</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('core_data')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            @can('view_categories')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('category.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('categories')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_brand_activity')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('brand_activity.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('brand_activity')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_event')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('event.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('event')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_influencer_travel')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('influencer_travel.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('influencer_travel')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_influencer_trend')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('influencer_trend.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('influencer_trend')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_tag')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('tag.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('tag')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_websites')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('website.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('links')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                            @can('view_platforms')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('platform.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('platforms')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                            @can('view_services')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('service.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('services')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_location')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('location.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('location')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan
                            @can('view_promotions')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('promotion_type.index')}}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
                                        <span class="menu-title">{{getCustomTranslation('promotion_types')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                            @can('view_influencer_group')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('influencer_group.index')}}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
                                        <span class="menu-title">{{getCustomTranslation('influencer_group')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endcanany
                    @canany(['view_influencer_trend'])
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                             class="menu-item py-2">
                            <!--begin:Menu link-->
                            <span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
        <span class="svg-icon svg-icon-2x">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3"
                      d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                      fill="currentColor"/>
                <path
                        d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                        fill="currentColor"/>
            </svg>
        </span>
        <!--end::Svg Icon-->
    </span>
</span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu content-->
                                    <div class="menu-content">
                                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('material')}}</span>
                                    </div>
                                    <!--end:Menu content-->
                                </div>
                                <!--end:Menu item-->
                                @can('view_influencer_trend')
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{Route('influencer_trend.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                            <span class="menu-title">{{getCustomTranslation('influencer_trend')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endcan

                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    @endcanany
                @canany(['view_fqs','show_fqs','update_setting'])
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                         class="menu-item py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
    <span class="menu-icon me-0">
        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
        <span class="svg-icon svg-icon-2x">
           <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3"
      d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z"
      fill="currentColor"/>
<path d="M12 22C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V21C13 21.6 12.6 22 12 22Z"
      fill="currentColor"/>
</svg>
        </span>
        <!--end::Svg Icon-->
    </span>
</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">{{getCustomTranslation('support_center')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            @can('view_fqs')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('fq.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('fq')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                            @can('view_support_center')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('support_center.index')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('support_center')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                            @can('hidden_questions_support_center')
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{Route('question.getHiddenQuestions')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                        <span class="menu-title">{{getCustomTranslation('hidden_question')}}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endcan

                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                @endcanany

                <!--begin:Menu item-->
                <div class="d-flex flex-center w-100 scroll-px" data-bs-toggle="tooltip" data-bs-placement="right"
                     data-bs-dismiss="click" data-kt-initialized="1">
                    <button type="button" class="btn btn-custom" data-kt-menu-trigger="click"
                            data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr076.svg-->
                        <span class="svg-icon svg-icon-2x">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)"
              fill="currentColor"></rect>
        <path
                d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z"
                fill="currentColor"></path>
        <path
                d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                fill="currentColor"></path>
    </svg>
</span>
                        <!--end::Svg Icon-->
                    </button>
                    <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                            data-kt-menu="true" style="">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">{{getCustomTranslation('quick_actions')}}</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{Route('user.show',user()->id)}}"
                               class="menu-link px-3">{{getCustomTranslation('my_profile')}}</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{Route('supportCenter.faq')}}"
                               class="menu-link px-3">{{getCustomTranslation('faq')}}</a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{Route('contact.create')}}"
                               class="menu-link px-3">{{getCustomTranslation('contact_us')}}</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <form id="frm-logout" action="{{ route('auth.logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <a href="{{ route('auth.logout') }}" class="menu-link px-3"
                               onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">{{getCustomTranslation('logout')}}</a>
                        </div>
                        <!--end::Menu item-->

                    </div>
                    <!--begin::Menu 2-->

                    <!--end::Menu 2-->
                </div>
                <!--end:Menu item-->

            </div>
        </div>
        <!--end::Aside menu-->
    </div>
</div>
