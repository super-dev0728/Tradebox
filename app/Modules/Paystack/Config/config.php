<?php
// module directory name
$HmvcConfig['Paystack']["_title"] = "Paystack";
$HmvcConfig['Paystack']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Paystack']['_database'] = false;
$HmvcConfig['Paystack']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Paystack']["_extra_query"] = true;