@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('influencer_group_schedule'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base">
                    @can('create_influencer_group_schedule')
                    <!--begin::Add customer-->
                    <a href="#" class="btn btn-primary" onclick="addGroup()">{{getCustomTranslation('add')}} {{getCustomTranslation('influencer_group_schedule')}}</a>
                    <!--end::Add customer-->
                    @endcan
                </div>

                <div class="d-flex justify-content-end" data-kt-customer-table-select="base" style="margin-left: 10px;">
                        <!--begin::Add customer-->
                        <a href="{{route('influencer_group_schedule.scanTable')}}" class="btn btn-primary" id="btn" onclick="disableButton()">Scan Schedule</a>
                        <!--end::Add customer-->
                </div>

            </div>
            <!--begin::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="data-table" style="width: 100%">
            @include('acl::influencer_group_schedule.table')
        </div>
        <!--end::Datatable-->
    </div>
    <div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('add_influencer_group_to_researcher')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_form" class="form" method="post" action="" enctype="multipart/form-data">
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
                                    <span class="required">{{getCustomTranslation('day')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="day" aria-label="Select a Day" id="day_f"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_day')}}...</option>
                                    @foreach(weekSchedule() as $key => $value)
                                        <option value="{{$key}}">{{getCustomTranslation($value)}}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
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
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">{{getCustomTranslation('shift')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="shift" aria-label="{{getCustomTranslation('select_a_shift')}}" id="shift"
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">{{getCustomTranslation('select_a_shift')}}...</option>
                                        <option value="0">{{getCustomTranslation('morning_group')}}</option>
                                        <option value="1">{{getCustomTranslation('night_group')}}</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">{{getCustomTranslation('group')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="influencer_group_id[]" aria-label="{{getCustomTranslation('select_a_group')}}" id="group_id"
                                        data-control="select2"  class="form-select form-select-solid form-select-lg fw-semibold" multiple>
                                    <option value="">{{getCustomTranslation('select_a_shift')}}...</option>
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
        $(document).ready(function () {
            group({{$day}})
        });

        function group(day) {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: 'GET',
                url: "{{route('influencer_group_schedule.influencer_group.remainder')}}",
                data: {
                    day: day
                },
                success: function (res) {
                    $('#group').empty()
                    for (let x in res) {
                        $('#group').append(`<br>${res[x].name_en}`);
                    }
                }
            });
            $('#loading').css('display', 'none');
        }

        $(document).on('change', '#day_f', function () {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: 'GET',
                url: "{{route('influencer_group_schedule.influencer_group.remainder')}}",
                data: {
                    day: $(this).val()
                },
                success: function (res) {
                    $('#group_id').empty()
                    for (let x in res) {
                        $('#group_id').append(`<option value="${res[x].id}">${res[x]['name_{{$lang}}']}</option>`);
                    }
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        });

        function addGroup() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_add').modal({backdrop: false})
            $('#kt_modal_add').modal('show');
        }

        function closeModel() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_add').modal({backdrop: true})
            $('#day_f').val("");
            $('#researcher_id').val("");
            $('#shift').val("");
            $('#group_id').val("").trigger('change');
            $('#group_id').empty();
            $('#kt_modal_add').modal('toggle');
            $('#loading').css('display', 'none');
        }

        $("#kt_modal_add_form").on("submit", function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            url = "{{route('influencer_group_schedule.store')}}";
            form = new FormData(this)
            $.ajax({
                type: "post",
                url: url,
                data: form,
                contentType: false,
                processData: false,
                success: function () {
                    $('#kt_modal_add').modal('toggle');
                    $('#kt_modal_add').modal({backdrop: true});
                    $('#day_f').val("");
                    $('#researcher_id').val("");
                    $('#shift').val("");
                    $('#group_id').val("").trigger('change');
                    $('#group_id').empty();
                    getData()
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });

        function getData() {
            d=document.getElementsByClassName('day active')
            $.ajax({
                type: "Get",
                url: "{{ route('influencer_group_schedule.index') }}",
                data:{
                  day : d[0].getAttribute('data-day')
                },
                success: function (res) {
                    $('#data-table').empty();
                    $('#data-table').html(res);
                    group(d[0].getAttribute('data-day'))
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }
        function deleteGroup(id) {
            $('#loading').css('display', 'flex');
            url="{{ route('influencer_group_schedule.destroy',['id'=>'id']) }}";
            url=url.replace('id', id)
            $.ajax({
                type: "DELETE",
                url: url,
                success: function (res) {
                    getData()
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });

        }
        function disableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = true;
            btn.innerText = '{{getCustomTranslation('sending')}}...'
            $('#loading').css('display', 'flex');
        }
    </script>
    <noscript>
        @php  redirect(route('influencer_group_schedule.index')) @endphp
    </noscript>
@endpush
