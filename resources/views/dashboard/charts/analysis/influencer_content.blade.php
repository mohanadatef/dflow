<figure class="highcharts-figure">
    <div id="container_content_category_{{$id}}"></div>

</figure>


<script>
    const content_category_{{$id}} = <?php echo json_encode($companiesData[$id]['influencer_content']); ?>;


    Highcharts.chart('container_content_category_{{$id}}', {
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
            text: 'Content Category',
            style: {
                color: '#151521',
                textTransform: 'uppercase',
                fontSize: '20px'
            }
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: content_category_{{$id}}['keys'],
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
            name: 'Categories',
            data: content_category_{{$id}}['values']
        }]
    });

</script>
