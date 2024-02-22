<figure class="highcharts-figure">
    <div id="container_promotion_type"></div>
</figure>


<script>

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
                    text: 'Total number of promotion types'
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
                pointFormat: '/ {point.name} <br> {point.y}</b> of total / {point.xx} %<br/>'
            },
            dataLabels: {
                enabled: true,
            },
            series: [
                {
                    name: "Category",
                    colorByPoint: true,
                    data: chart_data,
                },

            ],
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
                type: 'category',
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
            },
            yAxis: {
                title: {
                    text: 'Total number of promotion types',
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
                pointFormat: '/ {point.name} <br> {point.y}</b> of total / {point.xx} %<br/>'
            },

            series: [
                {
                    name: "Category",
                    colorByPoint: true,
                    data: chart_data
                }
            ],
        });
    }
</script>
