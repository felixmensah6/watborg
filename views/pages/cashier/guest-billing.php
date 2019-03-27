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
    <?= $this->app->page_menu($this->session->role_level); ?>
</div>

<!-- Content -->
<div class="content boxed">

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body">
            <div class="status"></div>
            <form action="<?= site_url("cashier/bill-payment"); ?>" method="post">
                <fieldset class="mt-3">
                    <legend>Guest Information</legend>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="label-required">Guest Name</label>
                            <input type="text" name="patient_name" class="form-control" placeholder="e.g. John Adongo" tabindex="1">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="label-required">Phone No.</label>
                            <input type="text" name="patient_phone" class="form-control" placeholder="e.g. 024xxxxxxx" tabindex="1">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="label-required">Locality</label>
                            <div class="input-group flex-nowrap">
                                <select class="form-control select2" name="locality" data-ajax--url="<?= site_url("data/localities"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select Locality" data-minimum-input-length="2" data-width="100%" data-name="locality" tabindex="1" data-clear></select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default load-modal" title="Add New" data-url="<?= site_url('settings/add-locality/'); ?>" data-title="Add New Locality" data-toggle="modal" data-target="#page-modal" data-backdrop="static">&#43;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-3 mb-3">
                    <legend>Service Charges</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Services</label>
                            <select class="form-control select2-services" data-ajax--url="<?= site_url("data/services"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select Service" data-width="100%" tabindex="1" data-clear></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Total Cost</label>
                            <h3 class="mb-0">
                                <span class="opacity-25"><?= $currency; ?></span>
                                <span id="total-cost">0.00</span>
                            </h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-light">
                                    <th width="50%">Service Name</th>
                                    <th width="25%">Service Category</th>
                                    <th width="15#">Service Cost</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="service-list">
                                <tr class="d-none">
                                    <td class="price">0.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="service-total">
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="label-required">Amount Paid</label>
                            <div class="input-group spinner" data-trigger="spinner">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?= $currency; ?></span>
                                </div>
                                <input type="text" class="form-control" name="amount_paid" value="0.00" data-rule="currency" data-step="1.00" tabindex="1">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-default spin-up" data-spin="up"><i class="icon-chevron-up"></i></button>
                                    <button type="button" class="btn btn-default spin-down" data-spin="down"><i class="icon-chevron-down"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <input type="hidden" name="submit" value="submit">
                <button onclick="registerPatient(this.form, true, false, true);" type="button" class="btn btn-primary" tabindex="1">Submit</button>
                <button id="reset-form" type="button" class="btn btn-default" tabindex="1">Clear</button>
            </form>
        </div>
    </div>

</div>

<!-- Javascript -->
<script src="<?= asset('plugins/populate/js/populate.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('.select2-services').select2().on('select2:select', function (e) {
            var data = e.params.data,
                markup = '<tr class="selected-service">' +
                         '<td>' + data.text + '<input type="hidden" name="service[]" value="' + data.id + '"></td>' +
                         '<td>' + data.category + '</td>' +
                         '<td class="price">' + data.cost + '</td>' +
                         '<td><button class="s2item btn btn-danger btn-xs">Remove</button></td></tr>';

            $('.service-list').append(markup);
            $(this).val(null).trigger("change");
            updateTotal();
        });

        $(document).on('click', '.s2item', function(event) {
            $(event.target).closest('tr').remove();
            updateTotal();
        });

        $('#reset-form').on('click', function(event) {
            resetForm(this.form, function(){
                $(".selected-service").remove();
                updateTotal();
            });
        });
    });
</script>
