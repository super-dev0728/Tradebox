<?php if (!defined('APPPATH')) exit('No direct script access allowed');
//get site_align setting
$db = \Config\Database::connect();
$query = $db->query("Select title,site_align,logo,favicon from setting");
$settings   = $query->getRow();
$session = \Config\Services::session();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= display('login') ?> - <?php echo (!empty($title) ? $title : null) ?></title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url(esc($settings->favicon)); ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url('public/assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">


    <!-- 7 stroke css -->
    <link href="<?php echo base_url('public/assets/css/pe-icon-7-stroke.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- style css -->
    <link href="<?php echo base_url('public/assets/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('public/assets/dist/css/style.css') ?>" rel="stylesheet">

</head>

<body>
    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe-7s-unlock"></i>
                        </div>
                        <div class="header-title">
                            <h3 style="display: table-cell;"><?= display('please_login') ?></h3>
                            <small><strong><?php echo (!empty($settings->title) ? $settings->title : null) ?></strong></small>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!-- alert message -->
                    <?php if ($session->get('exception') != null) {  ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <?php echo $session->get('exception'); ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="card-body">
                    <?php echo form_open('customer/login', 'id="loginForm" novalidate'); ?>
                    <div class="form-group">
                        <label class="control-label" for="email"><?= display('email') ?></label>
                        <input type="text" placeholder="<?php echo display('email') ?>" name="email" id="email"
                            class="form-control" value="<?php echo (!empty($user->email) ? $user->email : null) ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password"><?php echo display('password') ?></label>
                        <input type="password" placeholder="<?php echo display('password') ?>" name="password" id="password"
                            class="form-control" value="<?php echo (!empty($user->email) ? $user->password : null) ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="captcha"><?php echo  $captcha_image; ?> </label>
                        <label class="control-label" for="captcha"> </label>
                        <input type="text" placeholder="<?php echo display('captcha') ?>" name="captcha" id="captcha"
                            class="form-control" value="<?php echo (!empty($user->captcha) ? $user->captcha : null) ?>">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display('login') ?></button>
                    </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <!-- jQuery -->
    <script src="<?php echo base_url('public/assets/plugins/jQuery/jquery.min.js') ?>"></script>
    <!-- bootstrap js -->
    <script src="<?php echo base_url('public/assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('public/assets/js/login.js') ?>"></script>
</body>

</html>