<?php
// module directory name
$HmvcConfig['Paytm']["_title"] = "Paytm";
$HmvcConfig['Paytm']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Paytm']['_database'] = true;
$HmvcConfig['Paytm']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Paytm']["_extra_query"] = true;