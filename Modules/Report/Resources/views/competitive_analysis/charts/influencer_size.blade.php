<figure class="highcharts-figure">
    <div id="container_influencer_size"></div>
</figure>

<script>
    var influencer_size = <?php echo json_encode($influencer_size) ?>;
    var exportingUser="{{$userType}}" == 1 ? false : true;
    if (themeMode == 'light') {
        Highcharts.chart('container_influencer_size', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: '{{getCustomTranslation("influencer_size")}}'
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
                name: '{{getCustomTranslation("size")}}',
                colorByPoint: true,
                data: [{
                    name: '{{getCustomTranslation("micro")}}',
                    y: influencer_size['Micro'],
                    sliced: true
                }, {
                    name: '{{getCustomTranslation("macro")}}',
                    y: influencer_size['Macro'],
                },
                    {
                        name: '{{getCustomTranslation("power")}}',
                        y: influencer_size['Power'],
                    },
                    {
                        name: '{{getCustomTranslation("mega")}}',
                        y: influencer_size['Mega'],
                    },
                    {
                        name: '{{getCustomTranslation("nano")}}',
                        y: influencer_size['Nano'],
                    },
                    {
                        name: '-',
                        y: influencer_size['-'],
                    },
                    {
                        name: '{{getCustomTranslation("nano")}}',
                        y: influencer_size['nane'],
                    },
                ]
            }], exporting: {
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
        Highcharts.chart('container_influencer_size', {
            chart: {

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
                text: '{{getCustomTranslation("influencer_size")}}',
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
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
                name: 'Size',
                colorByPoint: true,
                data:  [{
                    name: '{{getCustomTranslation("micro")}}',
                    y: influencer_size['Micro'],
                    sliced: true
                }, {
                    name: '{{getCustomTranslation("macro")}}',
                    y: influencer_size['Macro'],
                },
                    {
                        name: '{{getCustomTranslation("power")}}',
                        y: influencer_size['Power'],
                    },
                    {
                        name: '{{getCustomTranslation("mega")}}',
                        y: influencer_size['Mega'],
                    },
                    {
                        name: '{{getCustomTranslation("nano")}}',
                        y: influencer_size['Nano'],
                    },
                    {
                        name: '-',
                        y: influencer_size['-'],
                    },
                    {
                        name: '{{getCustomTranslation("nano")}}',
                        y: influencer_size['nane'],
                    },
                ]
            }], exporting: {
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
