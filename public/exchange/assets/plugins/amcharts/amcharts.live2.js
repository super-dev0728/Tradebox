/**
 * ---------------------------------------
 * This demo was created using amCharts 5.
 * 
 * For more information visit:
 * https://www.amcharts.com/
 * 
 * Documentation is available at:
 * https://www.amcharts.com/docs/v5/
 * ---------------------------------------
 */
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
var interval = 300;

// Create root element
var root = am5.Root.new("chartDiv");

// Set themes
root.setThemes([am5themes_Animated.new(root)]);

// Create chart
var chart = root.container.children.push(
    am5xy.XYChart.new(root, {
        focusable: true,
        panX: true,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX"
    })
);

// Create axes
var xAxis = chart.xAxes.push(
    am5xy.DateAxis.new(root, {
        groupData: true,
        maxDeviation: 0.5,
        baseInterval: {
            timeUnit: unit,
            count: count
        },
        renderer: am5xy.AxisRendererX.new(root, {
            pan: "zoom"
        }),
        tooltip: am5.Tooltip.new(root, {})
    })
);

var yAxis = chart.yAxes.push(
    am5xy.ValueAxis.new(root, {
        maxDeviation: 1,
        renderer: am5xy.AxisRendererY.new(root, {
            pan: "zoom"
        })
    })
);

var color = root.interfaceColors.get("background");

// Add series
var series = chart.series.push(
    am5xy.CandlestickSeries.new(root, {
        fill: color,
        calculateAggregates: true,
        stroke: color,
        name: market,
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
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

// Add cursor
var cursor = chart.set(
    "cursor",
    am5xy.XYCursor.new(root, {
        xAxis: xAxis
    })
);
cursor.lineY.set("visible", false);

// Stack axes vertically
chart.leftAxesContainer.set("layout", root.verticalLayout);

// Add legend
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



// actual data loading and handling when it is loaded
function loadData(unit, count, market, interval) {
    // Load external data
    $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market + '&interval=' + interval), function (data) {
        // Set data
        if (data.length > 0) {
            // change base interval if it's different
            if (xAxis.get("baseInterval").timeUnit != unit) {
                xAxis.set("baseInterval", {
                    timeUnit: unit,
                    count: count
                });
            }

            series.data.setAll(data);

            // xAxis.zoom(0, 1, 0);
        }
    });
}

// Button handlers
$('.control .range').on('click', function () {
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.control .sub-range').removeClass('active');

    interval = $(this).data('range') * 1;
    var unit = $(this).data('unit');
    var count = $(this).data('count') * 1;

    loadData(unit, count, market, interval);
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

    loadData(unit, count, market, interval);
});

// var wheelTimeout;
// chart.events.on("wheelended", function () {
//     // load data with some delay when wheel ends, as this is event is fired a lot
//     // if we already set timeout for loading, dispose it
//     if (wheelTimeout) {
//         wheelTimeout.dispose();
//     }

//     wheelTimeout = chart.setTimeout(function () {
//         loadData(unit, count, market, interval);
//     }, 50);
// });

loadData(unit, count, market, interval);

// // Make stuff animate on load
series.appear(1000);
chart.appear(1000, 100);