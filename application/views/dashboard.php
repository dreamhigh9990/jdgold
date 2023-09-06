<?php $this->load->view('success_false_notify');?>
<?php
if(isset($this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']) && !empty($this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in'])){
    $logged_in_name = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']['user_name'];
    if($this->session->userdata()['userType']) {
        $userType = $this->session->userdata()['userType'];
    }
}
?>



  
        <!-- Main content -->
        <section class="content p-l-r">
        <h4 class="info-box-text-one text-center" style="margin-top: 0px; padding-top: 10px;"><img src="<?php echo base_url('assets/img/om-blue.png');?>" alt="" width="30px"> <img src="<?php echo base_url('assets/img/ganesha.png');?>" alt="" width="50px"> <img src="<?php echo base_url('assets/img/om-blue.png');?>" alt="" width="30px"></h4>
            <h4 class="info-box-text-one text-center red-text"><img src="<?php echo base_url('assets/img/trishul.png');?>" alt="" width="30px"> BHAVANI  <img src="<?php echo base_url('assets/img/trishul.png');?>" alt="" width="30px"></h4>
            <!-- <h3 class="mine-text"><?=isset($logged_in_name)?ucwords($logged_in_name):'Admin';?></h3> -->
            
            <?php if($this->applib->have_access_role(DASHBOARDS,"view")) { ?>
            <div class="row" id="all_block">
                <!-- box-one -->
                <div class="col-md-3 col-sm-6 col-xs-12" id="butt_block">
                    <div class="icon-box-one m-mt">
                        
                        <input type="hidden" name="account_id" value="536" id="butt_account_id">
                            <div class="row display-f align-items-center">
                                <div class="col-lg-4 col-sm-5 pr-0">
                                    <div class="box-icon bg-blue-one">
                                    <?php 
                                    if(isset($butt_profile) == "" || isset($butt_profile) == NULL ){?>    
                                        <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                        width="100%"></div>
                                    <?php } else{ ?>
                                                <img src="<?= base_url('uploads/account-images/536/'.$butt_profile)?>" alt=""
                                                width="100%"></div>
                                    <?php }?>
                                    
                                </div>
                                <div class="col-lg-8 col-sm-7 pl-0 pr-18" id="butt_model">
                                    </div>
                                    <div class="next-arrow butt_tab"><i class="fa-solid fa-arrow-down"></i></div>
                                </div>
                        </div>
                    </div>
                    <!-- box-one -->
                    
                    <!-- box-Two -->
                        <div class="col-md-3 col-sm-6 col-xs-12" id="asif_block">
                            <div class="icon-box-one">
                                    <input type="hidden" name="account_id" value="533" id="asif_account_id">
                                    <div class="row display-f align-items-center">
                                        <div class="col-lg-4 col-sm-5 pr-0">
                                            <div class="box-icon bg-blue-two">
                                        <?php 
                                        if(isset($asif_profile) == "" || isset($asif_profile) == NULL ){?>    
                                            <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                            width="100%">
                                        <?php } else{ ?>
                                                    <img src="<?= base_url('uploads/account-images/533/'.$asif_profile)?>" alt=""
                                                    width="100%">
                                        <?php }?>

                                        </div>
                                    </div>
                                <div class="col-lg-8 col-sm-7 pl-0 asif_model pr-18" id="asif_model">
                                </div>
                                <div class="next-arrow asif_tab"><i class="fa-solid fa-arrow-down"></i></div>
                            </div>
                    </div>
                </div>
                
                <?php
                    $from_date = get_financial_start_date_by_date();
                ?>
                <input type="hidden" name="daterange_1" id="from_date" class="form-control" value="<?php echo $from_date ; ?>">
                <!-- box-Two -->

                <!-- box-Three -->
                <div class="col-md-3 col-sm-6 col-xs-12" id="dharmi_block">
                    <div class="icon-box-one">
                        <input type="hidden" name="account_id" value="1001" id="dharmi_account_id">
                            <div class="row display-f align-items-center">
                                    <div class="col-lg-4 col-sm-5 pr-0">
                                        <div class="box-icon bg-blue-two">
                                        <?php 
                                        if(isset($dharmi_profile) == "" || isset($dharmi_profile) == NULL ){?>    
                                            <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                            width="100%">
                                        <?php } else{ ?>
                                                    <img src="<?= base_url('uploads/account-images/1001/'.$dharmi_profile)?>" alt=""
                                                    width="100%">
                                        <?php }?>

                                        </div>
                                    </div>
                                <div class="col-lg-8 col-sm-7 pl-0  pr-18" id="dharmi_model">
                                </div>
                                <div class="next-arrow dharmi_tab"><i class="fa-solid fa-arrow-down"></i></div>
                            </div>
                    </div>
                </div>
                <!-- box-Three -->

                <!-- box-Four -->
                <div class="col-md-3 col-sm-6 col-xs-12" id="hitesh_block">
                    <div class="icon-box-one">
                        <input type="hidden" name="account_id" value="542" id="hitesh_account_id">
                            <div class="row display-f align-items-center">
                                <div class="col-lg-4 col-sm-5 pr-0">
                                    <div class="box-icon bg-blue-two">
                                    <?php 
                                    if(isset($hitesh_profile) == "" || isset($hitesh_profile) == NULL ){?>    
                                        <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                        width="100%">
                                    <?php } else{ ?>
                                                <img src="<?= base_url('uploads/account-images/542/'.$hitesh_profile)?>" alt=""
                                                width="100%">
                                    <?php }?>

                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-7 pl-0 pr-18" id="hitesh_model">
                                </div>
                                <div class="next-arrow hitesh_tab"><i class="fa-solid fa-arrow-down"></i></div>
                            </div>
                    </div>
                </div>
                <!-- box-Four -->

                <!-- box-Five -->
                <div class="col-md-3 col-sm-6 col-xs-12" id="irfan_block">
                    <div class="icon-box-one">
                        <input type="hidden" name="account_id" value="1096" id="irfan_account_id">
                            <div class="row display-f align-items-center">
                                    <div class="col-lg-4 col-sm-5 pr-0">
                                        <div class="box-icon bg-blue-two">
                                        <?php 
                                        if(isset($irfan_profile) == "" || isset($irfan_profile) == NULL ){?>    
                                            <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                            width="100%">
                                        <?php } else{ ?>
                                                    <img src="<?= base_url('uploads/account-images/1096/'.$irfan_profile)?>" alt=""
                                                    width="100%">
                                        <?php }?>

                                        </div>
                                    </div>
                                <div class="col-lg-8 col-sm-7 pl-0 pr-18" id="irfan_model">
                                </div>
                                <div class="next-arrow irfan_tab"><i class="fa-solid fa-arrow-down"></i></div>
                            </div>
                    </div>
                </div>
                <!-- box-Five -->

                <!-- box-Six -->
                <div class="col-md-3 col-sm-6 col-xs-12" id="rana_block">
                    <div class="icon-box-one">
                        <input type="hidden" name="account_id" value="1094" id="rana_account_id">
                            <div class="row display-f align-items-center">
                                        <div class="col-lg-4 col-sm-5 pr-0">
                                            <div class="box-icon bg-blue-two">
                                            <?php 
                                            if(isset($rana_profile) == "" || isset($rana_profile) == NULL ){?>    
                                                <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                                width="100%">
                                            <?php } else{ ?>
                                                        <img src="<?= base_url('uploads/account-images/1094/'.$rana_profile)?>" alt=""
                                                        width="100%">
                                            <?php }?>

                                            </div>
                                    </div>
                                <div class="col-lg-8 col-sm-7 pl-0 pr-18" id="rana_model">
                                </div>
                                <div class="next-arrow rana_tab"><i class="fa-solid fa-arrow-down"></i></div>
                            </div>
                    </div>
                </div>
                <!-- box-Six -->

                <!-- box-Seven -->
                <div class="col-md-3 col-sm-6 col-xs-12" id="mozam_block">
                    <div class="icon-box-one">
                        <input type="hidden" name="account_id" value="882" id="mozam_account_id">
                            <div class="row display-f align-items-center">
                                        <div class="col-lg-4 col-sm-5 pr-0">
                                            <div class="box-icon bg-blue-two">
                                            <?php 
                                            if(isset($mozam_profile) == "" || isset($mozam_profile) == NULL ){?>    
                                                <img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                                width="100%">
                                            <?php } else{ ?>
                                                        <img src="<?= base_url('uploads/account-images/882/'.$mozam_profile)?>" alt=""
                                                            width="100%">
                                            <?php }?>

                                            </div>
                                    </div>
                                <div class="col-lg-8 col-sm-7 pl-0 pr-18" id="mozam_model">
                                </div>
                                <div class="next-arrow mozam_tab"><i class="fa-solid fa-arrow-down"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- box-Six -->

                <!-- box-three -->
                <!-- <?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"add")) { ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url() ?>transaction/payment/">
                        <div class="icon-box-one">
                            <div class="row display-f align-items-center">
                                <div class="col-lg-4 col-sm-5">
                                    <div class="box-icon bg-blue-three"><img src="<?php echo base_url('assets/img/men.jpeg');?>" alt=""
                                            width="100%"></div>

                                </div>
                                <div class="col-lg-7 col-sm-7 pl-0">
                                    <div class="red-text">
                                        <h4 class="info-box-text-one text-uppercase">Dharmi</h4>
                                        <h6 class="info-box-text-h6"> -3,000</h6>
                                    </div>
                                    <div class="next-arrow">
                                        <i class="fa-solid fa-arrow-bottom"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?> -->
                <!-- box-three -->

                <button id="btnDownload" class="icon-box-one" type="button">All Block Save</button>
            </div>
               <?php } ?>
        </section>
        <!-- /.content -->

        <!-- Bank Balance Report -->

        <?php if($this->applib->have_access_role(DASHBOARDS,"view")) { ?>

            <?php
            $from_date = ($this->session->userdata('trial_balance_from_date')?$this->session->userdata('trial_balance_from_date'):get_financial_start_date_by_date());
            $to_date = ($this->session->userdata('trial_balance_to_date')?$this->session->userdata('trial_balance_to_date'):date('d-m-Y'));
        ?>

        <section class="content bank-balance">
            <div class="">
                <!-- <section class="content-header pt-0">
                    <h3 class="mine-text">Bank Balance</h3>
                </section> -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                            <!-- <div class="box">
                                <div class="box-body box-body-one">
                                    <div class="form-inline">
                                        <div class="col-md-12 pl-0 col-lg-12 pl-one-r-0">






                                            <div class="col-md-3 col-sm-3 col-lg-2 pl-0 pl-one-r-0">
                                                <div class="form-group">
                                                    <label>From Date : </label><br>
                                                   
                                                        <input type="text" name="from_date" id="datepicker1" class="form-control-border" value="<?php echo date('d-m-Y',strtotime($from_date)) ?>">

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-lg-2 pl-0 pl-one-r-0">
                                                <div class="row">
                                                    <div class="col-lg-6"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>To Date : </label><br>
                                                     <input type="text" name="to_date" id="datepicker2" class="form-control-border" value="<?php echo date('d-m-Y',strtotime($to_date)) ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-5 col-lg-3 pl-0 pl-one-r-0">
                                                <div class="form-group w-100form">
                                                    <label for="site_id" class="">Site</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-6">
                                                        <select name="line_items_data[site_id]" id="site_id" class="form-control-border select2">
                                                        </select>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1 col-sm-12 col-lg-1 pl-0 pr-0 ">
                                                <input type="hidden" name="" id="table_draw" value="0">
                                                <button type="button" id="btn_search" class="btn btn-default pull-left btn-submit">Submit</button>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-12">
                            <!-- <div class="box box-primary">
                                <div class="box-body">
                                    
                                    <div class="table-responsive delta pb-5">
                                        <div class="row">
                                           <div class="box box-primary">
                                                <div class="box-body">
                                                    <table class="table table-striped table-bordered" id="trial_balance_table">
                                                        <thead>
                                                            <tr>
                                                                <th width="35%"><h4>Credit</h4></th>
                                                                <th width="150">Amount</th>
                                                                <th width="15"></th>
                                                                <th width="35%"><h4>Debit</h4></th>
                                                                <th width="150">Amount</th>
                                                            </tr>
                                                        </thead>

                                                        <tr class="thead-one">
                                                            <th scope="col" class="thead-one-th">
                                                                <div>Credit</div>
                                                            </th>
                                                            <th scope="col" class="amount">
                                                                <div>Amount</div>
                                                            </th>
                                                        </tr>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Total : </th>
                                                                <th></th>
                                                                <th></th>
                                                                <th>Total : </th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </section>
            </div>
        </section>

         <input type="hidden" name="total_net_amount" id="total_net_amount">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script>
function download(url){

  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "allblock.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture(element) {
    html2canvas(element).then(function(canvas) {
        download(canvas.toDataURL("image/png"));
    })
}

$('#btnDownload').click(function(){
  $('.next-arrow').hide();
  $('#btnDownload').hide();
  var element = document.querySelector("#all_block");
  saveCapture(element)
  $('.next-arrow').show();
  $('#btnDownload').show();
})

</script>

<script>
function download1(url){
    
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "butt.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture1(element) {
  html2canvas(element).then(function(canvas) {
    download1(canvas.toDataURL("image/png"));
  })
}

$('.butt_tab').click(function(){
    $('.next-arrow').hide();
    $('#butt_block').css({ 'margin-top':'50','height': '278', 'width': '700' })
    var element = document.querySelector("#butt_block");
    saveCapture1(element)
    $('.next-arrow').show();
    $('#butt_block').css({'width': '25%','height': '0'});
})

function download2(url){
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "asif.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture2(element) {
  html2canvas(element).then(function(canvas) {
    download2(canvas.toDataURL("image/png"));
  })
}

$('.asif_tab').click(function(){
    $('.next-arrow').hide();
    var element = document.querySelector("#asif_block");
    saveCapture2(element)
    $('.next-arrow').show();
})

function download3(url){
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "dharmi.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture3(element) {
  html2canvas(element).then(function(canvas) {
    download3(canvas.toDataURL("image/png"));
  })
}

$('.dharmi_tab').click(function(){
    $('.next-arrow').hide();
    var element = document.querySelector("#dharmi_block");
    saveCapture3(element)
    $('.next-arrow').show();
})

function download4(url){
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "hitesh.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture4(element) {
  html2canvas(element).then(function(canvas) {
    download4(canvas.toDataURL("image/png"));
  })
}
$('.hitesh_tab').click(function(){
    $('.next-arrow').hide();
    var element = document.querySelector("#hitesh_block");
    saveCapture4(element)
    $('.next-arrow').show();
})

function download5(url){
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "mozam.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture5(element) {
  html2canvas(element).then(function(canvas) {
    download5(canvas.toDataURL("image/png"));
  })
}
$('.mozam_tab').click(function(){
    $('.next-arrow').hide();
    var element = document.querySelector("#mozam_block");
    saveCapture5(element)
    $('.next-arrow').show();
})

function download6(url){
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "ranapkr.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture6(element) {
  html2canvas(element).then(function(canvas) {
    download6(canvas.toDataURL("image/png"));
  })
}
$('.rana_tab').click(function(){
    $('.next-arrow').hide();
    var element = document.querySelector("#rana_block");
    saveCapture6(element)
    $('.next-arrow').show();
})

function download7(url){
  var a = $("<a style='display:none' id='js-downloder'>")
  .attr("href", url)
  .attr("download", "irfan yusuf.png")
  .appendTo("body");
  a[0].click();
  a.remove();
}

function saveCapture7(element) {
  html2canvas(element).then(function(canvas) {
    download7(canvas.toDataURL("image/png"));
  })
}
$('.irfan_tab').click(function(){
    $('.next-arrow').hide();
    var element = document.querySelector("#irfan_block");
    saveCapture7(element)
    $('.next-arrow').show();

})
</script>
        <script type="text/javascript">



            $(document).ready(function(){
            $("#site_id").select2({
                placeholder: " --ALL-- ",
                allowClear: true,
                width:"100%",
                ajax: {
                    url: "<?= base_url('app/sites_select2_source') ?>",
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
                    columns: [0, 1, 2, 3, 4],
                }
            };

            table = $('#trial_balance_table').DataTable({
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
                                doc.content[1].table.widths = ["35%","14%","2%","35%","14%"]; 
                                var rowCount = document.getElementById("trial_balance_table").rows.length;
                                for (i = 0; i < rowCount; i++) {
                                    doc.content[1].table.body[i][0].alignment = 'left';
                                    doc.content[1].table.body[i][1].alignment = 'right';
                                    doc.content[1].table.body[i][3].alignment = 'left';
                                    doc.content[1].table.body[i][4].alignment = 'right';
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
                        "url": "<?php echo base_url('report/bank_balance_datatable')?>",
                        "type": "POST",
                        "data": function(d){
                            d.from_date = $("#datepicker1").val();
                            d.to_date = $("#datepicker2").val();
                            d.site_id = $("#site_id").val();
                        },
                        "dataSrc": function ( jsondata ) {
                            if(jsondata.total_net_amount){
                                $('#total_net_amount').val(jsondata.total_net_amount);
                            } else {
                                $('#total_net_amount').val('');
                            }
                            return jsondata.data;
                        }
                    },
                    "scrollY": '<?php echo MASTER_LIST_TABLE_HEIGHT;?>',
                    "scroller": {
                        "loadingIndicator": true
                    },
                    "columnDefs": [
                        {"className": "text-right", "targets": [1,4] },
                    ],
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
                        $( api.column( 1 ).footer() ).html('');
                        $( api.column( 1 ).footer() ).html($('#total_net_amount').val());
                        $( api.column( 4 ).footer() ).html('');
                        $( api.column( 4 ).footer() ).html($('#total_net_amount').val());
                    }
                });  
            });

            $(document).on('click','#btn_search',function(){
                table.draw();            
            });

        $(document).ready(function () {
            let account_id = $("#butt_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        if(rsp.data < 0){
                        $("#butt_model").html('<a href="<?php echo base_url() ?>report/ledger/536"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">BUTT</h4><h6 class="info-box-text-h6 total" id="butt_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#butt_total").text(rsp.data);
                        }else{
                            $("#butt_model").html('<a href="<?php echo base_url() ?>report/ledger/536"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">BUTT</h4><h6 class="info-box-text-h6 total" id="butt_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#butt_total").text(rsp.data);
                        }
                    }else{
                            $("#butt_model").html('<a href="<?php echo base_url() ?>report/ledger/536"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">BUTT</h4><h6 class="info-box-text-h6 total" id="butt_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#butt_total").text(0);
                        }
                }
            });
        });

        $(document).ready(function () {
            let account_id = $("#asif_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        if(rsp.data < 0){
                        $("#asif_model").html('<a href="<?php echo base_url() ?>report/ledger/533"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">ASIF</h4><h6 class="info-box-text-h6 total" id="asif_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#asif_total").text(rsp.data);
                        }else{
                            $("#asif_model").html('<a href="<?php echo base_url() ?>report/ledger/533"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">ASIF</h4><h6 class="info-box-text-h6 total" id="asif_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#asif_total").text(rsp.data);
                        }
                    }else{
                            $("#asif_model").html('<a href="<?php echo base_url() ?>report/ledger/533"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">ASIF</h4><h6 class="info-box-text-h6 total" id="asif_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#asif_total").text(0);
                        }
                }
            });
        });

        $(document).ready(function () {
            let account_id = $("#hitesh_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        if(rsp.data < 0){
                        $("#hitesh_model").html('<a href="<?php echo base_url() ?>report/ledger/542"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">HITESH</h4><h6 class="info-box-text-h6 total" id="hitesh_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#hitesh_total").text(rsp.data);
                        }else{
                            $("#hitesh_model").html('<a href="<?php echo base_url() ?>report/ledger/542"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">HITESH</h4><h6 class="info-box-text-h6 total" id="hitesh_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#hitesh_total").text(rsp.data);
                        }
                    }else{
                            $("#hitesh_model").html('<a href="<?php echo base_url() ?>report/ledger/542"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">HITESH</h4><h6 class="info-box-text-h6 total" id="hitesh_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#hitesh_total").text(0);
                        }
                }
            });
        });

        $(document).ready(function () {
            let account_id = $("#dharmi_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        console.log(rsp.data);
                        if(rsp.data < 0){
                        $("#dharmi_model").html('<a href="<?php echo base_url() ?>report/ledger/1001"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">DHARMI</h4><h6 class="info-box-text-h6 total" id="dharmi_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#dharmi_total").text(rsp.data);
                        }else{
                            $("#dharmi_model").html('<a href="<?php echo base_url() ?>report/ledger/1001"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">DHARMI</h4><h6 class="info-box-text-h6 total" id="dharmi_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#dharmi_total").text(rsp.data);
                        }
                    }else{
                            $("#irfan_model").html('<a href="<?php echo base_url() ?>report/ledger/1001"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">IRFAN YUSUF</h4><h6 class="info-box-text-h6 total" id="irfan_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#irfan_total").text(0);
                        }
                }
            });
        });

        $(document).ready(function () {
            let account_id = $("#irfan_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        // console.log(rsp.data)
                        if(rsp.data < 0){
                        $("#irfan_model").html('<a href="<?php echo base_url() ?>report/ledger/1096"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">IRFAN YUSUF</h4><h6 class="info-box-text-h6 total" id="irfan_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#irfan_total").text(rsp.data);
                        }else{
                            $("#irfan_model").html('<a href="<?php echo base_url() ?>report/ledger/1096"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">IRFAN YUSUF</h4><h6 class="info-box-text-h6 total" id="irfan_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#irfan_total").text(rsp.data);
                        }
                    }else{
                            $("#irfan_model").html('<a href="<?php echo base_url() ?>report/ledger/1096"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">IRFAN YUSUF</h4><h6 class="info-box-text-h6 total" id="irfan_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#irfan_total").text(0);
                        }
                }
            });
        });

        $(document).ready(function () {
            let account_id = $("#rana_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        if(rsp.data < 0){
                        $("#rana_model").html('<a href="<?php echo base_url() ?>report/ledger/1094"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">RANAPKR</h4><h6 class="info-box-text-h6 total" id="rana_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#rana_total").text(rsp.data);
                        }else{
                            $("#rana_model").html('<a href="<?php echo base_url() ?>report/ledger/1094"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">RANAPKR</h4><h6 class="info-box-text-h6 total" id="rana_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#rana_total").text(rsp.data);
                        }
                    }else{
                            $("#rana_model").html('<a href="<?php echo base_url() ?>report/ledger/1094"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">RANAPKR</h4><h6 class="info-box-text-h6 total" id="rana_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#rana_total").text(0);
                        }
                }
            });
        });

        $(document).ready(function () {
            let account_id = $("#mozam_account_id").val();
            let from_date = $("#from_date").val();

            $.ajax({
                url:"<?= base_url('auth/ledger_datatable') ?>",
                type: "post",
                dataType: "json",
                data: {account_id: account_id,from_date: from_date},
                success: function(rsp){
                    if(rsp.status=='OK'){
                        console.log(rsp.data);
                        if(rsp.data < 0){
                        $("#mozam_model").html('<a href="<?php echo base_url() ?>report/ledger/882"><div class="red-text text-center"><h4 class="info-box-text-one text-uppercase">MOZAM</h4><h6 class="info-box-text-h6 total" id="mozam_total"></h6><h6 class="info-box-text-h6"></h6></div></a>');
                        $("#mozam_total").text(rsp.data);
                        }else{
                            $("#mozam_model").html('<a href="<?php echo base_url() ?>report/ledger/882"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">MOZAM</h4><h6 class="info-box-text-h6 total" id="mozam_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#mozam_total").text(rsp.data);
                        }
                    }else{
                            $("#mozam_model").html('<a href="<?php echo base_url() ?>report/ledger/882"><div class="blue-text text-center"><h4 class="info-box-text-one text-uppercase">MOZAM</h4><h6 class="info-box-text-h6 total" id="mozam_total"></h6><h6 class="info-box-text-h6"</h6></div></a>');
                        $("#mozam_total").text(0);
                        }
                }
            });
        });

        
        </script>
<!-- end Bank Balance Report -->


<?php } ?>


