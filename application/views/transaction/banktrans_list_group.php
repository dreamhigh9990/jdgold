<?php $this->load->view('success_false_notify'); ?>
<?php $segment2 = $this->uri->segment(2); ?>
<?php
$page_parameter = '';
$page_title = '';
if ($segment2 == 'receipt_list') {
    $page_parameter = 'receipt_list';
    $page_title = 'Receipt';
} else if ($segment2 == 'payment_list') {
    $page_parameter = 'payment_list';
    $page_title = 'Payment';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="box-title">
            Bank Transaction List
            <a href="<?= base_url('transaction/banktrans'); ?>" class="btn btn-primary pull-right">Add Swipe</a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="javascript:void(0);" class="btn btn-primary btn_print_multiple_transaction">Print</a>
                        <br/>
                        <br/>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <!-- <div class="form-group"> -->
                            <label for="rp_from" class="control-label">From</label><br>
                            <?php if ($this->applib->have_access_role(MODULE_View_Previous_Date_Data,"view")) {?>
                                <input type="date" name="rp_from" id="rp_from">
                            <?php } else {?>
                                <input type="text" name="rp_from" id="rp_from" readonly >


                            <?php } ?>
                            <!-- </div> -->
                        </div>
                        <div class="col-md-2">
                            <!-- <div class="form-group"> -->
                            <label for="rp_from1" class="control-label">To</label><br>
                            <?php if ($this->applib->have_access_role(MODULE_View_Previous_Date_Data,"view")) {?>

                                <input type="date" name="rp_to" id="rp_to">
                            <?php } else {?>

                                <input type="text" name="rp_to" id="rp_to" readonly>

                            <?php } ?>


                            <!-- </div> -->
                        </div>
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label for="rp_machine" class="control-label">Swipe Machine</label>-->
<!--                                <select name="rp_machine" id="rp_machine" class="form-control select2"></select>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rp_bank" class="control-label">Bank</label>
                                <select name="rp_bank" id="rp_bank" class="form-control select2"></select>
                            </div>
                        </div>
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label for="rp_agent" class="control-label">Agent</label>-->
<!--                                <select name="rp_agent" id="rp_agent" class="form-control select2"></select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label for="rp_client" class="control-label">Client</label>-->
<!--                                <select name="rp_client" id="rp_client" class="form-control select2"></select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label for="rp_cash" class="control-label">Our Cash A/c</label>-->
<!--                                <select name="rp_cash" id="rp_cash" class="form-control select2"></select>-->
<!--                            </div>-->
<!--                        </div>-->
                        <!-- <div class="col-md-3"><input type="hidden" name="" id="table_draw" value="0"><br>
                            <button class="btn btn-primary pull-left" id='btn_filter'>Filter</button>
                        </div> -->
                        <div class="clearfix"></div>
                        <form id="form_print_multiple_transaction" class="" action="<?= base_url('transaction/print_multiple_transaction') ?>" method="post" enctype="multipart/form-data"  target="_blank" >
                            <input type="hidden" name="transaction_type" value="<?=$transaction_type?>">
                            <style>
                                th, td { width: 10%; }
                                table thead th:nth-child(5),th:nth-child(8),th:nth-child(9),th:nth-child(11),
                                tbody td:nth-child(5),td:nth-child(8),th:nth-child(9),td:nth-child(10),td:nth-child(11) {
                                    text-align: right;
                                }
                                .ra{
                                    text-align: right;
                                }
                            </style>
                            <table class="table table-striped table-bordered transaction-table" id="transaction-table">
                                <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>CUS+COMM</th>
                                    <th>Net In Bank</th>
                                    <th>Swiping</th>


                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="ra"></th>
                                    <th class="ra"></th>
                                    <th class="ra"></th>

                                </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ALERTS AND CALLOUTS -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    var table;
    function filter() { if(table) table.draw(); }
    $(document).ready(function () {
        $("#rp_machine").change(filter);
        $("#rp_client").change(filter);
        $("#rp_bank").change(filter);
        $("#rp_agent").change(filter);
        $("#rp_cash").change(filter);
        $("#rp_from").change(filter);
        $("#rp_to").change(filter);

        initAjaxSelect2($("#rp_machine"), "<?= base_url('app/swipe_machine_source') ?>");
        initAjaxSelect2wTag($("#rp_client"), "<?= base_url('app/account_select2_source') ?>");
        initAjaxSelect2($("#rp_bank"), "<?= base_url('app/our_bank_label_select2_source') ?>");
        initAjaxSelect2($("#rp_agent"), "<?= base_url('app/our_agent_label_select2_source') ?>");
        initAjaxSelect2($("#rp_cash"), "<?= base_url('app/cash_only_account_select2_source') ?>");

        var fullDate = new Date();
        var twoDigitMonth = (fullDate.getMonth()<=8)?('0' + (fullDate.getMonth()+1)):(fullDate.getMonth()+1);
        var twoDigitDate = (fullDate.getDate()<=9)?('0'+fullDate.getDate()):fullDate.getDate();
        var currentDate = fullDate.getFullYear() + '-' + twoDigitMonth + "-" + twoDigitDate;


        // var currentDate =twoDigitMonth+' / '+twoDigitDate+' / '+fullDate.getFullYear();




        $("#rp_from").attr("placeholder", currentDate);
        $("#rp_from").val(currentDate);
        $("#rp_to").val(currentDate); $("#rp_to").attr("placeholder", currentDate);

        var title = "Bank Transaction List";

        var buttonCommon = {
            exportOptions: {
                format: { body: function ( data, row, column, node ) { return data.replace(/(&nbsp;|<([^>]+)>)/ig, ""); } },
                columns: [1,2,3,4],
            }
        };

        table = $('.transaction-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                $.extend( true, {}, buttonCommon, { extend: 'copy', title: function () { return (title)}, action: newExportAction } ),
                $.extend( true, {}, buttonCommon, { extend: 'csvHtml5', title: function () { return (title)}, action: newExportAction } ),
                $.extend( true, {}, buttonCommon, { extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL', title: function () { return (title)}, action: newExportAction,
                    customize : function(doc){
                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .5; };
                        objLayout['vLineWidth'] = function(i) { return .5; };
                        doc.content[1].layout = objLayout;
                        doc.content[1].table.widths = ["10%","10%","10%","10%"];
                        var rowCount = document.getElementById("transaction-table").rows.length;

                        // for (i = 1; i < rowCount; i++) {
                        //     doc.content[1].table.body[i][3].alignment = 'right';
                        //     doc.content[1].table.body[i][3].alignment = 'right';
                        // };
                    }
                } ),
                $.extend( true, {}, buttonCommon, { extend: 'excelHtml5', title: function () { return (title)}, action: newExportAction } ),
                $.extend( true, {}, buttonCommon, { extend: 'print',  title: function () { return (title)},
                    customize : function(win){
                        // $(win.document.body).find('table thead th:nth-child(4)').css('text-align', 'right');

                    }, action: newExportAction } ),
            ],
            "serverSide": true,
            "ordering": true,
            "searching": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('transaction/banktransaction_datatable_group')?>",
                "type": "POST",
                "data": function (d) {
                    d.from_date = $('#rp_from').val();
                    d.to_date = $('#rp_to').val();
                    d.machine_id = $('#rp_machine').val();
                    d.bank_id = $('#rp_bank').val();
                    d.agent_id = $('#rp_agent').val();
                    d.client_id = $('#rp_client').val();
                    d.cash_id = $('#rp_cash').val();
                },
            },
            "columnDefs": [{
                    className: "dt-right",
                    targets: [1,2,3],
                },
                {"targets": 0,"orderable": false}
            ],

            "scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT; ?>',
            "scroller": {
                "loadingIndicator": true
            },
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                cashTotal = api.column(1, { page: 'current' }).data().reduce(function (a, b) {return parseFloat(a) + parseFloat(b);}, 0);
                $(api.column(1).footer()).html(cashTotal.toFixed(2));
                swipTotal = api.column(2, { page: 'current' }).data().reduce(function (a, b) {return parseFloat(a) + parseFloat(b);}, 0);
                $(api.column(2).footer()).html(swipTotal.toFixed(2));
                commTotal = api.column(3, { page: 'current' }).data().reduce(function (a, b) {return parseFloat(a) + parseFloat(b);}, 0);
                $(api.column(3).footer()).html(commTotal.toFixed(2));

            }
        });

        $(document).on("change","#check_all", function () {
            if($(this).is(":checked")) {
                $("[name='transaction_ids[]']").prop('checked',true);
            } else {
                $("[name='transaction_ids[]']").prop('checked',false);
            }
        });

        $(document).on("click", ".btn_print_multiple_transaction", function () {
            if($("[name='transaction_ids[]']:checked").length == 0) {
                show_notify('Please Select Transaction!', false);
            } else {
                /*var transaction_ids = [];
                $("[name='transaction_ids[]']:checked").each(function(index,element){
                    transaction_ids.push($(this).val());
                });*/
                $("#form_print_multiple_transaction").submit();
            }
        });

        $('#form_print_multiple_transaction').on('submit', function(e){
            var $form = $(this);
            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    // If checkbox is checked
                    if(this.checked){
                        // Create a hidden element
                        $form.append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                }
            });
        });

        $(document).on("click", ".delete_transaction", function () {
            var value = confirm('Are you sure delete this Transaction?');
            var tr = $(this).closest("tr");
            if (value) {
                $.ajax({
                    url: $(this).data('href'),
                    type: "POST",
                    data: 'id_name=transaction_id&table_name=transaction_entry',
                    success: function (data) {
                        table.draw();
                        show_notify('Transaction Deleted Successfully!', true);
                    }
                });
            }
        });
    });
</script>
