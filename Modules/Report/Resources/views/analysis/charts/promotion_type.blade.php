<figure class="highcharts-figure">
    <div id="container_promotion_type_{{$id}}"></div>
</figure>


<script>

    var chart_data = <?php echo json_encode($companiesData[$id]['promotion_type_chart']) ?>;
    var exportingUser="{{$userType}}" == 1 ? false : true;

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
                text: '{{getCustomTranslation("total_number_of_promotion_types")}}'
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
                name: "{{getCustomTranslation("browsers")}}",
                colorByPoint: true,
                data: chart_data
            }
        ],
        exporting: {
            enabled: exportingUser
        },
    });

</script>
