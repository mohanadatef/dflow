@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('tag'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_tag_create" aria-expanded="true"
             aria-controls="kt_tag_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('tag')}} {{getCustomTranslation('details')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_tag_edit_form" class="form" method="post" action="{{route('tag.update',$data->id)}}">
                @csrf
               
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <input type="text" name="name" value="{{$data->name}}"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="{{getCustomTranslation('name')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{  route('tag.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary" id="kt_tag_create_submit">{{getCustomTranslation('save_changes')}}
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
        var route = "{{ route('tag.index') }}";
    </script>
    {!! JsValidator::formRequest('Modules\CoreData\Http\Requests\Tag\EditRequest','#kt_tag_edit_form') !!}
@endpush
