<style>
    button#btn_datepicker {
    display: none;
}
</style>
<?php $this->load->view('success_false_notify'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
        <h1>Ledger</h1>
    </section> -->
    <!-- Main content -->
    <section class="content p-l-r">
        <h2 class="mine-text text-center" style="background-color:#0035BE !important;">Ledger</h2>
        <div class="row captureimg" id="captureimg">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-inline">
                            <div class="col-md-2 col-lg-1">
                                <label for="email" class="">Date</label>
                            </div>
                            <?php
                            if(isset($_GET['from_date'])){
                                $from_date = $_GET['from_date'];
                            }else{
                                $from_date = get_financial_start_date_by_date();
                            }
                            
                            if(isset($_GET['to_date'])){
                                $to_date = $_GET['to_date'];
                            }else{
                                $to_date = date('d-m-Y');
                            }
                            ?>
                            <input type="hidden" name="" id="display" value="<?= isset($_GET['display'])?>">
                            
                            <div class="form-inline col-md-8">
                                <div class="form-group col-md-3 pl-0 ">
                                    <label>From : </label>
                                    <input type="text" name="daterange_1" id="datepicker1" class="form-control-border" value="<?php echo $from_date ; ?>" disabled>
                                </div>
                                <div class="form-group col-md-3 pl-0 ">
                                    <label>To : </label>
                                    <input type="text" name="daterange_2" id="datepicker2" class="form-control-border" value="<?php echo $to_date ; ?>" disabled>
                                </div>
                                <input type="hidden" name="" id="table_draw" value="0">
                                <input type="hidden" name="" id="no_of_rows" value="">
                                <button type="button" id="btn_datepicker" class="btn btn-submit">Submit</button>
                            </div>
                            <div class="form-inline col-md-2 text-right closing-model"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><label for="email" class=""></label></div><div class="col-md-4"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="account_id" class="col-md-2 col-lg-1" style="line-height: 30px;">Account</label>
                            <div class="col-md-4">
                                <select name="account_id" id="account_id" class="account_id select2-selection--single" required disabled></select>
                            </div>
                        </div>
                        <div class="form-group">
<!--<label for="base_currency_id" class="col-md-2" style="line-height: 30px;">Currenct Name</label>-->
                            <div class="col-md-2">
                                <select name="base_currency_id" id="base_currency_id" class="base_currency_id select2-selection--single" disabled></select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <a id="downloadLink" style="display: none;" download></a>
                <div class="box box-primary">
                    <div class="box-body">
                        <!---content start --->
                        <table class="table table-striped table-bordered ledger_table" id="ledger_table">
                            <thead>
                                <tr>
                                    <th class="action_btn"></th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <!-- <th>Account No.</th> -->
                                    <th>Notes</th>
                                    <th>ID No.</th>
                                    <!-- <th>Total Qty</th>
                                    <th>Vehicle No</th>
                                    <th>Unit</th> -->
                                    <th>Particular</th>
                                    <th>Opp Account</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
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
    $(document).ready(function () {
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        initAjaxSelect2($("#account_id"), "<?= base_url('app/account_select2_source_view/') ?>");
        initAjaxSelect2($("#base_currency_id"), "<?= base_url('app/currency_select2_source') ?>");

        <?php if (isset($account_id) && !empty($account_id)) { ?>
            setSelect2Value($("#account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $account_id) ?>");
        
            $(document).ready(function(){
                setTimeout(() => {
                    console.log("teststest gyan ", totalrows * 30 + 'px' );
                    $(".dataTables_scrollBody").css({ 'height': totalrows * 60 + 'px' });
                }, 500);
            client = $("#account_id option:selected").text();
            var selected_id = $("#account_id").val();
            $.ajax({
                url:"<?= base_url('transaction/get_curr_data') ?>",
                type: "post", dataType: "json", data: {acc_id: selected_id},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        var data = (rsp.data.length>0)?rsp.data[0]:null;
                        if(data!=null){
                            changeCurrSelection(data.currency_id);
                        }
                    }
                }
            });

        });
            setTimeout(function(){ $('#btn_datepicker').click()}, 20);
        <?php } ?>

        var client = 'All'
        $(document).on('change','#account_id', function(){
            client = $("#account_id option:selected").text();
            var selected_id = $("#account_id").val();
            $.ajax({
                url:"<?= base_url('transaction/get_curr_data') ?>",
                type: "post", dataType: "json", data: {acc_id: selected_id},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        var data = (rsp.data.length>0)?rsp.data[0]:null;
                        if(data!=null){
                            changeCurrSelection(data.currency_id);
                        }
                    }
                }
            });

        });

        function changeCurrSelection(currency_id){
            setSelect2Value($("#base_currency_id"), "<?= base_url('app/set_currency_account_select2_val_by_id/') ?>" + currency_id);
        }
        
        var title = 'Ledger For '+client+ '( From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() + ' )';

        var buttonCommon = {
            exportOptions: {
                format: { body: function ( data, row, column, node ) { return data.toString().replace(/(&nbsp;|<([^>]+)>)/ig, ""); } },
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
            }
        };
        var totalrows = 0;
        $(document).on('click', '#btn_datepicker', function () {
            if ($.trim($("#datepicker1").val()) == '') {
                show_notify('Please Select From Date.', false);
                $("#datepicker1").focus();
                return false;
            }
            if ($.trim($("#datepicker2").val()) == '') {
                show_notify('Please Select To Date.', false);
                $("#datepicker2").focus();
                return false;
            }
            if ($.trim($("#account_id").val()) == '') {
                show_notify('Please Select Account.', false);
                $("#account_id").focus();
                return false;
            }
            
            if ($('#table_draw').val() == '0') {
                $('#table_draw').val('1');
                table = $('.ledger_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                    ],
                    "serverSide": true,
                    "ordering": false,
                    "searching": false,
                    "bInfo": false,
                    "order": [[0, 'asc']],
                    "ajax": {
                        "url": "<?php echo base_url('report/ledger_datatable') ?>",
                        "type": "POST",
                        "data": function (d) {
                            d.daterange_1 = $('#datepicker1').val();
                            d.daterange_2 = $('#datepicker2').val();
                            d.account_id = $("#account_id").val();
                            d.display = $("#display").val();

                        },
                        
                        "dataSrc": function ( jsondata ) {
                            totalrows = jsondata.no_of_rows;
                            console.log('totalrows testestst 132', (totalrows*30)+'px');
                            if(jsondata.closing_amount <= 0){
                                $('.closing-model').html('<h3 class="red-text">Balance : '+ jsondata.closing_amount +'</h3>');
                            } else {
                                $('.closing-model').html('<h3 class="blue-text">Balance : '+ jsondata.closing_amount +'</h3>');
                            }

                            return jsondata.data;
                        }
                    },
                    
                    "scrollY": '"'+(totalrows*30)+'px'+'"',
                    "scroller": {
                        "loadingIndicator": true
                    },
                    "columnDefs": [

                        {"className": "text-right", "targets": [5,6,7,8,9]},

                    ]
                });
            } else {
                table.draw();                
            }
            data_table_export_icon_style();
        });

        $(document).on("click",".delete_button",function(){
            var value = confirm('Are you sure delete this record?');
            var tr = $(this).closest("tr");
            if(value){
                $.ajax({
                    url: $(this).data('href'),
                    type: "POST",
                    data: '',
                    success: function(data){
                        table.draw();
                        show_notify('Deleted Successfully!',true);
                    }
                });
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
<script>
        jQuery(window).on("load", function(){
            
            var client_image = $("#account_id option:selected").text();
            
            const divElement = document.querySelector('.row.captureimg');
            divElement.setAttribute('id', '');
                setTimeout(ledgerimage, 1000);
                
            });
   

    function ledgerimage () {
        
        const divElement = document.querySelector('.row.captureimg');
            divElement.setAttribute('id', 'captureimg');
        const screenShot = document.getElementById('captureimg');
        var client_image = $("#account_id option:selected").text();
        html2canvas(screenShot).then((canvas) => {
        const base64image = canvas.toDataURL("image/png");
        var anchor = document.createElement('a');
        anchor.setAttribute("href",base64image);
        anchor.setAttribute("download",client_image+".png");
        anchor.click();
        anchor.remove();

    });
    }
    
</script>
