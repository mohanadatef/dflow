<!--begin::Card body-->
<div class="card-body border-top p-9">
    <!--begin::Input group-->
    <div class="row mb-6">
        <!--begin::Label-->
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_en')}}</label>
        <!--end::Label-->
        <!--begin::Col-->
        <div class="col-lg-8">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-6 fv-row">
                    <input type="text" name="id_company" id="id_company" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 id_company"
                           value="{{$data->id}}" disabled>
                    <input type="text" name="name_en" id="name_en"
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
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="row mb-6">
        <!--begin::Label-->
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name_ar')}}</label>
        <!--end::Label-->
        <!--begin::Col-->
        <div class="col-lg-8">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-6 fv-row">
                    <input type="text" name="name_ar" id="name_ar"
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
        <!--begin::Label-->
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('link')}}</label>
        <!--end::Label-->
        <!--begin::Col-->
        <div class="col-lg-8">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-6 fv-row">
                    <select name="websites[]" aria-label="{{getCustomTranslation('select_a_link')}}" id="websites"
                            multiple="multiple" data-control="select2"
                            data-placeholder="{{getCustomTranslation('select_a_link')}}..."
                            class="form-select form-select-solid form-select-lg fw-semibold">
                        <option value="">{{getCustomTranslation('select_a_link')}}...</option>
                        @foreach($sites as $value)
                            <option value="{{$value->id}}"
                                    @foreach($data->company_website as $website) @if($website['website_id'] == $value->id) selected @endif @endforeach>{{$value->{'name_'.$lang} }}</option>
                        @endforeach
                    </select>
                    <div id="link">
                        @foreach($data->company_website as $site)
                            <div id="link-{{$site['website_id']}}">
                                {{$site->website->{'name_'.$lang} }}  <input type="text" name="link[{{$site['website_id']}}]"
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
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="row mb-6">
        <!--begin::Label-->
        <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('contact_info')}}</label>
        <!--end::Label-->
        <!--begin::Col-->
        <div class="col-lg-8">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-6 fv-row">
                    <input type="text" name="contact_info" id="contact_info"
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
    <div class="row mb-6">
        <!--begin::Label-->
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('industry')}}</label>
        <!--end::Label-->
        <!--begin::Col-->
        <div class="col-lg-8">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-6 fv-row">
                    <select name="industry[]" aria-label="{{getCustomTranslation('select_a_industry')}}" data-control="select2"
                            multiple="multiple" data-placeholder="{{getCustomTranslation('select_a_industry')}}..."
                            class="form-select form-select-solid form-select-lg fw-semibold">
                        <option value="">{{getCustomTranslation('select_a_industry')}}...</option>
                        @foreach($industry as $value)
                            <option
                                    @if(in_array($value->id,$data->industry->pluck('id')->toArray())) selected
                                    @endif value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                        @endforeach
                    </select>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->

    <!--end::Card body-->
    <!--begin::Actions-->
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <a href="{{  route('company.index') }}"
           class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
        <button type="button" class="btn btn-primary" id="kt_company_create_submit" onclick="appendIds()">{{getCustomTranslation('merge')}}
        </button>
    </div>
</div>
<!--end::Actions-->


    <script>
        site_array = $('#websites').val();
        $('#websites').change(function () {
            result_add = $(this).val().filter(x => !site_array.includes(x));
            result_remove = site_array.filter(x => !$(this).val().includes(x));
            site_array = $(this).val();
            GetService($(this).val(), result_remove);
        });

        function GetService(add, remove) {
            url = '{{ route("website.list") }}';
            if (result_remove[0] !== undefined) {
                $(`#link #link-${result_remove[0]}`).remove();
            }
            $.ajax({
                type: "GET",
                url: url,
                data: {'id': result_add[0]},
                success: function (res) {
                    $(`#link`).append(`<div id="link-${result_add[0]}"></div>`);
                    for (let x in res) {
                        for (let i in res[x]) {
                            if (result_add[0] !== undefined) {
                                $(`#link #link-${result_add[0]}`).append(`
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

        function appendIds(){

            form = new FormData(document.getElementById('kt_company_create_form'));
            companies = [];
            c = document.getElementsByClassName('id_company');
            for(let i in c) {
                companies.push(c[i].value)
            }
            $('#companies').val(JSON.stringify(companies));
            $('#kt_company_create_form').attr('action','{{route('company.merge.merge')}}');
            $('#kt_company_create_form').submit();
        }

    </script>
    <script src="{{ asset('dashboard') }}/assets/js/scripts.bundle.js"></script>
    <script src="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.js"></script>
