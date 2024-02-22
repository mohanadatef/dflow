@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('researcher_dashboard').' : ' .$name)
@section('content')

    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">

            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->

            </div>
            <!--end::Card header-->
            <div style="width: 100%" id="main-index">
                @include('acl::users.researcherDashboard.main')
            </div>
        </div>
    </div>
    <!--end::Products-->
@endsection

@push('scripts')

    <script src="{{ asset('dashboard') }}/assets/js/highcharts/highcharts.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/exporting.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/accessibility.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/export-data.js"></script>
    <script>
        let themeModeLogo;
        const defaultThemeMode = "system";
        const name = document.body.getAttribute("data-kt-name");
        let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
        if (themeMode === null) {
            if (defaultThemeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            } else {
                themeMode = defaultThemeMode;
            }
            themeModeLogo = themeMode;
        }
        $(document).on('change', '#search_day', function () {
            $('#loading').css('display', 'flex');
            researcherDashboard();
            adsCount();
            adsChart();
            logResearcherDashboard();
            completedAdsChart();
            mediaSeenChart();
            errorsCount();
        });

        $(document).on('change', '#platform_id', function () {
            $('#loading').css('display', 'flex');
            researcherDashboard();
            completedAdsChart();
            mediaSeenChart();
        });

        function researcherDashboard(url = null) {
            if (url == null) {
                url = "{{ route('researcher_dashboard.researcherDashboard') }}";
            }
            $.ajax({
                type: "get",
                url: url,
                data: {
                    'search_day': $("#search_day").val(),
                    'platform_id': $("#platform_id").val(),
                    'user_id': {{request('user_id')}},
                },
                success: function (res) {
                    $('#main-table').empty()
                    $('#main-table').html(res)
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        function closeModel() {
            $('#kt_modal_media').modal('toggle');
            $('#kt_modal_media').modal({backdrop: true})
            @if($userLogin->id == request('user_id'))
            $('#loading').css('display', 'flex');
            researcherDashboard();
            mediaSeenChart();
            errorCountChart();
            @else
            $('#loading').css('display', 'none');
            @endif

        }

        influencer_id_ad = null
        platform_id_ad = null

        function getData(data) {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "POST",
                url: "{{ route('researcher_dashboard.researcherDashboard.get_files') }}",
                data: {
                    'search_day': $("#search_day").val(),
                    'user_id': "{{request('user_id')}}",
                    'url': data.url
                },
                success: function (res) {
                    if (res) {
                        $('#kt_modal_media').modal({backdrop: false})
                        $('#kt_modal_media').modal('show');
                        document.getElementById('influencer-name').innerText = data.influencer.name_en;
                        influencer_id_ad = data.influencer.id;
                        platform_id_ad = data.platform.id;
                        document.getElementById('platform-name').innerText = data.platform.name_en;
                        $('#media-file').html(res);
                        mediaSlider();
                    } else {
                        $('#media-file').html('<div class="alert alert-danger text-center">{{getCustomTranslation('influencer_havet_store')}}</div>');
                    }
                    $('#loading').css('display', 'none');
                }, error: function (res) {
                    $('#loading').css('display', 'none');
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        let slideIndex = 1;
        let mySlidesSeenIndex = 1;
        let mySlidesDateIndex = 1;

        function mediaSlider() {
            showSlides(slideIndex, mySlidesSeenIndex, mySlidesDateIndex);
        }

        function plusSlides(n) {
            showSlides(slideIndex += n, mySlidesSeenIndex += n, mySlidesDateIndex += n);
        }

        function showSlides(n) {
            $('#loading').css('display', 'flex');
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let mySlidesSeen = document.getElementsByClassName("mySlidesSeen");
            let mySlidesDate = document.getElementsByClassName("mySlidesDate");
            if (n > slides.length) {
                slideIndex = 1
                mySlidesSeenIndex = 1
                mySlidesDateIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
                mySlidesSeenIndex = mySlidesSeen.length
                mySlidesDateIndex = mySlidesDate.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < mySlidesSeen.length; i++) {
                mySlidesSeen[i].style.display = "none";
            }
            for (i = 0; i < mySlidesDate.length; i++) {
                mySlidesDate[i].style.display = "none";
            }
            slideIndexI = slides[slideIndex - 1]
            mySlidesSeenIndexI = mySlidesSeen[mySlidesSeenIndex - 1]
            mySlidesDateIndexI = mySlidesDate[mySlidesDateIndex - 1]
            @if($userLogin->id == request('user_id'))
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.seen_get_files') }}",
                data: {
                    'name': slideIndexI.id,
                },
                success: function (res) {
                },
            });
            @endif
                slideIndexI.style.display = "block";
            mySlidesSeenIndexI.style.display = "block";
            mySlidesDateIndexI.style.display = "block";
            var a = document.getElementById('ad-link'); //or grab it by tagname etc
            a.href = "{{route('ad_record.create')}}?mediaS3[]=" + slideIndexI.id + "&date=" + $("#search_day").val() + "&influencer_id=" + influencer_id_ad + "&platform_id=" + platform_id_ad
        }

        function adsCount() {
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.adsCount') }}",
                data: {
                    'user_id': {{request('user_id')}},
                    'search_day': $("#search_day").val(),
                },
                success: function (res) {
                    document.getElementById("allTimeRecords").innerText = res['cards']['allTime'];
                    document.getElementById("todayRecords").innerText = res['cards']['today'];
                },
            });
        }

        function draftsCount() {
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.draftsCount') }}",
                data: {
                    'user_id': {{request('user_id')}},
                    'search_day': $("#search_day").val(),
                },
                success: function (res) {
                    document.getElementById("allTimeDrafts").innerText = res['cards']['allTime'];
                    document.getElementById("todayDrafts").innerText = res['cards']['today'];
                },
            });
        }

        function errorsCount() {
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.error_count') }}",
                data: {
                    'search_day': $("#search_day").val(),
                },
                success: function (res) {
                    document.getElementById("todayErrors").innerText = res;
                },
            });
        }


        function adsChart() {
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.adsChart') }}",
                data: {
                    'user_id': {{request('user_id')}},
                    'search_day': $("#search_day").val(),
                },
                success: function (res) {
                    $('#basic_chart').empty();
                    $('#basic_chart').html(res);
                },
            });
        }

        function completedAdsChart() {
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.completedAdsChart') }}",
                data: {
                    'user_id': {{request('user_id')}},
                    'search_day': $("#search_day").val(),
                    'platform_id': $("#platform_id").val(),
                },
                success: function (res) {
                    $('#completed_ads_chart').empty();
                    $('#completed_ads_chart').html(res);
                    $('#loading').css('display', 'none');
                },
            });
        }

        function mediaSeenChart() {
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.researcherDashboard.mediaSeenChart') }}",
                data: {
                    'user_id': {{request('user_id')}},
                    'search_day': $("#search_day").val(),
                    'platform_id': $("#platform_id").val(),
                },
                success: function (res) {
                    $('#media_seen_chart').empty();
                    $('#media_seen_chart').html(res);
                    $('#loading').css('display', 'none');
                },
            });
        }


        function logResearcherDashboard(urlLog = null) {
            if (urlLog == null) {
                urlLog = "{{ route('researcher_dashboard.researcherDashboard.logResearcherDashboard') }}";
            }
            $.ajax({
                type: "get",
                url: urlLog,
                data: {
                    'user_id': {{request('user_id')}},
                    'search_day': $("#search_day").val(),
                },
                success: function (res) {
                    $('#log_researcher_dashboard').empty();
                    $('#log_researcher_dashboard').html(res);
                },
            });
        }

        function markAdComplete(id) {
            $('#loading').css('display', 'flex');
            $.ajax({
                type: "get",
                url: "{{ route('researcher_dashboard.markAdComplete') }}",
                data: {
                    'id': id,
                    'search_day': $("#search_day").val(),
                },
                success: function (res) {
                    researcherDashboard();
                    completedAdsChart();
                },
            });
        }

        $(document).ready(function () {
            adsCount();
            draftsCount();
            adsChart();
            completedAdsChart();
            logResearcherDashboard();
            mediaSeenChart();
            errorsCount();
            $('#loading').css('display', 'none');
        });

        var limitMainTable = "{{Request::get('perPage') ?? 10}}";
        var limitLogTable = "{{Request::get('perPage') ?? 10}}";

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

        $(document).on('click', '#main-table .pagination a', function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            var url = $(this).attr('href') + "&perPage=" + limitMainTable;
            researcherDashboard(url);
            $('#loading').css('display', 'none');
        });

        $(document).on('change', '#main-table #limit', function () {
            $('#loading').css('display', 'flex');
            limitMainTable = $(this).val();
            var url = "{{ route('researcher_dashboard.researcherDashboard') }}" + "?perPage=" + limitMainTable;
            researcherDashboard(url);
            $('#loading').css('display', 'none');
        });

        $(document).on('click', '#log_researcher_dashboard .pagination a', function (event) {
            event.preventDefault();
            $('#loading').css('display', 'flex');
            var urlLog = $(this).attr('href') + "&perPage=" + limitLogTable;
            logResearcherDashboard(urlLog);
            $('#loading').css('display', 'none');
        });

        $(document).on('change', '#log_researcher_dashboard #limit', function () {
            $('#loading').css('display', 'flex');
            limitLogTable = $(this).val();
            var urlLog = "{{ route('researcher_dashboard.researcherDashboard.logResearcherDashboard') }}" + "?perPage=" + limitLogTable;
            logResearcherDashboard(urlLog);
            $('#loading').css('display', 'none');
        });
    </script>
@endpush
