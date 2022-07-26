<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">إضافة منشأة</h3>
			</div>
			<?php echo form_open('company/add'); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="Name" class="control-label"><span class="text-danger">*</span> الاسم </label>

						<div class="form-group">
							<input type="text" name="Name" value="<?php echo $this->input->post('Name'); ?>" class="form-control" id="Name" />
							<span id="name-text-danger" class="text-danger"><?php echo form_error('Name'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="CompType" class="control-label">نوع المنشأة</label><span class="text-danger">*</span>
						<div class="form-group">
							<select name="CompType" class="form-control">
								<option value="">إختر نوع المنشأة</option>
								<?php
								foreach ($all_comptypes as $comptype) {
									$selected = ($comptype['CompType'] == $this->input->post('CompType')) ? ' selected="selected"' : "";
									echo '<option value="' . $comptype['CompType'] . '" ' . $selected . '>' . $comptype['Name'] . '</option>';
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('CompType'); ?></span>
						</div>
					</div>
				</div>
				<div class="row">
					<!--PARTNER_COMPANY BEGIN-->
					<div class="col-md-6">
						<div class="form-check">
							<label for="partner_company" class="control-label" style="margin-right:8px;">Partners</label>
						</div>
						<div id="div_partner_compnay" class="form-group">
							<input type="text" name="partner_company_name" value="<?php echo $this->input->post('partner_company_name'); ?>" class="form-control" id="partner_company_name" autocomplete="off">
							<div id="suggesstion_partner"></div>
							<div id="partner_list"></div>
							<span class="text-danger"><?php echo $err_partner_company_id; ?></span>
						</div>
					</div>
					<!--PARTNER_COMPANY END-->
					<!--HAS_MAIN_COMPANY BEGIN-->
					<div class="col-md-6">
						<?php
						$main_company_id = $this->input->post('main_company_id');
						$comp_checked_state = empty($main_company_id) ? "" : "checked";
						$comp_disabled = empty($main_company_id) ? "disabled" : "";
						?>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="has_company" name="has_company" <?php echo ($comp_checked_state); ?> />
							<label for="has_company" class="control-label" style="margin-right:8px;">Has a company</label>
						</div>
						<div id="div_has_main_company" class="form-group <?php echo $comp_disabled; ?>">
							<input type="text" name="main_company_name" value="<?php echo $this->input->post('main_company_name'); ?>" class="form-control" id="main_company_name" autocomplete="off">
							<input type="hidden" name="main_company_id" value="<?php echo $this->input->post('main_company_id'); ?>" class="form-control" id="main_company_id">
							<div id="suggesstion-company"></div>
							<span class="text-danger"><?php echo $err_main_company_id; ?></span>
						</div>
					</div>
					<!--HAS_MAIN_COMPANY END-->
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="Customer_id" class="control-label">العميل</label><span class="text-danger">*</span>
						<div class="form-group">
							<input type="text" name="Customer_ids" value="<?php echo $this->input->post('Customer_id'); ?>" class="form-control" id="search-box">
							<div id="suggesstion-box"></div>
							<div id="list_boxs"></div>
							<span class="text-danger"><?php echo $err_customer_id; ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="Managerid" class="control-label">المدير</label>
						<div class="form-group">
							<select name="Managerid" class="form-control">
								<option value="">اختر المدير</option>
								<?php
								foreach ($all_employees as $employee) {
									$selected = ($employee['employee_id'] == $this->input->post('Managerid')) ? ' selected="selected"' : "";

									echo '<option value="' . $employee['employee_id'] . '" ' . $selected . '>' . $employee['emp_name'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="companyNo" class="control-label">رقم المنشأة</label>
						<div class="form-group">
							<input type="text" name="companyNo" value="<?php echo $this->input->post('companyNo'); ?>" class="form-control" id="companyNo" />
							<span class="text-danger"><?php echo form_error('companyNo'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<label for="CompReg" class="control-label">رقم التسجيل</label>
						<div class="form-group">
							<input type="text" name="CompReg" value="<?php echo $this->input->post('CompReg'); ?>" class="form-control" id="CompReg" />
							<span class="text-danger"><?php echo form_error('CompReg'); ?></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="email" class="control-label">البريد الالكتروني</label>
						<div class="form-group">
							<input type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control" id="email" />
							<span class="text-danger"><?php echo form_error('email'); ?></span>
						</div>
					</div>

					<div class="col-md-6">
						<label for="Remarks" class="control-label">ملاحظات</label>
						<div class="form-group">
							<input type="text" name="Remarks" value="<?php echo $this->input->post('Remarks'); ?>" class="form-control" id="Remarks" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<?php
							$active_state = $this->input->post('active');
							$active_state = $active_state === 'on' ? "checked" : "";
						?>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="active" name="active" <?php echo ($active_state); ?> />
							<label for="active" class="control-label" style="margin-right:8px;">Active</label>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-success">
					<i class="fa fa-check"></i> حفظ
				</button>
				<a class="btn btn-default" href="<?php echo site_url("company/index") ?>">
					تراجع
				</a>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	function selectPartner(val) {
		var res = val.split(",");
		var parterId = "#" + "my_delete_partner_" + res[0];
		if ($(parterId).length == 0) {
			$("#partner_list").append('<div class="my_delete_my" id="company_partner_' + res[0] + '"><input class="rolesHidden" type="hidden" name="partner_id[]" value="' + res[0] + '"><span class="class_lists">' + res[1] + '</span><label data-id="' + res[0] + '" class="ic_delete_partners"><i class="fa fa-trash" aria-hidden="true"></i></label></div>');
		}
		$("#partner_company_name").val('');
		$("#suggesstion_partner").hide();
	}

	$(document).ready(function() {
		$("#Name").blur(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>company/check_name",
				data: "name=" + $(this).val(),
				beforeSend: function() {
					//$("#main_company_name").css("background", "#FFF url(<?php echo base_url(); ?>LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					//console.log('is_dup:' + data)
					if (data == "0") {
						$("#name-text-danger").html("")
					} else {
						$("#name-text-danger").html("The name is duplicated.")
					}
				}
			})
		})

		$("#partner_company_name").keyup(function() {
			roles = $('input.companyHidden').map(function() {
				return [
					[this.value]
				];
			}).get();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>company/get_partner",
				data: 'keyword=' + $(this).val() + '&role_id=' + roles,
				beforeSend: function() {
					$("#partner_company_name").css("background", "#FFF url(<?php echo base_url(); ?>LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#suggesstion_partner").show();
					$("#suggesstion_partner").html(data);
					$("#partner_company_name").css("background", "#FFF");
				}
			})
		})

		$("body").delegate(".ic_delete_partners", "click", function() {
			var answer = confirm('Are you sure you want to permanently delete this?');
			if (answer) {
				var id = $(this).data("id");
				$("#company_partner_" + id).remove();
			}
		})
	});
</script>