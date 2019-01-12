<!-- Page Header -->
<div class="page-header has-menu">
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
        <h1 class="display-5">Hello, <?= $this->app->user_info('title') . ' ' . ucwords($this->app->user_info('firstname') . ' ' . $this->app->user_info('lastname')); ?></h1>
        <p class="text-muted">We will display basic summaries, recent transactions, notifications, shortcuts etc. on your dashboard.</p>
    </div>
    <?php
    echo '<pre>';
    print_r($_SESSION);
    ?>
</div>
