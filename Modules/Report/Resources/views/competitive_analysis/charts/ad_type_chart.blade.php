<figure class="highcharts-figure">
    <div id="container_ad_type"></div>
</figure>


<script>
    var exportingUser="{{$userType}}" == 1 ? false : true;
    var chart_data = <?php echo json_encode($ad_type_chart) ?>;
    if (themeMode == 'light') {
        Highcharts.chart('container_ad_type', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: '{{getCustomTranslation("ad_type")}}',
                colorByPoint: true,
                data: chart_data
            }],
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
        Highcharts.chart('container_ad_type', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
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
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: '{{getCustomTranslation("ad_type")}}',
                colorByPoint: true,
                data: chart_data
            }],
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
