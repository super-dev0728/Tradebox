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

// =========================================================
// Setting up the chart
// =========================================================

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartDiv");
var interval = 300;

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
    am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
    panX: true,
    panY: false,
    wheelX: "panX",
    wheelY: "zoomX",
    layout: root.verticalLayout
}));

chart.get("colors").set("step", 2);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var valueAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
    renderer: am5xy.AxisRendererY.new(root, {
        inside: true
    }),
    height: am5.percent(70)
}));

valueAxis.get("renderer").labels.template.setAll({
    centerY: am5.percent(100),
    maxPosition: 0.98
});

valueAxis.axisHeader.children.push(am5.Label.new(root, {
    text: "Value",
    fontWeight: "bold",
    paddingBottom: 5,
    paddingTop: 5
}));

var dateAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
    groupData: true,
    maxDeviation: 0.5,
    baseInterval: {
        timeUnit: 'minute',
        count: 5
    },
    renderer: am5xy.AxisRendererX.new(root, {}),
    tooltip: am5.Tooltip.new(root, {})
}));

dateAxis.get("renderer").labels.template.setAll({
    minPosition: 0.01,
    maxPosition: 0.99
});

var color = root.interfaceColors.get("background");

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var valueSeries = chart.series.push(
    am5xy.CandlestickSeries.new(root, {
        fill: color,
        clustered: false,
        calculateAggregates: true,
        stroke: color,
        name: "Trading Market",
        xAxis: dateAxis,
        yAxis: valueAxis,
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

// var valueTooltip = valueSeries.set("tooltip", am5.Tooltip.new(root, {
//     getFillFromSprite: false,
//     getStrokeFromSprite: true,
//     getLabelFillFromSprite: true,
//     autoTextColor: false,
//     pointerOrientation: "horizontal",
//     labelText: "{name}: {valueY} {valueYChangePreviousPercent.formatNumber('[#00ff00]+#,###.##|[#ff0000]#,###.##|[#999999]0')}%"
// }));
// valueTooltip.get("background").set("fill", root.interfaceColors.get("background"));


var firstColor = chart.get("colors").getIndex(0);

// Add legend to axis header
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/axis-headers/
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var valueLegend = valueAxis.axisHeader.children.push(
    am5.Legend.new(root, {
        useDefaultMarker: true
    })
);
valueLegend.data.setAll([valueSeries]);

// Stack axes vertically
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/#Stacked_axes
chart.leftAxesContainer.set("layout", root.verticalLayout);


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
chart.set("cursor", am5xy.XYCursor.new(root, {}))

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

var market = getUrlParameter('market');

// =========================================================
// Data loading
// =========================================================

// actual data loading and handling when it is loaded
function loadData(unit, min, max, side, count, market, interval = 5) {

    // round min so that selected unit would be included
    min = am5.time.round(new Date(min), unit, 1).getTime();

    // Load external data
    $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market + '&interval=' + interval + '&start=' + min + '&end=' + max), function (data) {
        // Handle loaded data
        var start = dateAxis.get("start");
        var end = dateAxis.get("end");

        // will hold first/last dates of each series
        var seriesFirst = {};
        var seriesLast = {};

        // Set data
        if (side == "none") {
            if (data.length > 0) {
                // change base interval if it's different
                if (dateAxis.get("baseInterval").timeUnit != unit) {
                    dateAxis.set("baseInterval", {
                        timeUnit: unit,
                        count: count
                    });
                }

                dateAxis.set("min", min);
                dateAxis.set("max", max);
                dateAxis.setPrivate("min", min); // needed in order not to animate
                dateAxis.setPrivate("max", max); // needed in order not to animate     

                valueSeries.data.setAll(data);

                dateAxis.zoom(0, 1, 0);
            }
        } else if (side == "left") {
            // save dates of first items so that duplicates would not be added
            seriesFirst[valueSeries.uid] = valueSeries.data.getIndex(0).date;

            for (var i = data.length - 1; i >= 0; i--) {
                var date = data[i].date;
                // only add if first items date is bigger then newly added items date
                if (seriesFirst[valueSeries.uid] > date) {
                    valueSeries.data.unshift(data[i]);
                }
            }

            // update axis min
            min = Math.max(min, absoluteMin);
            dateAxis.set("min", min);
            dateAxis.setPrivate("min", min); // needed in order not to animate
            // recalculate start and end so that the selection would remain
            dateAxis.set("start", 0);
            dateAxis.set("end", (end - start) / (1 - start));
        } else if (side == "right") {
            // save dates of last items so that duplicates would not be added
            seriesLast[valueSeries.uid] = valueSeries.data.getIndex(valueSeries.data.length - 1).date;

            for (var i = 0; i < data.length; i++) {
                var date = data[i].date;
                // only add if last items date is smaller then newly added items date
                if (seriesLast[valueSeries.uid] < date) {
                    valueSeries.data.push(data[i]);
                }
            }
            // update axis max
            max = Math.min(max, absoluteMax);
            dateAxis.set("max", max);
            dateAxis.setPrivate("max", max); // needed in order not to animate

            // recalculate start and end so that the selection would remain
            dateAxis.set("start", start / end);
            dateAxis.set("end", 1);
        }
    });
}


function loadSomeData(market) {
    var start = dateAxis.get("start");
    var end = dateAxis.get("end");

    var selectionMin = Math.max(dateAxis.getPrivate("selectionMin"), absoluteMin);
    var selectionMax = Math.min(dateAxis.getPrivate("selectionMax"), absoluteMax);

    var min = dateAxis.getPrivate("min");
    var max = dateAxis.getPrivate("max");

    // if start is less than 0, means we are panning to the right, need to load data to the left (earlier days)
    if (start < 0) {
        loadData(currentUnit, selectionMin, min, "left", currentCount, market, interval);
    }
    // if end is bigger than 1, means we are panning to the left, need to load data to the right (later days)
    if (end > 1) {
        loadData(currentUnit, max, selectionMax, "right", currentCount, market, interval);
    }
}

// Button handlers
$('.control .range').on('click', function () {
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.control .sub-range').removeClass('active');

    interval = $(this).data('range') * 1;
    var unit = $(this).data('unit');
    var count = $(this).data('count') * 1;

    loadData(unit, dateAxis.getPrivate("selectionMin"), dateAxis.getPrivate("selectionMax"), "none", count, market, interval);
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

    loadData(unit, dateAxis.getPrivate("selectionMin"), dateAxis.getPrivate("selectionMax"), "none", count, market, interval);
});

var currentDate = new Date();
var currentUnit = "minute";
var currentCount = 5;

// initially load 50 days
var min = currentDate.getTime() - am5.time.getDuration("day", 10);
var max = currentDate.getTime();

// limit to the data's extremes
var absoluteMax = max;
var absoluteMin = new Date(2000, 0, 1, 0, 0, 0, 0);

// load data when panning ends
chart.events.on("panended", function () {
    loadSomeData(market);
});


var wheelTimeout;
chart.events.on("wheelended", function () {
    // load data with some delay when wheel ends, as this is event is fired a lot
    // if we already set timeout for loading, dispose it
    if (wheelTimeout) {
        wheelTimeout.dispose();
    }

    wheelTimeout = chart.setTimeout(function () {
        loadSomeData(market);
    }, 50);
});

// load some initial data with 5m interval
loadData("minute", min, max, "none", 5, market, 300);

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 500);