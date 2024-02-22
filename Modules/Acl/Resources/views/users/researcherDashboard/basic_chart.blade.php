<figure class="highcharts-figure">
    <div id="container1"></div>
</figure>

<script>

    function closemodel() {
        $('#kt_modal_showads').modal('toggle');
    }

    datere = " {{ $ads_count_chart['first'] ?? "" . ' - ' . $ads_count_chart['last'] ?? "" }}";
    var ads_count_chart = <?php echo json_encode($ads_count_chart['records']) ?>;

    if (themeMode == 'light') {
        Highcharts.chart('container1', {
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
                    text: '{{getCustomTranslation('number_of_ads')}}'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {
                                // kt_modal_showads
                                $('#kt_modal_showads').modal('toggle');
                                $("#date").text(this.category);
                                $("#count").text(this.y);

                                $.get({
                                    url: "{{route('researcher_dashboard.getResearcherChart')}}",
                                    data: {
                                        'search_day': this.category,
                                        'user_id': {{request('user_id')}}
                                    },
                                    success: function (data) {

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
                name: '{{getCustomTranslation('show_ads')}}',
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
            }
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
                    text: '{{getCustomTranslation('number_of_ads')}}'
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
                    point: {
                        events: {
                            click: function () {
                                // kt_modal_showads
                                $('#kt_modal_showads').modal('toggle');
                                $("#date").text(this.category);
                                $("#count").text(this.y);

                                $.get({
                                    url: "{{route('researcher_dashboard.getResearcherChart')}}",
                                    data: {
                                        'search_day': this.category,
                                        'user_id': "{{request('user_id')}}"
                                    },
                                    success: function (data) {
                                        console.log(ads_count_chart);
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
                name: '{{getCustomTranslation('show_ads')}}',
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
            }
        });
    }

</script>
