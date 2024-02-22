<figure class="highcharts-figure">
    <div id="container_influencer_gender"></div>
</figure>
<script>
    var influencer_gender = <?php echo json_encode($influencer_gender) ?>;
    // Data retrieved from https://netmarketshare.com
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
        Highcharts.chart('container_influencer_gender', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
            },
            title: {
                text: 'Influencer Gender'
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
                name: 'Gender',
                colorByPoint: true,
                data: [{
                    name: 'Female',
                    y: influencer_gender['female'],
                    sliced: true
                }, {
                    name: 'Male',
                    y: influencer_gender['male'],
                }
                , {
                    name: 'Not a Human',
                    y: influencer_gender['Not a Human'],
                }
                , {
                    name: '',
                    y: influencer_gender[''],
                }
            ]
            }]
        });
    } else {
        Highcharts.chart('container_influencer_gender', {
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
                text: 'Influencer Gender',
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
                name: 'Gender',
                colorByPoint: true,
                data: [{
                    name: 'Female',
                    y: influencer_gender['female'],
                    sliced: true
                }, {
                    name: 'Male',
                    y: influencer_gender['male'],
                }
                , {
                    name: 'Not a Human',
                    y: influencer_gender['Not a Human'],
                }
                , {
                    name: '',
                    y: influencer_gender[''],
                }
            ]
            }]
        });
    }


</script>
