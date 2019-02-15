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

<!-- Content -->
<div class="content boxed">

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body">
            <div class="status"></div>
            <form action="<?= site_url("records/patient-registration"); ?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="label-required">Hospital Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="hospital_number" id="hospital_number" placeholder="e.g. 100/15" readonly tabindex="1">
                            <?= select(['0'=>'New Patient','1'=>'Old Patient'], 'patient_type', null, ' ', 'form-control select2', 'id="patient_type" tabindex="1" data-placeholder="Patient Type" data-width="40%" data-minimum-results-for-search="Infinity" data-clear'); ?>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="patient_search" disabled tabindex="1">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="mt-3">
                    <legend>Patient Information</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Surname</label>
                            <input type="text" name="lastname" class="form-control" placeholder="e.g. Adongo" tabindex="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Other Names</label>
                            <input type="text" name="firstname" class="form-control" placeholder="e.g. John" tabindex="1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="label-required d-block">Gender</label>
                            <label class="radio-inline radio-styled mt-2 mr-3">
                                <input type="radio" name="gender" value="Male"> Male
                                <span class="tick"></span>
                            </label>
                            <label class="radio-inline radio-styled mt-2 mr-3">
                                <input type="radio" name="gender" value="Female"> Female
                                <span class="tick"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="label-required">Marrital Status</label>
                            <?= select($this->app->marrital_status(), 'marrital_status', null, ' ', 'form-control select2', ' tabindex="1" data-placeholder="Select Marrital Status" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Date of Birth</label>
                            <div class="input-group datetimepicker">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Age: <span class="ml-1" id="age">0</span></span>
                                </div>
                                <input type="text" class="form-control" name="birthday" id="birthday" placeholder="dd/mm/yyyy" data-date-format="DD/MM/YYYY" tabindex="1">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="button"><i class="icon-calendar-alt"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Occupation</label>
                            <select class="form-control select2" name="occupation" data-ajax--url="<?= site_url("data/occupations"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select Occupation" data-minimum-input-length="2" data-width="100%" tabindex="1"></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Religion</label>
                            <?= select($this->app->religion(), 'religion', null, ' ', 'form-control select2', ' tabindex="1" data-placeholder="Select Religion" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Home Address</label>
                            <input type="text" name="address" class="form-control" placeholder="e.g. Akwele, Kasoa" tabindex="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Phone No.</label>
                            <input type="phone" name="phone" class="form-control" placeholder="e.g. 024xxxxxxx" tabindex="1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>District</label>
                            <select class="form-control select2" name="district" data-ajax--url="<?= site_url("data/districts"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select District" data-minimum-input-length="2" data-width="100%" tabindex="1"></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Locality</label>
                            <select class="form-control select2" name="locality" data-ajax--url="<?= site_url("data/localities"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select Locality" data-minimum-input-length="2" data-width="100%" tabindex="1"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Next of Kin Name</label>
                            <input type="text" name="relative_name" class="form-control" id="relative_name" placeholder="e.g. John Adongo" tabindex="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Next of Kin Phone No.</label>
                            <input type="phone" name="relative_phone" class="form-control" id="relative_phone" placeholder="e.g. 024xxxxxxx" tabindex="1">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-3 mb-3">
                    <legend>Service Charges</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Services</label>
                            <select class="form-control select2-services" data-ajax--url="<?= site_url("data/services"); ?>" data-ajax--data-type="json" data-ajax--delay="250" data-placeholder="Select Service" data-width="100%" tabindex="1"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-light">
                                    <th>Service Name</th>
                                    <th>Category</th>
                                    <th>Cost Price</th>
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
                                    <td></td>
                                    <td><b>Total Cost :</b></td>
                                    <td><b id="total-cost">0.00</b></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </fieldset>
                <input type="hidden" name="submit" value="submit">
                <button onclick="submitForm(this.form);" type="button" class="btn btn-primary" tabindex="1">Submit</button>
            </form>
        </div>
    </div>

</div>

<!-- Javascript -->
<script type="text/javascript">
    $(document).ready(function(){

        $('.select2-services').select2().on('select2:select', function (e) {
            var data = e.params.data,
                markup = '<tr><td>' + data.text + '<input type="hidden" name="service[]" value="' + data.id + '"></td>' +
                         '<td>' + data.category + '</td>' +
                         '<td class="price">' + data.price + '</td>' +
                         '<td><button class="s2item btn btn-danger btn-xs">Remove</button></td></tr>';

            $('.service-list').append(markup);
            $(this).val(null).trigger("change");
            updateTotal();
        });

        $(document).on('click', '.s2item', function(event) {
            $(event.target).closest('tr').remove();
            updateTotal();
        });

        // Hospital Number
        $('#patient_type').on('change', function() {
            if(this.value == 1){
                $('#patient_search').removeProp('disabled');
                $('#hospital_number').removeProp('readonly');
            }else{
                $('#patient_search').prop('disabled', true);
                $('#hospital_number').prop('readonly', true);
            }
        });

        $('.datetimepicker').on("dp.change", function (e) {
            var input_date = format_date($("#birthday").val(), '/'),
                birth_date = (input_date == null) ? new Date() : new Date(input_date),
                age = moment().diff(birth_date, 'years');
            $("#age").text(age);
        });

    });
</script>
