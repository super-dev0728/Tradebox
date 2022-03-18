// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartDiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([am5themes_Animated.new(root)]);

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split("=");

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

// initial declaration
var market = getUrlParameter('market');

var unit = "minute";
var count = 5;
var interval = 5;

function loadData(market, interval, count, unit) {
    $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market + '&interval=' + interval), function (data) {
        // Handle loaded data
        // var start = xAxis.get("start");
        // var end = xAxis.get("end");

        // will hold first/last dates of each series
        // var seriesFirst = {};
        // var seriesLast = {};
        // var currentDate = new Date();
        // var min = currentDate.getTime() - am5.time.getDuration("day", 50);
        // var max = currentDate.getTime();

        // Set data
        if (data.length > 0) {
            // change base interval if it's different
            if (xAxis.get("baseInterval").timeUnit != unit) {
                xAxis.set("baseInterval", {
                    timeUnit: unit,
                    count: count
                });
            }

            // xAxis.set("min", min);
            // xAxis.set("max", max);
            // xAxis.setPrivate("min", min); // needed in order not to animate
            // xAxis.setPrivate("max", max); // needed in order not to animate     

            series.data.setAll(data);

            xAxis.zoom(0, 1, 0);
        }
    });
}

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
    am5xy.XYChart.new(root, {
        panX: true,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: root.verticalLayout
    })
);

chart.get("colors").set("step", 2);

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(
    am5xy.DateAxis.new(root, {
        groupData: true,
        maxDeviation: 0.5,
        baseInterval: {
            timeUnit: unit,
            count: count
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
    })
);

xAxis.get("renderer").labels.template.setAll({
    minPosition: 0.01,
    maxPosition: 0.99
});

var yAxis = chart.yAxes.push(
    am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {
            inside: true
        }),
        height: am5.percent(70)
    })
);

yAxis.get("renderer").labels.template.setAll({
    centerY: am5.percent(100),
    maxPosition: 0.98
});

// yAxis.axisHeader.children.push(am5.Label.new(root, {
//     text: "Value",
//     fontWeight: "bold",
//     paddingBottom: 5,
//     paddingTop: 5
// }));

var color = root.interfaceColors.get("background");

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(
    am5xy.CandlestickSeries.new(root, {
        fill: color,
        calculateAggregates: true,
        stroke: color,
        name: market,
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "close",
        openValueYField: "open",
        lowValueYField: "low",
        highValueYField: "high",
        valueXField: "date",
        lowValueYGrouped: "low",
        highValueYGrouped: "high",
        openValueYGrouped: "open",
        valueYGrouped: "close",
        legendValueText: "open: {openValueY} low: {lowValueY} high: {highValueY} close: {valueY}",
        legendRangeValueText: "{valueYClose}",
        tooltip: am5.Tooltip.new(root, {
            pointerOrientation: "horizontal",
            labelText: "open: {openValueY}\nlow: {lowValueY}\nhigh: {highValueY}\nclose: {valueY}"
        })
    })
);

var firstColor = chart.get("colors").getIndex(0);
// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set(
    "cursor",
    am5xy.XYCursor.new(root, {
        xAxis: xAxis
    })
);
cursor.lineY.set("visible", false);

// Stack axes vertically
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/#Stacked_axes
chart.leftAxesContainer.set("layout", root.verticalLayout);

// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
// var scrollbar = am5xy.XYChartScrollbar.new(root, {
//     orientation: "horizontal",
//     height: 50
// });
// chart.set("scrollbarX", scrollbar);

// var sbxAxis = scrollbar.chart.xAxes.push(
//     am5xy.DateAxis.new(root, {
//         groupData: true,
//         groupIntervals: [{
//             timeUnit: "week",
//             count: 1
//         }],
//         baseInterval: {
//             timeUnit: "day",
//             count: 1
//         },
//         renderer: am5xy.AxisRendererX.new(root, {
//             opposite: false,
//             strokeOpacity: 0
//         })
//     })
// );

// var sbyAxis = scrollbar.chart.yAxes.push(
//     am5xy.ValueAxis.new(root, {
//         renderer: am5xy.AxisRendererY.new(root, {})
//     })
// );

// var sbseries = scrollbar.chart.series.push(
//     am5xy.LineSeries.new(root, {
//         xAxis: sbxAxis,
//         yAxis: sbyAxis,
//         valueYField: "value",
//         valueXField: "date"
//     })
// );

// // Add legend
// // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
// var legend = yAxis.axisHeader.children.push(am5.Legend.new(root, {}));

// legend.data.push(series);

// legend.markers.template.setAll({
//     width: 10
// });

// legend.markerRectangles.template.setAll({
//     cornerRadiusTR: 0,
//     cornerRadiusBR: 0,
//     cornerRadiusTL: 0,
//     cornerRadiusBL: 0
// });

// set data
// series.data.setAll(data);
// sbseries.data.setAll(data);

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/

loadData(market, interval, count, unit);

// series.appear(1000);
chart.appear(1000, 100);

// Button handlers
$('.control .range').on('click', function () {
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.control .sub-range').removeClass('active');

    interval = $(this).data('range') * 1;
    var unit = $(this).data('unit');
    var count = $(this).data('count') * 1;

    loadData(market, interval, count, unit);
});

$('.control .sub-range').on('click', function () {
    $('.control .sub-range').removeClass('active');
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.dropdown').addClass('active');

    $('.control .dropdown').html($(this).text() + ' <i class="fa fa-sort-down"></i>');

    interval = $(this).data('range') * 1;
    var unit = $(this).data('unit')
    var count = $(this).data('count') * 1;

    loadData(market, interval, count, unit);
});