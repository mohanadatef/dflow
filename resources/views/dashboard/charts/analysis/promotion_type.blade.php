<figure class="highcharts-figure">
    <div id="container_promotion_type_{{$id}}"></div>
</figure>


<script>

    var chart_data = <?php echo json_encode($companiesData[$id]['promotion_type_chart']) ?>;


    // Create the chart
    Highcharts.chart('container_promotion_type_{{$id}}', {
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
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: "Browsers",
                colorByPoint: true,
                data: chart_data
            }
        ],
    });

</script>
