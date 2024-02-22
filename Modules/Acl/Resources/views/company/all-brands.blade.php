@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('company'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                      transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"/>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                    <input type="text" id="search-input" data-kt-company-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" autocomplete="off"
                           placeholder="{{getCustomTranslation('search_company')}}"
                           value="{{$request->name??""}}" disabled
                    />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Filter-->

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{getCustomTranslation('filter')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="padding:0">
                                <!--begin:: Filter Menu -->
                                <form method="GET" action="{{route('company.allBrands')}}" data-kt-menu="true">
                                    <input type="hidden" name="name" id="name" value="{{request('name')}}"/>

                                    <!--begin::Content-->
                                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('industries')}}:</label>
                                            <select name="industry" id="industry_id"
                                                    class="form-select form-select-solid fw-bold"
                                                    data-kt-select2="false" data-placeholder="{{getCustomTranslation('select_option')}}"
                                                    data-allow-clear="true"
                                                    data-kt-user-table-filter="role" data-hide-search="false">

                                            </select>
                                        </div>
                                        <!--end::Input group-->

                                        <input type="hidden" name="industry_name" id="industry_name"
                                               value="{{request('industry_name')}}"/>


                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" id="reset_filter"
                                                    class="btn btn-light fw-semibold me-2 px-6"
                                                    data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                            </button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-6"
                                                    data-kt-menu-dismiss="true"
                                                    data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </form>
                                <!--end::Filter Menu -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end::Card header-->
    <br>
    <!--begin::Card body-->
    <div class="card-body pt-0" id="data-table">
        <!--begin::Table-->
        @include('acl::company.brands_table')
    </div>
    <!--end::Datatable-->

    <!--end::Products-->

@endsection
@push('scripts')
    <script>
        let route = "{{ route('company.allBrands') . '?company=' .request('company') }}";
        let routeAll = "{{ route('company.allBrands',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
        let categoryListSearchRoute = "{{route('category.list_search') }}";

        $('#industry_id').select2({
            dropdownParent: $("#exampleModal"),
            delay: 1000,
            placeholder: "Select An Industry...",
            ajax: {
                cacheDataSource: [],
                url: categoryListSearchRoute,
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_'+"{{$lang}}"],
                            }
                        }),
                    };
                },
            },
        });
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/company/list.js?v=1"></script>
    <script>

        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
        var input = $('#search-input');

        //on keyup, start the countdown
        input.on('keyup', function () {
            doneTyping();
        });


        //user is "finished typing," do something
        function doneTyping() {
            let val = $("#search-input").val();
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            var url =
                "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" +
                "&name=" + val;
            loadTableData(url);
            // window.location = route + "&name=" + val + "&industry=" + '{{request('industry_id')}}'
            // ;
        }

        $("#industry_id").on("select2:select", function () {
            let name = $('#industry_id :selected').text(); //for getting text from selected option
            $("#industry_name").val(name);
        });


        $('#reset_filter').on('click', function () {
            $('#industry_id').val('').trigger('change');
            window.location = route;
        });
        $('#search-input').prop("disabled", false); // Element(s) are now enabled.

        function loadTableData(url) {
            $.ajax({
                url: url
            }).done(function (data) {
                $('#data-table').html(data);


                // referechDataTable();
            }).fail(function () {
                alert('{{getCustomTranslation("an_error_in_loading")}}');
            });
        }


    </script>
@endpush
