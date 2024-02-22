<figure class="highcharts-figure">
    <div id="container_influencer_gender_{{$id}}"></div>
</figure>


<script>

    var influencer_gender = <?php echo json_encode($companiesData[$id]['influencer_gender']) ?>;

    Highcharts.chart('container_influencer_gender_{{$id}}', {
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
            text: 'Influencer Gender',
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
            name: 'Categories',
            colorByPoint: true,
            data: [{
                name: 'Female',
                y: influencer_gender[0].y,
                sliced: true
            }, {
                name: 'Male',
                y: influencer_gender[1].y,
            }]
        }]
    });


</script>
