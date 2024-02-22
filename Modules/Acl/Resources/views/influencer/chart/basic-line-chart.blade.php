<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/highcharts.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/exporting.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/accessibility.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/highcharts/modules/export-data.js"></script>
<figure class="highcharts-figure">
    <div id="container1"></div>
</figure>
<script>
    let themeModeLogo;
    const defaultThemeMode = "system";
    const name = document.body.getAttribute("data-kt-name");
    let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
    var exportingUser="{{$userType}}" == 1 ? false : true;
    if (themeMode === null) {
        if (defaultThemeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        } else {
            themeMode = defaultThemeMode;
        }
        themeModeLogo = themeMode;
    }
    if (themeMode == 'light') {
        Highcharts.chart('container1', {
            chart: {
                type: 'column',
            },
            title: {
                text: '{{getCustomTranslation('ad_peak_days')}}',
            },
            xAxis: {
                accessibility: {
                    rangeDescription: 'days'
                },
                categories: [@foreach($date['date'] as $v)
                    "{{$v}}",@endforeach]
            },
            yAxis: {
                title: {
                    text: '{{getCustomTranslation('the_number_of_ads')}}'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'Ads',
                data: [@foreach($date['count'] as $v)
                    {{$v}},@endforeach]
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
        Highcharts.chart('container1', {
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
                text: '{{getCustomTranslation('ad_peak_days')}}',
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
                accessibility: {
                    rangeDescription: 'days'
                },
                categories: [@foreach($date['date'] as $v)
                    "{{$v}}",@endforeach],
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
            },
            yAxis: {
                title: {
                    text: '{{getCustomTranslation('the_number_of_ads')}}'
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
                    }
                }
            },
            series: [{
                name: 'Ads',
                data: [@foreach($date['count'] as $v)
                    {{$v}},@endforeach]
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
