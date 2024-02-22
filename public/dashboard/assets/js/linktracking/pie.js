"use strict";

// Class definition
var KTFlotDemoPie = function () {
    // Private functions
    var examplePie = function () {

        var data = [
            { label: "CSS", data: 10, color: getRandomColor() },
            { label: "HTML5", data: 40, color: getRandomColor() },
            { label: "PHP", data: 30, color: getRandomColor() },
            { label: "Angular", data: 20, color: getRandomColor() }
        ];
        var data_2 = [];
        var len = device_clicks_count.length;
        for (var i = 0; i < len; i++) {
            data_2.push({
                label: device_clicks_count[i].category,
                data: device_clicks_count[i].value,
                color: getRandomColor()
            });
        }
        $.plot($("#kt_docs_flot_pie"), data_2, {
            series: {
                pie: {
                    show: true
                }
            }
        });
    }

    return {
        // Public Functions
        init: function () {
            examplePie();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTFlotDemoPie.init();
});
;