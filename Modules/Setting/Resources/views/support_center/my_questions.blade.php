@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('question'))

@section('content')
    <div class="container-xxl">
        <!--begin::Navbar-->
        <div class="card mb-8">
            <div class="card-body py-7">


                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Title-->
                    <div class="d-flex flex-wrap align-items-center my-1">

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
                            <input type="text" id="search-input" name="question"
                                   class="form-control form-control-solid w-250px ps-15"
                                   placeholder="{{getCustomTranslation('search_question')}}"
                                   value="{{request('question')??""}}"
                            />
                        </div>
                        <!--end::Search-->
                    </div>

                    <!--end::Title-->
                    <!--begin::Controls-->
                    <div class="d-flex flex-wrap my-1">

                        <!--begin::Filter-->
                        <button type="button" class="btn btn-primary me-3 dropdown-toggle" id="dropdownMenuClickable"
                                data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                    fill="currentColor"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->{{getCustomTranslation('filter')}}
                        </button>
                        <!--begin::Menu 1-->
                        <form method="GET" id="filterDataForm"
                              class="dropdown-menu w-300px w-md-325px" data-kt-menu="true"
                              aria-labelledby="dropdownMenuClickable">

                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">{{getCustomTranslation('filter')}}</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">

                                <!--begin::Input group-->
                                <!--end::Input group-->

                                <input type="hidden" id="form_hidden_input" name="question" value="">
                                <div class="row mb-6" id="start_access">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">{{getCustomTranslation('date')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col fv-row">
                                                <input type="date" name="created_at"
                                                       value="{{ old('created_at') ?? \Carbon\Carbon::parse('today')->format('Y-m-d')}}"
                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                       placeholder="{{getCustomTranslation('date')}}"/>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" id="reset_filter"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                    </button>
                                    <span class="btn btn-primary fw-semibold px-6 filterDataForm"

                                    >{{getCustomTranslation('apply')}}
                                    </span>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!-- Add date here when I do it design is ruined -->
                            <!--end::Content-->
                        </form>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        @can('create_support_center')
                            <!--begin::Add influencer-->
                            <a href="{{ route('support_center.create') }}" class="btn btn-primary">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                      transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>
                            </svg>
                        </span>
                                <!--end::Svg Icon-->{{getCustomTranslation('add')}} {{getCustomTranslation('question')}}
                            </a>
                            <!--end::Add influencer-->
                        @endcan

                    </div>
                    <!--end::Controls-->
                </div>


                <div class="tab-content" id="data-table">

                    @include('setting::support_center.table')


                </div>
            </div>
        </div>

    </div>
    <!--end::Tab Content-->



@endsection


@push('scripts')
    <script>

        $(document).ready(function () {
            const url = new URL(window.location.href);
            var layout = url.searchParams.get('layout')

            if (layout == 'table') {
                var el = $('#kt_project_users_table_pane');
                el.addClass('active show')
                $('#table_layout_button').addClass('active');

                var element = $('#kt_project_users_card_pane');
                element.removeClass('active show')
                $('#card_layout_button').removeClass('active');
            } else {
                var el = $('#kt_project_users_card_pane');
                el.addClass('active show')
                $('#card_layout_button').addClass('active');

                var element = $('#kt_project_users_table_pane');
                element.removeClass('active show')
                $('#table_layout_button').removeClass('active');

            }

            if (!layout) {

                var layout = @json(auth()->user()->influencer_list);

            }
        });
@endpush
