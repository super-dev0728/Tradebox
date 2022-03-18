obj = JSON.parse(BDTASK.phrase());
theme = JSON.parse(BDTASK.theme());

$(function () {
    // Time interval control dropdown display and hide
    $('.chart-content .control .dropdown').on('mouseover', function () {
        $(this).css('color', '#00b746');
        $('.chart-content .control .range-dropdown').show();
    });

    $('.chart-content .control .range-dropdown').on('mouseleave', function () {
        $('.chart-content .control .dropdown').css('color', '#8e8e8e');
        $('.chart-content .control .range-dropdown').hide();
    });

    $('.chart-content .range-dropdown .close').on('click', function () {
        $('.chart-content .control .range-dropdown').hide();
    });
});
$(function ($) {
    "use strict";
    done();
    done1();
    done2();
    done01();
    done02();

    // Create root element
    $('#switcher').on('click', function () {
        tradehistoryupdates();
    });

    if ($('#chartTab').length) {
        document.getElementById('chartTab').style.display = 'none';
    }

    //tradingview initial off
    $('#original').on('click', function () {

        $("#tradingview").removeClass("active");
        $("#original").addClass("active");
        $("#tv_chart_container").css("display", "none");
        $("#chart_div").css("display", "block");
    });

    $('#tradingview').on('click', function () {

        $("#original").removeClass("active");
        $("#tradingview").addClass("active");
        $("#chart_div").css("display", "none");
        $("#tv_chart_container").css("display", "block");

    });

    if ($('#tv_chart_container').length) {

        document.getElementById('tv_chart_container').style.display = 'none';
    }

    //get url paramiter
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

    var symbolMarket = market.replace(/_/g, "");
    //chart-data-script
    var market_details = JSON.parse(BDTASK.market_details());

    // $.getJSON(BDTASK.getSiteAction('tradecharthistory?market=' + market + '&interval=' + interval), function (response) {
    //     createAmChart(response, market, unit, count);
    // });
    // }

    //message chat start
    $("#message_form").on("submit", function (event) {
        event.preventDefault();
        var inputdata = $("#message_form").serialize();

        $.ajax({
            url: BDTASK.getSiteAction('ajaxMessageChat'),
            type: "post",
            data: inputdata,
            dataType: "json",
            success: function (data) {
                if (data != 1) {
                    if (data.userInfo.image == null) {

                        var imagePath = 'public/assets/images/icons/user.png';

                    } else {

                        var imagePath = "public/" + data.userInfo.image;
                    }

                    $("#live_chat_list").append("<div class='message'><img class='avatar' src=" + BDTASK.getSiteAction(imagePath) + " data-toggle='tooltip' data-placement='top' data-original-title='Keith'><div class='text-main'><div class='d-flex align-items-center justify-content-between'><span class='time-ago'>" + data.messageInfo.datetime + "</span></div><div class='text-group'><div class='text'><p>" + data.messageInfo.message + "</p></div></div></div></div>");
                    document.getElementById("message_form").reset();
                } else {
                    allert_warning('warning', "Please Login Again!");
                }
            },
            error: function (data) {
                $("#live_chat").append("<pre>" + data + "</pre>");
            }

        });
    });
    //message chat end

    function done() {
        setTimeout(function () {
            updates_buy();
            done();
        }, 1500);
    }

    function done01() {
        setTimeout(function () {
            updates_sell();
            done01();
        }, 2000);
    }

    function done1() {
        setTimeout(function () {
            marketupdates();
            done1();
        }, 5000);
    }

    function done2() {
        setTimeout(function () {
            messageChat();
            done2();
        }, 1800);
    }

    function done02() {
        setTimeout(function () {
            tradehistoryupdates();
            done02();
        }, 10000);
    }

    //Message Ajax load
    function messageChat() {
        $.getJSON(BDTASK.getSiteAction("jsonMessageStream"), function (data) {
            $("#live_chat_list").empty();
            $.each(data, function (index, element) {
                if (element.image == null) {
                    var imagePath = 'public/assets/images/icons/user.png';
                } else {
                    var imagePath = "public/" + element.image;
                }
                $("#live_chat_list").prepend("<div class='message'><img class='avatar' src=" + BDTASK.getSiteAction(imagePath) + " data-toggle='tooltip' data-placement='top' data-original-title='Keith'><div class='text-main'><div class='d-flex align-items-center justify-content-between'><span class='time-ago'>" + element.datetime + "</span></div><div class='text-group'><div class='text'><p>" + element.message + "</p></div></div></div></div>");
            });
        });
    }
    //Market coinpair load 
    function marketupdates() {

        $.getJSON(BDTASK.getSiteAction('market-streamer?market=' + market), function (data) {

            $.each(data.marketstreamer, function (index, element) {

                $('#price_' + element.market_symbol).text(parseFloat(element.last_price).toFixed(8));
                $('#volume_' + element.market_symbol).text(Math.round(element.total_coin_supply * 100) / 100);

                var change = element.price_change_24h / element.last_price;
                var price_change_percent = (Math.round(change * 100) / 100) * 100;

                $('#price_change_' + element.market_symbol).text(parseFloat(price_change_percent.toFixed(2)).toString() + '%');
                if (change > 0) {
                    $('#price_change_' + element.market_symbol).addClass("positive");
                    $('#price_change_' + element.market_symbol).removeClass('negative');

                } else if (change < 0) {
                    $('#price_change_' + element.market_symbol).addClass("negative");
                    $('#price_change_' + element.market_symbol).removeClass('positive');
                } else {
                    $('#price_change_' + element.market_symbol).removeClass('positive');
                    $('#price_change_' + element.market_symbol).removeClass('negative');
                };

            });
        });
    }

    //Buy Orders load
    function updates_buy() {
        $.getJSON(BDTASK.getSiteAction('streamer-buy?market=' + market), function (data) {
            $("#buytrades").empty();
            $.each(data.trades, function (index, element) {
                var tradeType = "BAD_REQUEST";
                var cls = "";
                if (element.bid_type == 'BUY') {
                    tradeType = "BUY";
                    cls = "positive";
                    $("#buytrades").prepend("<tr><td class='buy_price coin positive'>" + parseFloat(element.bid_price).toFixed(8) + "</td><td class='buy_qty price'>" + parseFloat(element.total_qty).toFixed(6) + "</td><td class='change'>" + parseFloat(parseFloat(element.total_price).toString()).toFixed(6) + "</td></tr>");
                } else {

                    tradeType = "BAD_REQUEST";
                    cls = "";
                }

                //Max Row Show From Stemar
                var maxTableRow = 22;
                var length = $('table tbody#buytrades tr').length;
                if (length >= (maxTableRow)) {
                    $('table tbody#buytrades tr:last').remove();
                }
            });
        });
    }

    //Sell Orders load
    function updates_sell() {
        $.getJSON(BDTASK.getSiteAction('streamer-sell?market=' + market), function (data) {
            $("#selltrades").empty();

            $.each(data.trades, function (index, element) {

                var tradeType = "BAD_REQUEST";
                var cls = "";
                if (element.bid_type == 'SELL') {
                    tradeType = "SELL";
                    cls = "negative";
                    $("#selltrades").prepend("<tr><td class='sell_price coin negative'>" + parseFloat(element.bid_price).toFixed(8) + "</td><td class='sell_qty price'>" + parseFloat(element.total_qty).toFixed(6) + "</td><td class='change'>" + parseFloat(parseFloat(element.total_price).toString()).toFixed(6) + "</td></tr>");
                } else {
                    tradeType = "BAD_REQUEST";
                    cls = "";
                }
                //Max Row Show From Stemar
                var maxTableRow = 22;
                var length1 = $('table tbody#selltrades tr').length;
                if (length1 >= (maxTableRow)) {
                    $('table tbody#selltrades tr:last').remove();
                }

            });
        });
    }

    //Historycal data load
    function tradehistoryupdates() {
        var interval = 5;
        if ($('.range.dropdown').hasClass('active')) {
            $('.sub-range').each(function () {
                if ($(this).hasClass('active')) {
                    interval = $(this).data('range');
                }
            });
        } else {
            $('.range').each(function () {
                if ($(this).hasClass('active')) {
                    interval = $(this).data('range');
                }
            });
        }

        $.getJSON(BDTASK.getSiteAction('tradehistory?market=' + market + '&interval=' + interval), function (data) {
            $("#tradeHistory").empty();
            // var last_price;
            // var last_price = data[0].close;
            // var seconde_last_price = data[1].close;
            var secondLastPrice;
            // data.coinhistory.last_price = data.coinhistory[0].close;

            if (data.secondLast) {

                var secondLastPrice = data.secondLast.last_price;
            } else {

                var secondLastPrice = 0;
            }
            if (data.coinhistory) {

                if (data.openingTrade24 == null) {

                    var openingTrade24Lastprice = 0;

                } else {

                    var openingTrade24Lastprice = data.openingTrade24.last_price;
                }

                //binance formula for price change start
                var price_change_percent = ((data.coinhistory.last_price - openingTrade24Lastprice) / data.coinhistory.last_price) * 100;

                // var price_change_percent = ((data.coinhistory.last_price - openingTrade24Lastprice) / data.coinhistory.last_price) * 100;

                //binance formula for price change end

                if (price_change_percent < 0) {

                    $(".coin-change-price").removeClass("positive");
                    $(".coin-change-price").addClass("negative");

                } else {

                    $(".coin-change-price").removeClass("negative");
                    $(".coin-change-price").addClass("positive");
                }

                if (data.coinhistory.last_price > secondLastPrice) {

                    $(".price_updown").html("<span class='contract-price status-buy'>" + parseFloat(data.coinhistory.last_price).toFixed(8) + "<i class='feather-corner-right-down arrow-icon ms-1'></i><i class='feather-corner-right-up arrow-icon ms-1'></i></span>");

                } else if (data.coinhistory.last_price < secondLastPrice) {

                    $(".price_updown").html("<span class='contract-price status-sell'>" + parseFloat(data.coinhistory.last_price).toFixed(8) + "<i class='feather-corner-right-down arrow-icon ms-1'></i><i class='feather-corner-right-up arrow-icon ms-1'></i></span>");

                } else {

                    $(".price_updown").html("<span class='contract-price status-primary'>" + parseFloat(data.coinhistory.last_price).toFixed(8) + "<i class='feather-corner-right-down arrow-icon ms-1'></i><i class='feather-corner-right-up arrow-icon ms-1'></i></span>");
                }

                if (typeof (data.coinhistory.last_price) !== 'undefined' || typeof (data.coinhistory.last_price) != 'null') {

                    if (data.coinhistory.last_price > secondLastPrice) {

                        $(".coin-last-price").removeClass("status-primary");
                        $(".coin-last-price").removeClass("negative");
                        $(".coin-last-price").addClass("positive");

                    } else if (data.coinhistory.last_price < secondLastPrice) {

                        $(".coin-last-price").removeClass("status-primary");
                        $(".coin-last-price").removeClass("positive");
                        $(".coin-last-price").addClass("negative");

                    } else {

                        $(".coin-last-price").removeClass("negative");
                        $(".coin-last-price").removeClass("positive");
                    }

                    var last_price = data.coinhistory.last_price || 0;
                    $(".coin-last-price").html(parseFloat(last_price).toFixed(6).toString());

                };
                if (typeof (data.coinhistory.volume_24h) !== 'undefined' || typeof (data.coinhistory.volume_24h) != 'null') {
                    var volume_24h = data.coinhistory.volume_24h;
                    $(".total_volume").html(parseFloat(volume_24h).toFixed(6).toString());

                };
                if (typeof (data.coinhistory.price_change_24h) !== 'undefined' || typeof (data.coinhistory.price_change_24h) != 'null') {

                    $(".coin-change-price").html(price_change_percent.toFixed(8).toString() + '%');
                };
                if (typeof (data.high24.last_price) !== 'undefined' || typeof (data.high24.last_price) != 'null') {
                    var last_price = data.high24.last_price || 0;
                    $(".coin-price-high").html(parseFloat(last_price).toFixed(6).toString());
                };
                if (typeof (data.low24.last_price) !== 'undefined' || typeof (data.low24.last_price) != 'null') {
                    var last_price = data.low24.last_price || 0;
                    $(".coin-price-low").html(parseFloat(last_price).toFixed(6).toString());
                };
                if (typeof (data.volume_24h.volume_24h) !== 'undefined' || typeof (data.volume_24h.volume_24h) != 'null') {
                    var volume_24h = data.volume_24h.volume_24h || 0;
                    $(".coin-volume").html(parseFloat(volume_24h).toFixed(6).toString());
                };
            };

            $.each(data.tradehistory, function (index, element) {
                var tradeType = "BAD_REQUEST";
                var cls = "";
                var cls1 = "";
                if (element.bid_type == 'BUY') {
                    tradeType = "BUY";
                    cls = "positive";
                    cls1 = "buy_price";
                } else if (element.bid_type == 'SELL') {
                    tradeType = "SELL";
                    cls = "negative";
                    cls1 = "sell_price";
                } else {
                    tradeType = "BAD_REQUEST";
                    cls = "";
                }
                var d = new Date(element.success_time);

                $("#tradeHistory").append("<tr><td class='treade-size " + cls + "'>" + parseFloat(element.complete_qty).toFixed(6) + "</td><td class='price " + cls + "'>" + parseFloat(element.bid_price).toFixed(6) + "</td><td class='time'>" + element.successtime + "</td></tr>");

                //Max Row Show From Stemar
                var maxTableRow = 18;
                var length = $('table tbody#tradeHistory tr').length;
                if (length >= (maxTableRow)) {
                    $('table tbody#tradeHistory tr:last').remove();
                }

            });

            // updating candlestick chart
            // var candlestickStream = new CandlestickStream(market, interval, false);
            // candlestickStream.start();
        });
    }
    //Market Price From Market place

    $.getJSON(BDTASK.getSiteAction('coin-pairs'), function (data) {

        $.each(data.coin_pairs, function (index, element) {
            var cryptolistfrom = element.market_symbol;
            var cryptolistto = element.currency_symbol;

            $.getJSON("https://min-api.cryptocompare.com/data/price?fsym=" + cryptolistto + "&tsyms=" + cryptolistfrom + "&api_key=" + BDTASK.crypto_api(), function (result) {

                if (result[Object.keys(result)[0]] == 'Error') {
                    $('#price_' + element.market_symbol).text(market_details.initial_price);
                } else if (parseFloat($('#price_' + cryptolistto + '_' + cryptolistfrom).text()) <= 0) {
                    $('#price_' + cryptolistto + '_' + cryptolistfrom).text(parseFloat(result[Object.keys(result)[0]]).toFixed(8));
                };
            });
        });
    });

    var cryptolistfrom = market_details.currency_symbol;
    var cryptolistto = market_details.market_symbol;

    $.getJSON("https://min-api.cryptocompare.com/data/price?fsym=" + cryptolistfrom + "&tsyms=" + cryptolistto + "&api_key=" + BDTASK.crypto_api(), function (result) {


        var rate = 1;
        if (result[Object.keys(result)[0]] == 'Error') {

            var rate = market_details.initial_price;

        } else {

            var rate = parseFloat(parseFloat(result[Object.keys(result)[0]]).toFixed(8)).toString();
        };

        $("#buypricing").val(rate);
        $("#sellpricing").val(rate);
    });

    //buy and sell price percent slide start
    $("body").on("slide keyup keypress blur change", "#ex13", function (slideEvt) {

        var balance_buy = $("#balance_buy").text();
        var buypricing = $("#buypricing").val();
        var percentage = $("#ex13").val();

        var buyAmt = (+balance_buy * +percentage) / 100;
        var ableQty = (buyAmt / buypricing);

        $('#buyamount').val(parseFloat(ableQty.toFixed(8)).toString());
        $('#buyamount').trigger('change');
    });

    $("body").on("slide keyup keypress blur change", "#ex14", function (slideEvt) {

        var balance_sell = $("#balance_sell").text();
        var percentage = $("#ex14").val();
        var buyAmt = (+balance_sell * +percentage) / 100;

        $('#sellamount').val(parseFloat(buyAmt.toFixed(8)).toString());
        $('#sellamount').trigger('change');
    });
    //buy and sell price percent slide end

    //Buy Sell market/Initial price
    $('body').on('click', '.buy_price, .sell_price', function () {
        var buy_price = $(this).text();
        $("#buypricing").val(buy_price);
        $("#sellpricing").val(buy_price);

        $('#sellamount').trigger('change');
        $('#buyamount').trigger('change');
    });

    $('body').on('click', '.buy_qty', function () {
        var buy_qty = $(this).text();
        $("#buyamount").val(buy_qty);
        $("#sellamount").val(buy_qty);

        var sellwithout_fees = buy_qty * 1;
        var sellwithout_fees = sellwithout_fees.toFixed(8);

        $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
        $('#sellwithout_feesval').val(1);
        var feetxt = (BDTASK.sellfees() / 100) * 1;
        var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
        feetxt = feetxt.toFixed(8);
        feetxt2 = feetxt2.toFixed(8);

        $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
        $('#sellfeesval').val(parseFloat(feetxt).toString());

        var total = 1 + +feetxt;
        var total2 = +sellwithout_fees + +feetxt2;
        $("#selltotal").text(parseFloat(total2.toFixed(8)).toString());
        $('#selltotalval').val(parseFloat(total).toString());

        $('#sellamount').trigger('change');
    });

    $('body').on('click', '.sell_qty', function () {
        var buy_qty = $(this).text();
        $("#buyamount").val(buy_qty);
        $("#sellamount").val(buy_qty);

        var sellwithout_fees = buy_qty * 1;
        var sellwithout_fees = sellwithout_fees.toFixed(8);

        $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
        $('#sellwithout_feesval').val(1);
        var feetxt = (BDTASK.sellfees() / 100) * 1;
        var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
        feetxt = feetxt.toFixed(8);
        feetxt2 = feetxt2.toFixed(8);

        $("#sellfees").text(parseFloat(feetxt2).toString() + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
        $('#sellfeesval').val(parseFloat(feetxt).toString());

        var total = 1 + +feetxt;
        var total2 = +sellwithout_fees + +feetxt2;
        $("#selltotal").text(parseFloat(total2.toFixed(8)).toString());
        $('#selltotalval').val(parseFloat(total).toString());

        $('#buyamount').trigger('change');
    });

    $("#buypricing").on("keyup", function (event) {
        event.preventDefault();

        var buypricing = parseFloat($("#buypricing").val()) || 1;
        var buyamount = parseFloat($("#buyamount").val()) || 1;

        var buywithout_feesval = buypricing * buyamount;
        buywithout_feesval = buywithout_feesval.toFixed(8);

        $("#buywithout_fees").text(parseFloat(buywithout_feesval).toString());
        $('#buywithout_feesval').val(parseFloat(buywithout_feesval).toString());
        var feetxt = (BDTASK.buyfees() / 100) * (buywithout_feesval);
        feetxt = feetxt.toFixed(8);
        var fees = $("#buyfees").text(parseFloat(feetxt).toString() + market_details.market_symbol + ' (' + BDTASK.buyfees() + '%)');
        $('#buyfeesval').val(parseFloat(feetxt).toString());
        var total = +buywithout_feesval + +feetxt;
        $("#buytotal").text(parseFloat(total.toFixed(8)).toString());
        $('#buytotalval').val(parseFloat(total.toFixed(8)).toString());

    });

    $("#buypricing").on("change", function (event) {
        event.preventDefault();

        var buypricing = parseFloat($("#buypricing").val()) || 1;
        var buyamount = parseFloat($("#buyamount").val()) || 1;

        var buywithout_feesval = buypricing * buyamount;
        buywithout_feesval = buywithout_feesval.toFixed(8);

        $("#buywithout_fees").text(parseFloat(buywithout_feesval).toString());
        $('#buywithout_feesval').val(parseFloat(buywithout_feesval).toString());
        var feetxt = (BDTASK.buyfees() / 100) * (buywithout_feesval);
        feetxt = feetxt.toFixed(8);
        var fees = $("#buyfees").text(parseFloat(feetxt).toString() + market_details.market_symbol + ' (' + BDTASK.buyfees() + '%)');
        $('#buyfeesval').val(parseFloat(feetxt).toString());
        var total = +buywithout_feesval + +feetxt;
        $("#buytotal").text(parseFloat(total.toFixed(8)).toString());
        $('#buytotalval').val(parseFloat(total.toFixed(8)).toString());
    });

    $("#buyamount").on("keyup", function (event) {
        event.preventDefault();

        var buypricing = parseFloat($("#buypricing").val()) || 1;
        var buyamount = parseFloat($("#buyamount").val()) || 1;

        var buywithout_feesval = buypricing * buyamount;
        buywithout_feesval = buywithout_feesval.toFixed(8);

        $("#buywithout_fees").text(parseFloat(buywithout_feesval).toString());
        $('#buywithout_feesval').val(parseFloat(buywithout_feesval).toString());
        var feetxt = (BDTASK.buyfees() / 100) * (buywithout_feesval);
        feetxt = feetxt.toFixed(8);
        var fees = $("#buyfees").text(parseFloat(feetxt).toString() + market_details.market_symbol + ' (' + BDTASK.buyfees() + '%)');
        $('#buyfeesval').val(feetxt);
        var total = +buywithout_feesval + +feetxt;
        $("#buytotal").text(parseFloat(total.toFixed(8)).toString());
        $('#buytotalval').val(parseFloat(total.toFixed(8)).toString());
    });

    $("#buyamount").on("change", function (event) {
        event.preventDefault();

        var buypricing = parseFloat($("#buypricing").val()) || 1;
        var buyamount = parseFloat($("#buyamount").val()) || 1;

        var buywithout_feesval = buypricing * buyamount;
        buywithout_feesval = buywithout_feesval.toFixed(8);

        $("#buywithout_fees").text(parseFloat(buywithout_feesval).toString());
        $('#buywithout_feesval').val(parseFloat(buywithout_feesval).toString());
        var feetxt = (BDTASK.buyfees() / 100) * (buywithout_feesval);
        feetxt = feetxt.toFixed(8);
        var fees = $("#buyfees").text(parseFloat(feetxt).toString() + market_details.market_symbol + ' (' + BDTASK.buyfees() + '%)');
        $('#buyfeesval').val(feetxt);
        var total = +buywithout_feesval + +feetxt;
        $("#buytotal").text(parseFloat(total.toFixed(8)).toString());
        $('#buytotalval').val(parseFloat(total.toFixed(8)).toString());
    });

    $("#buyform").on("submit", function (event) {
        event.preventDefault();

        var inputdata = $("#buyform").serialize();
        var amount = $('#buyamount').val();
        var price = $('#buypricing').val();

        $("#buyButton").html("<i class='fas fa-circle-notch fa-spin'></i> wait...");
        $('#buyButton').attr('disabled', 'disabled');

        if (amount <= 0 || price <= 0) {

            $(".buyloginMessage").empty();

            //toastr alert start 
            toastr.options.positionClass = 'toast-top-right';
            toastr.warning('Please enter greater than 0 value');

            $("#buyButton").html('Buy ' + market_details.market_symbol);
            $('#buyButton').removeAttr('disabled');

            return false;
            //toastr alert end 
        }

        $.ajax({
            url: BDTASK.getSiteAction('buy'),
            type: "post",
            data: inputdata,
            success: function (data) {

                if (data == 0) {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.error('Trade does not submited');

                    $("#buyButton").html('Buy ' + market_details.market_symbol);
                    $('#buyButton').removeAttr('disabled');
                    //toastr alert end 

                } else if (data == 1) {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.warning('Please Login/Register!');

                    $("#buyButton").html('Buy ' + market_details.market_symbol);
                    $('#buyButton').removeAttr('disabled');
                    //toastr alert end 

                } else if (data == 2) {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.warning('You have not sufficient balance!');

                    $("#buyButton").html('Buy ' + market_details.market_symbol);
                    $('#buyButton').removeAttr('disabled');
                    //toastr alert end 

                } else {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.success('Your request successfully done');

                    $("#buyButton").html('Buy ' + market_details.market_symbol);
                    $('#buyButton').removeAttr('disabled');
                    //toastr alert end 

                    var trade = JSON.parse(data);
                    $("#balance_buy").text(parseFloat(trade.balance).toString());
                    $("#balance_sell").text(parseFloat(trade.balance_up_to).toString());
                    $("#buytrades").prepend("<tr><td class='buy_price coin positive'>" + trade.trades.bid_price + "</td><td class='price'>" + trade.trades.bid_qty + "</td><td class='change'>" + trade.trades.bid_qty + "</td></tr>");

                    var d = new Date();
                    var now = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

                    $('#openOrders').find('tbody')[0].innerHTML = '<tr class="odd"><td class="dtr-control sorting_1" tabindex="0">BUY</td><td>' + price + '</td><td>' + parseFloat(amount).toFixed(8) + '</td><td>' + parseFloat(amount).toFixed(8) + '</td><td>' + parseFloat(amount * price).toFixed(8) + '</td><td>' + parseFloat(amount * price).toFixed(8) + '</td><td>' + market_details.currency_symbol + '_' + market_details.market_symbol + '</td><td>' + now + '</td><td width="30"><div class="progress"><div title="Running" class="progress-bar progress-bar-striped width100percent">Running</div></div></td><td><a href="http://localhost/Tradebox/order-cancel/644" class="bg-danger text-white text-center" data-toggle="tooltip" data-placement="left" title="Cancel">Cancel</a></td></tr>' + $('#openOrders').find('tbody')[0].innerHTML;


                }

                document.getElementById("buyform").reset();

                var cryptolistfrom = market_details.currency_symbol;
                var cryptolistto = market_details.market_symbol;

                $.getJSON("https://min-api.cryptocompare.com/data/price?fsym=" + cryptolistfrom + "&tsyms=" + cryptolistto + "&api_key=" + BDTASK.crypto_api(), function (result) {

                    var rate = 1;
                    if (result[Object.keys(result)[0]] == 'Error') {
                        rate = market_details.initial_price;

                    } else {
                        rate = parseFloat(parseFloat(result[Object.keys(result)[0]]).toFixed(8)).toString();
                    };

                    $("#buypricing").val(rate);
                    $("#sellpricing").val(rate);

                    var buywithout_feesval = rate * 1;
                    buywithout_feesval = buywithout_feesval.toFixed(8);
                    $("#buywithout_fees").text(parseFloat(buywithout_feesval).toString());
                    $('#buywithout_feesval').val(parseFloat(buywithout_feesval).toString());
                    var feetxt = (BDTASK.buyfees() / 100) * (buywithout_feesval);
                    feetxt = feetxt.toFixed(8);
                    var fees = $("#buyfees").text(parseFloat(feetxt).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.buyfees() + '%)');
                    $('#buyfeesval').val(feetxt);
                    var total = +buywithout_feesval + +feetxt;
                    $("#buytotal").text(parseFloat(total.toFixed(8)).toString());
                    $('#buytotalval').val(parseFloat(total.toFixed(8)).toString());

                    var sellwithout_fees = rate * 1;
                    var sellwithout_fees = sellwithout_fees.toFixed(8);

                    $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
                    $('#sellwithout_feesval').val(1);
                    var feetxt = (BDTASK.sellfees() / 100) * 1;
                    var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
                    feetxt = feetxt.toFixed(8);
                    feetxt2 = feetxt2.toFixed(8);
                    $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
                    $('#sellfeesval').val(parseFloat(feetxt).toString());

                    var total = 1 + +feetxt;
                    var total2 = +sellwithout_fees + +feetxt2;
                    $("#selltotal").text(parseFloat(total2.toFixed(8)).toString());
                    $('#selltotalval').val(parseFloat(total).toString());
                });
            },
            error: function (data) {
                $(".buyloginMessage").prepend("<pre>" + data + "</pre>");
            }
        });
    });

    //Ajax Sell
    $("#sellpricing").on("keyup", function (event) {
        event.preventDefault();

        var sellpricing = parseFloat($("#sellpricing").val()) || 0;
        var sellamount = parseFloat($("#sellamount").val()) || 0;

        var sellwithout_fees = sellpricing * sellamount;
        var sellwithout_fees = sellwithout_fees.toFixed(8);

        $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
        $('#sellwithout_feesval').val(parseFloat(sellamount.toFixed(8)).toString());
        var feetxt = (BDTASK.sellfees() / 100) * sellamount;
        var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
        feetxt = feetxt.toFixed(8);
        feetxt2 = feetxt2.toFixed(8);

        $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
        $('#sellfeesval').val(parseFloat(feetxt).toString());

        var total = +sellamount + +feetxt;
        var total2 = +sellwithout_fees + +feetxt2;
        $("#selltotal").text(parseFloat(total2.toFixed(8)).toString());
        $('#selltotalval').val(parseFloat(total).toString());
    });

    $("#sellpricing").on("change", function (event) {
        event.preventDefault();

        var sellpricing = parseFloat($("#sellpricing").val()) || 0;
        var sellamount = parseFloat($("#sellamount").val()) || 0;

        var sellwithout_fees = sellpricing * sellamount;
        var sellwithout_fees = sellwithout_fees.toFixed(8);

        $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
        $('#sellwithout_feesval').val(parseFloat(sellamount.toFixed(8)).toString());
        var feetxt = (BDTASK.sellfees() / 100) * sellamount;
        var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
        feetxt = feetxt.toFixed(8);
        feetxt2 = feetxt2.toFixed(8);

        $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
        $('#sellfeesval').val(parseFloat(feetxt).toString());

        var total = +sellamount + +feetxt;
        var total2 = +sellwithout_fees + +feetxt2;
        $("#selltotal").text(parseFloat(total2.toFixed(8)).toString());
        $('#selltotalval').val(parseFloat(total).toString());
    });

    $("#sellamount").on("keyup", function (event) {
        event.preventDefault();
        var sellpricing = parseFloat($("#sellpricing").val()) || 1;
        var sellamount = parseFloat($("#sellamount").val()) || 1;

        var sellwithout_fees = sellpricing * sellamount;
        var sellwithout_fees = sellwithout_fees.toFixed(8);

        $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
        $('#sellwithout_feesval').val(parseFloat(sellamount.toFixed(8)).toString());
        var feetxt = (BDTASK.sellfees() / 100) * sellamount;
        var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
        feetxt = feetxt.toFixed(8);
        feetxt2 = feetxt2.toFixed(8);

        $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
        $('#sellfeesval').val(parseFloat(feetxt).toString());

        var total = +sellamount + +feetxt;
        var total2 = +sellwithout_fees + +feetxt2;
        $("#selltotal").text(parseFloat(total2).toString());
        $('#selltotalval').val(parseFloat(total).toString());
    });

    $("#sellamount").on("change", function (event) {
        event.preventDefault();
        var sellpricing = parseFloat($("#sellpricing").val()) || 1;
        var sellamount = parseFloat($("#sellamount").val()) || 1;

        var sellwithout_fees = sellpricing * sellamount;
        var sellwithout_fees = sellwithout_fees.toFixed(8);

        $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
        $('#sellwithout_feesval').val(parseFloat(sellamount.toFixed(8)).toString());
        var feetxt = (BDTASK.sellfees() / 100) * sellamount;
        var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
        feetxt = feetxt.toFixed(8);
        feetxt2 = feetxt2.toFixed(8);

        $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
        $('#sellfeesval').val(parseFloat(feetxt).toString());

        var total = +sellamount + +feetxt;
        var total2 = +sellwithout_fees + +feetxt2;
        $("#selltotal").text(parseFloat(total2).toString());
        $('#selltotalval').val(parseFloat(total).toString());
    });

    $("#sellform").on("submit", function (event) {
        event.preventDefault();

        var inputdata = $("#sellform").serialize();
        var amount = $('#sellamount').val();
        var price = $('#sellpricing').val();

        $("#sellButton").html("<i class='fas fa-circle-notch fa-spin'></i> wait...");
        $('#sellButton').attr('disabled', 'disabled');


        if (amount <= 0 || price <= 0) {
            $(".sellloginMessage").empty();
            //toastr alert start 
            toastr.options.positionClass = 'toast-top-right';
            toastr.warning('Please enter greater than 0 value');

            $("#sellButton").html("Sell " + market_details.currency_symbol);
            $('#sellButton').removeAttr('disabled');
            //toastr alert end 
            return false;
        }
        $.ajax({
            url: BDTASK.getSiteAction('sell'),
            type: "post",
            data: inputdata,
            success: function (data) {
                if (data == 0) {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.error('Trade does not submited');

                    $("#sellButton").html("Sell " + market_details.currency_symbol);
                    $('#sellButton').removeAttr('disabled');
                    //toastr alert end 

                } else if (data == 1) {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.warning('Please Login/Register!');

                    $("#sellButton").html("Sell " + market_details.currency_symbol);
                    $('#sellButton').removeAttr('disabled');
                    //toastr alert end 

                } else if (data == 2) {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.warning('You have not sufficient balance!');

                    $("#sellButton").html("Sell " + market_details.currency_symbol);
                    $('#sellButton').removeAttr('disabled');
                    //toastr alert end 

                } else {

                    //toastr alert start 
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.success('Your request successfully done');
                    //toastr alert end 

                    $("#sellButton").html("Sell " + market_details.currency_symbol);
                    $('#sellButton').removeAttr('disabled');

                    var trade = JSON.parse(data);
                    $("#balance_sell").text(parseFloat(trade.balance).toString());
                    $("#balance_buy").text(parseFloat(trade.balance_up_to).toString());
                    $("#selltrades").prepend("<tr><td class='coin negative'><div class='progres-s'></div>" + trade.trades.bid_price + "</td><td class='price'>" + trade.trades.bid_qty + "</td><td class='change'>" + trade.trades.total_amount + "</td></tr>");

                    var d = new Date();
                    var now = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

                    $('#openOrders').find('tbody')[0].innerHTML = '<tr class="odd"><td class="dtr-control sorting_1" tabindex="0">SELL</td><td>' + price + '</td><td>' + parseFloat(amount).toFixed(8) + '</td><td>' + parseFloat(amount).toFixed(8) + '</td><td>' + parseFloat(amount * price).toFixed(8) + '</td><td>' + parseFloat(amount * price).toFixed(8) + '</td><td>' + market_details.currency_symbol + '_' + market_details.market_symbol + '</td><td>' + now + '</td><td width="30"><div class="progress"><div title="Running" class="progress-bar progress-bar-striped width100percent">Running</div></div></td><td><a href="http://localhost/Tradebox/order-cancel/644" class="bg-danger text-white text-center" data-toggle="tooltip" data-placement="left" title="Cancel">Cancel</a></td></tr>' + $('#openOrders').find('tbody')[0].innerHTML;

                }

                document.getElementById("sellform").reset();

                var cryptolistfrom = market_details.currency_symbol;
                var cryptolistto = market_details.market_symbol;

                $.getJSON("https://min-api.cryptocompare.com/data/price?fsym=" + cryptolistfrom + "&tsyms=" + cryptolistto + "&api_key=" + BDTASK.crypto_api(), function (result) {
                    var rate = 1;
                    if (result[Object.keys(result)[0]] == 'Error') {
                        rate = market_details.initial_price;
                    } else {
                        rate = parseFloat(parseFloat(result[Object.keys(result)[0]]).toFixed(8)).toString();
                    };

                    $("#buypricing").val(rate);
                    $("#sellpricing").val(rate);

                    var buywithout_feesval = rate * 1;
                    buywithout_feesval = buywithout_feesval.toFixed(8);
                    $("#buywithout_fees").text(parseFloat(buywithout_feesval).toString());
                    $('#buywithout_feesval').val(parseFloat(buywithout_feesval).toString());
                    var feetxt = (BDTASK.buyfees() / 100) * (buywithout_feesval);
                    feetxt = feetxt.toFixed(8);
                    var fees = $("#buyfees").text(parseFloat(feetxt).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.buyfees() + '%)');
                    $('#buyfeesval').val(feetxt);
                    var total = +buywithout_feesval + +feetxt;
                    $("#buytotal").text(parseFloat(total.toFixed(8)).toString());
                    $('#buytotalval').val(parseFloat(total.toFixed(8)).toString());


                    var sellwithout_fees = rate * 1;
                    var sellwithout_fees = sellwithout_fees.toFixed(8);
                    $("#sellwithout_fees").text(parseFloat(sellwithout_fees).toString());
                    $('#sellwithout_feesval').val(1);
                    var feetxt = (BDTASK.sellfees() / 100) * 1;
                    var feetxt2 = (BDTASK.sellfees() / 100) * sellwithout_fees;
                    feetxt = feetxt.toFixed(8);
                    feetxt2 = feetxt2.toFixed(8);

                    $("#sellfees").text(parseFloat(feetxt2).toString() + ' ' + market_details.market_symbol + ' (' + BDTASK.sellfees() + '%)');
                    $('#sellfeesval').val(parseFloat(feetxt).toString());
                    var total = 1 + +feetxt;
                    var total2 = +sellwithout_fees + +feetxt2;
                    $("#selltotal").text(parseFloat(total2.toFixed(8)).toString());
                    $('#selltotalval').val(parseFloat(total).toString());
                });
            },
            error: function (data) {
                $(".sellloginMessage").prepend("<pre>" + data + "</pre>");
            }
        });
    });

    function balloon(item, graph) {
        var txt;
        if (graph.id === "asks") {
            txt = "Ask: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />" +
                "Total volume: <strong>" + formatNumber(item.dataContext.askstotalvolume, graph.chart, 4) + "</strong><br />" +
                "Volume: <strong>" + formatNumber(item.dataContext.asksvolume, graph.chart, 4) + "</strong>";
        } else {
            txt = "Bid: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />" +
                "Total volume: <strong>" + formatNumber(item.dataContext.bidstotalvolume, graph.chart, 4) + "</strong><br />" +
                "Volume: <strong>" + formatNumber(item.dataContext.bidsvolume, graph.chart, 4) + "</strong>";
        }
        return txt;
    }

    function formatNumber(val, chart, precision) {
        return AmCharts.formatNumber(
            val, {
                precision: precision ? precision : chart.precision,
                decimalSeparator: chart.decimalSeparator,
                thousandsSeparator: chart.thousandsSeparator
            }
        );
    }

    //Ajax Language Change start
    $("body").on("click", ".french,.english", function (event) {
        event.preventDefault();

        var inputdata = {};
        inputdata[BDTASK.csrf_token()] = BDTASK.csrf_hash();
        inputdata['lang'] = $(this).attr('data-id');

        $.ajax({
            url: BDTASK.getSiteAction('langChange'),
            type: "post",
            data: inputdata,
            success: function (result, status, xhr) {
                location.reload();
            },
            error: function (xhr, status, error) {
                location.reload();
            }
        });
    });
});

$(function () {
    "use strict";
    var info = $('table tbody tr');
    info.click(function () {
        var email = $(this).children().first().text();
        var password = $(this).children().first().next().text();
        var user_role = $(this).attr('data-role');

        $("input[name=luseremail]").val(email);
        $("input[name=lpassword]").val(password);
        $('select option[value=' + user_role + ']').attr("selected", "selected");
    });

    $('.footerHide').on('click', function () {
        $('#footer').hide();
    });

    $('.footerShow').on('click', function () {
        $('#footer').show();
    });

    //get news details
    $(".eachNews").on("click", function (event) {

        var postdata = {};
        postdata[BDTASK.csrf_token()] = BDTASK.csrf_hash();
        postdata['newsId'] = $(this).attr('data-news-id');

        $.ajax({
            url: BDTASK.getSiteAction('news_details'),
            type: "post",
            data: postdata,
            dataType: "JSON",
            success: function (data) {
                if (data.article_image != "") {
                    var newsimg = "public/" + data.article_image;
                } else {
                    var newsimg = "public/assets/images/icons/no-img.png";
                }

                $('#newsDetails').html('<div class="modal-content"><button type="button" class="close news-modal_close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><header class="header-img"><img src="' + BDTASK.baseUrl() + '/' + newsimg + '"></header><div class="modal-body"><div class="news-details"><h1>' + data.headline_en + '</h1><div class="news-details_content"><p><b>' + data.article1_en + '</b></p></div></div></div></div>');
            }
        });
    });
});
//Confirm Password check
function rePassword() {
    var pass = document.getElementById("pass").value;
    var r_pass = document.getElementById("r_pass").value;

    if (pass !== r_pass) {
        document.getElementById("r_pass").style.borderColor = '#f00';
        document.getElementById("r_pass").style.boxShadow = '0 0 0 0.2rem rgba(255, 0, 0,.25)';
        return false;
    } else {
        document.getElementById("r_pass").style.borderColor = '#ced4da';
        document.getElementById("r_pass").style.boxShadow = 'unset';
        return true;
    }
}

function validateForm() {

    var name = document.forms["registerForm"]["rf_name"].value;
    var email = document.forms["registerForm"]["remail"].value;
    var pass = document.forms["registerForm"]["rpass"].value;
    var r_pass = document.forms["registerForm"]["rr_pass"].value;
    var checkbox = document.forms["registerForm"]["accept_terms"].value;

    if (name == "") {

        allert_warning('warning', obj['first_name_required'][BDTASK.language()]);
        return false;
    } else if (email == "") {

        allert_warning('warning', obj['email'][BDTASK.language()]);
        return false;
    } else if (pass == "") {

        allert_warning('warning', obj['password_required'][BDTASK.language()]);
        return false;
    } else if (!pass.match(/[a-z]/)) {

        allert_warning('warning', obj['a_lowercase_letter'][BDTASK.language()]);
        return false;
    } else if (!pass.match(/[A-Z]/)) {

        allert_warning('warning', obj['a_capital_uppercase_letter'][BDTASK.language()]);
        return false;
    } else if (!pass.match(/\d/)) {

        allert_warning('warning', obj['a_number'][BDTASK.language()]);
        return false;
    } else if (!pass.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g)) {

        allert_warning('warning', obj['a_special'][BDTASK.language()]);
        return false;

    } else if (pass.length < 8) {

        allert_warning('warning', obj['please_enter_at_least_8_characters_input'][BDTASK.language()]);
        return false;

    } else if (r_pass == "") {

        allert_warning('warning', obj['confirm_password_must_be_filled_out'][BDTASK.language()]);
        return false;

    } else if (checkbox == "") {

        allert_warning('warning', obj['must_confirm_privacy_policy_and_terms_and_conditions'][BDTASK.language()]);
        return false;
    }
}

function allert_warning(type, message) {

    toastr[type]("", message)
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}
//Valid Email Address Check
function checkEmail() {
    var email = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
        document.getElementById("email").style.borderColor = '#f00';
        document.getElementById("email").style.boxShadow = '0 0 0 0.2rem rgba(255, 0, 0,.25)';
        return false;
    } else {
        document.getElementById("email").style.borderColor = '#ced4da';
        document.getElementById("email").style.boxShadow = 'unset';
        return true;
    }
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return pattern.test(emailAddress);
}
//print a div
function printContent(el) {
    var restorepage = $('body').html();
    var printcontent = $('#' + el).clone();
    $('body').empty().html(printcontent);
    window.print();
    $('body').html(restorepage);
    location.reload();
}
//copy url clickbord
function copyFunction() {
    var copyText = document.getElementById("copyed");
    copyText.select();
    document.execCommand("Copy");
}

//market search js start
function marketSearch() {

    var activeid = $("#myTabContent1 div.active div").attr('id');
    var tableId = activeid.split('_');

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId[0]);
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
//market search js end