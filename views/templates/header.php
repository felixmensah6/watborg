<?php
    // Redirect and force user to change default password
    if($this->session->temp_password == 1)
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
                <?php
                    // Menu Array
                    $menu = [
                        [
                            'group' => 'Overview',
                            'roles' => [1, 2, 3, 4, 5, 6],
                            'menu' => [
                                [
                                    'text' => 'Dashboard',
                                    'url' => null,
                                    'class' => null,
                                    'icon' => 'icon-tachometer',
                                    'attributes' => null,
                                    'roles' => [1, 2, 3, 4, 5, 6]
                                ]
                            ]
                        ],
                        [
                            'group' => 'OPD',
                            'roles' => [1, 3, 5, 6],
                            'menu' => [
                                [
                                    'text' => 'Records',
                                    'url' => 'records',
                                    'class' => null,
                                    'icon' => 'icon-address-book',
                                    'attributes' => null,
                                    'roles' => [1, 6]
                                ],
                                [
                                    'text' => 'Cashier',
                                    'url' => 'cashier',
                                    'class' => null,
                                    'icon' => 'icon-dollar-sign',
                                    'attributes' => null,
                                    'roles' => [1, 5]
                                ],
                                [
                                    'text' => 'Treatment Room',
                                    'url' => 'treatment',
                                    'class' => null,
                                    'icon' => 'icon-thermometer-half',
                                    'attributes' => null,
                                    'roles' => [1, 3]
                                ],
                                [
                                    'text' => 'Consulting Room',
                                    'url' => 'consultation',
                                    'class' => null,
                                    'icon' => 'icon-stethoscope',
                                    'attributes' => null,
                                    'roles' => [1, 2]
                                ],
                                [
                                    'text' => 'Pharmacy',
                                    'url' => 'pharmacy',
                                    'class' => null,
                                    'icon' => 'icon-mortar-pestle',
                                    'attributes' => null,
                                    'roles' => [1, 7]
                                ],
                                [
                                    'text' => 'Optical Display',
                                    'url' => 'optical-display',
                                    'class' => null,
                                    'icon' => 'icon-glasses',
                                    'attributes' => null,
                                    'roles' => [1, 7]
                                ]
                            ]
                        ],
                        [
                            'group' => 'Administration',
                            'roles' => [1],
                            'menu' => [
                                [
                                    'text' => 'Pay Slip',
                                    'url' => 'pay-slip',
                                    'class' => null,
                                    'icon' => 'icon-id-badge',
                                    'attributes' => null,
                                    'roles' => [1]
                                ]
                            ]
                        ],
                        [
                            'group' => 'Management',
                            'roles' => [1],
                            'menu' => [
                                [
                                    'text' => 'Settings',
                                    'url' => 'settings',
                                    'class' => null,
                                    'icon' => 'icon-cogs',
                                    'attributes' => null,
                                    'roles' => [1]
                                ],
                                [
                                    'text' => 'Setup Users',
                                    'url' => 'users',
                                    'class' => null,
                                    'icon' => 'icon-user-cog',
                                    'attributes' => null,
                                    'roles' => [1]
                                ]
                            ]
                        ],
                    ];

                    // Load menu
                    echo $this->app->sidebar($menu, $this->session->role_level);
                ?>
            </div>

        </div>

        <!-- Main -->
        <div class="main">

            <!-- Navbar -->
            <nav class="navbar navbar-expand-md navbar-light">
                <form class="navbar-search">
                    <button type="submit">
                        <i class="icon-search"></i>
                    </button>
                    <input type="search" name="search" placeholder="Type in to Search..." autocomplete="off">
                </form>
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
                            <a class="dropdown-item" href="users-profile.html">Profile</a>
                            <a class="dropdown-item d-flex align-items-center" href="widgets-inbox.html">
                                Inbox
                                <span class="badge badge-danger ml-auto">12</span>
                            </a>
                            <a class="dropdown-item" href="#">Notifications</a>
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
