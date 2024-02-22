@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('company'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!-- Modal -->
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-company-table-select="selected">
                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-company-table-select="selected_count"></span>Selected</div> --}}
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-company-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
                        </button>
                    </div>

                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-company-table-select="selected_count"></span>Selected</div> --}}
                        <a class="btn btn-success ms-1" href="{{route('company_merge_template.checkDuplicates')}}">
                            {{getCustomTranslation('check_duplicates')}}
                        </a>
                    </div>

                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-company-table-select="selected_count"></span>Selected</div> --}}
                        <a class="btn btn-success ms-1" href="{{route('company_merge_template.DeleteAll')}}">
                            {{getCustomTranslation('delete_all')}}
                        </a>
                    </div>
                    <div class="fw-bold me-5">
                        {{-- <span class="me-2" data-kt-company-table-select="selected_count"></span>Selected</div> --}}
                        <a class="btn btn-success ms-1" href="{{route('company_merge_template.MergeAll')}}">
                            {{getCustomTranslation('merge_all')}}
                        </a>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
        </div>
        <div class="card-body pt-0" id="data-table">
            @include('acl::company.company_merge_template.table')
        </div>

    </div>
    <!--end::Products-->
@endsection
@push('scripts')
    <script>
        let route = "{{ route('company_merge_template.index') }}";
        let routeAll = "{{ route('company_merge_template.index',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/companymerge/list.js?v=1"></script>
    <script>
        //data-kt-company-table-filter
        function handleDeleteRows() {

            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-company-table-filter="delete_row"]'
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

        $(document).on('change', '#limit', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            limit = $(this).val();
            var searchVal = $("#search-input").val().trim();
            var url = route + "?perPage=" + limit + "&search=" + searchVal + "&" + $("#filterDataForm").serialize();

            $.get({
                url: url,
                success: function (data) {
                    jQuery(document).ready(function () {
                        $('#data-table').html(data);
                        KTMenu.createInstances();
                        handleDeleteRows();
                    });
                },
            });
        });

    </script>
@endpush
