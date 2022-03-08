(function ($) {
"use strict";

    /**
     * Customer script start
     */
    $('.copy1').on('click',function(){
        myFunction1();
    });
     function myFunction1() {
      var copyText = document.getElementById("copyed1");
      copyText.select();
      document.execCommand("Copy");
    }

}(jQuery));