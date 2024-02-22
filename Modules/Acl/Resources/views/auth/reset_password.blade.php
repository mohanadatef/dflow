@extends('dashboard.layouts.auth.app')
@section('content')
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form"
          data-kt-redirect-url="{{ route('auth.login.form') }}" action="#">
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.
            </div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Email" name="email" autocomplete="off"
                   class="form-control bg-transparent"/>
            <!--end::Email-->
        </div>
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                <!--begin::Indicator label-->
                <span class="indicator-label">Submit</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                <!--end::Indicator progress-->
            </button>
            <a href="{{ route('auth.login.form') }}" class="btn btn-light">Cancel</a>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
@endsection
@push('scripts')
    <script>
        let URL = "{{ route('auth.reset.password.generate.post') }}";
        let csrfToken = "{{ csrf_token() }}";
        let ok_got_it = "{{getCustomTranslation('ok_got_it')}}";
    </script>
    <script src="{{ asset('dashboard/') }}/assets/js/custom/authentication/reset-password/reset-password.js"></script>
@endpush
