<script src="{{ asset('dashboard') }}/assets/js/highcharts/highcharts.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/wordcloud.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/exporting.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/accessibility.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/export-data.js"></script>

<div class="modal fade" id="kt_modal_discount_showads" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{getCustomTranslation("ads")}} </h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" onclick="closemodeldiscount()">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                              rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                              transform="rotate(45 7.41422 6)" fill="currentColor"/>
                    </svg>
                </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7">

                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <div class="row">

                            <label class="fs-5 fw-bold form-label mb-2">
                                <span >{{getCustomTranslation("promoted_offer")}}  :<span id="text_promoted_offer"></span></span>
                            </label>

                            <label class="fs-5 fw-bold form-label mb-2">
                                <span >{{getCustomTranslation("count")}} : <span id="count_promoted_offer"></span></span>
                            </label>

                    </div>
                    <div id="listAdRecorddiscount" style="width: 100%">

                    </div>


                    <!--end::Label-->
                    <!--begin::Input-->

                    <!--end::Input-->
                </div>

                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<div id="container-discount"></div>
<script>
        function closemodeldiscount(){
    $('#kt_modal_discount_showads').modal('toggle');
}
        var exportingUser="{{$userType}}" == 1 ? false : true;
    // promoted products
    data = @json($discount_cloud);
    if (themeMode == 'light') {
        Highcharts.chart('container-discount', {
            accessibility: {
                screenReaderSection: {
                    beforeChartFormat: '<h5>{chartTitle}</h5>' +
                        '<div>{chartSubtitle}</div>' +
                        '<div>{chartLongdesc}</div>' +
                        '<div>{viewTableButton}</div>'
                }
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
         point: {
             events: {
                click: function() {
                    $('#kt_modal_discount_showads').modal('toggle');
                   $("#text_promoted_offer").text(this.name);
                   $("#count_promoted_offer").text(this.weight);
                   $.get({
                url: "{{route('reports.getdatechartbydiscount')}}",
                data:{
                    'promoted_offer':this.name,
                    'company_id':"{{$current_company->id}}",
                      'ranges':$('#ranges').val(),
                      },
                success: function(data) {

                    $('#listAdRecorddiscount').html(data);

                }
            });

                }
            }
        }
                }
            },
            series: [{
                type: 'wordcloud',
                data,
                name: '{{getCustomTranslation("occurrences")}}'
            }],
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            tooltip: {
                enabled: false,
                headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
            }, exporting: {
                    enabled: exportingUser,
                    buttons: {
                        contextButton: {
                            menuItems: [{
                                text: '{{getCustomTranslation("view_full_screen")}}',
                                onclick: function () {
                                    this.fullscreen && this.fullscreen.toggle()
                                }
                            }, {
                                text: '{{getCustomTranslation("print_chart")}}',
                                onclick: function () {
                                    this.print();
                                }
                            }, {
                                separator: true
                            }, {
                                text: '{{getCustomTranslation("download_png")}}',
                                onclick: function () {
                                    this.exportChart();
                                }
                            }, {
                                text: '{{getCustomTranslation("download_jpeg")}}',
                                onclick: function () {
                                    this.exportChart({
                                        type: 'image/jpeg'
                                    });
                                }
                            }, {
                                text: '{{getCustomTranslation("download_pdf")}}',
                                onclick: function () {
                                    this.exportChart({
                                        type: 'application/pdf'
                                    });
                                }
                            }, {
                                text: '{{getCustomTranslation("download_svg")}}',
                                onclick: function () {
                                    this.exportChart({
                                        type: 'image/svg+xml'
                                    });
                                }
                            }]
                        }
                    }
                },
        });
    } else {
        Highcharts.chart('container-discount', {
            chart: {
                backgroundColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 1,
                        y2: 1
                    },
                    stops: [
                        [0, '#151521'],
                        [1, '#151521']
                    ]
                },
                style: {
                    fontFamily: '\'Unica One\', sans-serif'
                },
                plotBorderColor: '#606063'
            },
            accessibility: {
                screenReaderSection: {
                    beforeChartFormat: '<h5>{chartTitle}</h5>' +
                        '<div>{chartSubtitle}</div>' +
                        '<div>{chartLongdesc}</div>' +
                        '<div>{viewTableButton}</div>'
                }
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
         point: {
             events: {
                click: function() {
                    $('#kt_modal_discount_showads').modal('toggle');
                   $("#text_promoted_offer").text(this.name);
                   $("#count").text(this.weight);
                   $.get({
                url: "{{route('reports.getdatechartbydiscount')}}",
                data:{
                    'promoted_offer':this.name,
                    'company_id':"{{$current_company->id}}",
                      'ranges':$('#ranges').val(),
                      },
                success: function(data) {

                    $('#listAdRecord').html(data);

                }
            });

                }
            }
        }
                }
            },
            series: [{
                type: 'wordcloud',
                data,
                name: '{{getCustomTranslation("occurrences")}}'
            }],
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            tooltip: {
                enabled: false,
                headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
            }, exporting: {
                    enabled: exportingUser,
                    buttons: {
                        contextButton: {
                            menuItems: [{
                                text: '{{getCustomTranslation("view_full_screen")}}',
                                onclick: function () {
                                    this.fullscreen && this.fullscreen.toggle()
                                }
                            }, {
                                text: '{{getCustomTranslation("print_chart")}}',
                                onclick: function () {
                                    this.print();
                                }
                            }, {
                                separator: true
                            }, {
                                text: '{{getCustomTranslation("download_png")}}',
                                onclick: function () {
                                    this.exportChart();
                                }
                            }, {
                                text: '{{getCustomTranslation("download_jpeg")}}',
                                onclick: function () {
                                    this.exportChart({
                                        type: 'image/jpeg'
                                    });
                                }
                            }, {
                                text: '{{getCustomTranslation("download_pdf")}}',
                                onclick: function () {
                                    this.exportChart({
                                        type: 'application/pdf'
                                    });
                                }
                            }, {
                                text: '{{getCustomTranslation("download_svg")}}',
                                onclick: function () {
                                    this.exportChart({
                                        type: 'image/svg+xml'
                                    });
                                }
                            }]
                        }
                    }
                },
        });
    }
</script>
