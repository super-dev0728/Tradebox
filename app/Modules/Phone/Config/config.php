<?php
// module directory name
$HmvcConfig['Phone']["_title"] = "Phone";
$HmvcConfig['Phone']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Phone']['_database'] = false;
$HmvcConfig['Phone']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Phone']["_extra_query"] = true;