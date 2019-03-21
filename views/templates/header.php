<?php
    // Redirect and force user to change default password
    if(isset($this->session->temp_password) && $this->session->temp_password == 1)
    {
        redirect(site_url('change-password'));
    }

    // Check for an active session else redirect
    $this->app->check_active_session();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= asset('images/favicon.png'); ?>" sizes="32x32" type="image/png">
    <title><?= env('APP_OWNER') . ' - ' . env('APP_NAME'); ?></title>

    <!-- Stylesheets -->
    <link href="<?= asset('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset('plugins/select2/css/select2.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset('plugins/datetimepicker/css/datetimepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset("plugins/datatables/css/datatables.bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?= asset('css/unity.css'); ?>" rel="stylesheet">

    <!-- Javascript -->
    <script src="<?= asset('js/jquery.min.js'); ?>"></script>
</head>

<body>
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Header -->
            <nav class="navbar sidebar-header">
                <a class="navbar-brand" href="<?= site_url(); ?>">
                    <img src="<?= asset('images/watborg.svg'); ?>" width="18" height="18" class="d-inline-block align-top" alt="">
                    <?= env('APP_OWNER'); ?>
                </a>
            </nav>

            <!-- Sidebar Content -->
            <div class="sidebar-content optiscroll">

                <!-- Sidebar Nav -->
                <?= $this->app->sidebar($this->session->role_level); ?>
            </div>

        </div>

        <!-- Main -->
        <div class="main">

            <!-- Navbar -->
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand d-inline-block d-md-none w-auto" href="<?= site_url(); ?>">
                    <img src="<?= asset('images/watborg2.svg'); ?>" width="22" height="22" class="align-middle" alt="">
                    <span class="text-dark d-none d-sm-inline-block"><?= env('APP_OWNER'); ?></span>
                </a>
                <!-- <img src="" width="28" height="28" class="d-inline-block d-md-none align-top" alt=""> -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-user dropdown-toggle caret-none" href="#" data-toggle="dropdown">
                            <img src="<?= asset('images/user.svg'); ?>" class="rounded-circle" width="30" height="30" alt="User">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <span class="dropdown-item-text">
                                <?= $this->app->user_info('title') . ' ' . ucwords($this->app->user_info('firstname') . ' ' . $this->app->user_info('lastname')); ?>
                                <span class="d-block text-muted"><?= $this->app->user_info('role_name'); ?></span>
                            </span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= site_url('user-profile'); ?>">My Account</a>
                            <a class="dropdown-item" href="#">Help/Support</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= site_url('logout'); ?>">Logout</a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button">
                    <i class="icon-bars"></i>
                </button>
            </nav>
