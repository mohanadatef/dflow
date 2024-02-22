@method('put')
@csrf
<input type="hidden" name="city_id" value="{{ $city->id }}" id="cityId">
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('name_ar')}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="name_ar"
           class="form-control form-control-solid mb-3 mb-lg-0"
           placeholder="{{getCustomTranslation('name_ar')}}" value="{{ $city->name_ar }}"/>
    <!--end::Input-->
</div>
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('name_en')}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="name_en"
           class="form-control form-control-solid mb-3 mb-lg-0"
           placeholder="{{getCustomTranslation('name_en')}}" value="{{ $city->name_en }}"/>
    <!--end::Input-->
</div>
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('code')}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="code"
           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="{{getCustomTranslation('code')}}" value="{{ $city->code }}"/>
    <!--end::Input-->
</div>
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{getCustomTranslation('country')}}</label>
    <!--end::Label-->
    <select class="form-select" data-control="select2" data-placeholder="Select an option" name="country_id" id="">
        @foreach ($countries as $country)
            <option
                {{ $city->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->{'name_'.$lang} }}</option>
        @endforeach
    </select>

    <!--end::Input-->
</div>
<!--end::Input group-->
<!--end::Input group-->
