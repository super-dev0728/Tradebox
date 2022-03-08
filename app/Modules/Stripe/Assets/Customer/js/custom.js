(function ($) {
"use strict";
	$('.stripe-button-el').on('click',function(e){

        var key = $('#key').val();
        var test =  $("input[name='csrf_test_name']").val();  
        var sessionId = $('#sessionId').val();
    	var checkoutButton = document.getElementById("checkout-button");

    	var stripe = Stripe(key);
        return stripe.redirectToCheckout({
            sessionId: sessionId
        });
           
    
    
});

}(jQuery));