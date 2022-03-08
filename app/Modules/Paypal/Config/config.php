<?php
// module directory name
$HmvcConfig['Paypal']["_title"] = "Paypal";
$HmvcConfig['Paypal']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Paypal']['_database'] = false;
$HmvcConfig['Paypal']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Paypal']["_extra_query"] = true;