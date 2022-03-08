<?php namespace Config;
use CodeIgniter\Config\BaseConfig;
helper('filesystem');

$path = 'app/Modules/';
$map  = directory_map($path);
$csrf   = array();


if (is_array($map) && sizeof($map) > 0) {

	$test = '';
    foreach ($map as $key => $value) {
        $csrf_array = str_replace("\\", '/', $path . $key . 'Filter/CSRF_Filter.php');
        if (file_exists($csrf_array)) {
        	//array_push($csrf_off, $map);
            @include($csrf_array);

            //array_push($csrf_off, $csrf);
            //print_r($csrf_array);

            ///$test .=
            
        }
    }


    $newArr = array();
    foreach ($csrf as $key => $singleArr) {
    	
    	foreach ($singleArr as $index => $element) {

    		$newArr[] = $element;
    		
    	}
    }

    //print_r($newArr);


}

//print_r($csrf);
defined('EXCEPTURL') || define('EXCEPTURL',$newArr);

//print_r($csrf);
//die();
class Filters extends BaseConfig
{

	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'admin_filter' 		=> \App\Filters\Admin_filter::class,
		'customer_filter' 	=> \App\Filters\Customer_filter::class
	];

	// Always applied before every request
	


	public $globals = [
		'before' => [
			//'honeypot'
			'csrf' =>['except' => EXCEPTURL]
		//'csrf' =>['except' => ['backend/auto_update/update','backend/auto_update/updatenow','customer/payment_callback/paytmsuccess']]
		],
		'after'  => [
			'toolbar',
			//'csrf',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [];
}
