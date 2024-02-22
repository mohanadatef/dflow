<form id="kt_company_edit_form" class="form" method="post" action=""
      enctype="multipart/form-data">
    @csrf
    <!--begin::Card body-->
    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
        <!--begin::Input group-->
        <div class="row mb-6">
            <!--begin::Col-->
            <div class="col-lg-12">
                <!--begin::Row-->
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_en')}}</label>
                <div class="row">
                    <!--begin::Col-->
                    <div class="fv-row">
                        <input type="text" name="name_en"
                               value="{{$data->name_en}}"
                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                               placeholder="{{getCustomTranslation('name_en')}}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-6">
            <!--begin::Col-->
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_ar')}}</label>
            <div class="col-lg-12">
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="fv-row">
                        <input type="text" name="name_ar"
                               value="{{$data->name_ar}}"
                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                               placeholder="{{getCustomTranslation('name_ar')}}"/>
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
            <!--begin::Col-->
            <div class="col-lg-12">
                <!--begin::Row-->
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('link')}}</label>
                <div class="row">
                    <!--begin::Col-->
                    <div class="fv-row">
                        <select name="websites[]"
                                aria-label="{{getCustomTranslation('select_a_website')}}"
                                id="websites1"
                                multiple="multiple" data-control="select2"
                                data-placeholder="{{getCustomTranslation('select_a_website')}}..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">{{getCustomTranslation('select_a_website')}}
                                ...
                            </option>
                            @foreach($sites as $value)
                                <option value="{{$value->id}}"
                                        @foreach($data->company_website as $website) @if($website['website_id'] == $value->id) selected @endif @endforeach>{{$value->name_en ."/". $value->name_ar}}</option>
                            @endforeach
                        </select>
                        <div id="link1">
                            @foreach($data->company_website as $site)
                                <div id="link-{{$site['website_id']}}">
                                    {{$site->website->{'name_'.$lang} }} <input type="text"
                                                                                name="link[{{$site['website_id']}}]"
                                                                                value="{{$site['url']}}"
                                                                                class="form-control form-control-lg form-control-solid mb-3 "/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-6">
            <!--begin::Col-->
            <div class="col-lg-12">
                <!--begin::Row-->
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('contact_info')}}</label>
                <div class="row">
                    <!--begin::Col-->
                    <div class="fv-row">
                        <input type="text" name="contact_info"
                               value="{{$data->contact_info}}"
                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                               placeholder="{{getCustomTranslation('contact_info')}}"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-12">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('industry')}}</label>
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="fv-row">
                        <select name="industry[]"
                                aria-label="{{getCustomTranslation('select_a_industry')}}"
                                multiple="multiple"
                                data-control="select2"
                                data-placeholder="{{getCustomTranslation('select_a_industry')}}..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">{{getCustomTranslation('select_a_industry')}}
                                ...
                            </option>
                            @foreach($industry as $value)
                                <option @if(in_array($value->id,$data->industry->pluck('id')->toArray())) selected
                                        @endif value="{{$value->id}}">{{$value->name_en ."/". $value->name_ar}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-6">
            <!--begin::Label-->
            <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('icon')}}</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <!--begin::Image input-->
                <div class="image-input image-input-outline" data-kt-image-input="true"
                     style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')">
                    <!--begin::Preview existing avatar-->
                    <div class="image-input-wrapper w-125px h-125px"
                         style="background-image: url('{{ asset('dashboard') }}/assets/media/svg/avatars/blank.svg')"></div>
                    <!--end::Preview existing avatar-->
                    <!--begin::Label-->
                    <label
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change icon">
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <!--begin::Inputs-->
                        <input type="file" name="icon" accept=".png, .jpg, .jpeg"/>
                        <input type="hidden" name="icon_remove"/>
                        <!--end::Inputs-->
                    </label>
                    <!--end::Label-->
                    <!--begin::Cancel-->
                    <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel icon">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                    <!--end::Cancel-->
                    <!--begin::Remove-->
                    <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove icon">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                    <!--end::Remove-->
                </div>
                <!--end::Image input-->
                <!--begin::Hint-->
                <div class="form-text">{{getCustomTranslation('allowed_file_types')}}: png, jpg, jpeg.</div>
                <!--end::Hint-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Input group-->
    <!--end::Card body-->
    <!--begin::Actions-->
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="button" class="btn btn-primary" id="kt_company_create_submit"
                onclick="editCompanyAction('{{$data->url_form}}')">{{getCustomTranslation('save_changes')}}
        </button>
    </div>
    <!--end::Actions-->
</form>


<script>

    site_array = $('#websites1').val();
    $('#websites1').change(function () {
        result_add = $(this).val().filter(x => !site_array.includes(x));
        result_remove = site_array.filter(x => !$(this).val().includes(x));
        site_array = $(this).val();
        GetWebsites1($(this).val(), result_remove);
    });

    function GetWebsites1(add, remove) {
        url = '{{ route("website.list") }}';
        if (result_remove[0] !== undefined) {
            $(`#link1 #link-${result_remove[0]}`).remove();
        }
        $.ajax({
            type: "GET",
            url: url,
            data: {'id': result_add[0]},
            success: function (res) {
                $(`#link1`).append(`<div id="link-${result_add[0]}"></div>`);
                for (let x in res) {
                    for (let i in res[x]) {
                        if (result_add[0] !== undefined) {
                            $(`#link1 #link-${result_add[0]}`).append(`
                                <div >
                                ${res[x][i]['name_{{$lang}}']}    <input type="text" name="link[${result_add[0]}]" class="form-control form-control-lg form-control-solid mb-3 "/>
                                </div>`);
                        }
                    }
                }

            }, error: function (res) {
                for (let err in res.responseJSON.errors) {
                    toastr.error(res.responseJSON.errors[err]);
                }
            }
        });
    }
</script>
<script src="{{ asset('dashboard') }}/assets/js/scripts.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.js"></script>
