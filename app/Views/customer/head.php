<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title><?php echo  $settings->title ?> - <?php echo (!empty($title) ? esc($title) : null) ?></title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() . $settings->favicon ?>">
    <!--Global Styles(used by all pages)-->
    <link href="<?php echo base_url("public/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("public/assets/plugins/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
     <link href="<?php echo base_url("public/assets/plugins/metisMenu/metisMenu.min.css") ?>" rel="stylesheet"> 
    <link href="<?php echo base_url("public/assets/plugins/fontawesome/css/all.min.css") ?>" rel="stylesheet">
    <link href="<?php //echo base_url("public/assets/plugins/typicons/src/typicons.min.css") ?>" rel="stylesheet">
    <link href="<?php //echo base_url("public/assets/plugins/Semantic/semantic.min.css") ?>" rel="stylesheet">
    <link href="<?php //echo base_url("public/assets/plugins/typicons/src/typicons.min.css") ?>" rel="stylesheet">
    <link href="<?php //echo base_url("public/assets/plugins/themify-icons/themify-icons.min.css") ?>" rel="stylesheet"> 
    <!--Third party Styles(used by this page)-->


    <link href="<?php echo base_url("public/assets/plugins/datatables/dataTables.bootstrap4.min.css") ?>"
        rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/datatables/responsive.bootstrap4.min.css") ?>"
        rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/datatables/buttons.bootstrap4.min.css") ?>" rel="stylesheet">

    <link href="<?php //echo base_url("public/assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.min.css") ?>"
        rel="stylesheet" type="text/css" />
     <link href="<?php //echo base_url("public/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.min.css") ?>"
        rel="stylesheet" type="text/css" />
 
    <link href="<?php echo base_url("public/assets/css/customer_custom.css?v=4.1") ?>" rel="stylesheet"> 
    <link href="<?php echo base_url("public/assets/dist/css/style.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/select2/dist/css/select2.min.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css") ?>"
        rel="stylesheet">
    <script src="<?php echo base_url("public/assets/plugins/jQuery/jquery.min.js") ?>"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">

    <input type="hidden" name="base_url" id="base_url" value="<?php echo esc(base_url()); ?>">
    <input type="hidden" name="segment" id="segment" value="<?php echo esc($uri->setSilent()->getSegment(2)); ?>">
    <input type="hidden" name="language" id="language" value="<?php echo esc($settings->language); ?>">
</head>