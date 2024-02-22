@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('calendar'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_calendar_create" aria-expanded="true"
             aria-controls="kt_calendar_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('calendar')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <form id="kt_calendar_create_form" class="form" method="post" action="{{route('calendar.store')}}">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('description')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="description" value="{{Request::old('description')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('description')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('from')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="date" name="from"
                                           value="{{Request::old('from') ? Request::old('from') : request('from') }}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('from')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('to')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="date" name="to"
                                           value="{{Request::old('to') ? Request::old('to') : request('from')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('to')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('campaign')}}</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="campaign" value="{{Request::old('campaign')}}"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="{{getCustomTranslation('campaign')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                </div>
                <!--end::Input group-->
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('calendar.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary" id="kt_calendar_create_submit">{{getCustomTranslation('save_changes')}}
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

@endsection
@push('scripts')

    <script>
        var route = "{{ route('calendar.index') }}";
    </script>
    {!! JsValidator::formRequest('Modules\CoreData\Http\Requests\Calendar\CreateRequest','#kt_calendar_create_form') !!}
@endpush
