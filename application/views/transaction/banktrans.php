<?php $this->load->view('success_false_notify'); ?>
<?php $segment2 = $this->uri->segment(2); ?>
<?php
    $page_parameter = '';
    $page_title = '';
    if ($segment2 == 'receipt') {
        $page_parameter = 'receipt';
        $page_title = 'Receipt : ';
    } else if ($segment2 == 'payment') {
        $page_parameter = 'payment';
        $page_title = 'Payment : ';
    }
?>
<style>
.content-header { padding: 5px 15px 0 15px; }
#txtNotes { resize: none;  width: 100%;}
pre {color: #ff0000;}
.fc-80{ width: 80px !important; }
.fc-120{ width: 120px !important; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content p-l-r">
        <h2 class="mine-text text-center">Swipe</h2>
        <!-- START ALERTS AND CALLOUTS -->
        <div class="row">
            <div class="col-md-12">
                <form id="form_transaction" class="" action="<?= base_url('transaction/save_banktransaction') ?>" method="post" enctype="multipart/form-data" data-parsley-validate="" >
                    <?php if (isset($transaction_data['transaction_id']) && !empty($transaction_data['transaction_id'])) { ?>
                        <input type="hidden" name="transaction_id" class="transaction_id" value="<?= $transaction_data['transaction_id'] ?>">
                    <?php } ?>
                    <?php if($segment2 == 'payment') { ?>
                        <input type="hidden" name="transaction_type" class="transaction_id" value="1">
                    <?php } else { ?>
                        <input type="hidden" name="transaction_type" class="transaction_id" value="2">
                    <?php } ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">

                            <h3 class="box-title form_title"><?= isset($transaction_data['transaction_id']) ? 'Edit '.$page_title : 'Add '.$page_title ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row gy-3">
                                <div class="clearfix"></div>
                                <div class="col-md-4">


                                    <label for="account_id">Name</label>
                                    <select name="account_id" id="account_id" class="form-control select2">
                                    </select>
                                    <input type="hidden" name="account_name" id="account_name">
                                </div>
                                <?php
                                if(isset($transaction_data['account_mobile_numbers'])){
                                    ?>
                                        <div class="col-md-2">
                                            <label for="txtMobile">Mobile</label>
                                            <input type="text" pattern="[0-9]{10}" class="form-control fc-120" id="txtMobile" value="<?= isset($transaction_data['account_mobile_numbers']) ? $transaction_data['account_mobile_numbers'] : '' ?>"  name="txtMobile" placeholder="0123456789">
                                        </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="col-md-2">
                                        <label for="txtMobile">Mobile</label>
                                        <input type="text" pattern="[0-9]{10}" class="form-control fc-120" id="txtMobile" value=""  name="txtMobile" placeholder="0123456789">
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-md-1">
                                    <label for="txtClientPercentage">Client (%)</label>
                                    <input type="number" class="form-control fc-80" id="txtClientPercentage" name="txtClientPercentage" placeholder="0.00" value="<?= isset($transaction_data['client_perc']) ? $transaction_data['client_perc'] : '3.00' ?>" data-parsley-type="number" step="0.01" required>
                                </div>
                                <div class="col-md-3">&nbsp;</div>
                                <div class="col-md-2 text-end">
                                    <label for="txtDate">Date</label>
                                    <input type="date" class="form-control input-datepicker" id="txtDate" name="txtDate" placeholder=""
                                    value="<?= (isset($transaction_data['transaction_date'])) ? $transaction_data['transaction_date'] : $transaction_data['transaction_date']; ?>">
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-2">
                                    <label for="txtCash">Cash</label>
                                    <input type="number" class="form-control fc-120" id="txtCash" name="txtCash" placeholder="0.00" value="<?= isset($transaction_data['cash_amount']) ? $transaction_data['cash_amount'] : '' ?>" data-parsley-type="number" step="0.01">
                                </div>
                                <div class="col-md-2">
                                    <label for="txtActualPaid">Actual Paid</label>
                                    <input type="number" class="form-control fc-120" id="txtActualPaid" name="txtActualPaid" placeholder="0.00" value="<?= isset($transaction_data['cash_amount']) ? $transaction_data['cash_amount'] : '' ?>" data-parsley-type="number" step="0.01" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="drpCash">Our Cash Acc</label>
                                    <select class="form-control select2" id="drpCash" name="drpCash"></select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-2">
                                    <label for="txtSwipe">Or Swipe</label>
                                    <input type="number" class="form-control fc-120" id="txtSwipe" name="txtSwipe" value="<?= isset($transaction_data['swipe_amount']) ? $transaction_data['swipe_amount'] : '' ?>" placeholder="0.00" data-parsley-type="number" step="0.01">
                                </div>
                                <div class="col-md-2">
                                <label for="txtActualSwipe">Actual Swipe</label>
                                    <input type="number" class="form-control fc-120" id="txtActualSwipe" name="txtActualSwipe" value="<?= isset($transaction_data['swipe_amount']) ? $transaction_data['swipe_amount'] : '' ?>" placeholder="0.00" data-parsley-type="number" step="0.01" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="drpMachine">Machine Used</label>
                                    <select class="form-control select2" id="drpMachine" name="drpMachine"></select>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <label for="drpAgent">Agent</label>
                                    <select class="form-control select2" id="drpAgent" name="drpAgent"></select>
                                </div>
                                <div class="col-md-4">
                                    <label for="drpBank">Bank</label>
                                    <select class="form-control select2" name='drpBank' id="drpBank" disabled></select>                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div class="col-md-2">
                                    <label for="txtAgentCommission">Agent Commission (%)</label>
                                    <input type="number" class="form-control fc-120" id="txtAgentCommission" name="txtAgentCommission" value="<?= isset($transaction_data['agent_percentage']) ? $transaction_data['agent_percentage'] : '' ?>" placeholder="0.00" data-parsley-type="number" step="0.01" value='0.0'>
                                </div>
                                <div class="col-md-2">
                                    <label for="txtAgentAmount">Agent Amount</label>
                                    <input type="number" class="form-control fc-120" id="txtAgentAmount" name="txtAgentAmount" value="<?= isset($transaction_data['agent_commission']) ? $transaction_data['agent_commission'] : '' ?>" readonly data-parsley-type="number" step="0.01" value='0.0'>
                                </div>
                                <div class="col-md-2">
                                    <label for="txtBankCharges">Bank (%)</label>
                                    <input type="number" class="form-control fc-80" id="txtBankCharges" name="txtBankCharges" value="<?= isset($transaction_data['bank_percentage']) ? $transaction_data['bank_percentage'] : '' ?>" placeholder="0.00" data-parsley-type="number" step="0.01" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="vimg">Upload Verification Image</label>
                                    <input type="file" name="vimgs[]" class="form-control img-file-control" multiple='multiple' accept="image/*">
                                </div>

                                <div class="col-md-3">
                                    <label for="txtNotes">Transaction Notes</label><br>
                                    <textarea name="txtNotes" id="txtNotes" name="txtNotes"><?= isset($transaction_data['transaction_note']) ? $transaction_data['transaction_note'] : '' ?></textarea>
                                </div>
                                <input type="hidden" name="transaction_id_last" id="transaction_id_last" value="<?= isset($transaction_data['transaction_id_last']) ? $transaction_data['transaction_id_last'] : '' ?>" />
                                <input type="hidden" name="tag" id="tag" value="<?= isset($transaction_data['tag']) ? $transaction_data['tag'] : '' ?>" />
                                <div class="clearfix"></div>

                                <div class="col-md-4">
                                    <label>Previous Images</label>
                                    <div class='thumb-gallery'></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Last Transactions:</label>
<pre id='prev_transactions'>  
</pre>
                                </div>               
                                           
                                <div class="clearfix"></div>                                
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm form_btn module_save_btn" ><?= isset($transaction_data->transaction_id) ? 'Update' : 'Save' ?></button>
                            <b style="color: #0974a7">Ctrl + S</b>
                        </div>
                    </div>
                    <div id="myModal_detail" class="modal fade" role="dialog">
                        <div class="modal-dialog" style="width: 80%;">
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Sales Invoices</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box-body table-responsive">
                                        <table id="detail_table" class="table table-bordered table-striped" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Invoice No</th>
                                                    <th>Invoice Date</th>
                                                    <th style="text-align: right;">Invoice Amount</th>
                                                    <th style="text-align: right;">Paid Amount</th>
                                                    <th style="text-align: right;">Pending Amount</th>
                                                    <th style="text-align: right;">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body_detail_table">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: right;"><b>Total</b></td>
                                                    <td style="text-align: right; font-weight: 600;" class="foot"><b>0</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.box-body -->
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END ALERTS AND CALLOUTS -->
    </section>
    <!-- /.content -->
</div>
<input type="hidden" value="0" id="is_edit">
<!-- /.content-wrapper -->
<script type="text/javascript">
    
    $(document).ready(function () {
        var checked_invoice_ids = [];
        var unchecked_invoice_ids = [];
        //KAJAL        
        initAjaxSelect2wTag($("#account_id"), "<?= base_url('app/account_select2_source/'.SWIPE_ACCOUNT_GROUP_ID) ?>"); 
        initAjaxSelect2($("#drpBank"), "<?= base_url('app/our_bank_label_select2_source') ?>"); 
        initAjaxSelect2($("#drpAgent"), "<?= base_url('app/our_agent_label_select2_source') ?>"); 
        initAjaxSelect2($("#drpCash"), "<?= base_url('app/cash_only_account_select2_source') ?>");
        initAjaxSelect2($("#drpMachine"), "<?= base_url('app/swipe_machine_source') ?>");
        initAjaxSelect2($("#site_id"), "<?= base_url('app/sites_select2_source') ?>");

        setSelect2Value($("#drpCash"), "<?= base_url('app/set_account_select2_val_by_id/' . DEFAULT_OFFICE_CASH_ACCOUNT_ID) ?>");

        <?php
            if(isset($transaction_data['cash_id']) && !empty($transaction_data['cash_id']))
            {
        ?>
              setSelect2Value($("#drpCash"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data['cash_id']) ?>");
        <?php
            }
            if(isset($transaction_data['machine_id']) && !empty($transaction_data['machine_id']))
            {
        ?>
              setSelect2Value($("#drpMachine"), "<?= base_url('app/set_swipe_machine_val_by_id/' . $transaction_data['machine_id']) ?>");
        <?php
            }
            if(isset($transaction_data['agent_id']) && !empty($transaction_data['agent_id']))
            {
        ?>
              setSelect2Value($("#drpAgent"), "<?= base_url('app/set_agent_select2_val_by_id/' . $transaction_data['agent_id']) ?>");
        <?php
            }
            if(isset($transaction_data['bank_id']) && !empty($transaction_data['bank_id']))
            {
        ?>
            setSelect2Value($("#drpBank"), "<?= base_url('app/set_bank_account_select2_val_by_id/' . $transaction_data['bank_id']) ?>");
        <?php
            }
            if(isset($transaction_data['client_id']) && !empty($transaction_data['client_id']))
            {
            ?>
              setSelect2Value($("#account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data['client_id']) ?>");
        <?php
            }
        ?>
            <?php if (isset($transaction_data->from_account_id) && !empty($transaction_data->from_account_id)) { ?>
            <?php if($segment2 == 'payment') { ?>
                setSelect2Value($("#bank_account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data->from_account_id) ?>");
            <?php } else { ?> 
                $('#is_edit').val('1');
                //setSelect2Value($("#account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data->from_account_id) ?>");
            <?php } ?>
        <?php } ?>     
        
        <?php if (isset($transaction_data->to_account_id) && !empty($transaction_data->to_account_id)) { ?>
            <?php if($segment2 == 'payment') { ?>
                setSelect2Value($("#account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data->to_account_id) ?>");
            <?php } else { ?>

                setSelect2Value($("#bank_account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data->to_account_id) ?>");
                setSelect2Value($("#account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data->to_account_id) ?>");

    <?php } ?>
        <?php } ?>

        // setTimeout(function(){
        //     $('#account_id').select2('open');
        // },100);

                                                // $(document).on('click', '.select_invoice', function() {
                                                //     get_invoice_data();
                                                // });

                                                // $(document).on('change', '.select_invoice', function() {
                                                //     get_invoice_data();
                                                // });
                   
        $(document).on('keydown','#amount', function(e) {
            if (e.keyCode == 13) {
                $('#account_id').select2('open');
            }
        });

        shortcut.add("ctrl+s", function() {  
            $( ".module_save_btn" ).click();
        });
                                                // $('#account_id').on("select2:close", function(e) { 
                                                //     $("#amount").focus();
                                                // });

                                                // $('#bank_account_id').on("select2:close", function(e) { 
                                                //     $("#datepicker1").focus();
                                                // });
        $('#form_transaction').submit(function(e){            
            if($('#txtCash').val()=='') $('#txtCash').val('0.00');
            if($('#txtSwipe').val()=='') $('#txtSwipe').val('0.00');
            data = $('#account_id').select2('data');
            if(data[0].id =='-1') $('#account_name').val(data[0].text);
            if(valid_form()){ 
                $( "#drpBank" ).prop( "disabled", false );
                $( "#txtAgentAmount" ).prop( "disabled", false );
                return true;
            } else {
                e.preventDefault(e);
                return false;
            }
        }
        );
        function valid_form(){    
            if ($.trim($("#txtAgentCommission").val()).length==0) {
                $("#txtAgentCommission").val('0.00');
                $("#txtAgentAmount").val('0.00');
            }

            if($.trim($("#account_id").val()).length==0 && $.trim($("#txtMobile").val()).length==0){
                show_notify('Select Customer or provide mobile number.', false);
                $("#account_id").focus();
                return false;
            } else if ($.trim($("#txtDate").val()) == '') {
                show_notify('Please Select Date.', false);
                $("#txtDate").focus();
                return false;
            } else if ($.trim($("#txtActualPaid").val()).length==0 || parseFloat($.trim($("#txtActualPaid").val()))==0) {
                show_notify('Please Enter Actual Amount.', false);
                $("#txtActualPaid").focus();
                return false;
            } else if ($.trim($("#txtActualSwipe").val()).length==0 || parseFloat($.trim($("#txtActualSwipe").val()))==0) {
                show_notify('Please Enter Actual Swiped Amount.', false);
                $("#txtActualSwipe").focus();
                return false;
            } else if ($.trim($("#txtClientPercentage").val()).length==0 || parseFloat($.trim($("#txtClientPercentage").val()))==0) {
                show_notify('Please Enter Client Percentage.', false);
                $("#txtClientPercentage").focus();
                return false;
            } else if ($.trim($("#txtBankCharges").val()).length==0 || parseFloat($.trim($("#txtBankCharges").val()))==0) {
                show_notify('Please Enter Bank Percentage.', false);
                $("#txtBankCharges").focus();
                return false;
            } else if ($.trim($("#drpMachine").val()) == '') {
                show_notify('Please select Machine.', false);
                $("#drpMachine").focus();
                return false;
            } else if($.trim($("#drpCash").val()).length==0){
                show_notify('Select a Cash Account.', false);
                $("#drpCash").focus();
                return false;
            } else return true;
        }

//        $(document).on('click', '.view_detail', function () {
//            $('#clicked_item_id').val($(this).attr('data-client_id'));
//            detail_table.draw();
//            $('#myModal_detail').modal('show');
//        });

    $("#drpMachine").on("change",function(){
        //25102022
        var selected_id = $("#drpMachine").val();
        $.ajax({
            url:"<?= base_url('transaction/get_machine_bank_data') ?>",
            type: "post", dataType: "json", data: {mach_id: selected_id},
            success: function(rsp){
                if(rsp.status=='OK'){
                    var data = (rsp.data.length>0)?rsp.data[0]:null;
                    if(data!=null){
                        changeBankSelection(data.bank_acc_id, data.bank_commission);
                    }
                }
            }
        });
    });
        // $(document).on('input', '.invoice_check_box', function(){
        //     get_sum_selected();
        // });
  
        fillDate();
        $('#txtCash').keyup(valueChanged);
        $('#txtSwipe').keyup(valueChanged);
        $('#txtActualPaid').keyup(reviseDifference);
        $('#txtActualSwipe').keyup(reviseDifference);
        $('#txtCash').focus(function(){ $(this).select(); });
        $('#txtSwipe').focus(function(){ $(this).select(); });
        $('#txtActualPaid').focus(function(){ $(this).select(); });
        $('#txtActualSwipe').focus(function(){ $(this).select(); });
        $('#txtAgentCommission').focus(function(){ $(this).select(); });
        $('#txtBankCharges').focus(function(){ $(this).select(); });
        $('#txtClientPercentage').focus(function(){ $(this).select(); });
        // $('.img-file-control').focus(function(){ $(this).click(); });

        $("#txtMobile").focusout(checkMobileNumber);        
        $('#txtAgentCommission').focusout(reviseDifference);
        $("#account_id").on('select2:select',function(e){
            loadClientTransactionDetails();
        });

        setTabOrder();
    });
    
    function setTabOrder(){
        var tab=1;
        $('#account_id').attr('tabindex',tab++);
        $('#txtMobile').attr('tabindex',tab++);
        $('#txtClientPercentage').attr('tabindex',tab++);
        $('#txtCash').attr('tabindex',tab++);
        $('#txtActualPaid').attr('tabindex',tab++);
        $('#drpCash').attr('tabindex',tab++);
        $('#txtSwipe').attr('tabindex',tab++);
        $('#txtActualSwipe').attr('tabindex',tab++);
        $('#drpMachine').attr('tabindex',tab++);
        $('#drpAgent').attr('tabindex',tab++);
        $("#drpAgent").on('select2:select',function(e){
            if($('#drpAgent').val()==-1) $('.img-file-control').focus();
            else $('#txtAgentCommission').focus();
        });
        $("#drpAgent").focusout(function(e){
            console.log($('#drpAgent').val());
            $('.img-file-control').focus();
        });
        $('.img-file-control').attr('tabindex',tab++);
        $('#txtAgentCommission').attr('tabindex',tab++);
        $('#txtBankCharges').attr('tabindex',tab++);
        $('#txtNotes').attr('tabindex',tab++);
        $('.module_save_btn').attr('tabindex',tab);
    }

    function changeBankSelection(bank_acc_id,bank_commission){
        setSelect2Value($("#drpBank"), "<?= base_url('app/set_bank_account_select2_val_by_id/') ?>" + bank_acc_id);
        $('#txtBankCharges').val(bank_commission);        
    }
    
    function get_invoice_data(){
        $('.foot').text('0');
            var bill_wise = "<?php echo $this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')['is_bill_wise']; ?>";
            var tr_id = "<?= (isset($transaction_data->transaction_id)) ? $transaction_data->transaction_id : ''; ?>";
            if(bill_wise == '1'){
                var from_account_id = $('.from_account_id').val();
                $.ajax({
                    url: "<?= base_url('transaction/get_invoice_data') ?>",
                    type: "POST",
                    data: {account_id: from_account_id, tr_id: tr_id, rec_amount: $('#amount').val()},
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json['invoice_data'] != '') {
                            if($('#is_edit').val() == '0'){
                                $('#myModal_detail').modal('show');
                            } else {
                                $('#is_edit').val('0');
                            }
                            var row_html = "";
                            $.each(json['invoice_data'], function (index, value) {
                                new_amt = '';
                                if(value.new_amount){
                                    new_amt = value.new_amount;
                                }
                                row_html += "<tr class='tr_row'>\n\
                                        <td>"+value.sales_invoice_no+"</td>\n\
                                        <td>"+value.sales_invoice_date+"</td>\n\
                                        <td class='' style='text-align: right;'>"+value.bill_amount+"</td>\n\
                                        <td class='' style='text-align: right;'>"+value.paid_amount+"</td>\n\
                                        <td class='' style='text-align: right;'>"+value.pending_amount+"</td>\n\
                                        <td>\n\
                                            <input name='invoice_amount["+value.sales_invoice_id+"]' type='text' data-max_amt='"+value.pending_amount+"' class='num_only in_amount invoice_check_box pull-right' value='"+new_amt+"'>\n\
                                        </td>\n\
                                    </tr>";
                            });
                            $('#myModal_detail').modal('show');
                            $('.body_detail_table').html(row_html);
                            get_sum_selected();
                        }
                        return false;
                    },
                });
            }
    }
    
    function get_sum_selected(){
        var total_amt = 0;
        $('.body_detail_table .tr_row').each(function() {
            if(typeof $(this) === 'undefined'){ } else {
                var value_a = $(this).find("input").val();
                if(typeof value_a === 'undefined'){ } else {
                    if(value_a == ''){ } else {
                        if(parseInt($(this).find("input").val()) > parseInt($(this).find("input").data('max_amt'))){
                            show_notify('Amount can not greater than Pending Amount.', false);
                            $(this).find("input").val('');
                        } else {
                            total_amt = total_amt + parseInt($(this).find("input").val());
                        }
                    }
                }
            }
        });
        $('.foot').text(total_amt);
//        $('#amount').val(total_amt);
    }



function fillDate(){
  var fullDate = new Date();
  var twoDigitMonth = (fullDate.getMonth()<=8)?('0' + (fullDate.getMonth()+1)):(fullDate.getMonth()+1);
  var twoDigitDate = (fullDate.getDate()<=9)?('0'+fullDate.getDate()):fullDate.getDate();
  var currentDate = fullDate.getFullYear() + '-' + twoDigitMonth + "-" + twoDigitDate;
  $("#txtDate").attr("placeholder", currentDate);

  <?php if(!isset($transaction_data['transaction_date']) && empty($transaction_data['transaction_date'])) {?>
    $("#txtDate").val(currentDate);
  <?php } ?>
}

function valueChanged(){
  var cash = $('#txtCash');
  var swipe = $('#txtSwipe');
  var apd=$('#txtActualPaid');
  var aswp=$('#txtActualSwipe');
  var client = $('#txtClientPercentage');
  if(this.id=='txtCash') {
    swipe.val(((parseFloat(cash.val())*100)/(100-parseFloat(client.val()))).toFixed(2));
    apd.val(cash.val());
    aswp.val(swipe.val());
  } else {    
    cash.val((parseFloat(swipe.val())-(parseFloat(swipe.val())*parseFloat(client.val())/100)).toFixed(2));
    apd.val(cash.val());
    aswp.val(swipe.val());
  }
}

function reviseDifference() {
    var tclPer=$('#txtClientPercentage');
    var agt=$('#txtAgentAmount');
    var cmsn=$('#txtAgentCommission');
    var apd=$('#txtActualPaid');
    var aswp=$('#txtActualSwipe');

    if (tclPer.val()=='') tclPer.val('0.00');
    if (apd.val()=='') apd.val('0.00');
    if (aswp.val()=='') aswp.val('0.00');
    if (cmsn.val()=='') agt.val('0.00');
    
    agt.val(((parseFloat(apd.val())*parseFloat(tclPer.val() - cmsn.val()))/100).toFixed(2));
}

function checkMobileNumber() {
    if($.trim($("#txtMobile").val()).length>=10) {
        var strMobile = $.trim($("#txtMobile").val());
        setSelect2Value($("#account_id"), "<?= base_url('app/mobile_clinet_from_transaction/') ?>" + strMobile);  
        $("#account_id").trigger("change");
        loadClientTransactionDetails();
        $("#txtMobile").val(strMobile);
    }
}
function setClientTransactionDetails(){
    $("#txtMobile").val('');
    $.ajax({
        url: "<?=base_url('app/bank_transaction_details/')?>" + $("#account_id").val(),
        dataType: "json",
        type: "post",
        success: function(res){           
            
            var trans = res.transaction;
            var cfg  = res.config;
            if(trans.length>0){
                // $("#txtAgentCommission").val(trans[0]["agent_perc"]);
                $("#txtClientPercentage").val(trans[0]["client_perc"]);
                // changeMachineSelection(trans[0]["mach_id"], trans[0]["bank_perc"]);
            }
            var html = '';
            var trans_date = '';
            var agent_name = '';
            var cash,swipe = 0;

            $("#drpBank").val(null).trigger('change');
            setSelect2Value($("#drpCash"), "<?= base_url('app/set_account_select2_val_by_id/' . $transaction_data->from_account_id) ?>");
                $("#drpCash").trigger('change');
            $.each(trans,function(k,v){
                if(parseInt(v.to_account_id)==parseInt($("#account_id").val())){                    
                    setSelect2Value($("#drpCash"), "<?= base_url('app/set_account_select2_val_by_id/') ?>" + v.from_account_id);
                    cash=parseFloat(v.amount).toFixed(2);
                } else if(parseInt(v.from_account_id)==parseInt($("#account_id").val())){
                    swipe=parseFloat(v.amount).toFixed(2);
                    if(!$.isEmptyObject(v.from_mobile_numbers)){
                        var nums = v.from_mobile_numbers;
                        $("#txtMobile").val($.trim(nums.split(',')[0]));
                    } else $("#txtMobile").val('');
                } else if(parseInt(v.to_account_id)==parseInt(cfg.agent_commission_id)){
                    var url = "<?= base_url('app/set_agent_select2_val_by_id/') ?>" + v.from_account_id;
                    agent_name=v.from_name;
                    setSelect2Value($("#drpAgent"), url);
                } else if(parseInt(v.to_account_id)==parseInt(cfg.bank_commission_id)){
                    setSelect2Value($("#drpBank"), "<?= base_url('app/set_account_select2_val_by_id/') ?>" + v.from_account_id);
                }
                trans_date = v.transaction_date;
            });
            if(trans.length>0){
                var fullDate = new Date(trans_date);
                var month_names = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                var twoDigitDate = (fullDate.getDate()<=9)?('0'+fullDate.getDate()):fullDate.getDate();
                $("#prev_transactions").html(twoDigitDate + '-' + month_names[fullDate.getMonth()] + '-' + fullDate.getFullYear().toString().substr(2,2)
                    + ' ' + agent_name + ' ₹' + cash + ' cash, on swipe ₹' + swipe);     
            } else {
                $("#prev_transactions").html('No Transaction.')
            }
            showPreviousUploadedImages();
        }
    });
}

function changeMachineSelection(machineID,bank_commission){
    setSelect2Value($("#drpMachine"), "<?= base_url('app/set_swipe_machine_val_by_id/') ?>" + machineID);
    $('#txtBankCharges').val(bank_commission);        
}

function loadClientTransactionDetails(){
    setClientTransactionDetails();    
}

function showPreviousUploadedImages(){
    $.ajax({
        url: "<?=base_url('app/get_client_images/')?>" + $("#account_id").val(),
        dataType: "json",
        type: "post",
        success: function(res){  
            $('.thumb-gallery').html("");
            $.each(res,function(k,imgsrc){
                $('<img />').attr('src',imgsrc).appendTo('.thumb-gallery');
            });
            if(res.length>0){}
        }
    });
}
</script>
