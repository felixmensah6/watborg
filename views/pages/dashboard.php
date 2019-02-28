<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h5><?= $title; ?></h5>
    </div>
    <div class="page-header-link">
        <a href="#" class="link" data-toggle="tooltip" data-placement="bottom" title="Help">
            <i class="icon-question-circle"></i>
        </a>
    </div>
</div>

<!-- Content -->
<div class="content boxed">

    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1 class="display-5">Hello, <?= $this->app->user_info('title') . ' ' . ucwords($this->app->user_info('lastname')); ?></h1>
        <p class="text-muted">We will display basic summaries, recent transactions, notifications, shortcuts etc. on your dashboard.</p>
    </div>

    <!-- Row -->
    <div class="row">

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-default summary">
                <i class="icon icon-users text-tertiary"></i>
                <span class="value">
                    12
                    <small class="description text-muted">New Contacts</small>
                </span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-default summary">
                <i class="icon icon-history text-warning"></i>
                <span class="value">
                    1,895
                    <small class="description text-muted">Pending Emails</small>
                </span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-default summary">
                <i class="icon icon-wallet text-success"></i>
                <span class="value">
                    $7,951
                    <small class="description text-muted">Won from 16 Deals</small>
                </span>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-default summary">
                <i class="icon icon-trash text-danger"></i>
                <span class="value">
                    15
                    <small class="description text-muted">Items in trash</small>
                </span>
            </div>
        </div>

    </div>

    <?php
    echo '<pre>';
    print_r($_SESSION);
    ?>
</div>
