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