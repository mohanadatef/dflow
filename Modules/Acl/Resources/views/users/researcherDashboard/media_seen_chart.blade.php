<figure class="highcharts-figure">
    <div id="media_seen_chart"></div>
</figure>
<script>
    var mediaSeen = <?php echo json_encode($mediaSeen) ?>;

    if (themeMode == 'light') {
        Highcharts.chart('media_seen_chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: '{{getCustomTranslation('influencer_content')}}'
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
                name: '{{getCustomTranslation('influencer_content')}}',
                colorByPoint: true,
                data: [{
                    name: '{{getCustomTranslation('seen')}}',
                    y: mediaSeen['seen'],
                    sliced: true
                }, {
                    name: '{{getCustomTranslation('unseen')}}',
                    y: mediaSeen['unseen'],
                }
            ]
            }]
        });
    } else {
        Highcharts.chart('media_seen_chart', {
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
                text: '{{getCustomTranslation('influencer_content')}}',
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
                name: '{{getCustomTranslation('influencer_content')}}',
                colorByPoint: true,
                data: [{
                    name: '{{getCustomTranslation('seen')}}',
                    y: mediaSeen['seen'],
                    sliced: true
                }, {
                    name: '{{getCustomTranslation('unseen')}}',
                    y: mediaSeen['unseen'],
                }

            ]
            }]
        });
    }


</script>
