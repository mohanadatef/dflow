@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('log_ad_record'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="row card-title" style="width: 100%">
                <div class="col-md-4 d-flex align-items-center position-relative my-1">
                    <input id="date" type="date" name="created_at"
                           value="{{\Carbon\Carbon::parse($created_at)->format('Y-m-d')}}"
                           max="{{\Carbon\Carbon::today()->format('Y-m-d')}}"
                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                           placeholder="{{getCustomTranslation('created_at')}}"/>
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>
                <div class="col-md-4 d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <select id="type" name="type" class="form-select form-select-solid form-select-lg fw-semibold"
                            data-mce-placeholder="{{getCustomTranslation('select_type')}}">
                        <option disabled selected>{{getCustomTranslation('select_type')}}</option>
                        <option value="" selected>{{getCustomTranslation('all')}}</option>
                        @foreach(adReocrdLogText() as $key => $value)
                            <option value="{{$key}}">{{getCustomTranslation($value)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-toolbar"></div>
            <div id="data-table" style="width: 100%">
                @include('record::ad_record_log.table')
            </div>
            <!--end::Datatable-->
        </div>
    </div>
    <!--end::Products-->
@endsection
@push('scripts')
    <script>
    var limit = "{{Request::get('perPage') ?? 10}}";
    var route = "{{ route('ad_record_log.index') }}";
    $(document).on('change', '#type', function () {
        $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
        var url = window.location.href
        getData(url);
    });

    $(document).on('change', '#date', function () {
        $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
        var url = window.location.href
        getData(url);
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
            data:{
              'ad_record_id':"{{Request('ad_record_id')}}",
              'type':$("#type").val(),
                'created_at': $("#date").val(),
            },
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
        var url = route + "?perPage=" + limit
        getData(url);
    });
    </script>

@endpush
