<figure class="highcharts-figure">
    <div id="container_ad_type_{{$id}}"></div>
</figure>


<script>

    var chart_data = <?php echo json_encode($companiesData[$id]['ad_type']) ?>;
    var exportingUser="{{$userType}}" == 1 ? false : true;

    Highcharts.chart('container_ad_type_{{$id}}', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
        },
        title: {
            text: ''
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
            name: '{{getCustomTranslation("categories")}}',
            colorByPoint: true,
            data: chart_data
        }],
        exporting: {
            enabled: exportingUser
        },
    });

</script>
