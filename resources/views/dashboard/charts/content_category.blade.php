<figure class="highcharts-figure">
    <div id="container_content_category"></div>

</figure>


<script>

    var content_category = <?php echo json_encode($content_category); ?>
    // let themeModeLogo;
    // const defaultThemeMode = "system";
    // const name = document.body.getAttribute("data-kt-name");
    // let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");

    // if (themeMode === null) {
    //     if (defaultThemeMode === "system") {
    //         themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    //     } else {
    //         themeMode = defaultThemeMode;
    //     }
    //     themeModeLogo=themeMode;
    // }
    if (themeMode == 'light') {
        Highcharts.chart('container_content_category', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Influencer Category'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: content_category['keys'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
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
                name: 'Total Ads',
                data: content_category['values']
            }]
        });
    } else {
        Highcharts.chart('container_content_category', {
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
                text: 'Influencer Category',
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: content_category['keys'],
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
                name: 'Total Ads',
                data: content_category['values']
            }]
        });
    }

</script>
