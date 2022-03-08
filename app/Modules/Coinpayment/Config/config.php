<?php
// module directory name
$HmvcConfig['Coinpayment']["_title"] = "Coinpayment";
$HmvcConfig['Coinpayment']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Coinpayment']['_database'] = false;
$HmvcConfig['Coinpayment']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Coinpayment']["_extra_query"] = true;