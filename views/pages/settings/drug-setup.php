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
    <?= $this->app->page_menu($page_menu_list, $this->session->role_level); ?>
</div>
