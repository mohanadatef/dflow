@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('request_ad_media_access'))

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
                    <select id="status" name="status" class="form-select form-select-solid form-select-lg fw-semibold"
                            data-mce-placeholder="{{getCustomTranslation('select_status')}}">
                        <option disabled selected>{{getCustomTranslation('select_status')}}</option>
                        <option value="" selected>{{getCustomTranslation('all')}}</option>
                        @foreach(requestAccessText() as $key => $value)
                            <option value="{{$key}}">{{getCustomTranslation($value)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-toolbar"></div>
            <div id="data-table" style="width: 100%">
                @include('record::request_ad_media_access.system.table')
            </div>
            <!--end::Datatable-->
        </div>
    </div>
    <!--end::Products-->
@endsection
@push('scripts')
    <script>
        var limit = "{{Request::get('perPage') ?? 10}}";
        var route = "{{ route('request_ad_media_access.index') }}";
        var approveText = "{{getCustomTranslation(requestAccessText()[2])}}";
        var rejectText = "{{getCustomTranslation(requestAccessText()[3])}}";
        var canceledText = "{{getCustomTranslation(requestAccessText()[5])}}";
        $(document).on('change', '#status', function () {
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
                data: {
                    'created_at': $("#date").val(),
                    'status': $("#status").val()
                },
                success: function (data) {
                    $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
                    $("#data-table").empty();
                    $('#data-table').html(data);
                    KTMenu.createInstances();
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

        function approve(id) {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "POST",
                url: "{{ route('request_ad_media_access.update') }}",
                data: {
                    'id': id,
                    'status': 2,
                },
                success: function (res) {
                    if (res.status) {
                        $('#loading').css('display', 'none');
                        $(`#status-${id}`).empty();
                        $(`#status-${id}`).append(approveText);
                        $(`#user-${id}`).append(res.data.user.name);
                        $(`#action-${id}`).remove();
                    } else {
                        $('#loading').css('display', 'none');
                        toastr.error(res.message_false);
                    }
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    toastr.error(res.message_false);
                }
            });
        }

        function rejectRequest(id) {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "POST",
                url: "{{ route('request_ad_media_access.update') }}",
                data: {
                    'id': id,
                    'status': 3,
                },
                success: function (res) {
                    if (res.status) {
                        $('#loading').css('display', 'none');
                        $(`#status-${id}`).empty();
                        $(`#user-${id}`).append(res.data.user.name);
                        $(`#status-${id}`).append(rejectText);
                        $(`#action-${id}`).remove();
                    } else {
                        $('#loading').css('display', 'none');
                        toastr.error(res.message_false);
                    }
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    toastr.error(res.message_false);
                }
            });
        }
        function canceledRequest(id) {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "POST",
                url: "{{ route('request_ad_media_access.update') }}",
                data: {
                    'id': id,
                    'status': 5,
                },
                success: function (res) {
                    if (res.status) {
                        $('#loading').css('display', 'none');
                        $(`#status-${id}`).empty();
                        $(`#user-${id}`).append(res.data.user.name);
                        $(`#status-${id}`).append(canceledText);
                        $(`#action-${id}`).remove();
                    } else {
                        $('#loading').css('display', 'none');
                        toastr.error(res.message_false);
                    }
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    toastr.error(res.message_false);
                }
            });
        }
    </script>

@endpush
