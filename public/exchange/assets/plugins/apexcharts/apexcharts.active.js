pingpoliCandlestickChart.prototype.addTechnicalIndicator = function (indicator) {
    indicator.onInit(this);
    this.technicalIndicators.push(indicator);
}



function MovingAverage(samples, color, lineWidth) {
    this.samples = samples;
    this.color = color;
    this.lineWidth = lineWidth;
    this.data = [];
}



// gets triggered whenever the technical indicator is added to the chart class
MovingAverage.prototype.onInit = function (candlestickChart) {
    for (var i = 0; i < candlestickChart.candlesticks.length; ++i) {
        // average the number of samples
        var avg = 0;
        var counter = 0;
        for (var j = i; j > i - this.samples && j >= 0; --j) {
            avg += candlestickChart.candlesticks[j].close;
            ++counter;
        }
        avg /= counter;
        this.data.push(avg);
    }
}



// gets triggered whenever a new candlestick is added
MovingAverage.prototype.onAddCandlestick = function (candlestickChart, candlestickID) {
    // average the number of samples
    var avg = 0;
    var counter = 0;
    for (var i = candlestickID; i > candlestickID - this.samples && i >= 0; --i) {
        avg += candlestickChart.candlesticks[i].close;
        ++counter;
    }
    avg /= counter;
    this.data.push(avg);
}



// gets triggered whenever a candlestick is updated
MovingAverage.prototype.onUpdateCandlestick = function (candlestickChart, candlestickID) {
    // average the number of samples
    var avg = 0;
    var counter = 0;
    for (var i = candlestickID; i > candlestickID - this.samples && i >= 0; --i) {
        avg += candlestickChart.candlesticks[i].close;
        ++counter;
    }
    avg /= counter;
    this.data[candlestickID] = avg;
}



// gets triggered whenever the chart is redrawn
MovingAverage.prototype.draw = function (candlestickChart) {
    var oldLineWidth = candlestickChart.context.lineWidth;
    candlestickChart.context.lineWidth = this.lineWidth;
    for (var i = candlestickChart.zoomStartID; i < this.data.length - 1; ++i) {
        candlestickChart.drawLine(candlestickChart.xToPixelCoords(candlestickChart.candlesticks[i].timestamp), candlestickChart.yToPixelCoords(this.data[i]), candlestickChart.xToPixelCoords(candlestickChart.candlesticks[i + 1].timestamp), candlestickChart.yToPixelCoords(this.data[i + 1]), this.color);
    }
    candlestickChart.context.lineWidth = oldLineWidth;
}

var _candlestickStream;

function CandlestickStream(symbol, interval) {
    this.symbol = symbol;
    this.interval = interval;
    this.candlestickChart = new pingpoliCandlestickChart("canvas");
    this.webSocketConnected = false;
    this.webSocketHost = "wss://stream.binance.com:9443/ws/" + this.symbol + "@kline_" + this.interval;
    _candlestickStream = this;
}

CandlestickStream.prototype.start = function () {
    // get a few recent candlesticks before starting the stream
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "https://api.binance.com/api/v3/klines?symbol=" + this.symbol.toUpperCase() + "&interval=" + this.interval + "&limit=500");
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var json = JSON.parse(xmlhttp.responseText);

            for (var i = 0; i < json.length; ++i) {
                _candlestickStream.candlestickChart.addCandlestick(new pingpoliCandlestick(json[i][0], json[i][1], json[i][4], json[i][2], json[i][3]));
            }
            _candlestickStream.candlestickChart.addTechnicalIndicator(new MovingAverage(5, "#ffff00", 2));
            _candlestickStream.candlestickChart.draw();

            // start the websocket stream
            if (!_candlestickStream.webSocketConnected) {
                _candlestickStream.webSocket = new pingpoliWebSocket(_candlestickStream.webSocketHost, _candlestickStream.onOpen, _candlestickStream.onMessage, _candlestickStream.onClose);
                _candlestickStream.webSocket.setOnErrorCallback(_candlestickStream.onWebSocketError);
            }
        }
    }
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
}

CandlestickStream.prototype.close = function () {
    this.webSocket.close();
}

CandlestickStream.prototype.onOpen = function () {
    this.webSocketConnected = true;
    console.log("websocket connected");
}

CandlestickStream.prototype.onMessage = function (msg) {
    var json = JSON.parse(msg.data);
    var candlestick = json.k;
    var lastChartCandlestick = _candlestickStream.candlestickChart.candlesticks[_candlestickStream.candlestickChart.candlesticks.length - 1];
    // check if the candlestick already exists in the chart
    if (lastChartCandlestick.timestamp == candlestick.t) {
        // update the candlestick
        _candlestickStream.candlestickChart.updateCandlestick(_candlestickStream.candlestickChart.candlesticks.length - 1, candlestick.o, candlestick.c, candlestick.h, candlestick.l);
    } else {
        // if the candlestick does not exist in the chart, add a new one
        _candlestickStream.candlestickChart.addCandlestick(new pingpoliCandlestick(candlestick.t, candlestick.o, candlestick.c, candlestick.h, candlestick.l));
    }
    // update the chart
    _candlestickStream.candlestickChart.draw();
}

CandlestickStream.prototype.onClose = function () {
    if (this.webSocketConnected) {
        this.webSocketConnected = false;
        console.log("websocket closed");
    }
}

CandlestickStream.prototype.onWebSocketError = function (event) {
    this.webSocketConnected = false;
    console.log("custom websocket error function:");
    console.log(event);
}

//  get url paramiter
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

if ($('#chart_div').length) {
    $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market), function (response) {
        var options = {
            series: [{
                data: data
            }],
            chart: {
                type: 'candlestick',
                height: 500
            },
            title: {
                text: 'Stock Chart last 7 days',
                align: 'Center'
            },
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                tooltip: {
                    enabled: true
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_div"), options);
        chart.render();
    });
}