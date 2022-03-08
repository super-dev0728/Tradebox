<?php
// module directory name
$HmvcConfig['Bank']["_title"] = "Bank";
$HmvcConfig['Bank']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Bank']['_database'] = false;
$HmvcConfig['Bank']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Bank']["_extra_query"] = true;