@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('link_tracking'))

@section('content')
    <!--begin::Tracking Links-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                  transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-docs-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search')}}"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Filter-->

                <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                    {{getCustomTranslation('filter')}}
                </button>
                <!--end::Filter-->
                <!--begin:: Filter Menu -->
                <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{getCustomTranslation('filter')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="padding:0">
                                <form method="GET" action="{{route('linktracking.index')}}" data-kt-menu="true">
                                    <input type="hidden" name="title" value="{{request('title')}}"/>

                                    <!--begin::Content-->
                                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                                        <!--begin::Input group-->
                                        <div class="mb-10 mt-4">
                                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('influencer')}}:</label>
                                            <select name="influencer" id="influencer" class="form-select form-select-solid fw-bold" data-kt-select2="false" data-placeholder="{{getCustomTranslation('select_option')}}" data-allow-clear="true"
                                                    data-kt-user-table-filter="role" data-hide-search="false">
                                                <option value="{{request('influencer')}}" selected>{{request('influencer_name')}}</option>
                                            </select>
                                        </div>
                                        <!--end::Input group-->
                                        <input type="hidden" id="influencer_name" name="influencer_name" value="">
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" id="reset_filter" class="btn btn-light fw-semibold me-2 px-6"
                                                    data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                            </button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                                    data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Filter Menu -->
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <!--begin::Add linktracking-->
                    <a href="{{ route('linktracking.create') }}" class="btn btn-primary">{{getCustomTranslation('add')}}
                        {{getCustomTranslation('link_tracking')}}</a>
                    <!--end::Add linktracking-->
                </div>
                <button type="button" class="btn btn-danger ms-1 "
                        data-kt-docs-table-select="delete_selected">
                    {{getCustomTranslation('delete_selected')}}
                </button>
                <!--begin::Group actions-->
                <!--end::Group actions-->
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none"
                     data-kt-customer-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-customer-table-select="selected_count"></span>{{getCustomTranslation('selected')}}
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">{{getCustomTranslation('delete_selected')}}
                    </button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                   data-kt-check-target="#kt_customers_table .form-check-input" value="1"/>
                        </div>
                    </th>
{{--                    <th class="min-w-125px">{{getCustomTranslation('id')}}</th>--}}
                    <th class="min-w-125px">{{getCustomTranslation('title')}}</th>
                    <th class="min-w-125px">{{getCustomTranslation('destination')}}</th>
                    <th class="min-w-125px">{{getCustomTranslation('link')}}</th>
                    <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
        <!--end::Datatable-->
    </div>
    <div class="modal fade" tabindex="-1" id="link_tracker_modal">
        <div class="modal-dialog">
            <div class="modal-content bgi-position-center">
                <div class="modal-body">
                   {{getCustomTranslation('the_link_tracker_is_created_successfully')}}
                    <div>
                        <div class="swal2-icon swal2-success swal2-icon-show" >
                            <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                            <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                            <div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                            <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                        </div>
                        <h1 class="swal2-title" id="swal2-title">
                            <a id="tracker_link" href="https://click.dflow.tech/visit/{{session()->get('link_id')}}" target="_blank">
                                https://click.dflow.tech/visit/{{session()->get('link_id')}}</a>
                        </h1>
                        <span class="swal2-label"></span>
                        <div class="swal2-actions">
                            <div class="swal2-loader"></div>
                            <button type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;"
                                    onclick="copyLink()"
                            >{{getCustomTranslation('copy_the_url')}}</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{getCustomTranslation('close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Tracking Links-->
@endsection
@push('scripts')
    <script>
        let route = "{{ route('link.index') }}";
        let routeCapy = "click.dflow.tech";
        let routeAll = "{{ route('linktracking.index',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
        let influencer_id = "{{request('influencer')}}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/linktracking/list.js?v=1"></script>
    <script>

        copied_successfully="{{getCustomTranslation('copied_successfully')}}"
        async function copyLink(id) {
            let link;
            if(id){
                /* Get the text field */
                let copyText = document.getElementById("link" + id);
                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */
                /* Copy the text inside the text field */
                link = await createShortURL(copyText.value);
            }else {
                //tracker_link
                let long_link = document.getElementById("tracker_link").href;
                link = await createShortURL(long_link);
            }
            await navigator.clipboard.writeText(link);
            Swal.fire({
                position: 'center-center',
                icon: 'success',
                title: link,
                footer: copied_successfully,
                showConfirmButton: false,
                timer: 1500
            })
        }
        async function getShortURL(URL,id) {
            let link = await createShortURL(URL);
            $('#url-link-'+id).attr('title',link).tooltip('show');
        }
        function removeToolTip(id) {
            $('#url-link-'+id).tooltip('hide');
        }
        @if(session()->has('link_id')){
            $( document ).ready(function() {
                //route // visit
                $('#link_tracker_modal').modal('show');
            });
        }
        @endif
        async function createShortURL(url){
            let short_url = null;
            //const url = 'https://www.google.com/search?client=firefox-b-d&q=google+search';
            let accessToken = '3ed023145f18c11fdae43670943cac2c384e891f';
            let api_url = 'https://api-ssl.bitly.com/v3/shorten?access_token=' + accessToken + '&longUrl=' + encodeURIComponent(url);
            await $.getJSON(
                api_url,
                {},
                function(response)
                {
                    short_url = response.data.url;
                }
            );
            return short_url??url;
        }
        let search_influencer_url = "{{ route('influencer.search') }}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/influencer/select.js"></script>
    <script>
        $("#influencer").on("select2:select", function () {
            let influencer_name = $('#influencer :selected').text(); //for getting text from selected option
            $("#influencer_name").val(influencer_name);
        });
        $('#reset_filter').on('click', function () {
            window.location = route;
        })


    </script>
@endpush
