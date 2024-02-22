@method('put')
@csrf
<input type="hidden" name="country_id" value="{{ $country->id }}" id="countryId">
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('name_ar')}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="name_ar"
           class="form-control form-control-solid mb-3 mb-lg-0"
           placeholder="{{getCustomTranslation('name_ar')}}" value="{{ $country->name_ar }}"/>
    <!--end::Input-->
</div>
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('name_en')}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="name_en"
           class="form-control form-control-solid mb-3 mb-lg-0"
           placeholder="{{getCustomTranslation('name_en')}}" value="{{ $country->name_en }}"/>
    <!--end::Input-->
</div>
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('code')}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="code"
           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{getCustomTranslation('code')}}"
           value="{{ $country->code }}"/>
    <!--end::Input-->
</div>

<!--end::Input group-->
