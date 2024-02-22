<figure class="highcharts-figure">
    <div id="container_influencer_size"></div>
</figure>

<script>
    var influencer_size = <?php echo json_encode($influencer_size) ?>;
    if (themeMode == 'light') {
        Highcharts.chart('container_influencer_size', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: 'Influencer Size'
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
                data: [{
                    name: 'Micro',
                    y: influencer_size['Micro'],
                    sliced: true
                }, {
                    name: 'Macro',
                    y: influencer_size['Macro'],
                },
                    {
                        name: 'Power',
                        y: influencer_size['Power'],
                    },
                    {
                        name: 'Mega',
                        y: influencer_size['Mega'],
                    },
                    {
                        name: 'Nano',
                        y: influencer_size['Nano'],
                    },
                    {
                        name: '-',
                        y: influencer_size['-'],
                    },
                    {
                        name: 'nane',
                        y: influencer_size['nane'],
                    },
                ]
            }]
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
                text: 'Influencer Size',
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
                data: [{
                    name: 'Micro',
                    y: influencer_size['Micro'],
                    sliced: true
                }, {
                    name: 'Macro',
                    y: influencer_size['Macro'],
                },
                    {
                        name: 'Power',
                        y: influencer_size['Power'],
                    },
                    {
                        name: 'Mega',
                        y: influencer_size['Mega'],
                    },
                    {
                        name: 'Nano',
                        y: influencer_size['Nano'],
                    },
                    {
                        name: '-',
                        y: influencer_size['-'],
                    },
                    {
                        name: 'nane',
                        y: influencer_size['nane'],
                    },

                ]
            }]
        });
    }


</script>
