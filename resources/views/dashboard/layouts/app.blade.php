<!DOCTYPE html>

<html lang="en">
@include('dashboard.layouts.head')

<style>
    .users-list-actions {
        width: 160px !important;
    }

    .page-link {
        padding:20px;
    }
</style>
<!--begin::Body-->
<body data-kt-name="metronic" id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
@include('dashboard.layouts.birdeatsbug')
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
@include('dashboard.layouts.loader')
@yield('footer_content')
<!--end::Root-->
<!--end::Main-->
<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">{{getCustomTranslation('download_exported_file')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{getCustomTranslation('your_excel_file_download_is_ready')}}</p>
                <p>{{getCustomTranslation('click_the_button_below_to_download_the_file')}}</p>
                <a href="#" id="downloadLink" class="btn btn-primary">{{getCustomTranslation('download_file')}}</a>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary" id="showModalButton" style="display: none;" data-toggle="modal" data-target="#downloadModal"></button>
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true" style="margin-block: 25px;">
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
@include('dashboard.layouts.script')

</body>
<!--end::Body-->
</html>

