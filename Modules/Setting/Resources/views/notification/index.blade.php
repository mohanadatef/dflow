@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('notifications'))
@push('styles')
    <style>
        .dropdown-content {
            position: absolute;
        }
    </style>
@endpush
@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->

                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="data-table" style="width: 100%">
                @include('setting::notification.table')
            </div>
            <!--end::Datatable-->
        </div>
    <!--end::Products-->
    </div>
@endsection
@push('scripts')
    <script>
        var route = "{{ route('notification.index') }}";
        $(document).on('change', '#limit', function () {
            $('#data-table').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            limit = $(this).val();
            var fullSearchLink = route + "?perPage=" + limit;
            $.get({
                url: fullSearchLink,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {
                    $('#data-table').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        });
    </script>
@endpush
