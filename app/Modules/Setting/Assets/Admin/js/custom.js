(function ($) {
"use strict";
	$('.copy1').on('click',function(){
        myFunction1();
    });
     function myFunction1() {
      var copyText = document.getElementById("copyed1");
      copyText.select();
      document.execCommand("Copy");
    }
    $('.copy2').on('click',function(){
        myFunction2();
    });
    function myFunction2() {
      var copyText = document.getElementById("copyed2");
      copyText.select();
      document.execCommand("Copy");
    }
}(jQuery));