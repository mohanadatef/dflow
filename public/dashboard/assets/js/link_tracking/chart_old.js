"use strict";

// Class definition
let clicks_count_chart = function () {
    // Private methods
    let cat_array = [];

    countries_clicks.forEach(myFunction);
    function myFunction(item) {
        cat_array.push(item.country);
    }

    let initChart = function() {
        let element = document.getElementById("clicks_count_chart");

        if (!element) {
            return;
        }

        var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');

        var options = {
            series: [{
                name:"Count",
                data: [15, 12],
                show: false
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
                    borderRadius: 4,
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
            colors: ['#3E97FF', '#F1416C'],
            xaxis: {
                categories: ["dcsdcs", 'Laptops'],
                labels: {
                    formatter: function (val) {
                        return val + "";
                    },
                    style: {
                        colors: KTUtil.getCssVariableValue('--bs-gray-400'),
                        fontSize: '14px',
                        fontWeight: '600',
                        align: 'left'
                    }
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                // labels: {
                //     style: {
                //         colors: KTUtil.getCssVariableValue('--bs-gray-800'),
                //         fontSize: '14px',
                //         fontWeight: '600'
                //     },
                //     offsetY: 2,
                //     align: 'left'
                // }
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
                strokeDashArray: 4
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



// On document ready
KTUtil.onDOMContentLoaded(function() {
    clicks_count_chart.init();
});


;