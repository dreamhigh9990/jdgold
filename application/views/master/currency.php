<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Currency
			<?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"view")) { ?>
			<a href="<?=base_url('master/currency');?>" class="btn btn-primary pull-right">Add New</a>
			<?php } ?>
			
		</h1>

	</section>
	<!-- Main content -->
	<section class="content">
		<!-- START ALERTS AND CALLOUTS -->
		<div class="row">
            <div class="col-md-6 col-md-push-6">
            	<?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"add") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"edit")) { ?>
				<form id="form_currency" action="" enctype="multipart/form-data" data-parsley-validate="">
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
								<label for="sequence">Currency</label>
								<input type="text" name="currency_name" class="form-control" id="currency_name" placeholder="Enter currency name" value="<?=isset($currency_name) ? $currency_name : '' ?>" pattern="[^'\x22]+" title="Invalid input" >
							</div>

							<div class="form-group">
								<label for="sequence">Is default?</label>
								<select name="is_default" class="form-control select2">
									<option value="n" <?=isset($is_default) && $is_default == 'y' ? 'selected' : '' ?>>No</option>
									<option value="y" <?=isset($is_default) && $is_default == 'y' ? 'selected' : '' ?>>Yes</option>
								</select>
							</div>
							
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<?php if(isset($id) && $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"edit")){ ?>
								<button type="submit" class="btn btn-primary form_btn module_save_btn">Update</button>
								<b style="color: #0974a7">Ctrl + S</b>
							<?php } elseif ($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"add")) { ?>
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
				<?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"view")) { ?>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">List</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<!---content start --->
						<table class="table table-striped table-bordered currency-table">
							<thead>
								<tr>
									<th>Action</th>
									<th>Currency</th>
									<th>Default ?</th>
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
		
		table = $('.currency-table').DataTable({
			"serverSide": true,
			"ordering": true,
			"searching": true,
			"aaSorting": [[1, 'asc']],
			"ajax": {
				"url": "<?php echo base_url('master/currency_datatable')?>",
				"type": "POST"
			},
			"scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT;?>',
			"scroller": {
				"loadingIndicator": true
			},
			"columnDefs": [
				
			]
		});

        shortcut.add("ctrl+s", function() {  
            $( ".module_save_btn" ).click();
        });

        
		$(document).on('submit', '#form_currency', function () {

			var currency_name=$('#form_currency').val();

			// if(currency_name=='')
			// {
			// 	show_notify("Currency Name can't empty", false);
			// 	return false;
			// }
			
			var postData = new FormData(this);
			$.ajax({
				url: "<?=base_url('master/save_currency') ?>",
				type: "POST",
				processData: false,
				contentType: false,
				cache: false,
				data: postData,
				success: function (response) {

                    
					var json = $.parseJSON(response);
					if (json['error'] == 'Exist') {
						show_notify("Currency Already Exist", false);
					}
					if (json['success'] == 'Added') {
						table.draw();
						$('#form_currency').find('input:text, textarea').val('');
						show_notify('Currency Successfully Added.', true);
					}
					if (json['success'] == 'Updated') {
						table.draw();
						$('#form_currency').find('input:text, select, textarea').val('');
						$(".form_btn").html('Save');
						$(".form_title").html('Add');
						$('input[name="id"]').val("");
						show_notify('Currency Successfully Updated.', true);
					}
					// return false;
				},
			});
			return false;
		});

		$(document).on("click",".delete_button",function(){
			if(confirm('Are you sure delete this records?')){
                $.ajax({
                    url: $(this).data('href'),
                    type: "POST",
                    data: 'id_name=id&table_name=currency_master',
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json['error'] == 'Error') {
                            show_notify('You cannot delete this Currency. This Currency has been used.', false);
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
