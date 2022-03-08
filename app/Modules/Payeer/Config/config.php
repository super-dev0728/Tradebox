<?php
// module directory name
$HmvcConfig['Payeer']["_title"] = "Payeer";
$HmvcConfig['Payeer']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Payeer']['_database'] = false;
$HmvcConfig['Payeer']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Payeer']["_extra_query"] = true;