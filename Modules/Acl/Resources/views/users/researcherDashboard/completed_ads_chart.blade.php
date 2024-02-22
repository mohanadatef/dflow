<figure class="highcharts-figure">
    <div id="completed_ads_chart"></div>
</figure>
<script>
    var completed = <?php echo json_encode($completed) ?>;

    if (themeMode == 'light') {
        Highcharts.chart('completed_ads_chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: '{{getCustomTranslation('ads_recording')}}'
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
                name: '{{getCustomTranslation('ads')}}',
                colorByPoint: true,
                data: [{
                    name: '{{getCustomTranslation('complete')}}',
                    y: completed['completed_ads'],
                    sliced: true
                }, {
                    name: '{{getCustomTranslation('incomplete')}}',
                    y: completed['incompleted_ads'],
                }
            ]
            }]
        });
    } else {
        Highcharts.chart('completed_ads_chart', {
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
                text: '{{getCustomTranslation('ads_recording')}}',
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
                name: '{{getCustomTranslation('ads')}}',
                colorByPoint: true,
                data: [{
                    name: '{{getCustomTranslation('complete')}}',
                    y: completed['completed_ads'],
                    sliced: true
                }, {
                    name: '{{getCustomTranslation('incomplete')}}',
                    y: completed['incompleted_ads'],
                }

            ]
            }]
        });
    }


</script>
