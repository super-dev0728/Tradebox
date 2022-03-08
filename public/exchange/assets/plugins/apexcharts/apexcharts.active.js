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

var market = getUrlParameter('market').replace('_', '');

function plot() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "https://api.binance.com/api/v3/klines?symbol=" + market + "&interval=1d&limit=200");
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var json = JSON.parse(xmlhttp.responseText);
            candlestickChart = new pingpoliCandlestickChart("chart_div");
            for (var i = 0; i < json.length; ++i) {
                candlestickChart.addCandlestick(new pingpoliCandlestick(json[i][0], json[i][1], json[i][4], json[i][2], json[i][3]));
            }
            candlestickChart.draw();
        }
    }
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
}
plot();