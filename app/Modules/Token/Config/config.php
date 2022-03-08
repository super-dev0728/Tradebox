<?php
// module directory name
$HmvcConfig['Token']["_title"] = "Token";
$HmvcConfig['Token']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Token']['_database'] = false;
$HmvcConfig['Token']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Token']["_extra_query"] = true;