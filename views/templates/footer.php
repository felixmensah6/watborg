<!-- Footer -->
<div class="footer">
    <div class="row justify-content-md-center">
        <div class="col-sm-8">
            Copyright © <?= env('APP_DEVELOPER'); ?>
        </div>
        <div class="col-sm-4 text-sm-right">
            Version: <?= env('APP_VERSION'); ?>
        </div>
    </div>
</div>

</div>

</div>

<!-- Modal -->
<div class="modal fade" id="page-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" >Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Loading...
            </div>
        </div>
    </div>
</div>

<!-- Javascript -->
<script src="<?= asset('js/bootstrap.min.js'); ?>"></script>
<script src="<?= asset('plugins/select2/js/select2.min.js'); ?>"></script>
<script src="<?= asset('plugins/moment/js/moment.min.js'); ?>"></script>
<script src="<?= asset('plugins/datetimepicker/js/datetimepicker.min.js'); ?>"></script>
<script src="<?= asset("plugins/datatables/js/datatables.min.js"); ?>"></script>
<script src="<?= asset("plugins/datatables/js/datatables.bootstrap.min.js"); ?>"></script>
<script src="<?= asset('js/unity.core.min.js'); ?>"></script>
<script src="<?= asset('js/unity.min.js'); ?>"></script>
<script src="<?= asset('js/watborg.js'); ?>"></script>

</body>

</html>
