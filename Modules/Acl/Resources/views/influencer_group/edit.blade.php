@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer_group'))

@section('content')

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_influencer_group_create" aria-expanded="true"
             aria-controls="kt_influencer_group_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{getCustomTranslation('influencer_group')}}</h3>

            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" style="margin: 10px;" data-kt-customer-table-select="base">
                    <!--begin::Add customer-->
                    <a href="#" class="btn btn-primary" onclick="getSheetData()">{{getCustomTranslation('add')}} {{getCustomTranslation('influencer_by_sheet')}}</a>
                    <!--end::Add customer-->
                </div>
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base">
                    <!--begin::Add customer-->
                    <a href="#" class="btn btn-primary" onclick="getTimbrallyData()">{{getCustomTranslation('add')}} {{getCustomTranslation('influencer_by_timbrally')}}</a>
                    <!--end::Add customer-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card title-->
        </div>

        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            @include('dashboard.error.error')
            <form id="kt_influencer_group_create_form" class="form" method="post"
                  action="{{route('influencer_group.update',$data->id)}}">
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('name_ar')}}</span>
                                </label>

                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name_ar" value="{{$data->name_ar}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('name_ar')}}"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('name_en')}}</span>
                                </label>

                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name_en" value="{{$data->name_en}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('name_en')}}"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">{{getCustomTranslation('platform')}}</span>
                                </label>

                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="platform_id[]" id="platform_id" aria-label="{{getCustomTranslation('select_a_platform')}}" multiple
                                        data-control="select2" data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold r">
                                @foreach($platform as $value)
                                        <option @if(in_array($value->id,$data->influencer_follower_platform->pluck('platform_id')->toArray())) selected
                                                @endif value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>{{getCustomTranslation('influencer')}}</span>
                                </label>
                                <select id="influencer" name="influencer"
                                        class="form-select form-select-solid form-select-lg fw-semibold"
                                        data-mce-placeholder=""
                                ></select>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>{{getCustomTranslation('current_influencer_group')}}</span>
                                    <a href="{{ route('influencer_group_log.index',['influencer_group_id'=>$data->id]) }}" class="btn btn-primary" target="_blank"> log</a>
                                </label>
                                <div>
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        <span id="influencer-count">{{$data->countInfluencer}}</span>
                                        <span>{{getCustomTranslation('influencers')}}</span>
                                    </label>
                                    <label class="fs-6 fw-semibold form-label mt-3">
                                        <span>{{getCustomTranslation('average_ads')}} </span><span id="ad-count">{{$data->countAd}}</span>
                                    </label>
                                </div>
                                <div id="platform-all" style="overflow: scroll">
                                    @foreach($data->influencer_follower_platform as $influencer_follower_platform)
                                        <div class="count"
                                             id="{{$influencer_follower_platform->id}}"
                                             data-platfrom="{{$influencer_follower_platform->platform_id}}"
                                             data-count-{{$influencer_follower_platform->id}}="{{$influencer_follower_platform->count}}">
                                            {{ $influencer_follower_platform['line'] }}
                                            <a type="button"
                                               onclick="rowDelete({{$influencer_follower_platform->id}})"
                                               class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                               data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-5 m-0">
                                        <i class="fa fa-x"></i>
                                    </span>
                                            </a>
                                            <input type="text" name="influencer_Platform[]" class="id-data" hidden
                                                   id="{{$influencer_follower_platform->id}}"
                                                   value="{{$influencer_follower_platform->id}}"
                                            /></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Input group-->
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{  route('influencer_group.index') }}"
                           class="btn btn-light btn-active-light-primary me-2">{{getCustomTranslation('discard')}}</a>
                        <button type="submit" class="btn btn-primary" id="kt_influencer_group_create_submit">{{getCustomTranslation('save_changes')}}

                        </button>
                    </div>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
    <div class="modal fade" id="kt_modal_timbrally" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('import_timbrally')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_timbrally_form" class="form" method="post" action=""  enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                             data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                             data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                             data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">{{getCustomTranslation('platfrom')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="platform" aria-label="{{getCustomTranslation('select_a_platform')}}" id="platform_timbrally"
                                        data-control="select2" data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_platform')}}...</option>
                                    @foreach($platform as $value)
                                        <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>{{getCustomTranslation('timbrally')}}</span>
                                </label>
                                <!--end::Label-->
                                <input class="form-control" id="kt_tagify_1" name="key"/>
                                @if ($errors->has('keys'))
                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('key') }}</div></div>
                                @endif
                                <br>
                                <div id="check_message"></div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                    onclick="closeTimbrallyModel()">{{getCustomTranslation('discard')}}
                            </button>
                            <button type="button" class="btn btn-light me-3" onclick="actionButton('check')">{{getCustomTranslation('check')}}
                            </button>
                            <button type="button" class="btn btn-light me-3" onclick="actionButton('submit')">{{getCustomTranslation('submit')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_modal_sheet" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('import_sheet')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_sheet_form" class="form" method="post" action=""  enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                             data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                             data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                             data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">{{getCustomTranslation('platfrom')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="platform" aria-label="{{getCustomTranslation('select_a_platform')}}" id="platform_sheet"
                                        data-control="select2" data-placeholder="{{getCustomTranslation('select_a_platform')}}..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_platform')}}...</option>
                                    @foreach($platform as $value)
                                        <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>{{getCustomTranslation('sheet')}}</span>
                                </label>
                                <!--end::Label-->
                                <input
                                        type="file" name="file"
                                        class="form-control"
                                        required
                                >
                                <br>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                    onclick="closeSheetModel()">{{getCustomTranslation('discard')}}
                            </button>
                            <button type="submit" class="btn btn-light me-3">{{getCustomTranslation('submit')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
@push('scripts')

    <script>
        p = ["{{ implode(',',$data->influencer_follower_platform->pluck('platform_id')->toArray())}}"]
        var route = "{{ route('influencer_group.index') }}";
        let path = "{{ route('influencer_group.influencer.search') }}";
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var input1 = document.querySelector("#kt_tagify_1");
        // Initialize Tagify components on the above inputs
        new Tagify(input1, {
            autocomplete        : false,
            delimiters : ",| |:|[\\n\\r]",
            duplicates          : false,
            whitelist           : ['test', 'foobar'],
        });
        function closeTimbrallyModel() {
            $('#kt_modal_timbrally').modal('toggle');
            $('#kt_modal_timbrally').modal({backdrop: true})
            $('#loading').css('display', 'none');
        }

        function getTimbrallyData() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_timbrally').modal({backdrop: false})
            $('#kt_modal_timbrally').modal('show');
            $('#loading').css('display', 'none');
        }

        function closeSheetModel() {
            $('#kt_modal_sheet').modal('toggle');
            $('#kt_modal_sheet').modal({backdrop: true})
            $('#loading').css('display', 'none');
        }


        $("#kt_modal_sheet_form").on("submit", function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            url = "{{route('influencer_group.upload_influencer')}}";
            form = new FormData(this)
            influencerId = [];
            influencer = document.getElementsByClassName('id-data')
            for (let i in influencer) {
                influencerId.push(influencer[i].id)
            }
            form.append('influencer_id', influencerId);
            $.ajax({
                type: "post",
                url: url,
                data: form,
                contentType: false,
                processData: false,
                success: function (res) {
                    PlatformTemplates(res,$('#platform_sheet').val());
                    $('#kt_modal_sheet').modal('toggle');
                    $('#kt_modal_sheet').modal({backdrop: true});
                    $('#kt_modal_sheet_form').trigger("reset");
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });
        function getSheetData() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_sheet').modal({backdrop: false})
            $('#kt_modal_sheet').modal('show');
            $('#loading').css('display', 'none');
        }
        function actionButton(type) {
            form = document.getElementById('kt_modal_timbrally_form')
            if (type == 'check') {
                event.preventDefault();
                $('#loading').css('display', 'flex');
                url = "{{route('influencer_group.upload_influencer_check')}}";
                form = new FormData(form)
                $.ajax({
                    type: "post",
                    url: url,
                    data: form,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                       if(res)
                       {
                           text = res;
                       }else{
                           text = "{{getCustomTranslation('good')}}";
                       }
                       $('#check_message').empty();
                       $('#check_message').append(`<p>${text}<p>`);
                        $('#loading').css('display', 'none');
                    }, error: function (res) {
                        for (let err in res.responseJSON.errors) {
                            toastr.error(res.responseJSON.errors[err])
                        }
                    }
                });
            }
            if (type == 'submit') {
                event.preventDefault();
                $('#loading').css('display', 'flex');
                url = "{{route('influencer_group.upload_influencer')}}";
                form = new FormData(form)
                influencerId = [];
                influencer = document.getElementsByClassName('id-data')
                for (let i in influencer) {
                    influencerId.push(influencer[i].id)
                }
                form.append('influencer_id', influencerId);
                $.ajax({
                    type: "post",
                    url: url,
                    data: form,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        PlatformTemplates(res,$('#platform_timbrally').val());
                        $('#kt_modal_timbrally').modal('toggle');
                        $('#kt_modal_timbrally').modal({backdrop: true});
                        $('#kt_modal_timbrally_form').trigger("reset");
                        $('#loading').css('display', 'none');
                    }, error: function (res) {
                        for (let err in res.responseJSON.errors) {
                            toastr.error(res.responseJSON.errors[err])
                        }
                    }
                });
            }
        }

    </script>
    <script src="{{ asset('dashboard') }}/assets/js/influencer_group/edit.js"></script>
    {!! JsValidator::formRequest('Modules\Acl\Http\Requests\InfluencerGroup\EditRequest','#kt_influencer_group_create_form') !!}

@endpush
