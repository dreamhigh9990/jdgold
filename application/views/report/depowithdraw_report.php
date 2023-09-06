<?php $this->load->view('success_false_notify'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h2 class="mine-text text-center">Deposit Withdraw</h2>
    </section>
    <!-- Main content -->
    <style>
        .d-flex
        {
            display:flex;
        }
        textarea{
            color:#000;
        }
        input.row_multiplier {
            color: black;
        }
    </style>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        
                        <div class="row align-item-center">
                            
                            <?php
                               $from_date = get_financial_start_date_by_date();
                            ?>
                            <div class="col-md-2">

                                    
                                
                                    <label class="">Date From : </label>
                                    
                                    <input type="text" name="daterange_1" id="datepicker1" class="form-control-border" value="<?php echo date('d-m-Y') ; ?>">
                                    
                                   
                            
                            </div>

                            <div class="col-md-2">
                                    <label class="">To : </label>
                                    
                                    <input type="text" name="daterange_2" id="datepicker2" class="form-control-border" value="<?php echo date('d-m-Y') ; ?>">
                                     
                            </div>

                            <div class="col-md-2">
                                
                                        <label class="col-form-label">IB:</label>

                                        
                                        
                                        <select name="account_id" id="account_id" class="select2-selection--single account_id"></select>
                                        
                                    
                                
                            </div>
                            <!-- <div class="col-md-2">
                               

                                    
                                    <label for="sub_account_id" class="" >Responsible Account</label>
                                    
                                    
                                    <select name="sub_account_id" id="sub_account_id" class="sub_account_id account_id select2-selection--single"></select>
                                    
                                    
                                
                            </div> -->
                            <div class="col-md-1">
                                <button type="button" id="btn_datepicker" class="btn btn-submit">Submit</button>
                            </div>
                            <!-- <div class="col-md-3" style="padding-top: 22px;">

                                <label class="total_credit_amt " style="color:#3B71CA;margin-right:15px;line-height:28px;"></label>
                                    
                                    
                                <label class="total_debit_amt" style="color:#DC4C64;line-height:28px;"></label>
                                        
                                    
                                
                            </div> -->
                                <input type="hidden" name="" id="table_draw" value="0">
                                <input type="hidden" name="" id="update_ib_account_id" value="update_ib_account_id">
                            </div>
                        </div>
                        <div class="form-inline col-md-12">
                            <div class="col-md-2"><label for="email" class=""></label></div><div class="col-md-4"></div>
                        </div>
                        

                        
                        
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <!---content start --->
                        <table class="table table-striped table-bordered ledger_table" id="ledger_table">
                            <thead>
                                <tr>
                                    <!-- <th>Action</th> -->
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Account No</th>
                                    <th>Withdraw</th>                                    
                                    <th>Deposit</th>
                                    <th>Ib</th>
                                    <th>Multiplier | Note</th>
                                    <th>Responsible Account</th>
                                    <!-- <th>Other Data</th> -->
                                    <th></th>

                                    <th>IB Name</th>
                                    <th>Responsible Name</th>

                                    <th>Voucher Id</th>
                                    <th>Account Name</th>
                                    <!-- <th>Account Name</th> -->
                                    
                                    <!-- <th>Balance</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                  <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th id="wi">Total Withdraw</th>                                    
                                    <th id="de">Total Deposit</th>
                                    <th id="totalEntries">Total Entries</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                    <th></th>
                                    <th></th>

                                    <th></th>
                                    <th></th>
                  </tr>
                  </tfoot>
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
<style>
input[name="ischecked"] {
    display: none;
}
th:nth-child(8), td:nth-child(8) {
    display: none;
}
.ledger_table tr, .ledger_table td {
    font-family: 'TimesNewRoman';
    font-weight: bold;
}
.ledger_table th:nth-child(4), .ledger_table td:nth-child(4) {
    color: #a94442;
}
.ledger_table th:nth-child(5), .ledger_tabletd:nth-child(5) {
    color: #31708f;
}
</style>
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    $(document).ready(function () {
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        initAjaxSelect2($("#sub_account_id"), "<?= base_url('app/account_select2_source/') ?>");

        <?php if (isset($sub_account_id) && !empty($sub_account_id)) { ?>
            setSelect2Value($("#sub_account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $sub_account_id) ?>");
            //$("#btn_datepicker").trigger('click');
            setTimeout(function(){ $('#btn_datepicker').click()}, 20);
            //$('#btn_datepicker').click();
        <?php } ?>


            

        initAjaxSelect2($("#account_id"), "<?= base_url('app/account_select2_source/'.IB_GROUP_ID) ?>");
        <?php if (isset($account_id) && !empty($account_id)) { ?>
            setSelect2Value($("#account_id"), "<?= base_url('app/set_account_select2_val_by_id/' . $account_id) ?>");
            //$("#btn_datepicker").trigger('click');
            setTimeout(function(){ $('#btn_datepicker').click()}, 20);
            //$('#btn_datepicker').click();
        <?php } ?>

        var client = 'All'
        $(document).on('change','#account_id', function(){
            client = $("#account_id option:selected").text();
        });
        
        var title = 'Ledger For '+client+ '( From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() + ' )';

        var buttonCommon = {
            exportOptions: {
                format: { body: function ( data, row, column, node ) { return data.toString().replace(/(&nbsp;|<([^>]+)>)/ig, ""); } },
                columns: [0, 1, 2, 3, 4, 8, 9],
            }
        };

        

        $(document).on('click', '#btn_datepicker', function () {
            var total_withdraw_entries = 0;
            var total_deposit_entries = 0;

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
            // if ($.trim($("#account_id").val()) == '') {
            //     show_notify('Please Select Account.', false);
            //     $("#account_id").focus();
            //     return false;
            // }

            $('.total_credit_amt').html("");
            $('.total_debit_amt').html("");
            
            if ($('#table_draw').val() == '0') {
                $('#table_draw').val('1');
                table = $('.ledger_table').DataTable({
                    columnDefs: [
                        { targets: [3,4], className: 'text-right' },
                        { targets: [3,4], className: 'text-right' },
                        { target: 9, visible: false },
                        { target: 10, visible: false }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        $.extend( true, {}, buttonCommon, { extend: 'copy', title: function () { return (title)}, action: newExportAction } ),
                        $.extend( true, {}, buttonCommon, { extend: 'csvHtml5', title: function () { return (title)}, action: newExportAction, customize: function (csv) {
                                                    return 'Ledger For '+client+ '( From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() + ' )\n\n'+  csv;
                                                } } ),
                        $.extend( true, {}, buttonCommon, { extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL', title: function () { return (title)}, action: newExportAction,
                            customize : function(doc){
                                var objLayout = {};
                                // objLayout['hLineWidth'] = function(i) { return .5; };
                                //objLayout['vLineWidth'] = function(i) { return .5; };
                                doc.content[1].layout = objLayout;

                                // @ VIPUL BHAI (Width set Karvani Pan Jetali Column Hoy Etali Value Apavani Hati Like Apane 10 col batavi to 9 time "9%" avyu)
                                
                                doc.content[1].table.widths = ["9%","9%","9%","9%","9%","9%"]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                                var rowCount = document.getElementById("ledger_table").rows.length;

                                for (i = 1; i < rowCount; i++) {
                                    doc.content[1].table.body[i][3].alignment = 'right';

                                    doc.content[1].table.body[i][4].alignment = 'right';
                                    doc.content[1].table.body[i][5].alignment = 'right';
                                    // doc.content[1].table.body[i][6].alignment = 'right';
                                    text_name = '';
                                    text_o = doc.content[1].table.body[i][1].text;
                                    text_name = $.trim(text_o);;
                                    doc.content[1].table.body[i][1].text = text_name;
                                    // console.log(doc.content[1].table.body[i][1].text);
                                };
                            }
                        } ),
                        $.extend( true, {}, buttonCommon, { extend: 'excelHtml5', title: function () { return (title)}, action: newExportAction ,

                            customize : function (xlsx) {

                                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                var downrows = 4;
                                var clRow = $('row', sheet);
                                //update Row
                                clRow.each(function () {
                                    var attr = $(this).attr('r');
                                    var ind = parseInt(attr);
                                    ind = ind + downrows;
                                    $(this).attr("r",ind);
                                });

                                // Update  row > c
                                $('row c ', sheet).each(function () {
                                    var attr = $(this).attr('r');
                                    var pre = attr.substring(0, 1);
                                    var ind = parseInt(attr.substring(1, attr.length));
                                    ind = ind + downrows;
                                    $(this).attr("r", pre + ind);
                                });

                                function Addrow(index,data) {
                                    msg='<row r="'+index+'">'
                                    for(i=0;i<data.length;i++){
                                        var key=data[i].k;
                                        var value=data[i].v;
                                        msg += '<c t="inlineStr" r="' + key + index + '" s="42">';
                                        msg += '<is>';
                                        msg +=  '<t>'+value+'</t>';
                                        msg+=  '</is>';
                                        msg+='</c>';
                                    }
                                    msg += '</row>';
                                    return msg;
                                }
                                //insert
                                var r1 = Addrow(1, [{ k: 'A', v: 'Client :' }, { k: 'B', v: client }]);
                                var r2 = Addrow(2, [{ k: 'A', v: 'From :' }, { k: 'B', v: $('#datepicker1').val() }]);
                                var r3 = Addrow(3, [{ k: 'A', v: 'To :' }, { k: 'B', v: $('#datepicker2').val() }]);

                                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3  + sheet.childNodes[0].childNodes[1].innerHTML;
                            }
                        }),
                        $.extend( true, {}, buttonCommon, { extend: 'print',  title: function () { return (title)},
                        customize : function(win){
                            $(win.document.body).find('table thead th:nth-child(3)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'right');
                            $(win.document.body).find('table thead th:nth-child(4)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'right');
                            $(win.document.body).find('table thead th:nth-child(5)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(5)').css('text-align', 'right');
                            $(win.document.body).find('table thead th:nth-child(6)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(6)').css('text-align', 'right');
                        }, action: newExportAction } ),
                    ],
                    "serverSide": true,
                    "ordering": false,
                    "searching": false,
                    "bInfo": false,
                    "ajax": {
                        "url": "<?php echo base_url('report/depowithdraw_datatable_new') ?>",
                        "type": "POST",
                        "data": function (d) {
                            d.daterange_1 = $('#datepicker1').val();
                            d.daterange_2 = $('#datepicker2').val();
                            d.account_id = $("#account_id").val();
                            d.sub_account_id=$("#sub_account_id").val();
                            d.update_ib_account_id=$("#update_ib_account_id").val();
                        },
                        
                    },
                    "dataSrc" : function (json) {
                        
                    },
                    "scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT; ?>',
                    "scroller": {
                        "loadingIndicator": true
                    },
                    
                    
                    "initComplete": function(settings, json) {
                        $('.total_credit_amt').html("Total Withdraw"+json.total_credit_amt);
                        $('.total_debit_amt').html("Total Deposit="+json.total_debit_amt);
                        
                    },
                    
                    
                    "rowCallback": function( row, data ) {

                        //$(row).find('.row_is_checked').parent().css('display', 'flex');
                        //$(row).find('td:eq(3)').css('text-align', 'right');

                        if(parseFloat(data[3])> 0){
                            $(row).find('td:eq(0)').css('color', 'red');
                            $(row).find('td:eq(1)').css('color', 'red');
                            $(row).find('td:eq(2)').css('color', 'red');
                            $(row).find('td:eq(3)').css('color', 'red');
                            $(row).find('td:eq(4)').css('color', 'red');
                            total_withdraw_entries += 1;
                            console.log("w : "+total_withdraw_entries);
                            $("#wi").html("Total Withdraw = "+total_withdraw_entries);
                        }
                        if(parseFloat(data[4])> 0){
                            $(row).find('td:eq(0)').css('color', 'blue');
                            $(row).find('td:eq(1)').css('color', 'blue');
                            $(row).find('td:eq(2)').css('color', 'blue');
                            $(row).find('td:eq(3)').css('color', 'blue');
                            $(row).find('td:eq(4)').css('color', 'blue');
                            total_deposit_entries += 1;
                            console.log(total_deposit_entries);
                            $("#de").html("Total Deposit = "+total_deposit_entries);
                        }

                        
                        initAjaxSelect2($(row).find(".row_account_id"), "<?= base_url('app/account_select2_source/'.IB_GROUP_ID) ?>");

                        var set_lb_account_id=$(row).find('.row_set_transaction_id').val();
                        var set_lb_account_name=$(row).find('.row_set_transaction_name').val();

                        if(set_lb_account_id=='')
                        {
                            set_lb_account_id=$('#account_id').val();
                        }
                        if(set_lb_account_id){
                            setSelect2Valuemanual($(row).find(".row_account_id"),set_lb_account_id,set_lb_account_name);
                            //setSelect2Value($(row).find(".row_account_id"),"<?=base_url('app/set_lb_account_select2_val_by_id/')?>"+set_lb_account_id);
                        }

                        //fill responsible_account_id
                        initAjaxSelect2($(row).find(".row_responsible_account_id"), "<?= base_url('app/account_select2_source/') ?>");

                        var row_set_responsible_account_id=$(row).find('.row_set_responsible_account_id').val();
                        var row_set_responsible_account_name=$(row).find('.row_set_responsible_account_name').val();

                        if(row_set_responsible_account_id=='')
                        {
                            //row_set_responsible_account_id=$('#account_id').val();
                        }
                        if(row_set_responsible_account_id){
                            // alert(set_lb_account_id);
                            setSelect2Valuemanual($(row).find(".row_responsible_account_id"),row_set_responsible_account_id,row_set_responsible_account_name);
                          //  setSelect2Value($(row).find(".row_responsible_account_id"),"<?=base_url('app/set_responsible_account_select2_val_by_id/')?>"+row_set_responsible_account_id);
                        }
                        
                    }
                });

                
            } else {
                table.draw();                
            }
            table.on( 'xhr', function ( e, settings, json ) {
                $('.total_credit_amt').html("Total Withdraw="+json.total_credit_amt);
                $('.total_debit_amt').html("Total Deposit="+json.total_debit_amt);
                $("#totalEntries").html("Total Records = "+json.data.length);
            } );
            
            table.on('draw',function(){
                total_withdraw_entries = 0;
                total_deposit_entries = 0;
                // initAjaxSelect2($(".row_account_id"), "<?= base_url('app/account_select2_source/'.IB_GROUP_ID) ?>");
                // setSelect2Value($(".row_account_id"),"<?=base_url('app/set_account_select2_val_by_id/')?>"+$('#account_id').val() );
                // $(".row_account_id").val($('#account_id').val());
                // $(".row_account_id").trigger('change');

                // var set_lb_account_id=$(this).parent().find('.row_set_transaction_id').val();

                // alert("set_lb_account_id = "+set_lb_account_id);

                // setSelect2Value($(".row_account_id"),"<?=base_url('app/set_lb_account_select2_val_by_id/')?>"+467);

                


                
                $(document).on('keyup','.row_note',function(e){
                    
                    // alert(e.keyCode) 13 key for enter
                    var note=$(this).val();

                    var transaction_id=$(this).parent().parent().find('.row_transaction_id').val();

                    // alert("transaction_id "+transaction_id);

                    $.ajax({
                        url: "<?= base_url('transaction/update_note') ?>",
                        type: "POST",
                        data: {note: note,transaction_id:transaction_id},
                        success: function (response) {
                            // alert(response);
                        }
                    });
                })
              
                $(document).on('keyup','.row_multiplier',function(e){
                    
                    // alert(e.keyCode) 13 key for enter
                    var multiplier=$(this).val();

                    var transaction_id=$(this).parent().parent().find('.row_transaction_id').val();

                    // alert("transaction_id "+transaction_id);

                    $.ajax({
                        url: "<?= base_url('transaction/update_multiplier') ?>",
                        type: "POST",
                        data: {multiplier: multiplier,transaction_id:transaction_id},
                        success: function (response) {
                            // alert(response);
                        }
                    });
                })
                
            })
            
            data_table_export_icon_style();
            
            
        });

        $(document).on('change','.row_is_checked',function(){
            var is_checked=0;
            var transaction_id=$(this).parent().find('.row_transaction_id').val();

            if($(this).is(":checked"))
            {
                is_checked=1;
            }
            else
            {
                is_checked=0;

            }

            $.ajax({
                url: "<?= base_url('transaction/update_is_checked') ?>",
                type: "POST",
                data: {is_checked: is_checked,transaction_id:transaction_id},
                success: function (response) {
                    // alert(response);
                }
            });
        })
        
        $(document).on('select2:select','.row_account_id',function(){
                    
                    var lb_account_id=$(this).val();

                    var transaction_id=$(this).parent().find('.row_transaction_id').val();

                    // alert("lb_account_id "+lb_account_id);

                        $.ajax({
                            url: "<?= base_url('transaction/update_lb') ?>",
                            type: "POST",
                            data: {lb_account_id: lb_account_id,transaction_id:transaction_id},
                            success: function (response) {
                                // alert(response);
                            }
                        });

                        if(lb_account_id){
                            // alert(set_lb_account_id);
                           setSelect2Value($(this).parent().parent().find(".row_responsible_account_id"),"<?=base_url('app/set_responsible_account_select2_val_by_id/')?>"+lb_account_id);
                            // $(this).parent().parent().find(".row_responsible_account_id").val(lb_account_id);
                            $(this).parent().parent().find(".row_responsible_account_id").trigger('select2:select');
                            

                        }    
                })

            $(document).on('select2:select','.row_responsible_account_id',function(){
                
                var responsible_account_id=$(this).val();

                var transaction_id=$(this).parent().find('.row_transaction_id').val();

                // alert("lb_account_id "+lb_account_id+" transaction_id "+transaction_id);

                    $.ajax({
                        url: "<?= base_url('transaction/update_responsible_account_id') ?>",
                        type: "POST",
                        data: {responsible_account_id: responsible_account_id,transaction_id:transaction_id},
                        success: function (response) {
                            var resp = JSON.parse(response)
                            show_notify(resp.data, resp.status);
                            // var multiplier = $(this).closest('td').next().find('.row_multiplier');
                            // console.log(multiplier.value);
                            // $(multiplier).text(resp.multiplier);
                        }
                    });
            var total_withdraw_entries = 0;
            var total_deposit_entries = 0;

            // console.log('test '+$("#account_id").val());
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

            $('.total_credit_amt').html("");
            $('.total_debit_amt').html("");
            
            if ($('#table_draw').val() == '0') {
                $('#table_draw').val('1');
                table = $('.ledger_table').DataTable({
                    columnDefs: [
                        { targets: [3,4], className: 'text-right' },
                        { targets: [3,4], className: 'text-right' },
                        { target: 9, visible: false },
                        { target: 10, visible: false }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        $.extend( true, {}, buttonCommon, { extend: 'copy', title: function () { return (title)}, action: newExportAction } ),
                        $.extend( true, {}, buttonCommon, { extend: 'csvHtml5', title: function () { return (title)}, action: newExportAction, customize: function (csv) {
                                                    return 'Ledger For '+client+ '( From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() + ' )\n\n'+  csv;
                                                } } ),
                        $.extend( true, {}, buttonCommon, { extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL', title: function () { return (title)}, action: newExportAction,
                            customize : function(doc){
                                var objLayout = {};
                                // objLayout['hLineWidth'] = function(i) { return .5; };
                                //objLayout['vLineWidth'] = function(i) { return .5; };
                                doc.content[1].layout = objLayout;

                                // @ VIPUL BHAI (Width set Karvani Pan Jetali Column Hoy Etali Value Apavani Hati Like Apane 10 col batavi to 9 time "9%" avyu)
                                
                                doc.content[1].table.widths = ["9%","9%","9%","9%","9%","9%"]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                                var rowCount = document.getElementById("ledger_table").rows.length;

                                for (i = 1; i < rowCount; i++) {
                                    doc.content[1].table.body[i][3].alignment = 'right';

                                    doc.content[1].table.body[i][4].alignment = 'right';
                                    doc.content[1].table.body[i][5].alignment = 'right';
                                    // doc.content[1].table.body[i][6].alignment = 'right';
                                    text_name = '';
                                    text_o = doc.content[1].table.body[i][1].text;
                                    text_name = $.trim(text_o);;
                                    doc.content[1].table.body[i][1].text = text_name;
                                    // console.log(doc.content[1].table.body[i][1].text);
                                };
                            }
                        } ),
                        $.extend( true, {}, buttonCommon, { extend: 'excelHtml5', title: function () { return (title)}, action: newExportAction ,

                            customize : function (xlsx) {

                                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                var downrows = 4;
                                var clRow = $('row', sheet);
                                //update Row
                                clRow.each(function () {
                                    var attr = $(this).attr('r');
                                    var ind = parseInt(attr);
                                    ind = ind + downrows;
                                    $(this).attr("r",ind);
                                });

                                // Update  row > c
                                $('row c ', sheet).each(function () {
                                    var attr = $(this).attr('r');
                                    var pre = attr.substring(0, 1);
                                    var ind = parseInt(attr.substring(1, attr.length));
                                    ind = ind + downrows;
                                    $(this).attr("r", pre + ind);
                                });

                                function Addrow(index,data) {
                                    msg='<row r="'+index+'">'
                                    for(i=0;i<data.length;i++){
                                        var key=data[i].k;
                                        var value=data[i].v;
                                        msg += '<c t="inlineStr" r="' + key + index + '" s="42">';
                                        msg += '<is>';
                                        msg +=  '<t>'+value+'</t>';
                                        msg+=  '</is>';
                                        msg+='</c>';
                                    }
                                    msg += '</row>';
                                    return msg;
                                }
                                //insert
                                var r1 = Addrow(1, [{ k: 'A', v: 'Client :' }, { k: 'B', v: client }]);
                                var r2 = Addrow(2, [{ k: 'A', v: 'From :' }, { k: 'B', v: $('#datepicker1').val() }]);
                                var r3 = Addrow(3, [{ k: 'A', v: 'To :' }, { k: 'B', v: $('#datepicker2').val() }]);

                                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3  + sheet.childNodes[0].childNodes[1].innerHTML;
                            }
                        }),
                        $.extend( true, {}, buttonCommon, { extend: 'print',  title: function () { return (title)},
                        customize : function(win){
                            $(win.document.body).find('table thead th:nth-child(3)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(3)').css('text-align', 'right');
                            $(win.document.body).find('table thead th:nth-child(4)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'right');
                            $(win.document.body).find('table thead th:nth-child(5)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(5)').css('text-align', 'right');
                            $(win.document.body).find('table thead th:nth-child(6)').css('text-align', 'right');
                            $(win.document.body).find('table tbody td:nth-child(6)').css('text-align', 'right');
                        }, action: newExportAction } ),
                    ],
                    "serverSide": true,
                    "ordering": false,
                    "searching": false,
                    "bInfo": false,
                    "ajax": {
                        "url": "<?php echo base_url('report/depowithdraw_datatable_new') ?>",
                        "type": "POST",
                        "data": function (d) {
                            d.daterange_1 = $('#datepicker1').val();
                            d.daterange_2 = $('#datepicker2').val();
                            d.account_id = $("#account_id").val();
                            d.sub_account_id=$("#sub_account_id").val();
                        },
                        
                    },
                    "dataSrc" : function (json) {
                        
                    },
                    "scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT; ?>',
                    "scroller": {
                        "loadingIndicator": true
                    },
                    
                    
                    "initComplete": function(settings, json) {
                        $('.total_credit_amt').html("Total Withdraw"+json.total_credit_amt);
                        $('.total_debit_amt').html("Total Deposit="+json.total_debit_amt);
                        
                    },
                    
                    
                    "rowCallback": function( row, data ) {

                        //$(row).find('.row_is_checked').parent().css('display', 'flex');
                        //$(row).find('td:eq(3)').css('text-align', 'right');

                        if(parseFloat(data[3])> 0){
                            $(row).find('td:eq(0)').css('color', 'red');
                            $(row).find('td:eq(1)').css('color', 'red');
                            $(row).find('td:eq(2)').css('color', 'red');
                            $(row).find('td:eq(3)').css('color', 'red');
                            $(row).find('td:eq(4)').css('color', 'red');
                            total_withdraw_entries += 1;
                            $("#wi").html("Total Withdraw = "+total_withdraw_entries)

                        }
                        if(parseFloat(data[4])> 0){
                            $(row).find('td:eq(0)').css('color', 'blue');
                            $(row).find('td:eq(1)').css('color', 'blue');
                            $(row).find('td:eq(2)').css('color', 'blue');
                            $(row).find('td:eq(3)').css('color', 'blue');
                            $(row).find('td:eq(4)').css('color', 'blue');
                            total_deposit_entries += 1;
                            $("#de").html("Total Deposit = "+total_deposit_entries)
                        }

                        
                        initAjaxSelect2($(row).find(".row_account_id"), "<?= base_url('app/account_select2_source/'.IB_GROUP_ID) ?>");

                        var set_lb_account_id=$(row).find('.row_set_transaction_id').val();
                        var set_lb_account_name=$(row).find('.row_set_transaction_name').val();

                        if(set_lb_account_id=='')
                        {
                            set_lb_account_id=$('#account_id').val();
                        }
                        if(set_lb_account_id){
                            setSelect2Valuemanual($(row).find(".row_account_id"),set_lb_account_id,set_lb_account_name);
                            //setSelect2Value($(row).find(".row_account_id"),"<?=base_url('app/set_lb_account_select2_val_by_id/')?>"+set_lb_account_id);
                        }

                        //fill responsible_account_id
                        initAjaxSelect2($(row).find(".row_responsible_account_id"), "<?= base_url('app/account_select2_source/') ?>");

                        var row_set_responsible_account_id=$(row).find('.row_set_responsible_account_id').val();
                        var row_set_responsible_account_name=$(row).find('.row_set_responsible_account_name').val();

                        if(row_set_responsible_account_id=='')
                        {
                            //row_set_responsible_account_id=$('#account_id').val();
                        }
                        if(row_set_responsible_account_id){
                            // alert(set_lb_account_id);
                            setSelect2Valuemanual($(row).find(".row_responsible_account_id"),row_set_responsible_account_id,row_set_responsible_account_name);
                          //  setSelect2Value($(row).find(".row_responsible_account_id"),"<?=base_url('app/set_responsible_account_select2_val_by_id/')?>"+row_set_responsible_account_id);
                        }
                        
                    }
                });

                
            } else {
                table.draw();                
            }
            table.on( 'xhr', function ( e, settings, json ) {
                $('.total_credit_amt').html("Total Withdraw="+json.total_credit_amt);
                $('.total_debit_amt').html("Total Deposit="+json.total_debit_amt);
                $("#totalEntries").html("Total Records = "+json.data.length);
            } );
            
            var multiplier=$('.row_multiplier').val();

            var transaction_id=$('.row_transaction_id').parent().parent().find('.row_transaction_id').val();
            console.log(transaction_id)

            $.ajax({
                url: "<?= base_url('transaction/update_multiplier') ?>",
                type: "POST",
                data: {multiplier: multiplier,transaction_id:transaction_id},
                success: function (response) {
                    // alert(response);
                }
            });
            
            data_table_export_icon_style();
            
            
                })

        

        $("#btn_datepicker").click();

       

        // $(document).on("change",".row_account_id",function(){


        // //    alert(this.val());
        // // setSelect2Value($(".row_account_id"),"<?=base_url('app/set_item_select2_val_by_id/')?>" + this.val());

        // })



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
