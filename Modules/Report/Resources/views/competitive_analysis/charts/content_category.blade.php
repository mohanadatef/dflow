<figure class="highcharts-figure">
    <div id="container_content_category"></div>

</figure>


<script>
    var exportingUser = "{{$userType}}" == 1 ? false : true;
    var content_category = <?php echo json_encode($content_category); ?>;
    if (themeMode == 'light') {
        Highcharts.chart('container_content_category', {
            chart: {
                type: 'bar'
            },
            title: {
                text: '{{getCustomTranslation("influencer_category")}}'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: content_category['keys'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: '{{getCustomTranslation("total_ads")}}',
                data: content_category['values']
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
        Highcharts.chart('container_content_category', {
            chart: {
                type: 'bar',
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
                text: '{{getCustomTranslation("influencer_category")}}',
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: content_category['keys'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high',
                    style: {
                        color: '#E0E0E3',
                        textTransform: 'uppercase',
                        fontSize: '20px'
                    }
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Influencers'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },

            credits: {
                enabled: false
            },
            series: [{
                name: '{{getCustomTranslation("total_ads")}}',
                data: content_category['values']
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
