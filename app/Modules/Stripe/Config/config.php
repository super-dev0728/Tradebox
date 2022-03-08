<?php
// module directory name
$HmvcConfig['Stripe']["_title"] = "Stripe";
$HmvcConfig['Stripe']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Stripe']['_database'] = false;
$HmvcConfig['Stripe']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Stripe']["_extra_query"] = true;