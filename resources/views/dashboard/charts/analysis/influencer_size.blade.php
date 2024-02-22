<figure class="highcharts-figure">
    <div id="container_influencer_size_{{$id}}"></div>
</figure>

<script>

    var influencer_size = <?php echo json_encode($companiesData[$id]['influencer_size']) ?>;


    Highcharts.chart('container_influencer_size_{{$id}}', {
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
                    [0, '#dddd'],
                    [1, '#dddd']
                ]
            },
            style: {
                fontFamily: '\'Unica One\', sans-serif'
            },
            plotBorderColor: '#151521'
        },
        title: {
            text: 'Influencer Size',
            style: {
                color: '#151521',
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
                }]
        }]
    });


</script>
