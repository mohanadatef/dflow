@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('log'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div id="data-table" style="width: 100%">
                @include('acl::influencer_group_log.table')
            </div>
            <!--end::Datatable-->
        </div>
        <!--end::Products-->
        @endsection
        @push('scripts')

            <script>
                var limit = "{{Request::get('perPage') ?? 10}}";
                function getData(url) {
                    $.ajax({
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": $(
                                'meta[name="csrf-token"]'
                            ).attr("content"),
                        },
                        url: url,
                        success: function (data) {
                            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
                            $("#data-table").empty();
                            $('#data-table').html(data);
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
                    var url = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&perPage=" + limit ;
                    getData(url);
                });
            </script>
    @endpush