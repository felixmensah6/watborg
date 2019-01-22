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

        <!-- Login Form Container -->
        <div class="row login-box">
            <div class="col-sm-6 col-md-5 col-lg-4 login-box-content">

                <!-- Panel -->
                <div class="panel panel-default bordered">
                    <div class="panel-heading">
                        <div class="panel-title login-box-header">
                            <h4><?= env('APP_OWNER'); ?></h4>
                            <p class="text-muted mb-0">Please Log In below to get Started.</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?= site_url("login/authenticate"); ?>" id="user-login">
                            <div class="status"></div>
                            <div class="form-group">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autocomplete="off" tabindex="1">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off" tabindex="1">
                            </div>
                            <div class="form-row login-forgot">
                                <div class="form-group col-6"></div>
                                <div class="form-group col-6 text-right">
                                    <a href="<?= site_url('password-reset'); ?>" tabindex="1">Forgot password?</a>
                                </div>
                            </div>
                            <input type="hidden" name="submit" value="submit">
                            <button type="submit" onclick="submitForm('#user-login', true);return false;" class="btn btn-primary btn-block mb-2" tabindex="1">Log In</button>
                        </form>
                    </div>
                </div>

                <div class="login-box-footer">
                    Copyright © <?= env('APP_DEVELOPER'); ?>
                </div>

            </div>
        </div>

    </div>

    <!-- Javascript -->
    <script src="<?= asset('js/unity.core.min.js'); ?>"></script>
    <script src="<?= asset('js/unity.min.js'); ?>"></script>
    <script src="<?= asset('js/watborg.js'); ?>"></script>
</body>

</html>