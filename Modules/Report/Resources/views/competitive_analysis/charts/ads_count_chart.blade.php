
<div class="modal fade" id="kt_modal_showads" tabindex="-1" aria-hidden="true">
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
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" onclick="closemodel()">
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
                                <span >{{getCustomTranslation("date")}}  <span id="date">{{getCustomTranslation('date')}}</span></span>
                            </label>

                            <label class="fs-5 fw-bold form-label mb-2">
                                <span >{{getCustomTranslation("count")}}  <span id="count"></span></span>
                            </label>

                    </div>
                    <div id="listAdRecord" style="width: 100%">

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
<figure class="highcharts-figure">
    <div id="container_ads_count"></div>
</figure>


<script>
function closemodel(){
    $('#kt_modal_showads').modal('toggle');
}
    var ads_count_chart = <?php echo json_encode($ads_count_chart) ?>;
var exportingUser="{{$userType}}" == 1 ? false : true;
    var datere="{{ request('ranges')}}";
    datere=(datere) ? datere :" {{ $range_start->format('m/d/Y') . ' - ' . $range_end->format('m/d/Y') }}";
    if (themeMode == 'light') {
        Highcharts.chart('container_ads_count', {
            chart: {
                type: 'column',
            },
            title: {
                text: datere,
            },
            xAxis: {
                categories: Object.keys(ads_count_chart),
            },
            yAxis: {
                title: {
                    text: '{{getCustomTranslation("number_of_ads")}}'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
         point: {
             events: {
                click: function() {
                   // kt_modal_showads

                   $('#kt_modal_showads').modal('toggle');
                   $("#date").text(this.category);
                   $("#count").text(this.y);

                   $.get({
                url: "{{route('reports.getdatechartbycompany')}}",
                data:{
                    'date':this.category,
                    'company_id':"{{$current_company->id}}",

                      },
                success: function(data) {

                    $('#listAdRecord').html(data);

                }
            });

                  //  alert ('Category: '+ this.category +', value: '+ this.y);
                }
            }
        }
                }
            },
            series: [{
                name: '{{getCustomTranslation("show_ads_details")}}',
                data: Object.values(ads_count_chart)
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom',
                        },
                    }
                }]
            },
            exporting: {
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
        Highcharts.chart('container_ads_count', {
            chart: {
                type: 'column',
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
            title: {
                text: datere,
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
            },
            subtitle: {
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase'
                }
            },
            xAxis: {
                categories: Object.keys(ads_count_chart),
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
            },
            yAxis: {
                title: {
                    text: '{{getCustomTranslation("number_of_ads")}}'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    dataLabels: {
                        color: '#F0F0F3',
                        style: {
                            fontSize: '13px'
                        }
                    },
                    marker: {
                        lineColor: '#333'
                    },
                    cursor: 'pointer',
         point: {
             events: {
                click: function() {
                   // kt_modal_showads
                   alert(this.category);
                   $('#kt_modal_showads').modal('toggle');
                   $("#date").text(this.category);
                   $("#count").text(this.y);

                   $.get({
                url: "{{route('reports.getdatechartbycompany')}}",
                data:{
                    'date':this.category,
                    'company_id':"{{$current_company->id}}",

                      },
                success: function(data) {

                    $('#listAdRecord').html(data);

                }
            });

                  //  alert ('Category: '+ this.category +', value: '+ this.y);
                }
            }
        }
                }

            },
            series: [{
                name: '{{getCustomTranslation("show_ads_details")}}',
                data: Object.values(ads_count_chart),
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 1000
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom',
                        },
                    }
                }]
            },
            exporting: {
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
