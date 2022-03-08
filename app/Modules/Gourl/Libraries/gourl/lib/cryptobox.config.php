<?php

	define("DB_HOST",     'localhost');				
	define("DB_USER",     'root');		
	define("DB_PASSWORD", '');		
	define("DB_NAME",     'tradebox');

	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	// Check connection
	if (mysqli_connect_errno()){
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$sql = "SELECT * FROM payment_gateway WHERE identity='bitcoin'";
	$result = $con->query($sql);
	/**
	 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
	 *  Place values from your gourl.io signup page
	 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
	 */
	$cryptobox_private_keys = array();

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$pri_key = unserialize($row['private_key']);
	    	foreach ($pri_key as $key => $value) { 
				if ($value) {
					array_push($cryptobox_private_keys, $value);
				}
			}

	    }
	} else {
	    echo "0 results";

	}

	define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
	unset($cryptobox_private_keys); 

?>