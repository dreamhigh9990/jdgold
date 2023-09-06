<?php
if(isset($this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']) && !empty($this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in'])){
    if($this->session->userdata()['userType']) {
        $userType = $this->session->userdata()['userType'];
    }
    if($userType == USER_TYPE_USER) {
        $logged_in_name = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in_user']['user_name'];
        $logged_in_email = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in_user']['user'];
        $logged_in_image = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in_user']['logo_image'];
    } else {
        $logged_in_name = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']['user_name'];
        $logged_in_email = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']['user'];
        $logged_in_image = $this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']['logo_image'];    
    }
	
//        echo "<pre>"; print_r($this->session->userdata()[PACKAGE_FOLDER_NAME.'is_logged_in']); exit;
}
$currUrl = $this->uri->segment(1);
if($currUrl == ''){
	$currUrl = 'Dashboard';
}
if(isset($page_title)) {
    $currUrl = $page_title;
}
$package_name = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'package_name'));
$login_logo = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'login_logo'));

$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
$segment3 = $this->uri->segment(3);
$is_single_line_item = $this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')['is_single_line_item'];
$is_single_line_item = 1;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<title> <?=ucwords(str_replace("_", " ", $currUrl))?> | <?php echo $package_name; ?></title>


    	<link rel="stylesheet" href="<?= base_url();?>assets/css/style.css">
	    <!-- Bootstrap 3.3.6 -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.min.css">
	    <!-- Font Awesome -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/font-awesome.min.css">
	    <!-- Ionicons -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/ionicons.min.css">
	    <!-- iCheck for checkboxes and radio inputs -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/all.css">
	    <!-- jvectormap -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/jquery-jvectormap-1.2.2.css">
	    <!----------------Notify---------------->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/jquery.growl.css">
	    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/icon.css">

	    <link rel="stylesheet" href="<?= base_url();?>assets/css/datepicker3.css">
	    <!-- daterange picker -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/daterangepicker.css">
	    <!-- jQuery 2.2.3 -->
	    <script src="<?= base_url();?>assets/js/jquery-2.2.3.min.js"></script>
	    <!-------- /Parsleyjs --------->
	    <link href="<?= base_url();?>assets/css/parsley.css" rel="stylesheet" type="text/css">
	    <!-- DataTables -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/jquery.dataTables.min.css">
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/scroller.dataTables.min.css">
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/buttons.dataTables.min.css">
	    <!-- select 2 -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/select2.css">
	    <script src="<?= base_url();?>assets/js/select2.full.js"></script>
	    <!-- Theme style -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/AdminLTE.min.css">
	    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	    <link rel="stylesheet" href="<?= base_url();?>assets/css/_all-skins.min.css">
	    <link href="<?= base_url();?>assets/css/sweetalert.css" rel="stylesheet" type="text/css">
	    <link href="<?= base_url();?>assets/css/custom.css" rel="stylesheet" type="text/css">
	    <script src="https://kit.fontawesome.com/0270e2f21f.js" crossorigin="anonymous"></script>


	    <link rel="stylesheet" href="<?=base_url('assets/plugins/s2/select2.css');?>">
		<script src="<?=base_url('assets/plugins/s2/select2.full.js');?>"></script>

	    <style>
	        .dropdown-submenu {
	            position: relative;
	        }
            .dropdown-submenu:hover>.dropdown-menu {
                display: block;
                /* padding-right: 11px; */
                margin-left: 264px;
                margin-top:-60px;
            }

	        .dropdown-submenu>.dropdown-menu {
	            top: 0;
	            left: 100%;
	            margin-top: -6px;
	            margin-left: -1px;
	            -webkit-border-radius: 0 6px 6px 6px;
	            -moz-border-radius: 0 6px 6px;
	            border-radius: 0 6px 6px 6px;
	        }

	        .dropdown-submenu>a:after {
	            display: block;
	            content: " ";
	            float: right;
	            width: 0;
	            height: 0;
	            border-color: transparent;
	            border-style: solid;
	            border-width: 5px 0 5px 5px;
	            border-left-color: #ccc;
	            margin-top: 5px;
	            margin-right: -10px;
	        }

	        .dropdown-submenu:hover>a:after {
	            border-left-color: #fff;
	        }

	        .dropdown-submenu.pull-left {
	            float: none;
	        }

	        .dropdown-submenu.pull-left>.dropdown-menu {
	            left: -100%;
	            margin-left: 10px;
	            -webkit-border-radius: 6px 0 6px 6px;
	            -moz-border-radius: 6px 0 6px 6px;
	            border-radius: 6px 0 6px 6px;
	        }

	        .navbar-header2 {
	            background-color: white;
	        }
	    </style>
	    <style type="text/css">
	        .jqstooltip {
	            position: absolute;
	            left: 0px;
	            top: 0px;
	            visibility: hidden;
	            background: rgb(0, 0, 0) transparent;
	            background-color: rgba(0, 0, 0, 0.6);
	            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
	            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
	            color: white;
	            font: 10px arial, san serif;
	            text-align: left;
	            white-space: nowrap;
	            padding: 5px;
	            border: 1px solid white;
	            z-index: 10000;
	        }

	        .jqsfield {
	            color: white;
	            font: 10px arial, san serif;
	            text-align: left;
	        }
	    </style>

	</head>
        

	<body class="skin-blue-light layout-top-nav" style="height: auto; min-height: 100%;">
	    
		<div class="wrapper" style="height: auto; min-height: 100%;">

			<header class="main-header">
				<nav class="navbar navbar-static-top">
                    <div class="container" style="width: 100%;background-color:#2B3984;">
                    	<div class="navbar-header">
                            <a href="<?= base_url()?>" class="navbar-brand" style="padding:0px;">
			                    <span class="logo-lg"><b style=""><span style="color: #009ad9;">
                            </span></b></span>
							</a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">

                                <?php if($this->applib->have_access_role(MASTER_ID,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"add") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"edit") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"add") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"edit") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"edit") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"view") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"edit") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"add")) { ?>
                                <li tabindex="0" class="dropdown <?= ($segment1 == 'master') ? 'active' : '' ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if($this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"edit") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"add") ) { ?>
                                            <li class="">
                                                <a tabindex="-1" href="<?php echo base_url() ?>account/account_list/"><i class="fa fa-circle-o"></i> Account</a>
                                                <?php /*<ul class="dropdown-menu">
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>account/account/"><i class="fa fa-circle-o"></i> Add Account</a></li>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>account/account_list/"><i class="fa fa-circle-o"></i> Account List</a></li>
                                                </ul>*/?>
                                                
                                            </li>
                                        <?php } ?>
                                        <?php if($this->applib->have_access_role(MASTER_USER_ID,"view") || $this->applib->have_access_role(MASTER_USER_ID,"edit") || $this->applib->have_access_role(MASTER_USER_ID,"add") ) { ?>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?php echo base_url() ?>master/user_list/"><i class="fa fa-circle-o"></i> User</a>
                                                <ul class="dropdown-menu">
                                                <?php if($this->applib->have_access_role(MASTER_USER_ID,"add")) { ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>master/user/"><i class="fa fa-circle-o"></i> Add User</a></li>
                                                <?php } ?>
                                                <?php if($this->applib->have_access_role(MASTER_USER_ID,"view")) { ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>master/user_list/"><i class="fa fa-circle-o"></i> User List</a></li>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>master/user_user_rights/"><i class="fa fa-circle-o"></i> User Rights</a></li>
                                                <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
					                    <!-- <?php if($this->applib->have_access_role(MASTER_INVOICE_TYPE_ID,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'invoice_type') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/invoice_type/"><i class="fa fa-circle-o"></i> Invoice Type</a>
					                    </li>
					                    <?php } ?> -->
					                    <!-- <?php if($this->applib->have_access_role(MASTER_STATE_ID,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'state') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/state/"><i class="fa fa-circle-o"></i> State</a>
					                    </li>
					                    <?php } ?> 
					                    <?php if($this->applib->have_access_role(MASTER_CITY_ID,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'city') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/city/"><i class="fa fa-circle-o"></i> City</a>
					                    </li>
					                    <?php } ?>-->
					                    <?php if($this->applib->have_access_role(MASTER_ACCOUNT_GROUP_ID,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'account_group') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/account_group/"><i class="fa fa-circle-o"></i> Account Group</a>
					                    </li>
					                    <?php } ?>
                                        <?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'account_group') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/currency/"><i class="fa fa-circle-o"></i> Currency</a>
					                    </li>
					                    <?php } ?>
                                        <?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"edit")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'account_group') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/currency_rate/"><i class="fa fa-circle-o"></i> Currency Rate</a>
					                    </li>
					                    <?php } ?>
					                    <?php if($this->applib->have_access_role(MASTER_IMPORT_ID,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'import') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/import/"><i class="fa fa-circle-o"></i> Import</a>
					                    </li>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'export') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/export/"><i class="fa fa-circle-o"></i> Export</a>
					                    </li>
					                    <?php } ?>
                                        <!-- <?php if($this->applib->have_access_role(MODULE_SALES_DISCOUNT_ID,"view")) { ?>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?php echo base_url() ?>sales/discount_list/"><i class="fa fa-circle-o"></i> Discount</a>
                                                <ul class="dropdown-menu">
                                                    <?php if($this->applib->have_access_role(MODULE_SALES_DISCOUNT_ID,"add")) { ?>
                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>sales/discount_new/"><i class="fa fa-circle-o"></i> Add Discount</a></li>
                                                        <?php } ?>
                                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>sales/discount_list/"><i class="fa fa-circle-o"></i> Discount List</a></li>
                                                </ul>
                                            </li>
                                        <?php } ?> -->
					                    <!-- <?php if($userType == 'Admin' && $this->applib->have_access_role(MASTER_USER_RIGHTS_ID,"view")) { ?>
					                    <li class="<?= ($segment1 == 'master' && $segment2 == 'user_rights') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>master/user_rights/"><i class="fa fa-circle-o"></i> User Rights</a>
					                    </li>
					                    <?php } ?> -->
                                        <?php if($this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"view")) { ?>
                                            <li class="<?= ($segment1 == 'master' && $segment2 == 'bank_machine') ? 'active' : '' ?>">
                                                <a href="<?php echo base_url() ?>master/bank_machine/"><i class="fa fa-circle-o"></i> Bank Swipe Machine</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>	
                                <?php } ?>

                                <li tabindex="0" class="dropdown <?= ($segment1 == 'gstr1_excel' || $segment1 == 'gstr2_excel' || $segment1 == 'gstr_3b_excel')? 'active' : '' ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">₹ Amount <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <!-- <?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"view")) { ?>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?php echo base_url() ?>transaction/payment_list"><i class="fa fa-circle-o"></i> Payment</a>
                                                <ul class="dropdown-menu">
                                                    <?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"add")) { ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/payment/"><i class="fa fa-circle-o"></i> Add Payment</a></li>
                                                    <?php } ?>
                                                    <?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"add")) { ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/gst_payment/"><i class="fa fa-circle-o"></i> GST Payment</a></li>
                                                    <?php } ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/payment_list"><i class="fa fa-circle-o"></i> Payment List</a></li>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                        <?php if($this->applib->have_access_role(MODULE_RECEIPT_ID,"view")) { ?>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?php echo base_url() ?>transaction/receipt_list"><i class="fa fa-circle-o"></i> Receipt</a>
                                                <ul class="dropdown-menu">
                                                    <?php if($this->applib->have_access_role(MODULE_RECEIPT_ID,"add")) { ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/receipt/"><i class="fa fa-circle-o"></i> Add Receipt</a></li>
                                                    <?php } ?>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/receipt_list/"><i class="fa fa-circle-o"></i> Receipt List</a></li>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                        <?php if($this->applib->have_access_role(MODULE_CONTRA_ID,"view")) { ?>
                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?php echo base_url() ?>contra/contra_list"><i class="fa fa-circle-o"></i> Contra</a>
                                                <ul class="dropdown-menu">
                                                    <?php if($this->applib->have_access_role(MODULE_CONTRA_ID,"add")) { ?>
                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>contra/contra/"><i class="fa fa-circle-o"></i> Add Contra</a></li>
                                                        <?php } ?>
                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>contra/contra_list/"><i class="fa fa-circle-o"></i> Contra List</a></li>
                                                    </ul>
                                                </li>
                                                <?php } ?>
                                                <?php if($this->applib->have_access_role(MODULE_JOURNAL_ID,"view")) { ?>
                                                    <li class="dropdown-submenu">
                                                        <a tabindex="-1" href="<?php echo base_url() ?>journal/journal_list/"><i class="fa fa-circle-o"></i> Journal</a>
                                                        <ul class="dropdown-menu">
                                                            <?php if($this->applib->have_access_role(MODULE_JOURNAL_ID,"add")) { ?>
                                                                <li><a tabindex="-1" href="<?php echo base_url() ?>journal/journal"><i class="fa fa-circle-o"></i> Add Journal</a></li>
                                                                <?php } ?>
                                                                <?php if($this->applib->have_access_role(MODULE_JOURNAL_ID,"journal type 2")) { ?>
                                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>journal/journal_type2"><i class="fa fa-circle-o"></i> Journal Type 2</a></li>
                                                                    <?php } ?>
                                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>journal/journal_list/"><i class="fa fa-circle-o"></i> Journal List</a></li>
                                                                </ul>
                                                            </li>
                                                            <?php } ?> -->
                                                            <!-- <li class="dropdown">
                                                                <a tabindex="-1" href="<?php echo base_url() ?>transaction/day_book/"><i class="fa fa-circle-o"></i> Day Book</a>
                                                            </li> -->
                                                            <li class="dropdown-submenu">
                                                                <a tabindex="-1" href="<?php echo base_url() ?>transaction/listbanktrans/"><i class="fa fa-circle-o"></i> Swipe </a>
                                                                <ul class="dropdown-menu">
                                                                    <?php if($this->applib->have_access_role(MODULE_BANK_TRANSACTION,"add")) { //PENDING?><?php } ?>
                                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/banktrans/"><i class="fa fa-circle-o"></i> Add Swipe</a></li>
                                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/listbanktrans/"><i class="fa fa-circle-o"></i> List Swipe</a></li>
                                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/listgroupbanktrans/"><i class="fa fa-circle-o"></i> Bank View</a></li>
                                                                </ul>
                                                            </li>

                                                            <?php if($this->applib->have_access_role(MODULE_MBTRANS_ID,"view")) { ?>
                                                                <li class="dropdown-submenu">
                                                                    <a tabindex="-1" href="<?php echo base_url() ?>transaction/mbtrans_list"><i class="fa fa-circle-o"></i> MB Trans</a>
                                                                    <ul class="dropdown-menu">
                                                                        <?php if($this->applib->have_access_role(MODULE_MBTRANS_ID,"add")) { ?>
                                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/mbtrans/"><i class="fa fa-circle-o"></i> Add MBTrans</a></li>
                                                                        <?php } ?>
                                                                        
                                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/mbtrans_list"><i class="fa fa-circle-o"></i> MBTrans List</a></li>
                                                                    </ul>
                                                                </li>
                                                            <?php } ?>

                                                        </ul>
                                                    </li>
                                                    
                                <?php if($this->applib->have_access_role(MODULE_REPORT_ID,"view") || $this->applib->have_access_role(MODULE_Report_depoWithdraw,"view") || $this->applib->have_access_role(MODULE_LEDGER_ID,"view") || $this->applib->have_access_role(MODULE_USER_LOG_ID,"view")) { ?>
                                <li tabindex="0" class="dropdown <?= ($segment1 == 'report')? 'active' : '' ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <!-- <li class="dropdown-submenu">
                                            <a tabindex="-1" href=""><i class="fa fa-circle-o"></i> Register</a>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-submenu">
                                                        <a tabindex="-1" href=""><i class="fa fa-circle-o"></i> Sales</a>
                                                        <ul class="dropdown-menu">
                                                            <?php if($this->applib->have_access_role(MODULE_SALES_REGISTER_ID,"view")) { ?>
                                                            <li class="<?= ($segment2 == 'sales') ? 'active' : '' ?>">
                                                                <a href="<?php echo base_url() ?>report/sales/"><i class="fa fa-circle-o"></i> Sales Register</a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($this->applib->have_access_role(MODULE_SALES_BILL_REGISTER_ID,"view")) { ?>
                                                            <li class="<?= ($segment2 == 'sales_bill') ? 'active' : '' ?>">
                                                                <a href="<?php echo base_url() ?>report/sales_bill/"><i class="fa fa-circle-o"></i> Sales Bill Register</a>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </li>
                                                    <?php if($this->applib->have_access_role(MODULE_STOCK_REGISTER_ID,"view")) { ?>
                                                        <li class="<?= ($segment2 == 'stock') ? 'active' : '' ?>">
                                                            <a href="<?php echo base_url() ?>report/stock/"><i class="fa fa-circle-o"></i> Stock Register</a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->applib->have_access_role(MODULE_PURCHASE_REGISTER_ID,"view")) { ?>
                                                        <li class="<?= ($segment2 == 'purchase') ? 'active' : '' ?>">
                                                            <a href="<?php echo base_url() ?>report/purchase/"><i class="fa fa-circle-o"></i> Purchase Register</a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->applib->have_access_role(MODULE_CREDIT_NOTE_REGISTER_ID,"view")) { ?>
                                                        <li class="<?= ($segment2 == 'credit_note') ? 'active' : '' ?>">
                                                            <a href="<?php echo base_url() ?>report/credit_note/"><i class="fa fa-circle-o"></i> Credit Note Register</a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->applib->have_access_role(MODULE_DEBIT_NOTE_REGISTER_ID,"view")) { ?>
                                                        <li class="<?= ($segment2 == 'debit_note') ? 'active' : '' ?>">
                                                            <a href="<?php echo base_url() ?>report/debit_note/"><i class="fa fa-circle-o"></i> Debit Note Register</a>
                                                        </li>
                                                        <?php } ?>
                                                </ul>
                                            </li> -->

                                            <?php if($this->applib->have_access_role(MODULE_Report_depoWithdraw,"view")) { ?>
                                            <li class="<?= ($segment2 == 'ledger') ? 'active' : '' ?>">
                                                <a href="<?php echo base_url() ?>report/depoWithdraw/"><i class="fa fa-circle-o"></i>depoWithdraw</a>
                                            </li>
                                            <?php } ?>
					                    
                                            <?php if($this->applib->have_access_role(MODULE_LEDGER_ID,"view")) { ?>
                                            <li class="<?= ($segment2 == 'ledger') ? 'active' : '' ?>">
                                                <a href="<?php echo base_url() ?>report/ledger/"><i class="fa fa-circle-o"></i> Ledger</a>
                                            </li>
                                            <li class="<?= ($segment2 == 'ledger_new') ? 'active' : '' ?>">
                                                <a href="<?php echo base_url() ?>report/ledger_new/"><i class="fa fa-circle-o"></i> Ledger New</a>
                                            </li>
                                            <?php } ?>
                                            <!-- <?php if($this->applib->have_access_role(MODULE_SUMMARY_ID,"view")) { ?>
                                            <li class="<?= ($segment2 == 'summary_billwise') ? 'active' : '' ?> dropdown-submenu">
                                                <a href="<?php echo base_url() ?>report/summary_billwise"><i class="fa fa-circle-o"></i> Outstanding</a>

                                                <ul class="dropdown-menu">
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/receivable"><i class="fa fa-circle-o"></i> Receivable</a></li>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/payable"><i class="fa fa-circle-o"></i> Payable</a></li>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/billwise_receivable"><i class="fa fa-circle-o"></i> Bill Wise Receivable</a></li>
                                                    <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/billwise_payable"><i class="fa fa-circle-o"></i> Bill Wise Payable</a></li>
                                                </ul>
					                        </li>
					                    <?php } ?>
					                    <?php if($this->applib->have_access_role(MODULE_BALANCE_SHEET_ID,"view")) { ?>
					                    <li class="<?= ($segment2 == 'balance_sheet') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>report/balance_sheet/"><i class="fa fa-circle-o"></i> Balance Sheet</a>
					                    </li>
					                    <?php } ?>
					                    <?php if($this->applib->have_access_role(MODULE_BALANCE_SHEET_ID,"view")) { ?>
					                    <li class="<?= ($segment2 == 'balance_sheet_new') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>report/balance_sheet_new/"><i class="fa fa-circle-o"></i> Balance Sheet 2</a>
					                    </li>
					                    <?php } ?>
					                    <?php if($this->applib->have_access_role(MODULE_PROFIT_LOSS_ID,"view")) { ?>
					                    <li class="<?= ($segment2 == 'profit_loss') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>report/profit_loss/"><i class="fa fa-circle-o"></i> Profit Loss</a>
					                    </li>
					                    <?php } ?> -->
					                    <?php if($this->applib->have_access_role(MODULE_TRIAL_BALANCE_ID,"view")) { ?>
					                    <li class="<?= ($segment2 == 'trial_balance') ? 'active' : '' ?>">
					                        <a href="<?php echo base_url() ?>report/trial_balance/"><i class="fa fa-circle-o"></i> All Net Balance</a>
					                    </li>
					                    <?php } ?>
					                    <?php if($this->applib->have_access_role(MODULE_USER_LOG_ID,"view")) { ?>
					                        <li class="<?= ($segment2 == 'login_report') ? 'active' : '' ?>">
					                            <a href="<?php echo base_url() ?>report/login_report/"><i class="fa fa-circle-o"></i> User Log Report</a>
					                        </li>
					                    <?php } ?>
					                    <!-- <li class="<?= ($segment2 == 'stock_status_report') ? 'active' : '' ?>">
                                            <a href="<?php echo base_url() ?>report/stock_status_report/"><i class="fa fa-circle-o"></i> Stock Status Report </a>
                                        </li> -->
					                    <!-- <li class="<?= ($segment2 == 'pending_bills_report') ? 'active' : '' ?>">
                                            <a href="<?php echo base_url() ?>report/pending_bills_report/"><i class="fa fa-circle-o"></i> Pending Bills Report </a>
                                        </li>
                                        <li class="<?= ($segment2 == 'site_report') ? 'active' : '' ?>">
                                            <a href="<?php echo base_url() ?>report/site_report/"><i class="fa fa-circle-o"></i> Site Report </a>
                                        </li>
                                        <li class="<?= ($segment2 == 'site_wise_expenses_summary_ac') ? 'active' : '' ?>">
                                            <a href="<?php echo base_url() ?>report/site_wise_expenses_summary_ac/"><i class="fa fa-circle-o"></i>Site Wise Expenses Summary AC </a>
                                        </li>
                                        <li class="<?= ($segment2 == 'site_wise_expenses_summary') ? 'active' : '' ?>">
                                            <a href="<?php echo base_url() ?>report/site_wise_expenses_summary/"><i class="fa fa-circle-o"></i>Site Wise Expenses Summary </a>
                                        </li> -->
                                    </ul>
                                </li>	
                                <?php } ?>

                                <!-- <?php if($this->applib->have_access_role(MODULE_GSTR1_EXCEL_EXPORT_ID,"view") || $this->applib->have_access_role(MODULE_GSTR2_EXCEL_EXPORT_ID,"view") || $this->applib->have_access_role(MODULE_GSTR_3B_EXCEL_EXPORT_ID,"view")) { ?>
                                <li tabindex="0" class="dropdown <?= ($segment1 == 'gstr1_excel' || $segment1 == 'gstr2_excel' || $segment1 == 'gstr_3b_excel')? 'active' : '' ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">VAT <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if($this->applib->have_access_role(MODULE_GSTR1_EXCEL_EXPORT_ID,"view")) { ?>
                                            <li class="<?= ($segment1 == 'gstr1_excel') ? 'active' : '' ?>">
                                                <a href="<?= base_url() ?>gstr1_excel/"><i class="fa fa-circle-o"></i>  GSTR1 Excel Export</a>
                                            </li>
                                            <?php } ?>
                                            <?php if($this->applib->have_access_role(MODULE_GSTR2_EXCEL_EXPORT_ID,"view")) { ?>
                                                <li class="<?= ($segment1 == 'gstr2_excel') ? 'active' : '' ?>">
                                                    <a href="<?= base_url() ?>gstr2_excel/"><i class="fa fa-circle-o"></i>  GSTR2 Excel Export</a>
                                                </li>
                                                <?php } ?>
                                                <?php if($this->applib->have_access_role(MODULE_GSTR_3B_EXCEL_EXPORT_ID,"view")) { ?>
                                                    <li class="<?= ($segment1 == 'gstr_3b_excel') ? 'active' : '' ?>">
                                                        <a href="<?= base_url() ?>gstr_3b_excel/"><i class="fa fa-circle-o"></i>  GSTR-3B Excel Export</a>
                                                    </li>
                                                    <?php } ?>
                                                    <?php if($this->applib->have_access_role(MODULE_STOCK_STATUS_CHANGE_ID,"view")) { ?>
                                                        <li class="<?= ($segment1 == 'master' && $segment2 == 'stock_status_change') ? 'active' : '' ?>">
                                                            <a href="<?php echo base_url() ?>master/stock_status_change/"><i class="fa fa-circle-o"></i> Stock Status Change</a>
                                                        </li>
                                                        <?php } ?>
                                                        <?php if($this->applib->have_access_role(MODULE_SALES_INVOICE_ID,"add")) { ?>
                                                            <?php if($is_single_line_item == 1){?>
                                                                <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/sales_purchase_transaction/sales3"><i class="fa fa-circle-o"></i>Add Invoice 3 Old</a></li>
                                                            <?php } else { ?>
                                                                <li><a tabindex="-1" href="<?php echo base_url() ?>sales/invoice/"><i class="fa fa-circle-o"></i>Add Invoice 3 Old</a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <li><a tabindex="-1" href="<?php echo base_url() ?>sales/invoice_list/3"><i class="fa fa-circle-o"></i>Sales Invoice 3 List Old</a></li>
                                    </ul>
                                </li>
                                <?php } ?> -->

					            <?php if($this->applib->have_access_role(MODULE_BACKUP_DB_ID,"view")) { ?>
				                <li tabindex="0" class="dropdown <?= ($segment1 == 'backup') ? 'active' : '' ?>">
				                    <a href="<?= base_url() ?>backup/">
				                        <span>Backup DB</span>
				                    </a>
				                </li>
                                <li tabindex="0" class="dropdown <?= ($segment1 == 'dashboard') ? 'active' : '' ?>">
				                    <a href="<?= base_url() ?>">
				                        <span>Dashboard</span>
				                    </a>
				                </li>
					            <?php } ?>
                            </ul>
                        </div>
                        <div class="navbar-custom-menu">
                        	<ul class="nav navbar-nav">
                        		<!-- <?php
                                    // if($userType == 'Admin') {
                                        ?> -->
                                    <li class="dropdown staff-menu">
                                        <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-users"></i>
                                        </a> -->
                                        <ul class="dropdown-menu" role="menu">
                                            <!-- User image -->
                                            <li class="">
                                                <form>
                                                    <div class="form-group">
                                                        <?php $lead_owner = $this->crud->get_select_data_where('user',array('userType !=' => USER_TYPE_USER)); ?>
                                                        <div class="col-sm-12">
                                                            <select name="staff_session_id" id="staff_session_id" class="form-control input-sm select2">
                                                                <option value="">--Select--</option>
                                                                <?php foreach($lead_owner as $lo): ?>
                                                                <option value="<?= $lo->user_id; ?>"<?php if($this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')['user_id'] == $lo->user_id){echo 'selected';}?>><?= $lo->user_name; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
								<!-- <?php
                                    // }
                                    ?> -->

								<!-- User Account: style can be found in dropdown.less -->
								<li class="dropdown user user-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<!--<img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg');?>" class="user-image" alt="User Image">-->
										<img src="<?=isset($logged_in_image) && !empty($logged_in_image) ? base_url() .'assets/uploads/logo_image/'.$logged_in_image : base_url() . 'assets/dist/img/default-user.png';?>" class="user-image" alt="User Image">
										<span class="hidden-xs"><?=isset($logged_in_name)?ucwords($logged_in_name):'Admin';?></span>
									</a>
									<ul class="dropdown-menu">
										<!-- User image -->
										<li class="user-header">
											<img src="<?=isset($logged_in_image) && !empty($logged_in_image) ? BASE_URL.'assets/uploads/logo_image/'.$logged_in_image : base_url() . 'assets/dist/img/default-user.png';?>" class="img-circle" alt="User Image">
											<p>
												<?=isset($logged_in_name)?ucwords($logged_in_name):'Admin';?>
												<br/>
												<?=isset($logged_in_email)?$logged_in_email:'';?>
											</p>
										</li>
										<!-- Menu Footer-->
										<li class="user-footer">
											<div class="pull-left">
                                                <?php
                                                if($userType == USER_TYPE_USER) {
                                                    ?>
                                                    <!-- <a href="<?= base_url()?>master/user/profile" class="btn btn-default btn-flat">Profile</a> -->
                                                    <?php
                                                } else {
                                                    ?>
                                                    <!-- <a href="<?= base_url()?>user/user/1" class="btn btn-default btn-flat">Profile</a> -->
                                                    <?php
                                                }
                                                
                                                ?>
                                                <a href="<?= base_url('auth/profile'); ?>" class="btn btn-default pull-right" target="_blank">Change Password</a>
											</div>
											<div class="pull-right">
												<a href="<?= base_url()?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
											</div>
										</li>
									</ul>
								</li>
								<!-- Control Sidebar Toggle Button -->
                        	</ul>
                        </div>
                    </div>
                </nav>
			</header>
			<script>
                
                $(document).ready(function() {
                    $('.redBG').removeClass('redBG').addClass('black');
                    });

				$(document).ready(function(){
					$(".select2").select2({
						width:"100%",
						placeholder: " --Select-- ",
						allowClear: true,
					});
					$(document).on('change','#staff_session_id',function(){
						$.ajax({
							type: "POST",
							url: '<?=base_url();?>auth/change_seesion_staff',
							data: { user_id: $(this).val() },
							dataType: 'json',
							success: function(data){
								if(data.success) {
									location.reload();
								} else {
									alert('Something Went Wrong Please Try Again');
								}
							},
						});
					});
				});





                function showMenus() {
                    $(".navmenu1").toggleClass("showMenu");
                }
                function showMenus2() {
                    $(".navmenu2").toggleClass("showMenu");
                    
                }
                function showMenus3() {
                    $(".navmenu3").toggleClass("showMenu");
                }
			</script>

	<div class="sidebar close">
        <div class="logo-details">
          <i class='bx'><img src="<?php echo base_url('assets/img/om.png');?>" alt=""
                                            width="30px"></i>
          <span class="logo_name">GANPATI</span>
        </div>
        <ul class="nav-links">

        	<li>
            <a href="<?=base_url() ?>">
                <span class="icon-dashboard icon"></span>
              <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="<?=base_url() ?>">Dashboard</a></li>
            </ul>
          </li>
          <li>
            <a href="<?=base_url() ?>report/ganpati/">
                <span class="icon-dashboard icon"></span>
              <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="<?=base_url() ?>report/ganpati/">Dashboard Ganpati</a></li>
            </ul>
          </li>
          <?php if($this->applib->have_access_role(MODULE_TRIAL_BALANCE_ID,"view")) { ?>
        <li>
            <a href="<?=base_url() ?>report/trial_balance/">
                <span class="icon-report icon"></span>
              <span class="link_name">All Net Balance</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="<?php echo base_url() ?>report/trial_balance/">All Net Balance</a></li>
            </ul>
          </li>
          <?php }?>
            
    	 	<?php if($this->applib->have_access_role(MASTER_ID,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"add") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"edit") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"add") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"edit") || $this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"edit") || $this->applib->have_access_role(MASTER_IMPORT_ID,"view") || $this->applib->have_access_role(MASTER_IMPORT_ID,"edit")  || $this->applib->have_access_role(MASTER_IMPORT_ID,"add") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"edit") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"add") || $this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"view")) { ?>
			<li class="navmenu1" onClick="return showMenus()">
          	 	<div class="icon-link" >
                  <a href="#">
                    <span class="icon-master icon"></span>
                    <span class="dropdown link_name">Master <i class='bx bxs-chevron-down'></i></span>
                    
                  </a>
                  
                  <!-- <i class='bx bxs-chevron-down arrow'></i> -->

                </div>

                <ul class="sub-menu">

                	<!-----------------------account section start ---------------------------------------------->
                    <?php if($this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"add")) { ?>
                    <li class="">
                        <a tabindex="-1" href="<?php echo base_url() ?>account/account/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> Add Account</a>
                    </li>
                    <?php }?>
                    <?php if($this->applib->have_access_role(MASTER_ACCOUNT_COMPANY_ID,"view")) { ?>
                    <li class="">
                        <a tabindex="-1" href="<?php echo base_url() ?>account/account_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> Account</a>
                    </li>
                    <?php }?>

                    <?php if($this->applib->have_access_role(MASTER_USER_ID,"view") || $this->applib->have_access_role(MASTER_USER_ID,"edit") || $this->applib->have_access_role(MASTER_USER_ID,"add") ) { ?>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="<?php echo base_url() ?>master/user_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> User</a>
                        <ul class="dropdown-menu dropdown-menu-one">
                        <?php if($this->applib->have_access_role(MASTER_USER_ID,"add")) { ?>
                            <li><a tabindex="-1" href="<?php echo base_url() ?>master/user/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i> Add User</a></li>
                        <?php }?>
                        <?php if($this->applib->have_access_role(MASTER_USER_ID,"view")) { ?>
                            <li><a tabindex="-1" href="<?php echo base_url() ?>master/user_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i> User List</a></li>
                        <?php } ?>
                        <?php if($this->applib->have_access_role(MASTER_USER_ID,"view")) { ?>
                            <li><a tabindex="-1" href="<?php echo base_url() ?>master/user_user_rights/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i> User Rights</a></li>
                        </ul>
                        <?php } ?>
                    </li>
                     <?php } ?>
                      <?php if($this->applib->have_access_role(MASTER_ACCOUNT_GROUP_ID,"view")) { ?>
                    <li class="">
                        <a href="<?php echo base_url() ?>master/account_group/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> Account Group</a>
                    </li>
                    <?php } ?>
                    <?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY,"view")) { ?>
                    <li class="">
                        <a href="<?php echo base_url() ?>master/currency/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Currency</a>
                    </li>
                     <?php } ?>
                    <?php if($this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"view") || $this->applib->have_access_role(MASTER_ACCOUNT_CURRENCY_RATE,"edit")) { ?>
                    <li class="">
                        <a href="<?php echo base_url() ?>master/currency_rate/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Currency Rate</a>
                    </li>
                     <?php } ?>
                     <?php if($this->applib->have_access_role(MASTER_IMPORT_ID,"view")) { ?>
                    <li class="">
                        <a href="<?php echo base_url() ?>master/import/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Import</a>
                    </li>
                    <li class="">
                        <a href="<?php echo base_url() ?>master/export/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Export</a>
                    </li>
                    <?php } ?>
                    <?php if($this->applib->have_access_role(MASTER_BANK_SWIPE_GROUP_ID,"view")) { ?>
                    <li class="">
                        <a href="<?php echo base_url() ?>master/bank_machine/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Bank Swipe Machine</a>
                    </li>
                    <?php } ?>
                </ul>
          	</li>
          	<?php } ?>
         
          	<!-----------------------Amount section start ---------------------------------------------->
          

            <li class="navmenu2" onClick="return showMenus2()">
            <div class="icon-link">
              <a href="#">
                <span class="icon-amount icon"></span>
                <span class="link_name">Amount <i class='bx bxs-chevron-down'></i></span>
                
              </a>
              <!-- <i class='bx bxs-chevron-down arrow'></i> -->
              

            </div>
            <ul class="sub-menu">
            	<!-- <?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"view")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>transaction/payment_list"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Payment</a>
                    <ul class="dropdown-menu dropdown-menu-one">
                    	<?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/payment/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Add Payment</a></li>
                        <?php } ?>
                        <?php if($this->applib->have_access_role(MODULE_PAYMENT_ID,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/gst_payment/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  GST Payment</a></li>
                        <?php } ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/payment_list"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Payment List</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_RECEIPT_ID,"view")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>transaction/receipt_list"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Receipt</a>
                    <ul class="dropdown-menu dropdown-menu-one">
                    	<?php if($this->applib->have_access_role(MODULE_RECEIPT_ID,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/receipt/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Add Receipt</a></li>
                        <?php } ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/receipt_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Receipt List</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_CONTRA_ID,"view")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>contra/contra_list"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Contra</a>
                    <ul class="dropdown-menu dropdown-menu-one">
                    	<?php if($this->applib->have_access_role(MODULE_CONTRA_ID,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>contra/contra/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Add Contra</a></li>
                         <?php } ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>contra/contra_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Contra List</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_JOURNAL_ID,"view")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>journal/journal_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Journal</a>
                    <ul class="dropdown-menu dropdown-menu-one">
                    	<?php if($this->applib->have_access_role(MODULE_JOURNAL_ID,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>journal/journal"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Add Journal</a></li>
                         <?php } ?>
                        <?php if($this->applib->have_access_role(MODULE_JOURNAL_ID,"journal type 2")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>journal/journal_type2"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Journal Type 2</a></li>
                        <?php } ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>journal/journal_list/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Journal List</a></li>
                    </ul>
                </li>
                <?php } ?> -->
                <?php if($this->applib->have_access_role(MODULE_BANK_TRANSACTION,"view") || $this->applib->have_access_role(MODULE_BANK_TRANSACTION,"edit") || $this->applib->have_access_role(MODULE_BANK_TRANSACTION,"add")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>transaction/listbanktrans/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Swipe </a>
                    <ul class="dropdown-menu dropdown-menu-one">
                    <?php if($this->applib->have_access_role(MODULE_BANK_TRANSACTION,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/banktrans/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Add Swipe</a></li>
                    <?php }?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/listbanktrans/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  List Swipe</a></li>
                    </ul>
                </li>
                <?php }?>
                <?php if($this->applib->have_access_role(MODULE_MBTRANS_ID,"add") || $this->applib->have_access_role(MODULE_MBTRANS_ID,"view")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>transaction/mbtrans_list"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  MB Trans</a>
                    <ul class="dropdown-menu dropdown-menu-one">
                    	 <?php if($this->applib->have_access_role(MODULE_MBTRANS_ID,"add")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/mbtrans/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Add MBTrans</a></li>
                        <?php } ?>
                        
                        <?php if($this->applib->have_access_role(MODULE_MBTRANS_ID,"view")) { ?>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>transaction/mbtrans_list"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  MBTrans List</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
          </li>

                    <!-----------------------Report section start ---------------------------------------------->

          <?php if($this->applib->have_access_role(MODULE_REPORT_ID,"view")  || $this->applib->have_access_role(MODULE_Report_depoWithdraw,"view") || $this->applib->have_access_role(MODULE_TRIAL_BALANCE_ID,"view") || $this->applib->have_access_role(MODULE_LEDGER_ID,"view") || $this->applib->have_access_role(MODULE_USER_LOG_ID,"view")) { ?>
          <li class="navmenu3" onClick="return showMenus3()">
            <div class="icon-link">
              <a href="#">
                <span class="icon-report icon"></span>
                <span class="link_name">Report <i class='bx bxs-chevron-down'></i></span>
                
              </a>
              <!-- <i class='bx bxs-chevron-down arrow'></i> -->
              
            </div>
            <ul class="sub-menu">
            	<?php if($this->applib->have_access_role(MODULE_Report_depoWithdraw,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/depoWithdraw/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> depoWithdraw</a>
                </li>
            	<?php } ?>                
                <?php if($this->applib->have_access_role(MODULE_LEDGER_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/ledger/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Ledger</a>
                </li>
                <?php } ?>
            	<?php if($this->applib->have_access_role(MODULE_Report_depoWithdraw,"view")) { ?>
                    <!-- We do Not have "Ledger New" separate rights, it is better to use "depoWithdraw" rights for "Ledger New" -->
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/ledger_new/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Ledger New</a>
                </li>
                <?php } ?>
                <!-- <?php if($this->applib->have_access_role(MODULE_SUMMARY_ID,"view")) { ?>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Outstanding</a>
                    <ul class="dropdown-menu dropdown-menu-one">
                        <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/receivable"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Receivable</a></li>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/payable"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Payable</a></li>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/billwise_receivable"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>  Bill Wise Receivable</a></li>
                        <li><a tabindex="-1" href="<?php echo base_url() ?>report/summary_billwise/billwise_payable"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px; color: #000000;"></i>   Bill Wise Payable</a></li>
                    
                    </ul>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_BALANCE_SHEET_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/balance_sheet/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Balance Sheet</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_BALANCE_SHEET_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/balance_sheet_new/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Balance Sheet 2</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_PROFIT_LOSS_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/profit_loss/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Profit Loss</a>
                </li>
            	<?php } ?> -->
                <?php if($this->applib->have_access_role(MODULE_TRIAL_BALANCE_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/trial_balance/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  All Net Balance</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_USER_LOG_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/login_report/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   User Log Report </a>
                </li>
                <?php } ?>

                <!-- <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/pending_bills_report/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Pending Bills Report </a>
                </li>


                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/site_report/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>   Site Report </a>
                </li>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/site_wise_expenses_summary_ac/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Site Wise Expenses Summary AC </a>
                </li>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>report/site_wise_expenses_summary/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Site Wise Expenses Summary </a>
                </li> -->
            </ul>
          </li>
        <?php } ?>

        <!-----------------------VAT section start ---------------------------------------------->

          <!-- <?php if($this->applib->have_access_role(MODULE_GSTR1_EXCEL_EXPORT_ID,"view") || $this->applib->have_access_role(MODULE_GSTR2_EXCEL_EXPORT_ID,"view") || $this->applib->have_access_role(MODULE_GSTR_3B_EXCEL_EXPORT_ID,"view")) { ?>
           <li>
            <div class="icon-link">
              <a href="#">
                <span class="icon-vat icon"></span>
                <span class="link_name">VAT</span>
              </a>
              <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
            	<?php if($this->applib->have_access_role(MODULE_GSTR1_EXCEL_EXPORT_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?= base_url() ?>gstr1_excel/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  GSTR1 Excel Export</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_GSTR2_EXCEL_EXPORT_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?= base_url() ?>gstr2_excel/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  GSTR2 Excel Export</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_GSTR_3B_EXCEL_EXPORT_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?= base_url() ?>gstr_3b_excel/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  GSTR-3B Excel Export</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_STOCK_STATUS_CHANGE_ID,"view")) { ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>master/stock_status_change/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i>  Stock Status Change</a>
                </li>
                <?php } ?>
                <?php if($this->applib->have_access_role(MODULE_SALES_INVOICE_ID,"add")) { ?>
                	<?php if($is_single_line_item == 1){?>
	                <li class="">
	                    <a tabindex="-1" href="<?php echo base_url() ?>transaction/sales_purchase_transaction/sales3"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> Add Invoice 3 Old</a>
	                </li>
	                <?php } else { ?>
	                	<li class="">
	                    <a tabindex="-1" href="<?php echo base_url() ?>sales/invoice/"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> Add Invoice 3 Old</a>
	                </li>
	             	<?php } ?>
                <?php } ?>
                <li class="">
                    <a tabindex="-1" href="<?php echo base_url() ?>sales/invoice_list/3"><i class="fa fa-circle-o" aria-hidden="true" style="min-width: 32px;"></i> Sales Invoice 3 List Old</a>
                </li>
            </ul>
          </li>
          <?php } ?> -->

            <!-----------------------Backup DB section start ---------------------------------------------->
          <?php if($this->applib->have_access_role(MODULE_BACKUP_DB_ID,"view")) { ?>
          <li>
            <a href="#">
                <span class="icon-backup icon"></span>
              <span class="link_name">Backup DB</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="<?= base_url() ?>backup/">Backup DB</a></li>
            </ul>
          </li>
          
          
          <?php } ?>

          <li>
            <a href="<?= base_url() ?>auth/profile">
                <span class="icon-backup icon"></span>
              <span class="link_name">Change Password</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="<?= base_url() ?>auth/profile">Change Password</a></li>
            </ul>
          </li>
          <li>
            <a href="<?= base_url() ?>auth/logout">
                <span class="icon-backup icon"></span>
              <span class="link_name">Logout</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="<?= base_url() ?>auth/logout">Logout</a></li>
            </ul>
          </li>
          <!-----------------------Backup DB section End ---------------------------------------------->
          <li>
            <div class="profile-details">
              <div class="profile-content">
                <!-- <img src="<?php echo base_url('assets/img/2_1667219736.png');?>" alt="profileImg"> -->
              </div>
              <div class="name-job">
                <div class="profile_name"></div>
                <div class="job"><a href="mailto:admin@gmail.com" style="color: #fff;"> admin@gmail.com</a></div>
              </div>
              <a href="<?= base_url()?>auth/logout"><i class='bx bx-log-out'></i></a>
            </div>
          </li>



        </ul>
      </div>

<div class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>