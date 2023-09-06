<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller
{

    public $logged_in_id = null;
    public $now_time = null;
    function __construct()
    {
        parent::__construct();
        $this->load->model("Appmodel", "app_model");
        $this->load->model('Crud', 'crud');
        $this->load->library('form_validation');
        $this->now_time = date('Y-m-d H:i:s');
    }

    function index()
    {
        if ($this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')) {
            $where_array = array('data_lock_unlock' => '0', 'created_by' => $this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')['user_id']);

            $butt_profile = $this->db->select('profile')->where('account_id',536)->get('account')->row_array();
            $asif_profile = $this->db->select('profile')->where('account_id',533)->get('account')->row_array();
            $dharmi_profile = $this->db->select('profile')->where('account_id',1001)->get('account')->row_array();
            $hitesh_profile = $this->db->select('profile')->where('account_id',542)->get('account')->row_array();
            $irfan_profile = $this->db->select('profile')->where('account_id',1096)->get('account')->row_array();
            $rana_profile = $this->db->select('profile')->where('account_id',1094)->get('account')->row_array();
            $mozam_profile = $this->db->select('profile')->where('account_id',882)->get('account')->row_array();
            // print_r();die;

            $data = array(
                'needto_varifi' => $this->crud->get_id_by_val_count('user','user_id',array('isActive' => '0')),
                'varified' => $this->crud->get_id_by_val_count('user','user_id',array('isActive' => '1')),
                'total_user' => $this->crud->get_id_by_val_count('user','user_id',array('isActive' => '0')) + $this->crud->get_id_by_val_count('user','user_id',array('isActive' => '1')),
                'purchase_invoices' => $this->crud->get_id_by_val_count('purchase_invoice','purchase_invoice_id',$where_array),
                'sales_invoices' => $this->crud->get_id_by_val_count('sales_invoice','sales_invoice_id',$where_array),
                'credit_notes' => $this->crud->get_id_by_val_count('credit_note','credit_note_id',$where_array),
                'debit_notes' => $this->crud->get_id_by_val_count('debit_note','debit_note_id',$where_array),
                'butt_profile' => $butt_profile['profile'],
                'asif_profile' => $asif_profile['profile'],
                'dharmi_profile' => $dharmi_profile['profile'],
                'hitesh_profile' => $hitesh_profile['profile'],
                'irfan_profile' => $irfan_profile['profile'],
                'rana_profile' => $rana_profile['profile'],
                'mozam_profile' => $mozam_profile['profile'],
            );
            set_page('dashboard',$data);
        } else {
            redirect('/auth/login');
        }
    }

    /**
     * Login user on the site
     *
     * @return void
     */
    function login(){
        ini_set ('display_errors', 1);  
        ini_set ('display_startup_errors', 1);  
        error_reporting (E_ALL);  
        if ($this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')) {// logged in
            redirect('');
        } else {
            //$this->form_validation->set_rules('email','email', 'trim|required|valid_email');
            $this->form_validation->set_rules('pass', 'password', 'trim|required');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');
            $data['errors'] = array();
            if ($this->form_validation->run()) {
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $response = $this->app_model->login($email,$pass);
                if ($response) {
                    if($response[0]['verify_otp'] == 0){
                        $number = mt_rand(1000, 9999);
                        $this->crud->update('user',array("otp_code" => $number), array("user_id" => $response[0]['user_id']));
                        $mobile_no = $response[0]['phone'];
                        if(!empty($mobile_no)) {
                            $sms = SEND_SMS_FOR_OTP;
                            $vars = array(
                                '{{otp_no}}' => $number,
                            );
                            $sms = strtr($sms, $vars);
                            $this->send_sms($mobile_no, $sms);
                        }
                        $this->session->set_userdata('user_id',$response[0]['user_id']);
                        redirect('auth/otp');
                        exit;
                    }
//                    echo "<pre>"; print_r($response); exit;
                    if($response[0]['isActive'] == '0' || empty($response[0]['isActive'])){
                        $data['errors']['approve'] = 'Company Account not activated!';    
                    }else{
                        $tmp_response = $response;

                        $this->session->set_userdata('login_user_id',$response[0]['user_id']);
                        $this->session->set_userdata('userType',$response[0]['userType']);

                        if($response[0]['userType'] == USER_TYPE_USER) {
                            $this->session->set_userdata(PACKAGE_FOLDER_NAME.'is_logged_in_user',$response[0]);

                            $this->db->select('*');
                            $this->db->from('user');
                            $this->db->where('user_id',$response[0]['company_id']);
                            $this->db->limit('1');
                            $query = $this->db->get();
                            if($query->num_rows() > 0){
                                $response = $query->result_array();
                            }
                        }

                        if(!empty($response)) {
                            $response[0]['userType'] = $tmp_response[0]['userType'];
                            $this->session->set_userdata(PACKAGE_FOLDER_NAME.'is_logged_in',$response[0]);

                            $user_id = $tmp_response[0]['user_id'];
                            $company_id = $response[0]['user_id'];
                            $sql = "
                                SELECT
                                        ur.user_id,ur.website_module_id,ur.role_type_id, LOWER(r.title) as role, LOWER(m.title) as module
                                FROM user_roles ur
                                INNER JOIN website_modules m ON ur.website_module_id = m.website_module_id
                                INNER JOIN module_roles r ON ur.role_type_id = r.module_role_id WHERE ur.user_id = $user_id;
                            ";
                            $results = $this->crud->getFromSQL($sql);

                            $roles = array();
                            foreach ($results as $row) {
                                $roles[$row->website_module_id][] = $row->role;
                            }
                            $this->session->set_userdata('user_roles', $roles);
    
                            $login_time = date('Y-m-d H:i:s');
                            
                            $ip = $this->input->ip_address();
                            $this->crud->insert('user_login_log',array("user_id" => $user_id, "ip_add" => $ip, "datetime" => $login_time, "login_logout" => "1"));
                            $line_items = $this->crud->get_all_with_where('company_settings','','',array('company_id' => $company_id, 'module_name' => 2));
                            if(!empty($line_items)) {
                                foreach ($line_items as $line_item){
                                    $this->session->set_userdata('li_'.$line_item->setting_key,$line_item->setting_value);
                                }
                            }

                            $last_visited_page = $this->crud->get_column_value_by_id('user', 'last_visited_page', array('user_id' => $user_id));

                            if(empty($last_visited_page)) {
                                // redirect('');
                                redirect('report/ganpati/'); // Redirect to Add swipe menu
                            } else {
                                redirect($last_visited_page);
                            }
                        } else {
                            $data['errors']['invalid'] = 'Invalid email or password!';
                        }                        
                    }
                } else {
                    $data['errors']['invalid'] = 'Invalid email or password!';
                }
            } else {
                if (validation_errors()) {
                    $error_messages = $this->form_validation->error_array();
                    $data['errors'] = $error_messages;
                }
            }
            $data['package_name'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'package_name'));
            $data['login_logo'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'login_logo'));
            $this->load->view('login_form', $data);
        }
    }
    
    /**
     * Register user on the site
     *
     * @return void
     */
    function register()
    {
        if ($this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')) { // logged in
            redirect('');
            //set_page('dashboard');
        } else {
            $data = array();
            $data['package_name'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'package_name'));
            $this->load->view('register_form', $data);    
        }
    }
    
    function save_user() {
        $return = array();
        $post_data = $this->input->post();
        //echo '<pre>';print_r($post_data);exit;
        $user_id = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
        $post_data['state'] = isset($post_data['state']) ? $post_data['state'] : null;
        $post_data['city'] = isset($post_data['city']) ? $post_data['city'] : null;
        $post_data['user'] = isset($post_data['user']) ? $post_data['user'] : null;
        $post_data['address'] = isset($post_data['address']) ? $post_data['address'] : null;
        $post_data['postal_code'] = isset($post_data['postal_code']) ? $post_data['postal_code'] : null;
        $post_data['phone'] = isset($post_data['phone']) ? $post_data['phone'] : null;
        $post_data['gst_no'] = isset($post_data['gst_no']) ? $post_data['gst_no'] : null;
        $post_data['pan'] = isset($post_data['pan']) ? $post_data['pan'] : null;
        $post_data['aadhaar'] = isset($post_data['aadhaar']) ? $post_data['aadhaar'] : null;
        $post_data['contect_person_name'] = isset($post_data['contect_person_name']) ? $post_data['contect_person_name'] : null;
        $post_data['invoice_no_start_from'] = isset($post_data['invoice_no_start_from']) ? $post_data['invoice_no_start_from'] : 1;
        $post_data['is_letter_pad'] = isset($post_data['is_letter_pad']) ? 1 : 0;
        $post_data['is_bill_wise'] = isset($post_data['is_bill_wise']) ? 1 : 0;
        $post_data['bank_name'] = isset($post_data['bank_name']) ? $post_data['bank_name'] : null;
        $post_data['bank_branch'] = isset($post_data['bank_branch']) ? $post_data['bank_branch'] : null;
        $post_data['bank_ac_no'] = isset($post_data['bank_ac_no']) ? $post_data['bank_ac_no'] : null;
        $post_data['rtgs_ifsc_code'] = isset($post_data['rtgs_ifsc_code']) ? $post_data['rtgs_ifsc_code'] : null;
        $post_data['bank_acc_name'] = isset($post_data['bank_acc_name']) ? $post_data['bank_acc_name'] : null;
        $post_data['bank_city'] = isset($post_data['bank_city']) ? $post_data['bank_city'] : null;
        $post_data['verify_otp'] = '1';
        $post_data['purchase_rate'] = isset($post_data['purchase_rate']) && !empty($post_data['purchase_rate']) ? $post_data['purchase_rate'] : null;
        $post_data['sales_rate'] = isset($post_data['sales_rate']) && !empty($post_data['sales_rate']) ? $post_data['sales_rate'] : null;
        $post_data['invoice_type'] = isset($post_data['invoice_type']) && !empty($post_data['invoice_type']) ? $post_data['invoice_type'] : null;
        $post_data['is_single_line_item'] = isset($post_data['is_single_line_item'])? 1 : 0;
        $post_data['is_view_item_history'] = isset($post_data['is_view_item_history'])? 1 : 0;

        $is_company = 0;
        if (isset($post_data['is_company'])) {
            $is_company = 1;
            $main_fields = array();
            if (isset($post_data['main_fields']) && !empty($post_data['main_fields'])) {
                $main_fields = $post_data['main_fields'];
                unset($post_data['main_fields']);
            }
            $line_item_fields = array();
            if (isset($post_data['line_item_fields']) && !empty($post_data['line_item_fields'])) {
                $line_item_fields = $post_data['line_item_fields'];
                unset($post_data['line_item_fields']);
            }
            unset($post_data['is_company']);
            $line_items_data = json_decode($post_data['line_items_data']);
            unset($post_data['line_items_data']);
            $line_item_index = $post_data['line_items_index'];
            unset($post_data['line_items_index']);
            $prefix = $post_data['prefix'];
            unset($post_data['prefix']);
        }

        if (isset($post_data['user_id']) && !empty($post_data['user_id'])) {
            $where_arr['user_name'] = trim($post_data['user_name']);

            $ac_id = $this->crud->check_duplicate('user', 'user_id', $where_arr, $post_data['user_id']);
            if (!empty($ac_id)) {
                $return['error'] = "userExist";
                print json_encode($return);
                exit;
            }
            if (isset($post_data['user']) && !empty($post_data['user'])) {
                $mail_val = $this->crud->get_id_by_val_not('user', 'user_id', 'user', trim($post_data['user']), $post_data['user_id']);
                if (!empty($mail_val)) {
                    $return['error'] = "emailExist";
                    print json_encode($return);
                    exit;
                }
            }
        } else {
            $where_arr['user_name'] = trim($post_data['user_name']);

            $ac_id = $this->crud->check_duplicate('user', 'user_id', $where_arr);
            if (!empty($ac_id)) {
                $return['error'] = "userExist";
                print json_encode($return);
                exit;
            }
            if (isset($post_data['user']) && !empty($post_data['user'])) {
                $mail_val = $this->crud->get_id_by_val('user', 'user_id', 'user', trim($post_data['user']));
                if (!empty($mail_val)) {
                    $return['error'] = "emailExist";
                    print json_encode($return);
                    exit;
                }
            }
        }
        $user = isset($post_data['email_ids']) ? trim($post_data['email_ids']) : '';
        // get emails
        $temp = nl2br($user);
        $emails = explode(",", $temp);

        $email_status = 1;
        $email_msg = "";

        $email_ids = array();
        // multiple email validation
        if (is_array($emails) && count($emails) > 0) {
            foreach ($emails as $email) {
                if (trim($email) != "") {
                    $email = trim($email);
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                        $email_msg .= "$email is not valid email.&nbsp;";
                        $email_status = 0;
                    }
                    $this->db->select('*');
                    $this->db->from('user');
                    $this->db->where('user_id !=', $user_id);
                    $this->db->like('email_ids', $email);
                    $res = $this->db->get();
                    $rows = $res->num_rows();
                    if ($rows > 0) {
                        $result = $res->result();
                        $email_msg .= "$email email already exist.&nbsp; <br/> Original Company Account : " . $result[0]->user_name;
                        $email_status = 0;
                    } else {
                        $email_ids[] = $email;
                    }
                }
            }
        }
        if ($email_status == 0) {
            $return['error'] = "email_error";
            $return['msg'] = $email_msg;
            echo json_encode($return);
            exit;
        }
        $email_ids = implode(',', $email_ids);
        
        $sales_invoice_main_fields = array('shipment_invoice_no', 'shipment_invoice_date', 'sbill_no', 'sbill_date', 'origin_port', 'port_of_discharge', 'container_size', 'container_bill_no', 'container_date', 'container_no', 'vessel_name_voy', 'print_date', 'your_invoice_no', 'display_dollar_sign');
        $sales_invoice_line_item_fields = array('item_group', 'category', 'sub_category', 'short_name', 'unit', 'discount', 'basic_amount', 'cgst_per', 'cgst_amt', 'sgst_per', 'sgst_amt', 'igst_per', 'igst_amt', 'other_charges', 'amount', 'note', 'separate');
        $prefix_array = array('invoice_no_digit' => 'invoice_no_digit', 'year_post_fix' => 'year_post_fix');

        if (isset($post_data['user_id']) && !empty($post_data['user_id']) && $post_data['user_id'] != 0) {
            $post_data['email_ids'] = $email_ids;
            if (isset($post_data['password']) && !empty($post_data['password'])) {
                $post_data['password'] = md5($post_data['password']);
            } else {
                $result = $this->crud->get_data_row_by_id('user', 'user_id', $post_data['user_id']);
                $post_data['password'] = $result->password;
            }
            if (empty($post_data['user'])) {
                $result = $this->crud->get_data_row_by_id('user', 'user_id', $post_data['user_id']);
                $post_data['user'] = $result->user;
            }
            $post_data['updated_by'] = $this->logged_in_id;
            $post_data['user_updated_by'] = $this->session->userdata()['login_user_id'];
            $post_data['updated_at'] = $this->now_time;
            $where_array['user_id'] = $post_data['user_id'];
            $result = $this->crud->update('user', $post_data, $where_array);
            if ($result) {
                $return['success'] = "Updated";
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('message', 'Company Account Updated Successfully');
                $last_query_id = $post_data['user_id'];
                if ($is_company == '1') {
                    $user_id_logged_in = $this->session->userdata(PACKAGE_FOLDER_NAME . 'is_logged_in')['user_id'];
                    foreach ($sales_invoice_main_fields as $key => $value) {
                        $setting_data = array();
                        if (!empty($main_fields) && in_array($value, $main_fields)) {
                            $setting_data['setting_value'] = 1;
                        } else {
                            $setting_data['setting_value'] = 0;
                        }
                        $setting_data['updated_at'] = $this->now_time;
                        $setting_data['updated_by'] = $user_id_logged_in;
                        $setting_data['user_updated_by'] = $this->session->userdata()['login_user_id'];
                        $this->crud->update('company_settings', $setting_data, array('company_id' => $last_query_id, 'setting_key' => $value, 'module_name' => 1));
                    }
                    
                    foreach ($sales_invoice_line_item_fields as $key => $value) {
                        $setting_id = $this->crud->get_column_value_by_id('company_settings', 'company_settings_id', array('company_id' => $last_query_id, 'setting_key' => $value, 'module_name' => 2));

                        if(!empty($setting_id)) {
                            $setting_data = array();
                            if (in_array($value, $line_item_fields)) {
                                $setting_data['setting_value'] = 1;
                            } else {
                                $setting_data['setting_value'] = 0;
                            }
                            $setting_data['updated_at'] = $this->now_time;
                            $setting_data['updated_by'] = $user_id_logged_in;
                            $setting_data['user_updated_by'] = $this->session->userdata()['login_user_id'];
                            $this->crud->update('company_settings', $setting_data, array('company_settings_id' => $setting_id));
                        } else {
                            $setting_data = array();
                            $setting_data['company_id'] = $last_query_id;
                            $setting_data['module_name'] = 2;
                            $setting_data['setting_key'] = $value;
                            if (in_array($value, $line_item_fields)) {
                                $setting_data['setting_value'] = 1;
                            } else {
                                $setting_data['setting_value'] = 0;
                            }
                            $setting_data['created_at'] = $this->now_time;
                            $setting_data['created_by'] = $user_id_logged_in;
                            $setting_data['user_created_by'] = $this->session->userdata()['login_user_id'];
                            $this->crud->insert('company_settings', $setting_data);
                        }
                    }

                    //update company invoice prefix
                    if (!empty($line_items_data)) {
                        $prefix_ids = array();
                        foreach ($line_items_data as $lineitem) {
                            $insert_item = array();
                            $insert_item['company_id'] = $last_query_id;
                            $insert_item['prefix_name'] = $lineitem->company_invoice_prefix;
                            $insert_item['is_default'] = $lineitem->default_prefix;
                            $insert_item['created_at'] = $this->now_time;
                            $insert_item['created_by'] = $user_id_logged_in;
                            $insert_item['user_created_by'] = $this->session->userdata()['login_user_id'];
                            if(isset($lineitem->id) && $lineitem->id > 0) {
                                $this->crud->update('company_invoice_prefix', $insert_item,array('id' => $lineitem->id));
                                $prefix_ids[] = $lineitem->id;
                            } else {
                                $prefix_ids[] = $this->crud->insert('company_invoice_prefix', $insert_item);
                            }
                        }
                        if(!empty($prefix_ids)) {
                            $this->db->where_not_in('id',$prefix_ids);
                            $this->db->where('company_id',$last_query_id);
                            $this->db->delete('company_invoice_prefix');
                        } else {
                            $this->crud->delete("company_invoice_prefix", array("company_id" => $last_query_id));    
                        }
                        
                    }
                    // update sales invoice prefix settings
                    foreach ($prefix_array as $key => $value) {
                        $setting_data = array();
                        if ($value == 'year_post_fix') {
                            if (in_array($value, $prefix)) {
                                $setting_data['setting_value'] = 1;
                            } else {
                                $setting_data['setting_value'] = 0;
                            }
                        } else {
                            $setting_data['setting_value'] = $prefix[$key];
                        }
                        $setting_data['updated_at'] = $this->now_time;
                        $setting_data['updated_by'] = $user_id_logged_in;
                        $setting_data['user_updated_by'] = $this->session->userdata()['login_user_id'];
                        $this->crud->update('company_settings', $setting_data, array('company_id' => $last_query_id, 'setting_key' => $value, 'module_name' => 3));
                    }

                    if($user_id_logged_in == $last_query_id) {
                        $line_items = $this->crud->get_all_with_where('company_settings','','',array('company_id' => $user_id_logged_in, 'module_name' => 2));
                        if(!empty($line_items)) {
                            foreach ($line_items as $line_item){
                                $this->session->set_userdata('li_'.$line_item->setting_key,$line_item->setting_value);
                            }
                        }
                    }
                }
            } else {
                $return['error'] = "errorUpdated";
            }
        } else {
            $post_data['email_ids'] = $email_ids;
            $post_data['password'] = isset($post_data['password']) ? md5($post_data['password']) : null;
            $post_data['created_by'] = $this->logged_in_id;
            $post_data['user_created_by'] = $this->session->userdata()['login_user_id'];
            $post_data['created_at'] = $this->now_time;

            $post_data['updated_by'] = $this->logged_in_id;
            $post_data['user_updated_by'] = $this->session->userdata()['login_user_id'];
            $post_data['updated_at'] = $this->now_time;
            $result = $this->crud->insert('user', $post_data);
            $last_query_id = $this->db->insert_id();
            if ($result) {
                $return['success'] = "Added";
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('message', 'Company Account Added Successfully');

                if ($is_company == '1') {
                    // Add GST Accounts //
                    $acc_arr = array();
                    $acc_arr['account_group_id'] = GST_ACCOUNT_GROUP;
                    $acc_arr['opening_balance'] = '0';
                    $acc_arr['credit_debit'] = '1';
                    $acc_arr['consider_in_pl'] = '1';
                    $acc_arr['created_by'] = $last_query_id;
                    $acc_arr['created_at'] = $this->now_time;

                    $acc_arr['account_type'] = '1';
                    $acc_arr['account_name'] = 'CGST';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'CGST - Interest';
                    $acc_arr['account_type'] = '2';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'CGST - Penalty';
                    $acc_arr['account_type'] = '3';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'CGST - Fees';
                    $acc_arr['account_type'] = '4';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'CGST - Other charges';
                    $acc_arr['account_type'] = '5';
                    $this->crud->insert('account', $acc_arr);

                    $acc_arr['account_name'] = 'SGST';
                    $acc_arr['account_type'] = '6';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'SGST - Interest';
                    $acc_arr['account_type'] = '7';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'SGST - Penalty';
                    $acc_arr['account_type'] = '8';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'SGST - Fees';
                    $acc_arr['account_type'] = '9';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'SGST - Other charges';
                    $acc_arr['account_type'] = '10';
                    $this->crud->insert('account', $acc_arr);

                    $acc_arr['account_name'] = 'IGST';
                    $acc_arr['account_type'] = '11';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'IGST - Interest';
                    $acc_arr['account_type'] = '12';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'IGST - Penalty';
                    $acc_arr['account_type'] = '13';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'IGST - Fees';
                    $acc_arr['account_type'] = '14';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'IGST - Other charges';
                    $acc_arr['account_type'] = '15';
                    $this->crud->insert('account', $acc_arr);

                    $acc_arr['account_name'] = 'UTGST';
                    $acc_arr['account_type'] = '16';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'UTGST - Interest';
                    $acc_arr['account_type'] = '17';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'UTGST - Penalty';
                    $acc_arr['account_type'] = '18';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'UTGST - Fees';
                    $acc_arr['account_type'] = '19';
                    $this->crud->insert('account', $acc_arr);
                    $acc_arr['account_name'] = 'UTGST - Other charges';
                    $acc_arr['account_type'] = '20';
                    $this->crud->insert('account', $acc_arr);
                        
                   
                   
                   
                   
                    
                    $user_id_logged_in = $this->session->userdata(PACKAGE_FOLDER_NAME . 'is_logged_in')['user_id'];
                    foreach ($sales_invoice_main_fields as $key => $value) {
                        $setting_data = array();
                        $setting_data['company_id'] = $last_query_id;
                        $setting_data['module_name'] = 1;
                        $setting_data['setting_key'] = $value;
                        if (!empty($main_fields) && in_array($value, $main_fields)) {
                            $setting_data['setting_value'] = 1;
                        } else {
                            $setting_data['setting_value'] = 0;
                        }
                        $setting_data['created_at'] = $this->now_time;
                        $setting_data['created_by'] = $user_id_logged_in;
                        $setting_data['user_created_by'] = $this->session->userdata()['login_user_id'];
                        $this->crud->insert('company_settings', $setting_data);
                    }

                    foreach ($sales_invoice_line_item_fields as $key => $value) {
                        $setting_data = array();
                        $setting_data['company_id'] = $last_query_id;
                        $setting_data['module_name'] = 2;
                        $setting_data['setting_key'] = $value;
                        if (in_array($value, $line_item_fields)) {
                            $setting_data['setting_value'] = 1;
                        } else {
                            $setting_data['setting_value'] = 0;
                        }
                        $setting_data['created_at'] = $this->now_time;
                        $setting_data['created_by'] = $user_id_logged_in;
                        $setting_data['user_created_by'] = $this->session->userdata()['login_user_id'];
                        $this->crud->insert('company_settings', $setting_data);
                    }
                    //insert company invoice prefix
                    if (!empty($line_items_data)) {
                        foreach ($line_items_data as $lineitem) {
                            $insert_item = array();
                            $insert_item['company_id'] = $last_query_id;
                            $insert_item['prefix_name'] = $lineitem->company_invoice_prefix;
                            $insert_item['is_default'] = $lineitem->default_prefix;
                            $insert_item['created_at'] = $this->now_time;
                            $insert_item['created_by'] = $user_id_logged_in;
                            $insert_item['user_created_by'] = $this->session->userdata()['login_user_id'];
                            $this->crud->insert('company_invoice_prefix', $insert_item);
                        }
                    }
                    // insert sales invoice prefix settings
                    foreach ($prefix_array as $key => $value) {
                        $setting_data = array();
                        $setting_data['company_id'] = $last_query_id;
                        $setting_data['module_name'] = 3;
                        $setting_data['setting_key'] = $value;
                        if ($value == 'year_post_fix') {
                            if (in_array($value, $prefix)) {
                                $setting_data['setting_value'] = 1;
                            } else {
                                $setting_data['setting_value'] = 0;
                            }
                        } else {
                            $setting_data['setting_value'] = $prefix[$key];
                        }
                        $setting_data['created_at'] = $this->now_time;
                        $setting_data['created_by'] = $user_id_logged_in;
                        $setting_data['user_created_by'] = $this->session->userdata()['login_user_id'];
                        $this->crud->insert('company_settings', $setting_data);
                    }

                    if($user_id_logged_in == $last_query_id) {
                        $line_items = $this->crud->get_all_with_where('company_settings','','',array('company_id' => $user_id_logged_in, 'module_name' => 2));
                        if(!empty($line_items)) {
                            foreach ($line_items as $line_item){
                                $this->session->set_userdata('li_'.$line_item->setting_key,$line_item->setting_value);
                            }
                        }
                    }
                }
            } else {
                $return['error'] = "errorAdded";
            }
        }
        if ($result) {
            $file_element_name = 'logo_image';
            $config['upload_path'] = './assets/uploads/logo_image/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = TRUE;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;
            $newFileName = $_FILES['logo_image']['name'];
            $tmp = explode('.', $newFileName);
            $file_extension = end($tmp);
            $filename = $last_query_id . "_" . time() . "." . $file_extension;
            $config['file_name'] = $filename;
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $return['Uploaderror'] = $this->upload->display_errors();
            }
            $file_data = $this->upload->data();
            if (!empty($file_data['file_name']) && !empty($file_extension)) {
                $f_data['logo_image'] = $file_data['file_name'];
                $f_where_array['user_id'] = $last_query_id;
                $file_id = $this->crud->update('user', $f_data, $f_where_array);
            }
            @unlink($_FILES[$file_element_name]);
        }
        //echo '<pre>';print_r($data);exit;
        print json_encode($return);
        exit;
    }

    function logout()
    {
        $login_time = date('Y-m-d H:i:s');
        $user_id_logged_in = $this->session->userdata('login_user_id');
        $userType = $this->session->userdata('userType');
        $ip = $this->input->ip_address();
        $this->crud->insert('user_login_log', array("user_id" => $user_id_logged_in, "ip_add" => $ip, "datetime" => $login_time, "login_logout" => "2"));
        $this->session->unset_userdata(PACKAGE_FOLDER_NAME.'is_logged_in');
        if($userType == USER_TYPE_USER) {
            $this->session->unset_userdata(PACKAGE_FOLDER_NAME.'is_logged_in_user');
        }

        session_destroy();

        /*--- last visited page set to dashboad when logout ---*/
        $this->crud->update('user',array("last_visited_page" =>''),array("user_id" => $user_id_logged_in));
        redirect('auth/login');
    }

    
    function profile()
    {
        if(!$this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')) {// logged in
            redirect('');
        }
        $data = array();
        $query = $this->db->get_where('user',array('user_id',$this->session->userdata('login_user_id')));
        set_page('change_password',$query->row());
        
    }
    
    function change_password() 
    {
        $data = array();
        if (!empty($_POST)) {
            $this->form_validation->set_rules('user_id', 'Admin ID', 'trim|required');
            $this->form_validation->set_rules('old_pass', 'old password', 'trim|required|callback_check_old_password');
            $this->form_validation->set_rules('new_pass', 'new password', 'trim|required');
            $this->form_validation->set_rules('confirm_pass', 'confirm Password', 'trim|required|matches[new_pass]');
            if ($this->form_validation->run()) {
                $this->db->where('user_id',$_POST['user_id']);
                $this->db->update('user',array('password'=>md5($_POST['new_pass'])));
                $this->session->set_flashdata('success',true);
                $this->session->set_flashdata('message','You have successfully changed password!');
                redirect('auth/profile');
            } else {
                if (validation_errors()) {
                    $error_messages = $this->form_validation->error_array();
                    $data['errors'] = $error_messages;
                }
            }
            set_page('change_password',$data);
        } else {
            redirect('auth/profile/');
        }
    }

    function check_old_password($old_pass){
        $user_id = $_POST['user_id'];
        $query = $this->db->get_where('user',array('user_id'=>$user_id,'password'=>md5($old_pass)));
        if($query->num_rows() > 0){
            return true;
        }else{
            $this->form_validation->set_message('check_old_password', 'wrong old password.');
            return false;
        }
    }
    
    public function change_seesion_staff() {
        $data = array();
        $query = $this->db->query("select * from user where user_id='".$_POST['user_id']."'");
        $response = $query->result_array();
        if ($response) {
            $this->session->set_userdata(PACKAGE_FOLDER_NAME.'is_logged_in',$response[0]);
            $this->session->set_userdata('userType','Admin');
            //echo '<pre>';print_r($this->session->userdata()['userType']);exit;
            $staff_id = $response[0]['user_id'];
            $item_group = $this->crud->get_column_value_by_id('company_settings', 'setting_value', array('setting_key' => 'item_group', 'company_id' => $staff_id, 'module_name' => 2));
            if(!empty($item_group) && $item_group == 1) {
                $this->session->set_userdata('itemGroup',1);
            } else {
                $this->session->set_userdata('itemGroup',0);
            }
            $line_items = $this->crud->get_all_with_where('company_settings','','',array('company_id' => $staff_id, 'module_name' => 2));
            if(!empty($line_items)) {
                foreach ($line_items as $line_item){
                    $this->session->set_userdata('li_'.$line_item->setting_key,$line_item->setting_value);
                }
            }
            // $user_id = $response[0]['user_id'];
            $user_id = $this->session->userdata()['login_user_id'];
            $sql = "
                SELECT
                        ur.user_id,ur.website_module_id,ur.role_type_id, LOWER(r.title) as role, LOWER(m.title) as module
                FROM user_roles ur
                INNER JOIN website_modules m ON ur.website_module_id = m.website_module_id
                INNER JOIN module_roles r ON ur.role_type_id = r.module_role_id WHERE ur.user_id = $user_id;
            ";
            $results = $this->crud->getFromSQL($sql);

            $roles = array();
            foreach ($results as $row) {
                $roles[$row->website_module_id][] = $row->role;
            }
            $this->session->set_userdata('user_roles', $roles);
//            echo '<pre>';print_r($this->session->userdata());exit;
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        echo json_encode($data);
        exit;
    }
    
    function otp(){
        $data = array();
        $data['package_name'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'package_name'));
        $data['login_logo'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'login_logo'));
        $this->load->view('login_otp_form', $data);
    }
    
    function login_otp() {
        $data['errors'] = array();
        $data['package_name'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'package_name'));
        $data['login_logo'] = $this->crud->get_column_value_by_id('settings', 'setting_value', array('setting_key' => 'login_logo'));
        $this->form_validation->set_rules('otp', 'password', 'trim|required');
        $this->form_validation->set_rules('remember', 'Remember me', 'integer');
        if ($this->form_validation->run()) {
            $otp = $_POST['otp'];
            $user_id = $_POST['user_id'];
            $response = $this->crud->get_row_by_id('user', array('user_id' => $user_id, "otp_code" => $otp));
//            echo '<pre>'; print_r($response); exit;
            if (!empty($response)) {
                $response = json_decode(json_encode($response), True);
                if ($response[0]['isActive'] == '0' || empty($response[0]['isActive'])) {
                    $data['errors']['invalid'] = 'Company Account not activated!';
                    $this->load->view('login_otp_form', $data);
                } else {
                    $tmp_response = $response;

                    $this->session->set_userdata('login_user_id',$response[0]['user_id']);
                    $this->session->set_userdata('userType',$response[0]['userType']);

                    if($response[0]['userType'] == USER_TYPE_USER) {
                        $this->session->set_userdata(PACKAGE_FOLDER_NAME.'is_logged_in_user',$response[0]);

                        $this->db->select('*');
                        $this->db->from('user');
                        $this->db->where('user_id',$response[0]['company_id']);
                        $this->db->limit('1');
                        $query = $this->db->get();
                        if($query->num_rows() > 0){
                            $response = $query->result_array();
                        }
                    }

                    if(!empty($response)) {
                        $response[0]['userType'] = $tmp_response[0]['userType'];
                        $this->session->set_userdata(PACKAGE_FOLDER_NAME.'is_logged_in',$response[0]);
                        

                        $user_id = $tmp_response[0]['user_id'];
                        $company_id = $response[0]['user_id'];

                        $sql = "
                            SELECT
                                    ur.user_id,ur.website_module_id,ur.role_type_id, LOWER(r.title) as role, LOWER(m.title) as module
                            FROM user_roles ur
                            INNER JOIN website_modules m ON ur.website_module_id = m.website_module_id
                            INNER JOIN module_roles r ON ur.role_type_id = r.module_role_id WHERE ur.user_id = $user_id;
                        ";
                        $results = $this->crud->getFromSQL($sql);

                        $roles = array();
                        foreach ($results as $row) {
                            $roles[$row->website_module_id][] = $row->role;
                        }
                        $this->session->set_userdata('user_roles', $roles);
                        $this->session->set_flashdata('success', true);
                        $this->session->set_flashdata('message', 'You have successfully login.');
                        $login_time = date('Y-m-d H:i:s');
                        $user_id_logged_in = $this->session->userdata(PACKAGE_FOLDER_NAME.'is_logged_in')['user_id'];
                        $ip = $this->input->ip_address();
                        $this->crud->insert('user_login_log', array("user_id" => $user_id, "ip_add" => $ip, "datetime" => $login_time, "login_logout" => "1"));
                        redirect('/');
                    } else {
                        $data['errors']['invalid'] = 'Invalid OTP !';
                        $this->load->view('login_otp_form', $data);
                    }
                }
            } else {
                $data['errors']['invalid'] = 'Invalid OTP !';
                $this->load->view('login_otp_form', $data);
            }
        } else {
            if (validation_errors()) {
                $error_messages = $this->form_validation->error_array();
                $data['errors'] = $error_messages;
            }
        }
    }
    
    function send_sms($mobile_no, $sms){
        $api_params = 'UserID=' . SEND_SMS_USER_ID . '&UserPassword=' . SEND_SMS_USERPASSWORD . '&PhoneNumber=' . $mobile_no . '&Text=' . urlencode($sms) . '&SenderId=' . SEND_SMS_SENDER_ID . '&AccountType=2';
        $smsGatewayUrl = "http://sms.infisms.co.in/API/SendSMS.aspx?"; 
        $url = $smsGatewayUrl . $api_params;
        $ch = curl_init();                       // initialize CURL
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);                         // Close CURL
        if (!$result) {
            $result = file_get_contents($url);
        }
//        if ($result) {
//            echo 'sms sent';
//        } else {
//            echo 'sms Not Sent';
//        }
    }

    function print_session() 
    {
        $session = $this->session->userdata();
        echo "<pre>";
        echo "SITE SESSION";
        print_r($session);
        echo "</pre>";
    }

    function ledger_datatable()
    {
        $from_date = date('Y-m-d', strtotime($_POST['from_date']));
        // $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
        $account_id = $_POST['account_id'];

        //$is_kasar_account = $this->crud->get_val_by_id('account',$account_id,'account_id','is_kasar_account');
        $tmp_from_date = date('Y-m-d', strtotime('-1 day', strtotime($from_date)));

        $opening_bal = $this->crud->get_account_balance($account_id, $tmp_from_date);

        $opening_balance = array();
        $opening_balance[] = (object) array("tr_date" => $tmp_from_date, "trans_time" => null, 'opening_amount' => $opening_bal, 'tran_type' => 'opening_balance');

        $ledger_data = array();
        $ledger_data = array_merge($ledger_data, $opening_balance);


        $account_row = $this->crud->get_data_row_by_where('account', array('account_id' => $account_id));
        $user_default_currency_id = $account_row->currency_id;

        /*-------- Payment ------*/
        $from_payment_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'from_payment' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.to_account_id  WHERE tr.transaction_type = 1 AND tr.from_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($from_payment_res)) {
            $ledger_data = array_merge($ledger_data, $from_payment_res);
        }


        $to_payment_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'to_payment' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.from_account_id  WHERE tr.transaction_type = 1 AND tr.to_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($to_payment_res)) {
            $ledger_data = array_merge($ledger_data, $to_payment_res);
        }


        /*------- Receipt -------*/
        $from_receipt_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'from_receipt' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.to_account_id  WHERE tr.transaction_type = 2 AND tr.from_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($from_receipt_res)) {
            $ledger_data = array_merge($ledger_data, $from_receipt_res);
        }

        $to_receipt_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'to_receipt' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.from_account_id  WHERE tr.transaction_type = 2 AND tr.to_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($to_receipt_res)) {
            $ledger_data = array_merge($ledger_data, $to_receipt_res);
        }


        /*-------- Contra ------*/
        $from_contra_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'from_contra' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.to_account_id  WHERE tr.transaction_type = 3 AND tr.from_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($from_contra_res)) {
            $ledger_data = array_merge($ledger_data, $from_contra_res);
        }

        $to_contra_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'to_contra' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.from_account_id  WHERE tr.transaction_type = 3 AND tr.to_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($to_contra_res)) {
            $ledger_data = array_merge($ledger_data, $to_contra_res);
        }

        /*------- Journal ------*/
        $from_journal_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'from_journal' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.to_account_id WHERE tr.transaction_type = 4 AND tr.from_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "'");

        if (!empty($from_journal_res)) {
            if ($account_row->is_kasar_account == 1 && !empty($from_journal_res)) {
                foreach ($from_journal_res as $key => $from_journal_row) {
                    $acc_row = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.to_account_id WHERE tr.transaction_type = 4 AND tr.journal_id=" . $from_journal_row->journal_id . " AND transaction_id!=" . $from_journal_row->transaction_id . " LIMIT 1");
                    if (!empty($acc_row)) {
                        $acc_row = $acc_row[0];
                        $from_journal_res[$key]->opp_acc_name = $acc_row->opp_acc_name;
                    }
                }
            }
            $ledger_data = array_merge($ledger_data, $from_journal_res);
        }

        $to_journal_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.transaction_date AS tr_date,'to_journal' as tran_type FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.from_account_id WHERE tr.transaction_type = 4 AND tr.to_account_id=" . $account_id . " AND tr.transaction_date >= '" . $from_date . "' AND tr.transaction_date <= '" . $to_date . "' AND a.is_kasar_account = 0 ");

        if (!empty($to_journal_res)) {
            if ($account_row->is_kasar_account == 1 && !empty($to_journal_res)) {
                foreach ($to_journal_res as $key => $from_journal_row) {
                    $acc_row = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name FROM transaction_entry as tr LEFT JOIN account as a ON a.account_id = tr.from_account_id WHERE tr.transaction_type = 4 AND tr.journal_id=" . $from_journal_row->journal_id . " AND transaction_id!=" . $from_journal_row->transaction_id . " LIMIT 1");
                    if (!empty($acc_row)) {
                        $acc_row = $acc_row[0];
                        $to_journal_res[$key]->opp_acc_name = $acc_row->opp_acc_name;
                    }
                }
            }
            $ledger_data = array_merge($ledger_data, $to_journal_res);
        }


        /*-------- Purchase ------*/
        $purchase_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.purchase_invoice_date AS tr_date,'purchase' as tran_type FROM purchase_invoice as tr LEFT JOIN account as a ON a.account_id = tr.against_account_id WHERE tr.account_id=" . $account_id . " AND tr.purchase_invoice_date >= '" . $from_date . "' AND tr.purchase_invoice_date <= '" . $to_date . "'");

        if (!empty($purchase_res)) {
            $ledger_data = array_merge($ledger_data, $purchase_res);
        }
        $against_purchase_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.purchase_invoice_date AS tr_date,'against_purchase' as tran_type FROM purchase_invoice as tr LEFT JOIN account as a ON a.account_id = tr.account_id WHERE tr.against_account_id=" . $account_id . " AND tr.purchase_invoice_date >= '" . $from_date . "' AND tr.purchase_invoice_date <= '" . $to_date . "'");

        if (!empty($against_purchase_res)) {
            $ledger_data = array_merge($ledger_data, $against_purchase_res);
        }


        /*-------- Sale ------*/
        $sales_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.sales_invoice_date AS tr_date,'sales' as tran_type FROM sales_invoice as tr LEFT JOIN account as a ON a.account_id = tr.against_account_id  WHERE tr.account_id=" . $account_id . " AND tr.sales_invoice_date >= '" . $from_date . "' AND tr.sales_invoice_date <= '" . $to_date . "'");

        if (!empty($sales_res)) {
            $ledger_data = array_merge($ledger_data, $sales_res);
        }

        $against_sales_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.sales_invoice_date AS tr_date,'against_sales' as tran_type FROM sales_invoice as tr LEFT JOIN account as a ON a.account_id = tr.account_id  WHERE tr.against_account_id=" . $account_id . " AND tr.sales_invoice_date >= '" . $from_date . "' AND tr.sales_invoice_date <= '" . $to_date . "'");

        if (!empty($against_sales_res)) {
            $ledger_data = array_merge($ledger_data, $against_sales_res);
        }


        /*-------- Credit Note ------*/
        $credit_note_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.credit_note_date AS tr_date,'credit_note' as tran_type FROM credit_note as tr LEFT JOIN account as a ON a.account_id = tr.against_account_id WHERE tr.account_id=" . $account_id . " AND tr.credit_note_date >= '" . $from_date . "' AND tr.credit_note_date <= '" . $to_date . "'");

        if (!empty($credit_note_res)) {
            $ledger_data = array_merge($ledger_data, $credit_note_res);
        }

        $against_credit_note_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.credit_note_date AS tr_date,'against_credit_note' as tran_type FROM credit_note as tr LEFT JOIN account as a ON a.account_id = tr.account_id  WHERE tr.against_account_id=" . $account_id . " AND tr.credit_note_date >= '" . $from_date . "' AND tr.credit_note_date <= '" . $to_date . "'");

        if (!empty($against_credit_note_res)) {
            $ledger_data = array_merge($ledger_data, $against_credit_note_res);
        }


        /*-------- Debit Note ------*/
        $debit_note_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.debit_note_date AS tr_date,'debit_note' as tran_type FROM debit_note as tr LEFT JOIN account as a ON a.account_id = tr.against_account_id WHERE tr.account_id=" . $account_id . " AND tr.debit_note_date >= '" . $from_date . "' AND tr.debit_note_date <= '" . $to_date . "'");

        if (!empty($debit_note_res)) {
            $ledger_data = array_merge($ledger_data, $debit_note_res);
        }


        $against_debit_note_res = $this->crud->getFromSQL("SELECT a.account_name as opp_acc_name,tr.*,tr.debit_note_date AS tr_date,'against_debit_note' as tran_type FROM debit_note as tr LEFT JOIN account as a ON a.account_id = tr.account_id WHERE tr.against_account_id=" . $account_id . " AND tr.debit_note_date >= '" . $from_date . "' AND tr.debit_note_date <= '" . $to_date . "'");

        if (!empty($against_debit_note_res)) {
            $ledger_data = array_merge($ledger_data, $against_debit_note_res);
        }
        
        function date_compare($a, $b)
        {
            $t1 = strtotime($a->tr_date);
            $t2 = strtotime($b->tr_date);
            return $t1 - $t2;
        }

        usort($ledger_data, 'date_compare');

        $data = array();
        $tr_date = '';
        $tr_time = '';
        $particular = '';
        $credit_amt = 0;
        $base_currency_id = $user_default_currency_id;
        $total_credit_amt = 0;
        $debit_amt = 0;
        $total_debit_amt = 0;
        $balance_amt = 0;
        $opening_amount = 0;
        $remote_accountno = '';
        $transaction_entry_note = '';

        $is_single_line_item = $this->session->userdata(PACKAGE_FOLDER_NAME . 'is_logged_in')['is_single_line_item'];

        $incree = 0;
        // echo '<pre>';
        // print_r($ledger_data);
        // echo '</pre>';


        foreach ($ledger_data as $list_row) {
            $incree++;
            $tr_date = (!empty(strtotime($list_row->tr_date))) ? date('d-m-Y', strtotime($list_row->tr_date)) : '';
            $tr_time = (!empty(strtotime($list_row->trans_time))) ? date('H:i:s', strtotime($list_row->trans_time)) : '';
            $remote_accountno = (!empty($list_row->remote_accountno)) ? $list_row->remote_accountno : '';
            $transaction_entry_note = (!empty($list_row->note)) ? $list_row->note : '';
            $particular = '';
            $bill_no = '';
            $delete_link = '';
            $row = array();

            if ($list_row->tran_type == "opening_balance") {
                $particular = "Opening Balance";
                // print_r($list_row);
                if ($list_row->opening_amount < 0) {
                    $debit_amt = $list_row->opening_amount;
                    $opening_amount = $list_row->opening_amount;
                } else {
                    $opening_amount = $list_row->opening_amount;
                    $credit_amt = $list_row->opening_amount;

                }

            } elseif ($list_row->tran_type == "from_payment") {

                $particular = 'From Payment';

                $isEdit = $this->applib->have_access_role(MODULE_PAYMENT_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_PAYMENT_ID, "delete");

                if ($isEdit) {
                    $particular = '<a href="' . base_url("transaction/payment/" . $list_row->transaction_id) . '">Payment</a>';
                } else {
                    $particular = 'Payment';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = 0;
                if($user_default_currency_id == $list_row->currency_id)
                {
                    $credit_amt = $list_row->amount;
                }else{
                    $credit_amt = $list_row->base_currency_amount;
                }

            } elseif ($list_row->tran_type == "to_payment") {

                $particular = 'To Payment';

                $isEdit = $this->applib->have_access_role(MODULE_PAYMENT_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_PAYMENT_ID, "delete");

                if ($isEdit) {
                    $particular = '<a href="' . base_url("transaction/mbtrans/" . $list_row->transaction_id) . '">Payment</a>';
                } else {
                    $particular = 'Payment';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                if($user_default_currency_id == $list_row->currency_id)
                {
                    $debit_amt = $list_row->amount;
                }else{
                    $debit_amt = $list_row->base_currency_amount;
                }
                $credit_amt = 0;

            } elseif ($list_row->tran_type == "from_receipt") {

                $particular = 'From Receipt';

                $isEdit = $this->applib->have_access_role(MODULE_RECEIPT_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_RECEIPT_ID, "delete");

                if ($isEdit) {
                    $particular = '<a href="' . base_url("transaction/receipt/" . $list_row->transaction_id) . '">Receipt</a>';
                } else {
                    $particular = 'Receipt';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_receipt_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = 0;
                if($user_default_currency_id == $list_row->currency_id)
                {
                    $credit_amt = $list_row->amount;
                }else{
                    $credit_amt = $list_row->base_currency_amount;
                }

            } elseif ($list_row->tran_type == "to_receipt") {

                $particular = 'To Receipt';

                $isEdit = $this->applib->have_access_role(MODULE_RECEIPT_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_RECEIPT_ID, "delete");

                if ($isEdit) {
                    $particular = '<a href="' . base_url("transaction/receipt/" . $list_row->transaction_id) . '">Receipt</a>';
                } else {
                    $particular = 'Receipt';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_receipt_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                if($user_default_currency_id == $list_row->currency_id)
                {
                    $debit_amt = $list_row->amount;
                }else{
                    $debit_amt = $list_row->base_currency_amount;
                }
                $credit_amt = 0;

            } elseif ($list_row->tran_type == "from_contra") {
                $bill_no = $list_row->contra_no;
                $particular = 'From Contra';

                $isEdit = $this->applib->have_access_role(MODULE_CONTRA_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_CONTRA_ID, "delete");

                if ($isEdit) {
                    $particular = '<a href="' . base_url("contra/contra/" . $list_row->transaction_id) . '">Contra</a>';
                } else {
                    $particular = 'Contra';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = 0;
                if($user_default_currency_id == $list_row->currency_id)
                {
                    $credit_amt = $list_row->amount;
                }else{
                    $credit_amt = $list_row->base_currency_amount;
                }

            } elseif ($list_row->tran_type == "to_contra") {
                $bill_no = $list_row->contra_no;
                $particular = 'To Contra';

                $isEdit = $this->applib->have_access_role(MODULE_CONTRA_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_CONTRA_ID, "delete");

                if ($isEdit) {
                    $particular = '<a href="' . base_url("contra/contra/" . $list_row->transaction_id) . '">Contra</a>';
                } else {
                    $particular = 'Contra';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                if($user_default_currency_id == $list_row->currency_id)
                {
                    $debit_amt = $list_row->amount;
                }else{
                    $debit_amt = $list_row->base_currency_amount;
                }
                $credit_amt = 0;

            } elseif ($list_row->tran_type == "from_journal") {
                $bill_no = $list_row->contra_no;
                $particular = 'From Journal';

                $isEdit = $this->applib->have_access_role(MODULE_JOURNAL_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_JOURNAL_ID, "delete");

                if ($isEdit) {
                    if (!empty($list_row->journal_id)) {
                        $particular = '<a href="' . base_url("journal/journal_type2/" . $list_row->journal_id) . '">Journal</a>';
                    } else {
                        $particular = '<a href="' . base_url("journal/journal/" . $list_row->transaction_id) . '">Journal</a>';
                    }

                } else {
                    $particular = 'Journal';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }


                $debit_amt = 0;
                if($user_default_currency_id == $list_row->currency_id)
                {
                    $credit_amt = $list_row->amount;
                }else{
                    $credit_amt = $list_row->base_currency_amount;
                }

            } elseif ($list_row->tran_type == "to_journal") {
                $bill_no = $list_row->contra_no;
                $particular = 'To Journal';

                $isEdit = $this->applib->have_access_role(MODULE_JOURNAL_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_JOURNAL_ID, "delete");

                if ($isEdit) {
                    if (!empty($list_row->journal_id)) {
                        $particular = '<a href="' . base_url("journal/journal_type2/" . $list_row->journal_id) . '">Journal</a>';
                    } else {
                        $particular = '<a href="' . base_url("journal/journal/" . $list_row->transaction_id) . '">Journal</a>';
                    }

                } else {
                    $particular = 'Journal';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('transaction/delete_transaction/' . $list_row->transaction_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                if($user_default_currency_id == $list_row->currency_id)
                {
                    $debit_amt = $list_row->amount;
                }else{
                    $debit_amt = $list_row->base_currency_amount;
                }
                $credit_amt = 0;

            } elseif ($list_row->tran_type == "purchase") {
                $bill_no = $list_row->bill_no;
                $particular = 'Purchase Invoice';

                $isEdit = $this->applib->have_access_role(MODULE_PURCHASE_INVOICE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_PURCHASE_INVOICE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        if ($list_row->invoice_type == 3) {
                            $particular = '<form id="edit_' . $list_row->purchase_invoice_id . '" method="post" action="' . base_url('transaction/order_type2') . '" style="width: 25px; display: initial;" >
                                            <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value="' . $list_row->purchase_invoice_id . '">
                                            <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->purchase_invoice_id . '\').submit();" title="Edit Invoice">Purchase Invoice</a>
                                        </form> ';
                        } else {
                            $particular = '<form id="edit_' . $list_row->purchase_invoice_id . '" method="post" action="' . base_url($list_row->invoice_type == '2' ? 'transaction/sales_purchase_transaction/purchase' : 'purchase/order') . '" style="width: 25px; display: initial;" >
                                            <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value="' . $list_row->purchase_invoice_id . '">
                                            <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->purchase_invoice_id . '\').submit();" title="Edit Invoice">Purchase Invoice</a>
                                        </form> ';
                        }
                    } else {
                        $particular = '<form id="edit_' . $list_row->purchase_invoice_id . '" method="post" action="' . base_url($list_row->invoice_type ? 'purchase/invoice' : 'purchase/order') . '" style="width: 25px; display: initial;" >
                                            <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value="' . $list_row->purchase_invoice_id . '">
                                            <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->purchase_invoice_id . '\').submit();" title="Edit Invoice">Purchase Invoice</a>
                                        </form> ';
                    }
                } else {
                    $particular = 'Purchase Invoice';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('purchase/invoice_delete/' . $list_row->purchase_invoice_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = 0;
                $credit_amt = $list_row->amount_total;

            } elseif ($list_row->tran_type == "against_purchase") {
                $bill_no = $list_row->bill_no;
                $particular = 'Against Purchase Invoice';

                $isEdit = $this->applib->have_access_role(MODULE_PURCHASE_INVOICE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_PURCHASE_INVOICE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        if ($list_row->invoice_type == 3) {
                            $particular = '<form id="edit_' . $list_row->purchase_invoice_id . '" method="post" action="' . base_url('transaction/order_type2') . '" style="width: 25px; display: initial;" >
                                            <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value="' . $list_row->purchase_invoice_id . '">
                                            <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->purchase_invoice_id . '\').submit();" title="Edit Invoice">Purchase Invoice</a>
                                        </form> ';
                        } else {
                            $particular = '<form id="edit_' . $list_row->purchase_invoice_id . '" method="post" action="' . base_url($list_row->invoice_type == '2' ? 'transaction/sales_purchase_transaction/purchase' : 'purchase/order') . '" style="width: 25px; display: initial;" >
                                            <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value="' . $list_row->purchase_invoice_id . '">
                                            <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->purchase_invoice_id . '\').submit();" title="Edit Invoice">Purchase Invoice</a>
                                        </form> ';
                        }
                    } else {
                        $particular = '<form id="edit_' . $list_row->purchase_invoice_id . '" method="post" action="' . base_url($list_row->invoice_type ? 'purchase/invoice' : 'purchase/order') . '" style="width: 25px; display: initial;" >
                                            <input type="hidden" name="purchase_invoice_id" id="purchase_invoice_id" value="' . $list_row->purchase_invoice_id . '">
                                            <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->purchase_invoice_id . '\').submit();" title="Edit Invoice">Purchase Invoice</a>
                                        </form> ';
                    }
                } else {
                    $particular = 'Purchase Invoice';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('purchase/invoice_delete/' . $list_row->purchase_invoice_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = $list_row->amount_total;
                $credit_amt = 0;

            } elseif ($list_row->tran_type == "credit_note") {
                $bill_no = $list_row->credit_note_no;
                $particular = 'Credit Note';

                $isEdit = $this->applib->have_access_role(MODULE_CREDIT_NOTE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_CREDIT_NOTE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        $particular = '<form id="edit_' . $list_row->credit_note_id . '" method="post" action="' . base_url() . 'transaction/sales_purchase_transaction/credit_note" style="width: 25px; display: initial;" >
                                <input type="hidden" name="credit_note_id" id="credit_note_id" value="' . $list_row->credit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->credit_note_id . '\').submit();" title="Edit Credit Note">Credit Note</a>
                            </form> ';
                    } else {
                        $particular = '<form id="edit_' . $list_row->credit_note_id . '" method="post" action="' . base_url() . 'credit_note/add" style="width: 25px; display: initial;" >
                                <input type="hidden" name="credit_note_id" id="credit_note_id" value="' . $list_row->credit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->credit_note_id . '\').submit();" title="Edit Credit Note">Credit Note</a>
                            </form> ';
                    }
                } else {
                    $particular = 'Credit Note';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('credit_note/credit_note_delete/' . $list_row->credit_note_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = 0;
                $credit_amt = $list_row->amount_total;

            } elseif ($list_row->tran_type == "against_credit_note") {
                $bill_no = $list_row->credit_note_no;
                $particular = 'Against Credit Note';
                $isEdit = $this->applib->have_access_role(MODULE_CREDIT_NOTE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_CREDIT_NOTE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        $particular = '<form id="edit_' . $list_row->credit_note_id . '" method="post" action="' . base_url() . 'transaction/sales_purchase_transaction/credit_note" style="width: 25px; display: initial;" >
                                <input type="hidden" name="credit_note_id" id="credit_note_id" value="' . $list_row->credit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->credit_note_id . '\').submit();" title="Edit Credit Note">Credit Note</a>
                            </form> ';
                    } else {
                        $particular = '<form id="edit_' . $list_row->credit_note_id . '" method="post" action="' . base_url() . 'credit_note/add" style="width: 25px; display: initial;" >
                                <input type="hidden" name="credit_note_id" id="credit_note_id" value="' . $list_row->credit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->credit_note_id . '\').submit();" title="Edit Credit Note">Credit Note</a>
                            </form> ';
                    }
                } else {
                    $particular = 'Credit Note';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('credit_note/credit_note_delete/' . $list_row->credit_note_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $debit_amt = $list_row->amount_total;
                $credit_amt = 0;

            } elseif ($list_row->tran_type == "sales") {
                $bill_no = $this->applib->format_invoice_number($list_row->sales_invoice_id, $list_row->sales_invoice_date);
                $particular = 'Sales Invoice';
                $isEdit = $this->applib->have_access_role(MODULE_SALES_INVOICE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_SALES_INVOICE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        $particular = '<form id="edit_' . $list_row->sales_invoice_id . '" method="post" action="' . base_url() . 'transaction/sales_purchase_transaction/sales" style="width: 25px; display: initial;" >
                                <input type="hidden" name="sales_invoice_id" id="sales_invoice_id" value="' . $list_row->sales_invoice_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->sales_invoice_id . '\').submit();" title="Edit Invoice">Sales Invoice</a>
                            </form> ';
                    } else {
                        $particular = '<form id="edit_' . $list_row->sales_invoice_id . '" method="post" action="' . base_url() . 'sales/invoice" style="width: 25px; display: initial;" >
                                <input type="hidden" name="sales_invoice_id" id="sales_invoice_id" value="' . $list_row->sales_invoice_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->sales_invoice_id . '\').submit();" title="Edit Invoice">Sales Invoice</a>
                            </form> ';
                    }
                } else {
                    $particular = 'Sales Invoice';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('sales/invoice_delete/' . $list_row->sales_invoice_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $credit_amt = 0;
                $debit_amt = $list_row->amount_total;

            } elseif ($list_row->tran_type == "against_sales") {
                $bill_no = $this->applib->format_invoice_number($list_row->sales_invoice_id, $list_row->sales_invoice_date);
                $particular = 'Against Sales Invoice';
                $isEdit = $this->applib->have_access_role(MODULE_SALES_INVOICE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_SALES_INVOICE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        $particular = '<form id="edit_' . $list_row->sales_invoice_id . '" method="post" action="' . base_url() . 'transaction/sales_purchase_transaction/sales" style="width: 25px; display: initial;" >
                                <input type="hidden" name="sales_invoice_id" id="sales_invoice_id" value="' . $list_row->sales_invoice_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->sales_invoice_id . '\').submit();" title="Edit Invoice">Sales Invoice</a>
                            </form> ';
                    } else {
                        $particular = '<form id="edit_' . $list_row->sales_invoice_id . '" method="post" action="' . base_url() . 'sales/invoice" style="width: 25px; display: initial;" >
                                <input type="hidden" name="sales_invoice_id" id="sales_invoice_id" value="' . $list_row->sales_invoice_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->sales_invoice_id . '\').submit();" title="Edit Invoice">Sales Invoice</a>
                            </form> ';
                    }
                } else {
                    $particular = 'Sales Invoice';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('sales/invoice_delete/' . $list_row->sales_invoice_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $credit_amt = $list_row->amount_total;
                $debit_amt = 0;

            } elseif ($list_row->tran_type == "debit_note") {
                $bill_no = $list_row->debit_note_no;
                $particular = 'Debit Note';
                $isEdit = $this->applib->have_access_role(MODULE_DEBIT_NOTE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_DEBIT_NOTE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        $particular = '<form id="edit_' . $list_row->debit_note_id . '" method="post" action="' . base_url() . 'transaction/sales_purchase_transaction/debit_note" style="width: 25px; display: initial;" >
                                <input type="hidden" name="debit_note_id" id="debit_note_id" value="' . $list_row->debit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->debit_note_id . '\').submit();" title="Edit Debit Note">Debit Note</a>
                            </form> ';
                    } else {
                        $particular = '<form id="edit_' . $list_row->debit_note_id . '" method="post" action="' . base_url() . 'debit_note/add" style="width: 25px; display: initial;" >
                                <input type="hidden" name="debit_note_id" id="debit_note_id" value="' . $list_row->debit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->debit_note_id . '\').submit();" title="Edit Debit Note">Debit Note</a>
                            </form> ';
                    }
                } else {
                    $particular = 'Debit Note';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('debit_note/debit_note_delete/' . $list_row->debit_note_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $credit_amt = 0;
                $debit_amt = $list_row->amount_total;

            } elseif ($list_row->tran_type == "against_debit_note") {
                $bill_no = $list_row->debit_note_no;
                $particular = 'Against Debit Note';
                $isEdit = $this->applib->have_access_role(MODULE_DEBIT_NOTE_ID, "edit");
                $isDelete = $this->applib->have_access_role(MODULE_DEBIT_NOTE_ID, "delete");

                if ($isEdit) {
                    if ($is_single_line_item == 1 || 1) {
                        $particular = '<form id="edit_' . $list_row->debit_note_id . '" method="post" action="' . base_url() . 'transaction/sales_purchase_transaction/debit_note" style="width: 25px; display: initial;" >
                                <input type="hidden" name="debit_note_id" id="debit_note_id" value="' . $list_row->debit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->debit_note_id . '\').submit();" title="Edit Debit Note">Debit Note</a>
                            </form> ';
                    } else {
                        $particular = '<form id="edit_' . $list_row->debit_note_id . '" method="post" action="' . base_url() . 'debit_note/add" style="width: 25px; display: initial;" >
                                <input type="hidden" name="debit_note_id" id="debit_note_id" value="' . $list_row->debit_note_id . '">
                                <a class="edit_button" href="javascript:{}" onclick="document.getElementById(\'edit_' . $list_row->debit_note_id . '\').submit();" title="Edit Debit Note">Debit Note</a>
                            </form> ';
                    }
                } else {
                    $particular = 'Debit Note';
                }

                if ($isDelete) {
                    $delete_link = '<a href="javascript:void(0);" class="delete_button" data-href="' . base_url('debit_note/debit_note_delete/' . $list_row->debit_note_id) . '"><span class="glyphicon glyphicon-trash" style="color : red">&nbsp;</span></a>';
                } else {
                    $delete_link = '';
                }

                $credit_amt = $list_row->amount_total;
                $debit_amt = 0;
            }


            // echo "Opening Amount: ".$opening_amount.'<br/>';
            $credit_amt = round($credit_amt);
            $debit_amt = round($debit_amt);

            $total_credit_amt += abs($credit_amt);

            if ($incree === 1) {
                $balance_amt = $debit_amt;
                $total_debit_amt = abs($debit_amt);
                $balance_amt += $credit_amt;
            } else {
                $balance_amt += $credit_amt - $debit_amt;
                $total_debit_amt += abs($debit_amt);
            }

            // $balance_amt = $total_debit_amt - $total_credit_amt;

            if (isset($list_row->purchase_invoice_id)) {
                $unit_data = $this->crud->getFromSQL("SELECT u.pack_unit_name as unit_name FROM lineitems as li LEFT JOIN pack_unit as u ON u.pack_unit_id = li.unit_id  WHERE li.parent_id=" . $list_row->purchase_invoice_id . "");
            }

            $row[] = $delete_link;
            $row[] = $tr_date;
            $row[] = $tr_time;
            // $row[] = $remote_accountno;
            $row[] = $transaction_entry_note;
            $row[] = $bill_no;
            // $row[] = isset( $list_row->qty_total ) ? $list_row->qty_total : 0;
            // $row[] = isset( $list_row->vehicle_no ) ? $list_row->vehicle_no : '';
            // $row[] = isset( $unit_data[0]->unit_name ) ? $unit_data[0]->unit_name : '';
            $row[] = $particular;
            $row[] = isset($list_row->opp_acc_name) ? $list_row->opp_acc_name : '';
            $row[] = abs($credit_amt);
            $row[] = abs($debit_amt);
            $row[] = $balance_amt;
            $data[] = $row;
        }
        $total[] = '';
        $total[] = '';
        $total[] = '';
        $total[] = '';
        $total[] = '';
        $total[] = '';
        $total[] = 'Total';
        $total[] = $total_credit_amt;
        $total[] = $total_debit_amt;
        $total[] = '';
        $data[] = $total;

        $total = $balance_amt;
        $total2[] = '';
        $total2[] = '';
        $total2[] = '';
        $total2[] = '';
        $total2[] = '';
        $total2[] = '';
        $total2[] = '<b>Closing Balance</b>';
        $total2[] = '';
        $total2[] = '';
        $total2[] = '<b>' . $total . '</b>';
        $data[] = $total2;
        $output = array(
            "draw" => $_POST['draw'],
            "data" => $data,
        );
        
        //output to json format
        // echo json_encode($output);
        
        if($total){
            
            $response['status'] = "OK";
            $response['data'] = (!empty($total))?$total:[];
            
        } else {
            $response['status'] = "FAILED";
        }
        echo json_encode($response);
    }

}