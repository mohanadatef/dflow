"use strict";

// Class definition
let clicks_count_chart = function () {
    // Private methods
    let cat_array = [];
    let count_array = [];
    let colors = [];

    let percent_array =[];
    let maleTotal = 0;
    for(let i = 0; i < countries_clicks.length; i++) {
        let row = countries_clicks[i];
        maleTotal += row.value;
    }

    countries_clicks.forEach(myFunction);
    function myFunction(item) {
        if (item.category){
            cat_array.push(item.category);

        }else {
            cat_array.push("Other");
        }
        item.malePercent = 1 * Math.round((item.value / maleTotal) * 10000) / 100;
        count_array.push(item.value);
        percent_array.push(item.malePercent);
        colors.push(getRandomColor());
    }
    let initChart = function() {
        let element = document.getElementById("clicks_count_chart");
        if (!element) {
            return;
        }
        let borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');

        let options = {
            series: [{
                name:"Percent",
                data: percent_array,
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
                },
            plotOptions: {
                bar: {
                    borderRadius: 3,
                    horizontal: true,
                    distributed: true,
                    barHeight: 23
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: colors,
            xaxis: {
                categories: cat_array,
                labels: {
                    // formatter: function (val,opts) {
                    //   //  return val + "%";
                    //     const sum = opts.series[0].reduce((a, b) => a + b, 0);
                    //     const percent = (value / sum) * 100;
                    //     return percent.toFixed(0) + '%'
                    // },
                    style: {
                        colors: KTUtil.getCssVariableValue('--bs-gray-400'),
                        fontSize: '14px',
                        fontWeight: '600',
                        align: 'right'
                    }
                },
                //   axisBorder: {
                //     show: false
                // }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: KTUtil.getCssVariableValue('--bs-gray-800'),
                        fontSize: '14px',
                        fontWeight: '600'
                    },
                    offsetY: 2,
                    align: 'left'
                }
            },
            grid: {
                borderColor: borderColor,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                strokeDashArray: countries_clicks.length
            }
        };
        let chart = new ApexCharts(element, options);
        setTimeout(function() {
            chart.render();
        }, 200);
    }

    // Public methods
    return {
        init: function () {
            initChart();
        }
    }
}();

let clicks_count_chart_2 = function () {
    // Private methods
    let cat_array = [];
    let count_array = [];
    let colors = [];

    let percent_array =[];
    let maleTotal = 0;
    for(let i = 0; i < platform_clicks_count.length; i++) {
        let row = platform_clicks_count[i];
        maleTotal += row.value;
    }

    platform_clicks_count.forEach(myFunction);
    function myFunction(item) {
        if (item.category){
            cat_array.push(item.category);

        }else {
            cat_array.push("Other");
        }
        item.malePercent = 1 * Math.round((item.value / maleTotal) * 10000) / 100;
        count_array.push(item.value);
        percent_array.push(item.malePercent);
        colors.push(getRandomColor());
    }
    let initChart = function() {
        let element = document.getElementById("kt_amcharts_1");
        if (!element) {
            return;
        }
        let borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');

        let options = {
            series: [{
                name:"Percent",
                data: percent_array,
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 3,
                    vertical: true,
                    distributed: true,
                    barHeight: 23
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: colors,
            xaxis: {
                categories: cat_array,
                labels: {
                    formatter: function (val,opts) {
                        return val;
                        // const sum = opts.series[0].reduce((a, b) => a + b, 0);
                        // const percent = (value / sum) * 100;
                        // return percent.toFixed(0) + '%'
                    },
                    style: {
                        colors: KTUtil.getCssVariableValue('--bs-gray-400'),
                        fontSize: '14px',
                        fontWeight: '600',
                        align: 'right'
                    }
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val,opts) {
                        return val +"%";
                        // const sum = opts.series[0].reduce((a, b) => a + b, 0);
                        // const percent = (value / sum) * 100;
                        // return percent.toFixed(0) + '%'
                    },
                    style: {
                        colors: KTUtil.getCssVariableValue('--bs-gray-800'),
                        fontSize: '14px',
                        fontWeight: '600'
                    },
                    offsetY: 2,
                    align: 'left'
                }
            },
            grid: {
                borderColor: borderColor,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                strokeDashArray: platform_clicks_count.length
            }
        };
        let chart = new ApexCharts(element, options);
        setTimeout(function() {
            chart.render();
        }, 200);
    }

    // Public methods
    return {
        init: function () {
            initChart();
        }
    }
}();

function getRandomColor() {
    let letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// On document ready
KTUtil.onDOMContentLoaded(function() {
    clicks_count_chart.init();
    clicks_count_chart_2.init();
});
;
