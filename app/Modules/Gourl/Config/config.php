<?php
// module directory name
$HmvcConfig['Gourl']["_title"] = "Gourl";
$HmvcConfig['Gourl']["_description"] = "Payment Gateway";
// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['Gourl']['_database'] = false;
$HmvcConfig['Gourl']["_tables"] = array(
);
//Table sql Data insert into existing tables to run module
$HmvcConfig['Gourl']["_extra_query"] = true;