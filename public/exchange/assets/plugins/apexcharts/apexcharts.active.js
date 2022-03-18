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

// draw chart
var market = getUrlParameter('market');
var interval = 5; // real
// var interval = '5m'; // test

var candlestickStream = new CandlestickStream(market, interval, true);
candlestickStream.start();

$('.control .range').on('click', function () {
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.control .sub-range').removeClass('active');

    interval = $(this).data('range') * 1; // real
    // interval = $(this).text().toLowerCase(); // test

    var candlestickStream = new CandlestickStream(market, interval, true);
    candlestickStream.start();
});

$('.control .sub-range').on('click', function () {
    $('.control .sub-range').removeClass('active');
    $('.range').removeClass('active');
    $(this).addClass('active');
    $('.dropdown').addClass('active');

    $('.control .dropdown').html($(this).text() + ' <i class="fa fa-sort-down"></i>');

    interval = $(this).data('range') * 1; // real
    // interval = $(this).text().toLowerCase(); // test

    var candlestickStream = new CandlestickStream(market, interval, true);
    candlestickStream.start();
});