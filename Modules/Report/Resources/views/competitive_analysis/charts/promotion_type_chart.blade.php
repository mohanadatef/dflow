<figure class="highcharts-figure">
    <div id="container_promotion_type"></div>
</figure>


<script>
    var exportingUser="{{$userType}}" == 1 ? false : true;
    var chart_data = <?php echo json_encode($promotion_type_chart) ?>;
    if (themeMode == 'light') {
        // Create the chart
        Highcharts.chart('container_promotion_type', {
            chart: {
                type: 'column',
            },
            title: {
                align: 'center',
                text: ''
            },
            subtitle: {
                align: 'center',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: '{{getCustomTranslation('total_number_of_promotion_types')}}'
                },
                stackLabels: {
                    enabled: true
                }
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        format: '{point.xx}</b> %<br/>'
                    }
                }
            },

            tooltip: {

                headerFormat: '{series.name}',
                pointFormat: '/ {point.name} <br> {point.y}</b> {{getCustomTranslation("of_total")}} / {point.xx} %<br/>'
            },
            dataLabels: {
                enabled: true,
            },
            series: [
                {
                    name: "{{getCustomTranslation("category")}}",
                    colorByPoint: true,
                    data: chart_data,
                },

            ], exporting: {
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
        Highcharts.chart('container_promotion_type', {
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
                align: 'center',
                text: ''
            },
            subtitle: {
                align: 'center',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: '{{getCustomTranslation("category")}}',
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
            },
            yAxis: {
                title: {
                    text: '{{getCustomTranslation('total_number_of_promotion_types')}}',
                    style: {
                        text:'ss',
                        color: '#E0E0E3'
                    }
                },
                stackLabels: {
                    borderWidth: 20,
                    enabled: true
                },
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        format: '{point.xx}</b> %<br/>'
                    }
                }
            },

            tooltip: {
                headerFormat: '{series.name}',
                pointFormat: '/ {point.name} <br> {point.y}</b> {{getCustomTranslation("of_total")}}  / {point.xx} %<br/>'
            },

            series: [
                {
                    name: "{{getCustomTranslation('category')}}",
                    colorByPoint: true,
                    data: chart_data
                }
            ], exporting: {
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
