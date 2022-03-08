$(document).ready(function () {
    "use strict";
    for (var e = document.querySelectorAll(".disable-autohide .market-symbol"), t = 0; t < e.length; t++)
        e[t].addEventListener("click", function (e) {
            e.stopPropagation();
        });

    // Switcher
    $('#switcher').on('click', function () {
        if ($('#switcher').attr('checked', true)) {
            $('body').toggleClass('dark-theme');
        } else if ($('#switcher').attr('checked', false)) {
            $('body').toggleClass('dark-theme');
        }
    });

    // DataTable
    $('.trade-market-table').DataTable({
        lengthChange: false,
        searching: false,
        paging: false,
        info: false,
        scrollY: '45vh',
        scrollCollapse: true
    });

    // DataTable
    $('.account-box_table').DataTable({

        responsive: true,
        lengthChange: false,
        searching: false,
        paging: false,
        info: false,
        scrollY: '30vh',
        scrollX: true,
        scrollCollapse: true
    });

    var screensize          = document.documentElement.clientWidth;

     if(screensize > 0 && screensize < 1024){

        var middelcontentwidth  = screensize;

        $("#allTrade").css("width", middelcontentwidth);
        $("#openOrders").css("width", middelcontentwidth);
        $("#orderHistory").css("width", middelcontentwidth);

        $("#openOrders div table").removeAttr("style");
        $("#openOrders div table").css("width", "100%");

        $("#orderHistory div table").removeAttr("style");
        $("#orderHistory div table").css("width", "100%");

        $("#allTrade div table").removeAttr("style");
        $("#allTrade div table").css("width", "100%");

    }else if(screensize > 1023 && screensize < 1200){

        var middelcontentwidth  = screensize - 305;

        $("#allTrade").css("width", middelcontentwidth);
        $("#openOrders").css("width", middelcontentwidth);
        $("#orderHistory").css("width", middelcontentwidth);

        $("#openOrders div table").removeAttr("style");
        $("#openOrders div table").css("width", "100%");

        $("#orderHistory div table").removeAttr("style");
        $("#orderHistory div table").css("width", "100%");

        $("#allTrade div table").removeAttr("style");
        $("#allTrade div table").css("width", "100%");

    } else if(screensize > 1200){

        var middelcontentwidth  = screensize - 610;

        $("#allTrade").css("width", middelcontentwidth);
        $("#openOrders").css("width", middelcontentwidth);
        $("#orderHistory").css("width", middelcontentwidth);

        $("#openOrders div table").removeAttr("style");
        $("#openOrders div table").css("width", "100%");

        $("#orderHistory div table").removeAttr("style");
        $("#orderHistory div table").css("width", "100%");

        $("#allTrade div table").removeAttr("style");
        $("#allTrade div table").css("width", "100%");
    }

    
    $('.place-order_header .btn-close, .orderform-overlay').on('click', function () {
        $('.place-order_container').removeClass('active');
        $('.orderform-overlay').removeClass('active');
    });
    $('.profile-collapse').on('click', function () {
        $('.place-order_container').addClass('active');
        $('.orderform-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
    });

    // Order Form Tabs Trigger
    $(".btn-sell").on("click", function () {
        $('.nav-tabs > .nav-item').find('#sell-tab').trigger('click');
    });

    $(".btn-buy").on("click", function () {
        $('.nav-tabs > .nav-item').find('#buy-tab').trigger('click');
    });

    // Form Input Focus
    $(".input-group-form").on("click", function () {
        $(this).find('input').focus();
    });

    // Without JQuery
    var slider = new Slider("#ex13", {
        ticks: [0, 25, 50, 75, 100],
        ticks_positions: [0, 25, 50, 75, 100],
        ticks_labels: ['0%', '25%', '50%', '75%', '100%'],
        ticks_snap_bounds: 1
    });

    var slider = new Slider("#ex14", {
        ticks: [0, 25, 50, 75, 100],
        ticks_positions: [0, 25, 50, 75, 100],
        ticks_labels: ['0%', '25%', '50%', '75%', '100%'],
        ticks_snap_bounds: 1
    });

    // Table Progressbar
    var trs = document.querySelectorAll('.table-body tr');
    for (var i = 0; i < trs.length; i++) {
        var tr = trs[i];
        var pr = tr.querySelector('.progres-s');
        pr.style.right = (tr.dataset.progress - 100) + '%';
        pr.style.height = tr.clientHeight + 'px';
    }

});
// Preloader Text Animation
function preloaderTextAnimation() {
    let $ = (e) => document.querySelector(e);
    let dots = $(".dots");
    function animate(element, className) {
        element.classList.add(className);
        setTimeout(() => {
            element.classList.remove(className);
            setTimeout(() => {
                animate(element, className);
            }, 500);
        }, 2500);
    }
    animate(dots, "dots--animate");
}
// Preloader 
$(window).on("load", function () {
    preloaderTextAnimation();
    setTimeout(function () {
        $('.loader-wrapper').fadeOut();
        $('body').css({ 'overflow-y': 'visible' });
    }, 1000);
});