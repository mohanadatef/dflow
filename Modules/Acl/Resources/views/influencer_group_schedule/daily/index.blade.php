@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer_group_edit'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base">
                    <!--begin::Add customer-->
                    <a href="{{ route('influencer_group_schedule.index') }}" class="btn btn-primary">{{getCustomTranslation('back')}}</a>
                    <!--end::Add customer-->
                </div>
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base" style="padding-left: 10px">
                    <!--begin::Add customer-->
                    <a href="#" class="btn btn-primary" onclick="changeResearcher()">{{getCustomTranslation('change_researcher')}}</a>
                    <!--end::Add customer-->
                </div>
            </div>
            <!--begin::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="data-table" style="width: 100%">
            @include('acl::influencer_group_schedule.daily.table')
        </div>
        <!--end::Datatable-->
    </div>
    <div class="modal fade" id="kt_modal_change" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('change_influencer_to_researcher')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_change_form" class="form" method="post" action="" enctype="multipart/form-data">
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
                                    <span class="required">{{getCustomTranslation('researcher')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="researcher_id" aria-label="{{getCustomTranslation('select_a_researcher')}}" id="researcher_id"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_researcher')}}...</option>
                                    @foreach($researchers as $researcher)
                                        <option value="{{$researcher->id}}">{{$researcher->name}}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                    onclick="closeModel()">{{getCustomTranslation('discard')}}
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
    <!--end::Products-->
@endsection
@push('scripts')
    <script>
        function changeResearcher() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_change').modal({backdrop: false})
            $('#kt_modal_change').modal('show');
        }
        function closeModel() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_change').modal({backdrop: true})
            $('#kt_modal_change').modal('toggle');
            $('#loading').css('display', 'none');
        }
        $("#kt_modal_change_form").on("submit", function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            form = new FormData(this)
            result=[];
            values = document.querySelectorAll('.item_check')
            for (var i = 0; i < values.length; i++) {
                if (values[i].checked) {
                    result.push(values[i].value);
                }
            }
            form.append('id', result);
            $.ajax({
                type: "post",
                url: "{{route('reseacher_influencers_daily.changeResearcher')}}",
                data: form,
                contentType: false,
                processData: false,
                success: function () {
                    $('#kt_modal_change').modal('toggle');
                    $('#kt_modal_change').modal({backdrop: true});
                    getData()
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });
        function getData() {
            $.ajax({
                type: "Get",
                url: window.location.href,
                success: function (res) {
                    $('#data-table').empty();
                    $('#data-table').html(res);
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }
    </script>
@endpush
