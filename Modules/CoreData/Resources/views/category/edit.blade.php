@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('category'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_category_create" aria-expanded="true"
             aria-controls="kt_category_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('category')}} {{getCustomTranslation('details')}}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_category_edit_form" class="form" method="post" action="{{route('category.update',$data->id)}}">
                @csrf
               
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('group')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <select id="groups" name="group" aria-label="{{getCustomTranslation('select_a_group')}}" data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_group')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                            <option value="">{{getCustomTranslation('select_a_group')}}...</option>
                                            @foreach(groupType() as $value)
                                            <option {{Request::old('group') == $value || $data->group == $value ? 'selected' : "" }}   value="{{$value}}">{{getCustomTranslation($value)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-lg-6">
                            <!--begin::Input group-->
                            <div class="row mb-6 {{Request::old('group') == 'industry_child' || $data->group == 'industry_child' ?: "d-none" }} " id="parents">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('parent')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <select name="parent_id" aria-label="{{getCustomTranslation('select_a_parent')}}" data-control="select2"
                                            data-placeholder="{{getCustomTranslation('select_a_parent')}}..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">{{getCustomTranslation('select_a_parent')}}...</option>
                                        @foreach($category as $value)
                                            <option {{Request::old('parent_id') == $value->id || $data->parent_id == $value->id ? 'selected' : "" }} value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-lg-6">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_en')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <input type="text" name="name_en" value="{{$data->name_en}}"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="{{getCustomTranslation('name_en')}}"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-lg-6">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_ar')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <input type="text" name="name_ar" value="{{$data->name_ar}}"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="{{getCustomTranslation('name_ar')}}"/>
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
                    <a href="{{  route('category.index') }}"
                       class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                    <button type="submit" class="btn btn-primary" id="kt_category_create_submit">{{getCustomTranslation('save_changes')}}
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
        var route = "{{ route('category.index') }}";
    </script>
    {!! JsValidator::formRequest('Modules\CoreData\Http\Requests\Category\EditRequest','#kt_category_edit_form') !!}
    <script>
        $(document).ready(function () {
            $("#groups").on('change', function(){
                let group = $('#groups').val();
                let parents = $('#parents');
                if(group == "industry_child"){
                    parents.removeClass('d-none');
                }else{
                    parents.addClass('d-none');
                }
            })
        });
    </script>
@endpush
