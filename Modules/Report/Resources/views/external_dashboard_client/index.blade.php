@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('client_external_dashboard'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex justify-content-end" data-kt-external-dashboard-table-select="base">
                    <!--begin::Add customer-->
                    <a href="#" class="btn btn-primary"
                       onclick="addClient()">{{getCustomTranslation('add')}} {{getCustomTranslation('client')}}</a>
                    <!--end::Add customer-->
                </div>
            </div>
            <div class="card-toolbar"></div>
            <div id="data-table" style="width: 100%">
                @include('report::external_dashboard_client.table')
            </div>
            <!--end::Datatable-->
        </div>
    </div>
    <div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('add_client_to_external_dashboard')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_form" class="form" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">{{getCustomTranslation('client')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="user_id" id="client"
                                        class="form-select form-select-solid form-select-lg fw-semibold"
                                        data-mce-placeholder="">
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>{{getCustomTranslation('start_date')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="start_date"
                                       value="{{Request::old('start_date') ? \Carbon\Carbon::parse(Request::old('start_date'))->format('Y-m-d') :  \Carbon\Carbon::today()}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('start_date')}}"
                                       id="start_date"
                                />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>{{getCustomTranslation('end_date')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="end_date"
                                       value="{{Request::old('end_date') ? \Carbon\Carbon::parse(Request::old('end_date'))->format('Y-m-d') :  \Carbon\Carbon::today()}}"
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('end_date')}}"
                                       id="end_date"
                                />
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
    <div class="modal fade" id="kt_modal_edit" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{getCustomTranslation('edit_client_to_external_dashboard')}}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-lg-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_edit_form" class="form" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>{{getCustomTranslation('start_date')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="start_date"
                                       value=""
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('start_date')}}"
                                       id="start_date_edit"
                                />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span>{{getCustomTranslation('end_date')}}</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="end_date"
                                       value=""
                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{getCustomTranslation('end_date')}}"
                                       id="end_date_edit"
                                />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                    onclick="closeModelEdit()">{{getCustomTranslation('discard')}}
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
        var route = "{{ route('external_dashboard_client.index') }}";
        let routeAll = "{{ route('external_dashboard_client.index',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
        var limit = "{{Request::get('perPage') ?? 10}}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/external_dashboard/client.js"></script>
    <script>
        function handleDeleteRows() {

            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-external-dashboard-table-filter="delete_row"]'
            );
            if (deleteButtons) {
                deleteButtons.forEach((d) => {

                    // Delete button on click
                    d.addEventListener("click", function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest("tr");

                        // Get customer name
                        const customerName = parent.querySelectorAll("td")[1].innerText;
                        const customerId = parent.querySelectorAll("td div input")[0].value;

                        // SweetAlert2 pop up --- official ad_record reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text:
                                are_you_sure_you_want_to_delete +
                                customerId +
                                "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: yes_delete,
                            cancelButtonText: no_cancel,
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton:
                                    "btn fw-bold btn-active-light-primary",
                            },
                        }).then(function (result) {
                            if (result.value) {
                                $.ajax({
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                    },
                                    url: route + "/" + customerId,
                                    data: {
                                        _token: csrfToken,
                                        _method: "DELETE",
                                        id: customerId,
                                    },
                                })
                                    .done(function (res) {
                                        // Simulate delete request -- for demo purpose only
                                        Swal.fire({
                                            text:
                                                you_have_deleted +
                                                customerId +
                                                "!.",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: ok_got_it,
                                            customClass: {
                                                confirmButton:
                                                    "btn fw-bold btn-primary",
                                            },
                                        }).then(function () {
                                            // delete row data from server and re-draw datatable
                                            location.reload();
                                        });
                                    })
                                    .fail(function (res) {
                                        Swal.fire({
                                            text:
                                                customerId + was_not_deleted,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: ok_got_it,
                                            customClass: {
                                                confirmButton:
                                                    "btn fw-bold btn-primary",
                                            },
                                        });
                                    });
                            } else if (result.dismiss === "cancel") {
                                Swal.fire({
                                    text: customerId + was_not_deleted,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: ok_got_it,
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    },
                                });
                            }
                        });
                    });
                });
            }
        }
        function addClient() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_add').modal({backdrop: false})
            $('#kt_modal_add').modal('show');
        }
        urlUpdate = "";
        user_id_update = "";
        external_dashboard_id = "";
        function editClient(data) {
            urlUpdate = "{{route('external_dashboard_client.update',['id'=>'id'])}}";
            urlUpdate = urlUpdate.replace("id", data.id);
            external_dashboard_id = data.external_dashboard_id;
            user_id_update = data.user_id;
            $('#loading').css('display', 'flex');
            $('#kt_modal_edit').modal({backdrop: false})
            $('#kt_modal_edit').modal('show');
            $('#start_date_edit').val(data.start_date ? new Date(data.start_date).toLocaleDateString('en-CA') : "");
            $('#end_date_edit').val(data.end_date ?new Date(data.end_date).toLocaleDateString('en-CA'): "");
        }
        function closeModel() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_add').modal({backdrop: true})
            $('#start_date').val("");
            $('#end_date').val("");
            $('#client').val("");
            $('#kt_modal_add').modal('toggle');
            $('#loading').css('display', 'none');
        }
        function closeModelEdit() {
            $('#loading').css('display', 'flex');
            $('#kt_modal_edit').modal({backdrop: true})
            $('#start_date_edit').val("");
            $('#end_date_edit').val("");
            $('#kt_modal_edit').modal('toggle');
            $('#loading').css('display', 'none');
        }
        $("#kt_modal_add_form").on("submit", function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            url = "{{route('external_dashboard_client.store')}}";
            form = new FormData(this)
            form.append('external_dashboard_id', "{{request('external_dashboard_id')}}");
            $.ajax({
                type: "post",
                url: url,
                data: form,
                contentType: false,
                processData: false,
                success: function () {
                    $('#kt_modal_add').modal('toggle');
                    $('#kt_modal_add').modal({backdrop: true});
                    $('#start_date').val("");
                    $('#end_date').val("");
                    $('#client').val("");
                    getData("{{ route('external_dashboard_client.index') }}")
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });
        $("#kt_modal_edit_form").on("submit", function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            form = new FormData(this)
            form.append('external_dashboard_id', external_dashboard_id);
            form.append('user_id', user_id_update);
            $.ajax({
                type: "post",
                url: urlUpdate,
                data: form,
                contentType: false,
                processData: false,
                success: function () {
                    $('#kt_modal_edit').modal('toggle');
                    $('#kt_modal_edit').modal({backdrop: true});
                    $('#start_date_edit').val("");
                    $('#end_date_edit').val("");
                    getData("{{ route('external_dashboard_client.index') }}")
                }, error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err])
                    }
                }
            });
        });
        function getData(url) {
            $.ajax({
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                url: url,
                data: {
                    'external_dashboard_id': "{{Request('external_dashboard_id')}}",
                },
                success: function (data) {
                    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
                    $("#data-table").empty();
                    $('#data-table').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                    $('#loading').css('display', 'none');
                },
            })
        }

        function updatePageParam(url, page) {
            var hasPageParam = url.includes('page=');

            if (hasPageParam) {
                // Update the 'page' parameter in the URL
                url = url.replace(/([?&])page=[^&]*(&|$)/, '$1page=' + page + '$2');
            } else {
                // Add the 'page' parameter to the URL
                url += (url.includes('?') ? '&' : '?') + 'page=' + page;
            }
            return url;
        }

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            var url = $(this).attr('href') + "&perPage=" + limit;
            getData(url);
        });

        $(document).on('change', '#limit', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            limit = $(this).val();
            var url = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&perPage=" + limit;
            getData(url);
        });
        $('#client').select2({
            delay: 900,
            placeholder: "{{getCustomTranslation('select_a_client')}}...",
            ajax: {
                cacheDataSource: [],
                url: '{{ route("external_dashboard_client.listAssign") }}',
                method: 'get',
                data: {
                    'external_dashboard_id': "{{request('external_dashboard_id')}}"
                },
                dataType: 'json',
                delay: 900,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        }),
                    };
                },
            }
        });
    </script>
@endpush
