
<figure class="highcharts-figure">
    <div id="container_promoted_products_{{$id}}"></div>
</figure>

<script>
    // promoted products
    data = @json($promoted_products_cloud);
    defaultThemeMode = "system";
    name = document.body.getAttribute("data-kt-name");
    themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
    if (themeMode === null) {
        if (defaultThemeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        } else {
            themeMode = defaultThemeMode;
        }
        themeModeLogo = themeMode;
    }
    var exportingUser="{{$userType}}" == 1 ? false : true;

    Highcharts.chart('container_promoted_products_{{$id}}', {
        accessibility: {
            screenReaderSection: {
                beforeChartFormat: '<h5>{chartTitle}</h5>' +
                    '<div>{chartSubtitle}</div>' +
                    '<div>{chartLongdesc}</div>' +
                    '<div>{viewTableButton}</div>'
            }
        },
        series: [{
            type: 'wordcloud',
            data,
            name: '{{getCustomTranslation("occurrences")}}'
        }],
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        tooltip: {
            headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
        },
        exporting: {
            enabled: exportingUser
        },
    });



</script>
