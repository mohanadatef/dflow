@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('unique_influencers'))

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
                            <input type="text" id="search" data-kt-company-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-15"
                                   placeholder="{{getCustomTranslation('search_influencers')}}"
                                   value="{{request('name')??""}}"
                            />

                        </div>

                        <!--end::Search-->
                    </div>
                    <div class="d-flex align-items-center position-relative flex-wrap my-1">
                        <a href="{{Route('influencer.discover')}}" class="btn btn-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <!--end::Svg Icon-->{{getCustomTranslation('discover_influencers')}}</a>
                    </div>
                    <!--begin::Card title-->
                </div>

                <!--begin::Card body-->
                <div id="data-table">
                    @include('acl::influencer.unique.tableuniqueInfluencers')
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
        var input = $('#search');
        //on keyup, start the countdown
        input.on('keyup', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            getData(window.location.href);
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
                    "sorting": $("#sortingcount").attr('data-sorting_type'),
                    "search": $('#search').val(),
                    "company_id": "{{request('company_id')}}",
                    "ranges": "{{request('ranges')}}",
        },

                success:function(data) {
                    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

                    $("#data-table").empty();
                    $('#data-table').html(data);
                },
            })
        }
        function sorting() {
            let sorting = $("#sortingcount").attr('data-sorting_type') ;
            if(sorting == 'desc')
            {
                document.getElementById( "sortingcount" ).setAttribute('data-sorting_type','asc') ;
            }else{
                document.getElementById( "sortingcount" ).setAttribute('data-sorting_type','desc')
            }
            url= "{{route('influencer.uniqueInfluencers')}}?company_id=" + '{{ Request('company_id')}}' + "&ranges=" + '{{ Request('ranges')}}';
            getData(url)
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
            var url = $(this).attr('href')  ;
            getData(url);
        });

        $(document).on('change', '#limit', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();

            var url = window.location.href + "&perPage=" + limit ;

            getData(url);
        });

    </script>
@endpush
