<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Bank Swipe Machine
			<?php if($this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"add")) { ?>
			<a href="<?=base_url('master/bank_machine');?>" class="btn btn-primary pull-right">Add New</a>
			<?php } ?>
		</h1>

	</section>
	<!-- Main content -->
	<section class="content">
		<!-- START ALERTS AND CALLOUTS -->
		<div class="row">
            <div class="col-md-6 col-md-push-6">
            	<?php if($this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"add") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"edit")) { ?>
				<form id="form_mach" action="" enctype="multipart/form-data" data-parsley-validate="">
					<?php if(isset($id) && !empty($id)){ ?>
					<input type="hidden" id="id" name="id" value="<?=$id;?>">
					<?php } ?>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title form_title"><?=isset($id) ? 'Edit' : 'Add' ?></h3> 
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="form-group">
								<label for="bank_id">Bank<span class="required-sign">*</span></label><br />
								<select name="bank_id" id="bank_id" class="form-control select2" required></select>
							</div>
							<div class="form-group">
								<label for="machine_name">Machine Name<span class="required-sign">*</span></label>
								<input type="text" name="machine_name" class="form-control" id="machine_name" placeholder="Enter Machine Name" value="<?=isset($model_name) ? $model_name : '' ?>" pattern="[^'\x22]+" title="Invalid input" required>
							</div>
							<div class="form-group">
								<label for="bank_commission">Commission (%)<span class="required-sign">*</span></label>
								<input type="number" name="bank_commission" class="form-control" id="bank_commission" placeholder="0.00" data-parsley-type="number" step="0.01" title="Invalid input" required>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<?php if(isset($id) && $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"edit")){ ?>
								<button type="submit" class="btn btn-primary form_btn module_save_btn">Update</button>
								<b style="color: #0974a7">Ctrl + S</b>
							<?php } elseif ($this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"add")) { ?>
								<button type="submit" class="btn btn-primary form_btn module_save_btn">Save</button>
								<b style="color: #0974a7">Ctrl + S</b>
							<?php } ?>
						</div>
					</div>
				</form>
				<!-- /.box -->
				<?php } ?>
			</div>
            
			<div class="col-md-6 col-md-pull-6">
				<?php if($this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"view")) { ?>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">List</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<!---content start --->
						<table class="table table-striped table-bordered bank-table">
							<thead>
								<tr>
									<th>Action</th>
									<th>Swipe Machine Name</th>
									<th>Bank Name</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						<!---content end--->
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				<?php } ?>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
		<!-- END ALERTS AND CALLOUTS -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
	var table;
	$(document).ready(function(){
		initAjaxSelect2($("#bank_id"),"<?=base_url('app/our_bank_label_select2_source')?>");
		<?php if(isset($state_id) && !empty($state_id)){ //???>
		setSelect2Value($("#bank_id"),"<?=base_url('app/set_state_select2_val_by_id/'.$state_id)?>");
		<?php } ?>
		table = $('.bank-table').DataTable({
			"serverSide": true,
			"ordering": true,
			"searching": true,
			"aaSorting": [[1, 'asc']],
			"ajax": {
				"url": "<?php echo base_url('master/bank_datatable')?>",
				"type": "POST"
			},
			"scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT;?>',
			"scroller": {
				"loadingIndicator": true
			},
			"columnDefs": [
				{"targets": 0, "orderable": false }
			]
		});
        
        shortcut.add("ctrl+s", function() {  
            $( ".module_save_btn" ).click();
        });

        $('#bank_id').select2('open');
        $('#bank_id').on("select2:close", function(e) { 
            $("#machine_name").focus();
        });

		$(document).on('submit', '#form_mach', function () {
			var bank_id = $('#bank_id').val();
			var machine_name = $('#machine_name').val();
			if($('#bank_commission').val()=='') $('#bank_commission').val('0.0');
			var commission = $('#bank_commission').val();

			var postData = new FormData(this);
			$.ajax({
				url: "<?=base_url('master/save_bank_machine') ?>",
				type: "POST",
				processData: false,
				contentType: false,
				cache: false,
				data: postData,
				success: function (response) {
					var json = $.parseJSON(response);
					if (json['error'] == 'Exist') {
						show_notify("Swipe Machine already Exist", false);
					} else if (json['success'] == 'Added') {
						table.draw();
						$('#form_mach').find('input:text, select, textarea').val('');
						$('#bank_commission').val('0.0');
						$("#bank_id").val(null).trigger("change");
						show_notify('Swipe Machine successfully Added.', true);
					}else if (json['success'] == 'Updated') {
						table.draw();
						$('#form_mach').find('input:text, select, textarea').val('');
						$("#bank_id").val(null).trigger("change");
						$(".form_btn").html('Save');
						$(".form_title").html('Add');
						$('input[name="id"]').val("");
						show_notify('Swipe Machine successfully Updated.', true);
					}
					return false;
				},
			});
			return false;
		});

		$(document).on("click",".delete_button",function(){
			if(confirm('Are you sure delete this records?')){
                $.ajax({
                    url: $(this).data('href'),
                    type: "POST",
                    data: 'id_name=city_id&table_name=city',
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json['error'] == 'Error') {
                            show_notify('You cannot delete this City. This City has been used.', false);
                        } else if (json['success'] == 'Deleted') {
                            table.draw();
                            show_notify('Deleted Successfully!', true);
                        }
                    }
                });
            }
		});
	});
</script>
