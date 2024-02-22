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

                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                </div>
                <div id="data-table">
                    <!--begin::Card body-->
                    @include('acl::influencer.byIds.table')
                    <!--end::Card body-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Tab Content-->
    </div>
@endsection
@push('scripts')

    <script>
        var route = "{{ route('influencer.InfluencersByids') }}";
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
                },
                success: function (data) {
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
            url= "{{route('influencer.InfluencersByids')}}?category=" + '{{ Request('category')}}' + "&ranges=" + '{{ Request('ranges')}}';
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
