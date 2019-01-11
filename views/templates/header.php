<?php
// Check if already logged in and redirect
$this->session->check("user_id", site_url("login"), true);
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
    <link href="<?= asset('css/unity.css'); ?>" rel="stylesheet">

    <!-- Javascript -->
    <script src="<?= asset('js/jquery.min.js'); ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js'); ?>"></script>
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
                            'roles' => [],
                            'menu' => [
                                [
                                    'text' => 'Dashboard',
                                    'url' => null,
                                    'class' => null,
                                    'icon' => 'icon-tachometer',
                                    'attributes' => null,
                                    'roles' => []
                                ]
                            ]
                        ],
                        [
                            'group' => 'OPD',
                            'roles' => [],
                            'menu' => [
                                [
                                    'text' => 'Records',
                                    'url' => 'records',
                                    'class' => null,
                                    'icon' => 'icon-address-book',
                                    'attributes' => null,
                                    'roles' => []
                                ],
                                [
                                    'text' => 'Cashier',
                                    'url' => 'cashier',
                                    'class' => null,
                                    'icon' => 'icon-dollar-sign',
                                    'attributes' => null,
                                    'roles' => []
                                ],
                                [
                                    'text' => 'Pharmacy',
                                    'url' => 'pharmacy',
                                    'class' => null,
                                    'icon' => 'icon-mortar-pestle',
                                    'attributes' => null,
                                    'roles' => []
                                ]
                            ]
                        ],
                        [
                            'group' => 'Consultation',
                            'roles' => [],
                            'menu' => [
                                [
                                    'text' => 'Consulting Room 1',
                                    'url' => 'room-one',
                                    'class' => null,
                                    'icon' => 'icon-user-md',
                                    'attributes' => null,
                                    'roles' => []
                                ]
                            ]
                        ],
                        [
                            'group' => 'Settings',
                            'roles' => [],
                            'menu' => [
                                [
                                    'text' => 'System Setup',
                                    'url' => 'system',
                                    'class' => null,
                                    'icon' => 'icon-wrench',
                                    'attributes' => null,
                                    'roles' => []
                                ],
                                [
                                    'text' => 'User Accounts',
                                    'url' => 'users',
                                    'class' => null,
                                    'icon' => 'icon-user-cog',
                                    'attributes' => null,
                                    'roles' => []
                                ]
                            ]
                        ],
                    ];

                    // Load menu
                    echo $this->app->sidebar($menu, $this->uri->segment(1), '');
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
                                John W. Smith
                                <span class="d-block text-muted">smith.john@gmail.com</span>
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
