<?php $this->load->view('success_false_notify');?>
 <section class="content bank-balance">
            <div class="">
                <section class="content-header pt-0">
                    <h3 class="mine-text">All Net Balance</h3>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="box">
                                <div class="box-body box-body-one" style="max-height: 94px;">
                                    <div class="form-inline">
                                        <div class="col-md-12 pl-0 col-lg-12 pl-one-r-0">
                                            <div class="col-md-4 col-sm-4 col-lg-2 pl-0 pl-one-r-0">
                                                <div class="form-group">
                                                    <label>From Date : </label><br>

                                                        <input type="text" name="from_date" id="datepicker1" class="form-control-border" value="<?php echo date('d-m-Y', strtotime($from_date)) ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-lg-2 pl-0 pl-one-r-0">
                                                <div class="row">
                                                    <div class="col-lg-6"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>To Date : </label><br>
                                                        <input type="text" name="to_date" id="datepicker2" class="form-control-border" value="<?php echo date('d-m-Y', strtotime($to_date)) ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-2 pl-0 pl-one-r-0">
                                                <div class="form-group w-100form">
                                                    <label for="site_id" class="">Account Groups</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-12">
                                                            <select class="form-control-border select2 " id="group_id" name="group_ids[]" multiple="multiple">
                                                                <option value="">- Select Account - </option>
                                                                <?php foreach ($group_ids as $group_id): ?>
                                                                <option value="<?php echo $group_id->account_group_id; ?>"><?php echo $group_id->account_group_name; ?></option>
                                                                <?php endforeach;?>
                                                            </select>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1 col-sm-12 col-lg-1 pl-0 pr-0 ">
                                                <button type="button" id="btn_search"
                                                    class="btn btn-default pull-left btn-submit">Submit</button>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <!-- <div class="col-md-2">
                                                <h6 class="text-danger f-w-600">All Credit</h6>    
                                                <h4 class="text-danger f-w-600 credit_amount">00</h4>
                                            </div>
                                            <div class="col-md-2">
                                                <h6 class="text-info f-w-600" >All Debit</h6>
                                                <h4 class="text-info f-w-600 debit_amount">00</h4>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table class="table table-striped" id="trial_balance_table_1">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="thead-one-th">
                                                    <div>Credit</div>
                                                </th>
                                                <th scope="col" class="amount">
                                                    <div>Amount</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <!-- <th>Total : </th>
                                                <th></th> -->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table class="table table-striped" id="trial_balance_table_2">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="thead-one-th">
                                                    <div>Debit</div>
                                                </th>
                                                <th scope="col" class="amount">
                                                    <div>Amount</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <!-- <th>Total : </th>
                                                <th></th> -->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </section>
            </div>
        </section>









<input type="hidden" name="total_net_amount" id="total_net_amount">
<script type="text/javascript">
	$(document).ready(function(){
    $("#site_id").select2({
        placeholder: " --ALL-- ",
        allowClear: true,
        width:"100%",
        ajax: {
            url: "<?=base_url('app/sites_select2_source')?>",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data,params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 5) < data.total_count
                    }
                };
            },
            cache: true
        }
    });


    var title = 'Trial Balance (From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() +')';

    var buttonCommon = {
        exportOptions: {
            format: { body: function ( data, row, column, node ) { return data.toString().replace(/(&nbsp;|<([^>]+)>)/ig, ""); } },
            columns: [0, 1],
        }
    };

	table_1 = $('#trial_balance_table_1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                $.extend( true, {}, buttonCommon, { extend: 'copy',footer: true, title: function () { return (title)} } ),
                $.extend( true, {}, buttonCommon, { extend: 'csvHtml5',footer: true, title: function () { return (title)}, customize: function (csv) {
                        return 'Trial Balance ( From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() + ' )\n\n'+  csv;
                    }
                }),
                $.extend( true, {}, buttonCommon, { extend: 'pdf',footer: true, orientation: 'portrait', pageSize: 'LEGAL', title: function () { return (title)}, action: newExportAction,
                    customize : function(doc){
                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .5; };
                        objLayout['vLineWidth'] = function(i) { return .5; };
                        doc.content[1].layout = objLayout;
                        doc.content[1].table_1.widths = ["35%","14%"];
                        var rowCount = document.getElementById("trial_balance_table_1").rows.length;
                        for (i = 0; i < rowCount; i++) {
                            doc.content[1].table_1.body[i][0].alignment = 'left';
                            doc.content[1].table_1.body[i][1].alignment = 'right';
                            // doc.content[1].table.body[i][3].alignment = 'left';
                            // doc.content[1].table.body[i][4].alignment = 'right';
                        };
                    }
                }),
                $.extend( true, {}, buttonCommon, { extend: 'excelHtml5',footer: true, title: function () { return (title)} ,

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
                        var r1 = Addrow(1, [{ k: 'A', v: 'From Date :' }, { k: 'B', v: $('#datepicker1').val() }]);
                        var r2 = Addrow(2, [{ k: 'A', v: 'To Date :' }, { k: 'B', v: $('#datepicker2').val() }]);

                        sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 +sheet.childNodes[0].childNodes[1].innerHTML;
                    }
                }),
                $.extend( true, {}, buttonCommon, { extend: 'print',footer: true,  title: function () { return (title)},
                    customize : function(win){
                        $(win.document.body).find('table_1 thead th:nth-child(1)').css('text-align', 'left');
                        $(win.document.body).find('table_1 thead th:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table_1 thead th:nth-child(4)').css('text-align', 'left');
                        $(win.document.body).find('table_1 thead th:nth-child(5)').css('text-align', 'right');

                        $(win.document.body).find('table_1 tbody td:nth-child(1)').css('text-align', 'left');
                        $(win.document.body).find('table_1 tbody td:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table_1 tbody td:nth-child(4)').css('text-align', 'left');
                        $(win.document.body).find('table_1 tbody td:nth-child(5)').css('text-align', 'right');

                        $(win.document.body).find('table_1 tfoot th:nth-child(1)').css('text-align', 'left');
                        $(win.document.body).find('table_1 tfoot th:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table_1 tfoot th:nth-child(4)').css('text-align', 'left');
                        $(win.document.body).find('table_1 tfoot th:nth-child(5)').css('text-align', 'right');
                    }
                }),
            ],
            "serverSide": true,
            "ordering": false,
            "searching": false,
            "bInfo" : false,
            "ajax": {
                "url": "<?php echo base_url('report/trial_balance_datatable_2') ?>",
                "type": "POST",
                "data": function(d){
                	d.from_date = $("#datepicker1").val();
                	d.to_date = $("#datepicker2").val();
                    d.group_id = $("#group_id").val();
                },
                "dataSrc": function ( jsondata ) {
                    if(jsondata.total_net_amount){
                        $('#total_net_amount').val(jsondata.total_net_amount);
                    } else {
                        $('#total_net_amount').val('');
                    }
                     $('.credit_amount').html(jsondata.total_credit_amount);
                     $('.debit_amount').html(jsondata.total_debit_amount);

                    return jsondata.data;
                }
            },
            "scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT; ?>',
            "scroller": {
                "loadingIndicator": true
            },
            "columnDefs": [
                {"className": "text-right", "targets": [1] },
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                $( api.column( 1 ).footer() ).html('');
                $( api.column( 1 ).footer() ).html($('#total_net_amount').val());
                // $( api.column( 4 ).footer() ).html('');
                // $( api.column( 4 ).footer() ).html($('#total_net_amount').val());
            }
        });
 

        table = $('#trial_balance_table_2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                $.extend( true, {}, buttonCommon, { extend: 'copy',footer: true, title: function () { return (title)} } ),
                $.extend( true, {}, buttonCommon, { extend: 'csvHtml5',footer: true, title: function () { return (title)}, customize: function (csv) {
                        return 'Trial Balance ( From Date : ' + $('#datepicker1').val() + ' To Date : ' + $('#datepicker2').val() + ' )\n\n'+  csv;
                    }
                }),
                $.extend( true, {}, buttonCommon, { extend: 'pdf',footer: true, orientation: 'portrait', pageSize: 'LEGAL', title: function () { return (title)}, action: newExportAction,
                    customize : function(doc){
                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .5; };
                        objLayout['vLineWidth'] = function(i) { return .5; };
                        doc.content[1].layout = objLayout;
                        doc.content[1].table.widths = ["35%","14%"];
                        var rowCount = document.getElementById("trial_balance_table_2").rows.length;
                        for (i = 0; i < rowCount; i++) {
                            doc.content[1].table.body[i][0].alignment = 'left';
                            doc.content[1].table.body[i][1].alignment = 'right';
                            // doc.content[1].table.body[i][3].alignment = 'left';
                            // doc.content[1].table.body[i][4].alignment = 'right';
                        };
                    }
                }),
                $.extend( true, {}, buttonCommon, { extend: 'excelHtml5',footer: true, title: function () { return (title)} ,

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
                        var r1 = Addrow(1, [{ k: 'A', v: 'From Date :' }, { k: 'B', v: $('#datepicker1').val() }]);
                        var r2 = Addrow(2, [{ k: 'A', v: 'To Date :' }, { k: 'B', v: $('#datepicker2').val() }]);

                        sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 +sheet.childNodes[0].childNodes[1].innerHTML;
                    }
                }),
                $.extend( true, {}, buttonCommon, { extend: 'print',footer: true,  title: function () { return (title)},
                    customize : function(win){
                        $(win.document.body).find('table thead th:nth-child(1)').css('text-align', 'left');
                        $(win.document.body).find('table thead th:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table thead th:nth-child(4)').css('text-align', 'left');
                        $(win.document.body).find('table thead th:nth-child(5)').css('text-align', 'right');

                        $(win.document.body).find('table tbody td:nth-child(1)').css('text-align', 'left');
                        $(win.document.body).find('table tbody td:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'left');
                        $(win.document.body).find('table tbody td:nth-child(5)').css('text-align', 'right');

                        $(win.document.body).find('table tfoot th:nth-child(1)').css('text-align', 'left');
                        $(win.document.body).find('table tfoot th:nth-child(2)').css('text-align', 'right');
                        $(win.document.body).find('table tfoot th:nth-child(4)').css('text-align', 'left');
                        $(win.document.body).find('table tfoot th:nth-child(5)').css('text-align', 'right');
                    }
                }),
            ],
            "serverSide": true,
            "ordering": false,
            "searching": false,
            "bInfo" : false,
            "ajax": {
                "url": "<?php echo base_url('report/trial_balance_datatable_1') ?>",
                "type": "POST",
                "data": function(d){
                	d.from_date = $("#datepicker1").val();
                	d.to_date = $("#datepicker2").val();
                    d.group_id = $("#group_id").val();
                },
                "dataSrc": function ( jsondata ) {
                    if(jsondata.total_net_amount){
                        $('#total_net_amount').val(jsondata.total_net_amount);
                    } else {
                        $('#total_net_amount').val('');
                    }
                     $('.credit_amount').html(jsondata.total_credit_amount);
                     $('.debit_amount').html(jsondata.total_debit_amount);

                    return jsondata.data;
                }
            },
            "scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT; ?>',
            "scroller": {
                "loadingIndicator": true
            },
            "columnDefs": [
                {"className": "text-right", "targets": [1] },
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                $( api.column( 1 ).footer() ).html('');
                $( api.column( 1 ).footer() ).html($('#total_net_amount').val());
                // $( api.column( 4 ).footer() ).html('');
                // $( api.column( 4 ).footer() ).html($('#total_net_amount').val());
            }
        });
	});
           
	$(document).on('click','#btn_search',function(){
        console.log('table_1');
        table_1.draw();
    });
    
	$(document).on('click','#btn_search',function(){
        console.log('table_2');
        table.draw();
    });
</script>
