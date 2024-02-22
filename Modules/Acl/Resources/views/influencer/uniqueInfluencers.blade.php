@extends('dashboard.layouts.app')

@section('title', 'Unique Influencers')

@section('content')
    <div class="container-xxl">

        <!--begin::Tab Content-->
        <div class="tab-content">

            <!--begin::Tab pane-->

                <!--begin::Card-->
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
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                  rx="1"
                                                  transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="currentColor"/>
                                        </svg>
                                    </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="search-input" data-kt-company-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-15"
                                       placeholder="Search influencers"
                                       name="search"
                                       value="{{request('search')??""}}" disabled
                                />

                            </div>

                            <!--end::Search-->
                        </div>
                        <div class="d-flex align-items-center position-relative flex-wrap my-1">
                            <a href="{{Route('influencer.discover')}}" class="btn btn-primary">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <!--end::Svg Icon-->Discover Influencers</a>
                        </div>
                        <!--begin::Card title-->
                    </div>

                    <!--begin::Card body-->
                    <div id="data-table">
                        @include('acl::influencer.tableuniqueInfluencers')
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->


        </div>
        <!--end::Tab Content-->

    </div>

@endsection
@push('scripts')




    <script>
  let check ='desc';

        $(document).ready(function () {
            const url = new URL(window.location.href);
            var layout = url.searchParams.get('layout')

            if (layout == 'table') {
                var el = $('#kt_project_users_table_pane');
                el.addClass('active show')
                $('#table_layout_button').addClass('active')

                var element = $('#kt_project_users_card_pane');
                element.removeClass('active show')
                $('#card_layout_button').removeClass('active')
            }

            if (!layout) {
                var layout = @json(auth()->user()->influencer_list);

                if (layout == 'table') {
                    var el = $('#kt_project_users_table_pane');
                    el.addClass('active show')
                    $('#table_layout_button').addClass('active')

                    var element = $('#kt_project_users_card_pane');
                    element.removeClass('active show')
                    $('#card_layout_button').removeClass('active')
                }
            }
        });


        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
        var input = $('#search-input');
        input.on('keyup', function () {

            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div></div>');

            let sorting = "&sorting=" + check;
            let searchVal = "&search=" + $("#search-input").val();
            var fullSearchLink = "{!! url()->full() !!}" + searchVal + sorting;

            $.get({
                url: fullSearchLink,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {

                    $('#data-table').html(data);
                    check=(check == 'asc')?'desc':'asc';

                }
            });
        });
        $('#search-input').prop("disabled", false); // Element(s) are now enabled.

        function sortig(){
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div></div>');
            let searchVal = "&name=" + $("#search-input").val();
            let sorting = "&sorting=" + check;
            var fullSearchLink = "{!! url()->full() !!}" + searchVal + sorting;


            $.get({
                url: fullSearchLink,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {
                    $('#data-table').html(data);
                    check=(check == 'asc')?'desc':'asc';

                }
            });

        }



    </script>
@endpush
