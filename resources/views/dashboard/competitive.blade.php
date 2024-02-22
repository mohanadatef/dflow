@extends('dashboard.layouts.app')

@section('title', 'Competitive Analysis')

@push('styles')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endpush

@section('content')
    <script>
        defaultThemeMode = "system";
        name = document.body.getAttribute("data-kt-name");
        themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");

        if (themeMode === null) {
            if (defaultThemeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            } else {
                themeMode = defaultThemeMode;
            }
            themeModeLogo = themeMode;
        }
    </script>
        @if(user()->role->role->type != 1)
            <div class="row" style="margin-bottom:50px;">
            <div class="col-md-4">
                <div class="d-flex align-items-center position-relative my-1">
                    <select id="search_company" name="company_id"
                            class="form-select form-select-solid form-select-lg fw-semibold"
                            data-mce-placeholder=""
                    ></select>
                </div>
            </div>
            <div class="col-md-4"></div>
        @else
                    <div class="row" style="margin-bottom:50px;margin-top:-50px">
            <div class="col-md-4">
                <div class="row">

                        <div class="d-flex align-items-center position-relative my-1">
                            <select id="search_company_direct" name="company_id"
                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                    data-mce-placeholder="select company direct"
                            >
                                <option disabled selected>Select Direct Competitor</option>
                                @foreach($companies_direct as $compan)
                                    <option value="{{$compan->id}}">{{$compan->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <div class="row">
                        <div class="d-flex align-items-center position-relative my-1">
                            <select id="search_company_indirect" name="company_id"
                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                    data-mce-placeholder="select company indirect">
                                <option disabled selected>Select Indirect Competitor</option>
                                @foreach($companies_indirect as $compan)
                                    <option value="{{$compan->id}}">{{$compan->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
        <div class="col-md-4"></div>
@endif
        <div class="col-md-4">
            <input
                    id="ranges"
                    type="text"
                    name="ranges"
                    value="{{ $range_start->format('m/d/Y') . ' - ' . $range_end->format('m/d/Y') }}"
                    style="margin-right:5px"
                    class="form-select"
            />
            <input type="hidden" name="company" value="{{$current_company->id}}"/>
        </div>
    </div>


    <div class="row g-5 g-xl-10">


        <div id="main-content">
            @include('dashboard.mainContent')

        </div>
    </div>
@endsection


@push('scripts')

    <script src="{{ asset('dashboard') }}/assets/js/highcharts/highcharts.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/wordcloud.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/exporting.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/accessibility.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/export-data.js"></script>
    <script>
        let start_date = "{{ $range_start->format('MM/DD/YYYY') }}";
        let end_date = "{{ $range_end->format('MM/DD/YYYY') }}";
        $(function () {
            $('input[name="ranges"]').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                start_date = start.format('MM/DD/YYYY');
                end_date = end.format('MM/DD/YYYY');
            });
        });
        let path = "{{ route('competitive_analysis.search_companies') }}";
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#search_company_indirect').select2().on('select2:select', function (e) {

            let id = e.params.data.id
            let ranges = $('#ranges').val();
            loadMainContent(id, ranges);
        });
        $('#search_company_direct').select2().on('select2:select', function (e) {

            let id = e.params.data.id
            let ranges = $('#ranges').val();
            loadMainContent(id, ranges);
        });
        $('#search_company').select2({
            minimumInputLength: 3,
            delay: 1000,
            placeholder: "Select a Company...",
            ajax: {
                cacheDataSource: [],
                url: path,
                method: 'post',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item.name_en,
                            }
                        }),
                    };
                },
            }
        }).on('select2:select', function (e) {

            let id = e.params.data.id
            let ranges = $('#ranges').val();
            loadMainContent(id, ranges);
        });
        $("#ranges").on('change', function () {
            let ranges = $('#ranges').val();
            let id = $('#search_company').val() ? $('#search_company').val() : "{{ request('company') }}";
            loadMainContent(id, ranges)
        });

        function loadMainContent(id, ranges) {
            $.get({
                url: "{{route('competitive_analysis')}}",
                data: {
                    company: id,
                    ranges: ranges,
                },
                beforeSend: function () {
                    $('#loading').css('display', 'flex')
                },
                success: function (data) {
                    var url = 'competitive_analysis' + '?company=' + id + "&ranges=" + ranges;
                    window.history.pushState("data", "Title", url);
                    $('#main-content').html(data)
                },
                complete: function () {
                    $('#loading').css('display', 'none')
                }
            });
        }


    </script>
@endpush
