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
                    <legend>Patient Information</legend>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Patient Name</label>
                            <input type="text" class="form-control" value="<?= $row['patient_name']; ?>" tabindex="1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone No.</label>
                            <input type="text" class="form-control" value="<?= $row['patient_phone']; ?>" tabindex="1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Locality</label>
                            <input type="text" name="locality" class="form-control" value="<?= $row['patient_locality']; ?>" tabindex="1" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Hospital Number</label>
                            <input type="text" class="form-control" value="<?= $row['hospital_number']; ?>" tabindex="1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date of Attendance</label>
                            <input type="text" class="form-control" value="<?= time_format($row['bill_date'], 'DD MMM. YYYY'); ?>" tabindex="1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Receipt Number</label>
                            <input type="text" class="form-control" value="<?= $row['receipt_number']; ?>" readonly tabindex="-1">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-3 mb-3">
                    <legend>Bills/Service Charges</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Services</label>
                            <select class="form-control select2-services" data-ajax--url="<?= site_url("data/services"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select Service" data-width="100%" tabindex="1" data-clear></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Total Cost</label>
                            <h3 class="mb-0">
                                <span class="opacity-25"><?= $currency; ?></span>
                                <span id="total-cost"><?= number_format($row['bill_debit'], 2); ?></span>
                            </h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-light">
                                    <th width="50%">Service Name</th>
                                    <th width="35#">Service Cost</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="service-list">
                                <?php
                                    foreach ($bill_items as $item)
                                    {
                                        echo '<tr>' .
                                                '<td>' . $item['bill_item_description'] . '</td>' .
                                                '<td class="price">' . number_format($item['bill_item_debit'], 2) . '</td>' .
                                                '<td><button class="btn btn-danger btn-xs" disabled>Remove</button></td>' .
                                             '</tr>';
                                    }
                                ?>
                                <tr class="d-none">
                                    <td colspan="3" class="price">0.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="service-total">
                                    <td colspan="3"></td>
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
                <a class="btn btn-default" href="<?= site_url("cashier/billing"); ?>" tabindex="1">Clear</a>
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
