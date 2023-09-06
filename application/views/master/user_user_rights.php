<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Rights
        </h1>
    </section>
    <div class="clearfix">
        <div class="row">
            <div style="margin: 15px;">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="main-frm">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Users<span class="required-sign">*</span></label>
                                            <div class="col-sm-4" style="margin-bottom:10px;">
                                                <?php
                                                
                                                ?>
                                                <select class="form-control select2" id="user_type" name="user_type" onchange="window.location='<?php echo base_url(); ?>master/user_user_rights?user_type='+$(this).val();">
                                                    <option value="">- Select User - </option>
                                                    <?php foreach($users as $user):?>
                                                    <option <?php echo $user_type_id == $user->user_id ? 'selected="selected"':''; ?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Allowed Accounts To Entry<span class="required-sign">*</span></label>
                                            <div class="col-sm-4" style="margin-bottom:10px;">
                                                <?php
                                                
                                                ?>
                                                <select class="form-control select2" id="allowed_accounts" name="allowed_accounts[]" multiple="multiple">
                                                    <option value="">- Select Account - </option>
                                                    <?php foreach($accounts as $account):?>
                                                    <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_name; ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Allowed Accounts To View<span class="required-sign">*</span></label>
                                            <div class="col-sm-4" style="margin-bottom:10px;">
                                                <?php
                                                
                                                ?>
                                                <select class="form-control select2" id="allowed_accounts_view" name="allowed_accounts_view[]" multiple="multiple">
                                                    <option value="">- Select Account - </option>
                                                    <?php foreach($accounts as $account):?>
                                                    <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_name; ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" id="select_user_default_cash_acc_id" name="select_user_default_cash_acc_id"
                                        value="<?php echo $user_default_cash_acc_id ?>"/>

                                        <div class="clearfix"></div>
                                        
                                            
                                                    
                                                <div class="form-group" id="">
                                                    <label for="bank_id" class="control-label col-sm-2">Default Bank/Cash Account<span class="required-sign">*</span></label>
                                                    <div class="col-sm-4">
                                                    <select name="user_default_cash_acc_id" id="user_default_cash_acc_id" class=" form-control select2" ></select>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Allowed Users To View <span class="required-sign">*</span></label>
                                                        <div class="col-sm-4" style="margin-bottom:10px;">
                                                            <?php
                                                            
                                                            ?>
                                                            <select class="form-control select2" id="allowed_users_view" name="allowed_users_view[]" multiple="multiple">
                                                                <option value="">- Select User - </option>
                                                                <?php foreach($users as $user):?>
                                                                <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>                                      
                                                </div>
                                            
                                            
                                        
                                        <a class="btn btn-success btn-update-roles pull-right" style="position:fixed; right:30px;">Update [ Ctrl + S ]</a>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix"></div>
                                        
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Module AND Roles
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="20%">Module</th>
                                                            <th width="80%">
                                                                Roles
                                                                <a class="btn btn-xs btn-danger un-chk-all pull-right">Un Select ALL</a>
                                                                <a class="btn btn-xs btn-primary chk-all pull-right" style="margin-right: 5px;">Select ALL</a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if(count($modules_roles) > 0):
                                                        ?>
                                                        <?php foreach($modules_roles as $key => $row):?>
                                                            <?php
                                                                if(in_array($row['id'],array(MASTER_COMPANY_ID,MASTER_USER_ID,MASTER_USER_RIGHTS_ID))) {
                                                                    continue;
                                                                }
                                                            ?>
                                                        <tr>
                                                            <td><?php echo $row['title'];?></td>
                                                            <td>
                                                                <?php foreach($row['roles'] as $role):?>
                                                                <label class="col-sm-2">
                                                                    <input type="checkbox" <?php echo in_array($role['module_role_id'], $user_roles) ? 'checked="checked"':''; ?> class="chkids <?php echo $row['main_module']; ?>" value="<?php echo $role['module_role_id'];?>" name="roles[<?php echo $role['module_role_id'];?>_<?php echo $role['website_module_id'];?>]" /> <?php echo str_replace("_", " ", ucwords($role['title']));?>
                                                                </label>
                                                                <?php endforeach;?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                        <?php endif;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <a class="btn btn-success btn-update-roles pull-right">Update [ Ctrl + S ]</a>
                                    </form>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $('#allowed_accounts').select2();
        $('#allowed_accounts_view').select2();
        $('#allowed_users_view').select2();

        var select_user_default_cash_acc_id= $("#select_user_default_cash_acc_id").val();

        initAjaxSelect2($("#user_default_cash_acc_id"), "<?= base_url('app/cash_bank_account_select2_source') ?>");

        // initAjaxSelect2($("#user_default_cash_acc_id"),"<?=base_url('app/cash_bank_account_select2_source/')?>" + select_user_default_cash_acc_id);

        <?php if(($user_default_cash_acc_id!=0) && isset($user_default_cash_acc_id)) { ?>
        setSelect2Value($("#user_default_cash_acc_id"), "<?= base_url('app/set_account_select2_val_by_id/'.$user_default_cash_acc_id) ?>");
        <?php } ?>
        
        var PRESELECTED_FRUITS =<?php echo json_encode($set_allowed_account_ids );?>;
        var PRESELECTED_FRUITS_VIEW =<?php echo json_encode($set_allowed_account_ids_view );?>;
        var PRESELECTED_FRUITS_USER_VIEW =<?php echo json_encode($set_allowed_user_ids_view );?>;
		
        setSelect2MultiValue($("#allowed_accounts"), "<?=base_url('app/set_account_id_select2_multi_val_by_id/')?>"+PRESELECTED_FRUITS);    
        setSelect2MultiValue($("#allowed_accounts_view"), "<?=base_url('app/set_account_id_select2_multi_val_by_id/')?>"+PRESELECTED_FRUITS_VIEW);    
        setSelect2MultiValue($("#allowed_users_view"), "<?=base_url('app/set_user_id_select2_multi_val_by_id/')?>"+PRESELECTED_FRUITS_USER_VIEW);    


        

        // $("#user_default_cash_acc_id").val(442);

        $('#user_type').select2();
        $(".chk-all").click(function(){
            $(".chkids").prop("checked",true);
        });

        $(".un-chk-all").click(function(){
            $(".chkids").prop("checked",false);
        });
        
        $(document).on("keydown", function(e){
            if(e.ctrlKey && e.which == 83){
                update_rights();
                return false;
            }
        });

        $(".btn-update-roles").click(function(){
            update_rights();
            return false;
        });
    });
    
    function update_rights(){
        $.ajax({
            type: 'post',
            url: '<?=base_url("master/update_roles/")?>',
            data: $('.main-frm').serialize(),
            success: function(data) {
                var data = JSON.parse(data);
                $msg = data.msg;
                if(data.status == 1)
                {
                    show_notify($msg,true);
                }
                else
                {
                    show_notify($msg,false);
                }

            },
        });
    }
</script>
