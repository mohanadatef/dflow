@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('content_records'))

@push('styles')


@endpush

@section('content')

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-10">
        <div class="col-xl-12">
            <!--begin::Table Widget 5-->
            <div class="card card-flush h-xl-100">
                <!--begin::Card header-->
                <div class="card-header py-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">{{getCustomTranslation('content_records')}}</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{getCustomTranslation('all_content_records_are_displayed_here')}}...</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Actions-->
                    <div class="card-toolbar">
                        <!--begin::Filters-->
                        <div class="d-flex flex-stack flex-wrap gap-4">
                            <a href="{{route('content_record.create')}}"
                               class="btn btn-success">{{getCustomTranslation('create_content_record')}}</a>
                        </div>
                        <!--begin::Filters-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Card header-->

            </div>
            <!--end::Table Widget 5-->
        </div>
    </div>
    <!-- End::Row -->



    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_record_table">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            @if(count($datas))
                @foreach($datas as $data)
                    <div class="col-md-4">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-center flex-column p-9 pb-0">

                                <div class="d-flex flex-stack mb-3 w-100">
                                    <!--begin::Badge-->
                                    <div class="badge badge-success">{{ $data->platform->{'name_'.$lang} }}</div>
                                    <!--end::Badge-->
                                    <!--begin::Menu-->
                                    <div class="mt--3">
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                            <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                         viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                        </g>
                                    </svg>
                                </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                             data-kt-menu="true" style="">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <input type="hidden" id="content_id" value="{{$data->id}}">
                                                <a href="{{route('content_record.edit', $data->id)}}"
                                                   class="menu-link flex-stack px-3">
                                                    {{getCustomTranslation('edit')}}
                                                    <i class="fas fa-edit text-info ms-2 fs-7" data-bs-toggle="tooltip"
                                                       aria-label="Specify a target name for future usage and reference"
                                                       data-kt-initialized="1"></i>
                                                </a>


                                                <a href="#" id="delete" class="menu-link flex-stack px-3"
                                                   onclick="deleteItem({{$data->id}}, '{{route('content_record.destroy', $data->id)}}')">
                                                    {{getCustomTranslation('delete')}}
                                                    <i class="fas fa-trash text-info ms-2 fs-7" data-bs-toggle="tooltip"
                                                       aria-label="Specify a target name for future usage and reference"
                                                       data-kt-initialized="1"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--begin::Avatar-->
                                <div class="symbol symbol-65px symbol-circle mb-5" style="width: 100%;
                                        padding-top: 56.25%;
                                        height: 0px;
                                        position: relative;
                                    ">
                                    <video style="width: 100%;
                                        height: 100%;
                                        position: absolute;
                                        top: 0;
                                        left: 0;" controls autoplay muted loop
                                           src="{{getFile($data->video->file??null,pathType()['ip'],getFileNameServer($data->video))}}"></video>
                                </div>
                                <!--end::Avatar-->
                                <div class="d-flex justify-content-between" style="width:100%">
                                    <!--begin::Name-->
                                    <a href="{{route('content_record.edit', $data->id)}}"
                                       class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ $data->influencer?$data->influencer->name_en:"" }}</a>
                                    <!--end::Name-->
                                    <!--begin::Position-->
                                    <div class="fw-semibold text-gray-400 mb-6">{{ $data->company->{'name_'.$lang} }}</div>
                                    <!--end::Position-->
                                </div>


                                <div class="d-flex justify-content-between" style="width:100%">
                                    <!--begin::Name-->
                                    <div class="fw-semibold text-gray-400 mb-6 w-100 flex" style="font-size:15px;">
                                        <i class="fas fa-clock"></i>
                                        <b class="font-weight:100">{{getCustomTranslation('date')}} </b>
                                        {{ Carbon\Carbon::parse($data->date)->format('Y-m-d') }}
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Position-->
                                    <input type="text" hidden
                                           value="{{url('record/content_record/generate-short-link/'.$data->shortLinkRelation->code)}}"
                                           id="myInput-{{$data->id}}">
                                    <button onclick="myFunction({{$data->id}})" class="mb-6 btn copy-btn"
                                            id="company_name">{{getCustomTranslation('copy')}}</button>
                                    <!--end::Position-->
                                </div>


                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->

                    </div>
                @endforeach
            @else
                <div class="col-md-2"></div>
                <div class="col-md-8">

                    <!--begin::Card widget 19-->
                    <div class="card card-flush bg-primary h-lg-100">

                        <!--begin::Body-->
                        <div class="card-body text-white">
                            <!--begin::Row-->
                            <div class="row align-items-center">
                                <!--begin::Col-->
                                <div class="col-sm-7 pe-0 mb-5 mb-sm-0">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex justify-content-between h-100 flex-column pt-xl-5 pb-xl-2 ps-xl-7">
                                        <!--begin::Container-->
                                        <div class="mb-7">
                                            <!--begin::Title-->
                                            <div class="mb-6">
                                                <h3 class="fs-2x fw-semibold text-white">{{getCustomTranslation('no_content_category')}}</h3>
                                                <span class="fw-semibold text-grey opacity-75">{{getCustomTranslation('try_adding_new_content_record')}}</span>
                                            </div>
                                            <!--end::Title-->

                                            <a class="btn btn-danger"
                                               href="{{route('content_record.create')}}">{{getCustomTranslation('add_new_content')}}</a>
                                        </div>
                                        <!--end::Container-->

                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--begin::Col-->
                                <!--begin::Col-->
                                <div class="col-sm-5">
                                    <!--begin::Illustration-->
                                    <img src="{{asset('dashboard/assets/media/svg/illustrations/easy/7.svg')}}"
                                         class="h-200px h-lg-250px my-n6" alt=""/>
                                    <!--end::Illustration-->
                                </div>
                                <!--begin::Col-->
                            </div>
                            <!--begin::Row-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>

            @endif
        </div>
        <!--end::Row-->

    </div>
    <!--end::Container-->

@endsection
@push('scripts')
    <script>
        var route = "{{ route('content_record.index') }}";
        var routeAll = "{{ route('content_record.index',Request()->all()) }}";
        var csrfToken = "{{ csrf_token() }}";
        var deletePermission = {{permissionShow('delete_content_record') ? 1 : 0}};
        var updatePermission = {{permissionShow('update_content_record') ? 1 : 0}};
    </script>

    <script>
        function deleteItem(id, delete_route) {
            Swal.fire({
                text: "{{getCustomTranslation('are_you_sure_you_want_to_delete_this_content_record')}}",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: yes_delete,
                cancelButtonText: no_cancel,
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                },
            }).then(function (result, csrfToken) {
                if (result.value) {
                    $.ajax({
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $(
                                'meta[name="csrf-token"]'
                            ).attr("content"),
                        },
                        url: delete_route,
                        data: {
                            _token: csrfToken,
                            _method: "DELETE",
                            id: id,
                        },
                    })
                        .done(function (res) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "{{getCustomTranslation('you_have_deleted_the_item')}}",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                // delete row data from server and re-draw datatable
                                location.reload();
                            });
                        })
                        .fail(function (res) {
                            Swal.fire({
                                text: "{{getCustomTranslation('item_was_not_deleted')}}",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: ok_got_it,
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            });
                        });
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "{{getCustomTranslation('item_was_not_deleted')}}",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: ok_got_it,
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/content_record/list.js?v=1"></script>
    <script>
        function myFunction(id) {
            // Get the text field
            var copyText = document.getElementById(`myInput-${id}`);

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
            toastr.success("{{getCustomTranslation('copied_the_text')}}" + copyText.value);
        }
    </script>

    <script>
        // $('#company_name')
        var mode = KTThemeMode.getMode();
        var copyBtn = $('.copy-btn');
        mode == 'light' ? copyBtn.addClass(' btn-outline btn-outline-dark btn-active-light-dark border border-dark text-dark') : copyBtn.addClass('btn-light border border-white text-light');
    </script>
@endpush
