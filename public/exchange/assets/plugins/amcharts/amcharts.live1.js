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

var unit = "day";
var count = 1;
var interval = 1440;

function loadData(market, interval, count, unit, min, max, side) {
    // round min so that selected unit would be included
    min = am5.time.round(new Date(min), unit, 1).getTime();

    $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market + '&interval=' + interval + '&start=' + min + '&end=' + max), function (data) {
        // Handle loaded data
        var start = xAxis.get("start");
        var end = xAxis.get("end");

        // will hold first/last dates of each series
        var seriesFirst = {};
        var seriesLast = {};

        // Set data
        if (side == "none") {
            if (data.length > 0) {
                // change base interval if it's different
                if (xAxis.get("baseInterval").timeUnit != unit) {
                    xAxis.set("baseInterval", {
                        timeUnit: unit,
                        count: count
                    });
                }

                xAxis.set("min", min);
                xAxis.set("max", max);
                xAxis.setPrivate("min", min); // needed in order not to animate
                xAxis.setPrivate("max", max); // needed in order not to animate     

                series.data.setAll(data);

                xAxis.zoom(0, 1, 0);
            }
        } else if (side == "left") {
            // save dates of first items so that duplicates would not be added
            seriesFirst[series.uid] = series.data.getIndex(0).date;

            for (var i = data.length - 1; i >= 0; i--) {
                var date = data[i].date;
                // only add if first items date is bigger then newly added items date
                if (seriesFirst[series.uid] > date) {
                    series.data.unshift(data[i]);
                }
            }

            // update axis min
            min = Math.max(min, absoluteMin);
            xAxis.set("min", min);
            xAxis.setPrivate("min", min); // needed in order not to animate
            // recalculate start and end so that the selection would remain
            xAxis.set("start", 0);
            xAxis.set("end", (end - start) / (1 - start));
        } else if (side == "right") {
            // save dates of last items so that duplicates would not be added
            seriesLast[series.uid] = series.data.getIndex(series.data.length - 1).date;

            for (var i = 0; i < data.length; i++) {
                var date = data[i].date;
                // only add if last items date is smaller then newly added items date
                if (seriesLast[series.uid] < date) {
                    series.data.push(data[i]);
                }
            }
            // update axis max
            max = Math.min(max, absoluteMax);
            xAxis.set("max", max);
            xAxis.setPrivate("max", max); // needed in order not to animate

            // recalculate start and end so that the selection would remain
            xAxis.set("start", start / end);
            xAxis.set("end", 1);
        }
    });
}

function loadSomeData(market) {
    var start = xAxis.get("start");
    var end = xAxis.get("end");

    var selectionMin = Math.max(xAxis.getPrivate("selectionMin"), absoluteMin);
    var selectionMax = Math.min(xAxis.getPrivate("selectionMax"), absoluteMax);

    var min = xAxis.getPrivate("min");
    var max = xAxis.getPrivate("max");

    // if start is less than 0, means we are panning to the right, need to load data to the left (earlier days)
    if (start < 0) {
        loadData(market, interval, count, unit, selectionMin, min, "left");
    }
    // if end is bigger than 1, means we are panning to the left, need to load data to the right (later days)
    if (end > 1) {
        loadData(market, interval, count, unit, max, selectionMax, "right");
    }
}

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
    am5xy.XYChart.new(root, {
        panX: true,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: root.verticalLayout,
        cursor: am5xy.XYCursor.new(root, {})
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

// xAxis.get("renderer").labels.template.setAll({
//     minPosition: 0.01,
//     maxPosition: 0.99
// });

var yAxis = chart.yAxes.push(
    am5xy.ValueAxis.new(root, {
        numberFormat: "#,###.00000000",
        renderer: am5xy.AxisRendererY.new(root, {
            inside: true
        }),
        inversed: true,
        x: am5.percent(100),
        centerX: am5.percent(100),
        tooltip: am5.Tooltip.new(root, {})
        // height: am5.percent(70)
    })
);

yAxis.get("renderer").labels.template.setAll({
    centerY: am5.percent(100),
    // maxPosition: 0.98
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
            labelText: "open: {openValueY.formatNumber('#,###.00000000')}\nlow: {lowValueY.formatNumber('#,###.00000000')}\nhigh: {highValueY.formatNumber('#,###.00000000')}\nclose: {valueY.formatNumber('#,###.00000000')}"
        })
    })
);

var firstColor = chart.get("colors").getIndex(0);

// Stack axes vertically
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/#Stacked_axes
chart.leftAxesContainer.set("layout", root.verticalLayout);

var currentDate = new Date();

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

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
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

loadData(market, interval, count, unit, min, max, "none");

// Update data every second
// setInterval(function () {
//     reloadData();
// }, 1000)

function reloadData() {
    var xmin = xAxis.get("start");
    var xmax = xAxis.get("end");

    loadData(market, interval, count, unit, xmin, xmax, "none");
}

/*
// Generate random data
var value = 100;
var easing = am5.ease.linear;

function addData() {
    // save selection min and max (these are timestamps)
    var selectionMin = xAxis.getPrivate("selectionMin");
    var selectionMax = xAxis.getPrivate("selectionMax");
    var max = xAxis.getPrivate("max");

    var lastDataItem = series.dataItems[series.dataItems.length - 1];

    var lastValue = lastDataItem.get("valueY");
    var newValue = value + ((Math.random() < 0.5 ? 1 : -1) * Math.random() * 5);
    var lastDate = new Date(lastDataItem.get("valueX"));
    var time = am5.time.add(new Date(lastDate), "second", 1).getTime();
    series.data.removeIndex(0);
    series.data.push({
        date: time,
        value: newValue
    })

    var newDataItem = series.dataItems[series.dataItems.length - 1];
    newDataItem.animate({
        key: "valueYWorking",
        to: newValue,
        from: lastValue,
        duration: 600,
        easing: easing
    });

    // use the bullet of last data item so that a new sprite is not created
    newDataItem.bullets = [];
    newDataItem.bullets[0] = lastDataItem.bullets[0];
    newDataItem.bullets[0].get("sprite").dataItem = newDataItem;
    // reset bullets
    lastDataItem.dataContext.bullet = false;
    lastDataItem.bullets = [];


    var animation = newDataItem.animate({
        key: "locationX",
        to: 0.5,
        from: -0.5,
        duration: 600
    });
    if (animation) {
        var tooltip = xAxis.get("tooltip");
        if (tooltip && !tooltip.isHidden()) {
            animation.events.on("stopped", function () {
                xAxis.updateTooltip();
            })
        }
    }

    // set the same selection min and max
    series.events.once("datavalidated", function () {
        if (max - selectionMax > xAxis.baseDuration()) {
            xAxis.zoomToValues(selectionMin, selectionMax);
        }
    })
}*/

// series.appear(1000);
chart.appear(1000, 100);

// Button handlers
$('.control .range').on('click', function () {
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.control .sub-range').removeClass('active');

    interval = $(this).data('range') * 1;
    unit = $(this).data('unit');
    count = $(this).data('count') * 1;

    loadData(market, interval, count, unit, xAxis.getPrivate("selectionMin"), xAxis.getPrivate("selectionMax"), "none");
});

$('.control .sub-range').on('click', function () {
    $('.control .sub-range').removeClass('active');
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.range.dropdown').addClass('active');

    $('.control .dropdown').html($(this).text() + ' <i class="fa fa-sort-down"></i>');

    interval = $(this).data('range') * 1;
    unit = $(this).data('unit')
    count = $(this).data('count') * 1;

    loadData(market, interval, count, unit, xAxis.getPrivate("selectionMin"), xAxis.getPrivate("selectionMax"), "none");
});

// Update data every second
// setInterval(function () {
//     $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market + '&interval=' + interval + '&start=' + min), function (data) {
//         series.data.setIndex(series.data.length, {
//             value: data[data.length - 1]
//         });
//     });
// }, 1000);
// setInterval(function () {
//     chart.dataProvider = reloadData();
//     chart.validateData();
// }, 1000);

// function addData() {
//     // save selection min and max (these are timestamps)
//     var selectionMin = xAxis.getPrivate("selectionMin");
//     var selectionMax = xAxis.getPrivate("selectionMax");
//     var max = xAxis.getPrivate("max");

//     var lastDataItem = series.dataItems[series.dataItems.length - 1];

//     var lastValue = lastDataItem.get("valueY");

//     var newValue = lastValue + ((Math.random() < 0.5 ? 1 : -1) * Math.random() * 5);
//     var lastDate = new Date(lastDataItem.get("valueX"));
//     var time = am5.time.add(new Date(lastDate), "second", 1).getTime();
//     series.data.removeIndex(0);
//     series.data.push({
//         date: time,
//         value: newValue
//     })

//     var newDataItem = series.dataItems[series.dataItems.length - 1];
//     newDataItem.animate({
//         key: "valueYWorking",
//         to: newValue,
//         from: lastValue,
//         duration: 600
//     });

//     // use the bullet of last data item so that a new sprite is not created
//     newDataItem.bullets = [];
//     newDataItem.bullets[0] = lastDataItem.bullets[0];
//     newDataItem.bullets[0].get("sprite").dataItem = newDataItem;
//     // reset bullets
//     lastDataItem.dataContext.bullet = false;
//     lastDataItem.bullets = [];


//     var animation = newDataItem.animate({
//         key: "locationX",
//         to: 0.5,
//         from: -0.5,
//         duration: 600
//     });
//     if (animation) {
//         var tooltip = xAxis.get("tooltip");
//         if (tooltip && !tooltip.isHidden()) {
//             animation.events.on("stopped", function () {
//                 xAxis.updateTooltip();
//             })
//         }
//     }

//     // set the same selection min and max
//     series.events.once("datavalidated", function () {
//         if (max - selectionMax > xAxis.baseDuration()) {
//             xAxis.zoomToValues(selectionMin, selectionMax);
//         }
//     })
// }