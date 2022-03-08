<?php 
namespace App\Modules\Finance\Controllers\Customer;

class Withdraw extends BaseController
{

    public function index()
    {   

        $data['title']           = display('withdraw');
        $data['payment_gateway'] = $this->common_model->payment_gateway();

        $data['content'] = $this->BASE_VIEW . '\Withdraw\withdraw';
        return $this->template->customer_layout($data);
      
    }
     public function withdraw_ajax_list($user_id = null)
    { 
        $table = 'withdraw';
        $column_order = array(null,'withdraw_id','amount','walletid','method','request_date','status'); //set column field database for datatable orderable
        $column_search = array('withdraw_id','amount','walletid','method','request_date','status');//set column field database for datatable searchable 

        $order = array('withdraw_id' => 'DESC'); // default order      
        $where = array('user_id' => $user_id);
        $list = $this->finance_model->get_datatables($table,$column_order,$column_search,$order,$where);
        
        $data = array();
        $no = $this->request->getvar('start');
        foreach ($list as $withdraw) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $withdraw->amount;
            $row[] = $withdraw->walletid;
            $row[] = $withdraw->method;
            $row[] = $withdraw->request_date;
            if($withdraw->status==1){
                $row[] = '<i class="fas fa-spinner fa-spin text-warning"></i>';
            }else if($withdraw->status==2){
                $row[] = '<i class="fas fa-check text-success"></i>';
            }else{
                $row[] = '<i class="fas fa-times text-danger"></i>';
            }


             $row[] =  '<a href="'.base_url("customer/withdraw/withdraw_details/$withdraw->withdraw_id").'"'.' class="btn btn-success">'.display('details').'</a>';
            $data[] = $row;
        }

        $output = array(
                "draw" => intval($this->request->getvar('draw')),
                "recordsTotal" => $this->finance_model->count_all($table,$where),
                "recordsFiltered" => $this->finance_model->count_filtered($table,$column_order,$column_search,$order,$where),
                "data" => $data,
            );
        //output to json format
        echo json_encode($output);
    }

    public function withdraw_list()
    {

        $user_id           = $this->session->get('user_id');
        $data['title']     = display('withdraw_list'); 
 
        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page              = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number       = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['user_id']   = $user_id;  
        #------------------------
        #pagination ends
        #------------------------

        $data['content']  = $this->BASE_VIEW . '\Withdraw\withdraw_list';
        return $this->template->customer_layout($data);
    }

    public function withdraw_details($id=NULL)
    {
        $user_id            = $this->session->get('user_id');
        $data['title']      = display('withdraw_details'); 
        $where              = array(
                                'user_id' => $user_id
                              );
        
        $data['my_info']    = $this->common_model->read('user_registration',$where);
        $data['withdraw']   = $this->finance_model->get_withdraw_by_id($id);
        
        $data['content']    = $this->BASE_VIEW . '\Withdraw\withdraw_details';
        return $this->template->customer_layout($data); 

    }


    public function store()
    {
        
        $this->validation->setRule('amount', display('amount'), 'required');
        $this->validation->setRule('varify_media','OTP Send To', 'required');
       
        $appSetting = $this->common_model->get_setting();

        if($this->validation->withRequest($this->request)->run()){

            $user_lang      = $this->db->table('user_registration')->select('language')->where('user_id', $this->session->get('user_id'))->get()->getRow();

            $amount         = $this->request->getVar('amount',FILTER_SANITIZE_STRING);
            $varify_media   = $this->request->getVar('varify_media',FILTER_SANITIZE_STRING);
            $varify_code    = $this->randomID();
            #----------------------------
            // check balance 
            $blance         = $this->check_balance($this->request->getVar('amount',FILTER_SANITIZE_STRING));
           
            if($blance!=true){
                $this->session->setFlashdata('exception', display('balance_is_unavailable'));
                return redirect()->to(base_url('customer/withdraw/withdraw_money'));

            } else {

                if($varify_media==2){
                    #--------------------------
                    #  email verify smtp mail
                    #--------------------------
                    $template = array( 
                        'fullname'      => $this->session->get('fullname'),
                        'amount'        => $amount,
                        'balance'       => @$blance['balance'],
                        'user_id'       => $this->session->get('user_id'),
                        'verify_code'   => $varify_code,
                        'date'          => date('d F Y')
                    );
                    
                    $config_var = array( 
                        'template_name' => 'withdraw_verification',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->email_msg_generate($config_var, $template);

                    $send_email = array(
                        'title'         => $appSetting->title,
                        'to'            => $this->session->get('email'),
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                    );
                    
                    $code_send = $this->common_model->send_email($send_email);
                    if($code_send){
                        $message_data = array(
                            'sender_id'     => 1,
                            'receiver_id'   => $this->session->get('user_id'),
                            'subject'       => $message['subject'],
                            'message'       => $message['message'],
                            'datetime'      => date('Y-m-d h:i:s'),
                        );
                        $this->common_model->insert('message',$message_data);
                    }
               
                } else {
                    $template = array( 
                        'fullname'      => $this->session->get('fullname'),
                        'amount'        => $amount,
                        'balance'       => @$blance['balance'],
                        'user_id'       => $this->session->get('user_id'),
                        'verify_code'   => $varify_code,
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'withdraw_verification',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->sms_msg_generate($config_var, $template);
                    
                    $code_send = $this->sms_lib->send(array(
                    'to'              => $this->session->get('phone'), 
                    'message'         => $message['message']
                ));
                if($code_send){
                    $message_data = array(
                        'sender_id'     => 1,
                        'receiver_id'   => $this->session->get('user_id'),
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                        'datetime'      => date('Y-m-d h:i:s'),
                    );
                    $this->common_model->insert('message',$message_data);
                    }
                }
                if($code_send != NULL ){

                    // get withdraw fees
                    $fees = $this->fees_load($this->request->getVar('amount',FILTER_SANITIZE_STRING),$this->request->getVar('method',FILTER_SANITIZE_STRING),'withdraw');
                    #-----------------------
                    $withdraw = array(
                        'user_id'       => $this->session->get('user_id'),
                        'amount'        => $this->request->getVar('amount',FILTER_SANITIZE_STRING),
                        'fees'          => @$fees,
                        'walletid'      => $this->request->getVar('walletid',FILTER_SANITIZE_STRING),
                        'request_ip'    => $this->request->getIPAddress(),
                        'request_date'  => date('Y-m-d h:i:s'),
                        'method'        => $this->request->getVar('method',FILTER_SANITIZE_STRING)
                    );


                    $varify_data = array(
                        'ip_address'    => $this->request->getIPAddress(),
                        'user_id'       => $this->session->get('user_id'),
                        'session_id'    => $this->session->get('isLogIn'),
                        'verify_code'   => $varify_code,
                        'data'          => json_encode($withdraw)
                    );

                    $result = $this->finance_model->save_transfer_verify($varify_data);
                    return redirect()->to(base_url('customer/withdraw/confirm_withdraw/'.$result['id']));
                } else {

                    $this->session->setFlashdata('exception', "Missing Your Verify Media, Please Try Again.");
                    return redirect()->to(base_url('customer/withdraw/withdraw_money'));
                }   
            }     

        } else {

            $data['old'] = (object)$_POST;
            $data['title']   = display('withdraw'); 
            $data['content'] = $this->BASE_VIEW . '\Withdraw\withdraw';
            return $this->template->customer_layout($data);
        
        }
    }



    /*
    |---------------------------------
    |   Fees Load and deposit amount 
    |---------------------------------
    */
    public function fees_load($amount=null,$method=null,$level)
    {   
        $builder = $this->db->table('fees_tbl');
        $result = $builder->select('*')
        ->where('level',$level)
        ->get()
        ->getRow();
       return $fees = ($amount/100)*(float)@$result->fees;
        
    }

    /*
    |-----------------------------------
    |   confirm_withdraw
    |-----------------------------------
    */

    public function confirm_withdraw($id = null)
    {

        $data['v'] = $this->finance_model->get_verify_data($id);

        if($data['v']!=NULL){

            $data['title']   = display('confirm_withdraw'); 
            
            $data['content'] = $this->BASE_VIEW . '\Withdraw\confirm_withdraw';
             return $this->template->customer_layout($data);
            
        } else {
             return redirect()->to(base_url('customer/withdraw/withdraw_money'));
        }
    }    

    /*
    |-----------------------------------
    |   verify the code
    |-----------------------------------
    */
    public function withdraw_verify()
    {

        $code = $this->request->getVar('code',FILTER_SANITIZE_STRING);
        $id = $this->request->getVar('confirm_id',FILTER_SANITIZE_STRING);

        // check verify code
        $builder = $this->db->table('verify_tbl');
        $data = $builder->select('*')
        ->where('verify_code',$code)
        ->where('id',$id)
        ->where('session_id',$this->session->get('isLogIn'))
        ->where('status',1)
        ->get()
        ->getRow();

        if($data!=NULL) {

            $t_data = ((array) json_decode($data->data));
 
            $result = $this->finance_model->withdraw($t_data);

            $set           = $this->common_model->email_sms('email');
            $smsPermission = $this->common_model->email_sms('email');
            $appSetting    = $this->common_model->get_setting();
             $user_lang      = $this->db->table('user_registration')->select('language')->where('user_id', $this->session->get('user_id'))->get()->getRow();

            #----------------------------
            #      email verify smtp
            #----------------------------
            $balance = $this->finance_model->get_cata_wais_transections();
            $new_balance = ($balance['balance']-$t_data['amount']);
            if(!empty($set) && $set->withdraw == 1){
                
                $post = array(
                    'title'             => $appSetting->title,
                    'subject'           => 'Withdraw',
                    'to'                => $this->session->get('email'),
                    'message'           => 'You successfully withdraw the amount Is $'.$t_data['amount'].'. from your account. Your new balance is $'.$new_balance,
                );
                $send = $this->common_model->send_email($post);
            }
                
            $notification2 = array(
                    'user_id'                => $this->session->get('user_id'),
                    'subject'                => display('withdraw'),
                    'notification_type'      => 'withdraw',
                    'details'                => 'You successfully withdraw the amount Is $'.$t_data['amount'].'. from your account. Your new balance is $'.$new_balance,
                    'date'                   => date('Y-m-d h:i:s'),
                    'status'                 => '0'
            );
             $this->common_model->insert('notifications',$notification2); 

            #----------------------------
            #      Sms verify
            #----------------------------
                  
            if(!empty($smsPermission) && $smsPermission->transfer == 1){
                
                $template = array( 
                        'name'      => $this->session->get('fullname'),
                        'amount'        => $t_data['amount'],
                        'new_balance'       => $new_balance,
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'withdraw_success',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->email_msg_generate($config_var, $template);
            }

            $transections_data = array(
                'user_id'                   => $this->session->get('user_id'),
                'transection_category'      => 'withdraw',
                'releted_id'                => $result['withdraw_id'],
                'amount'                    => $t_data['amount'],
                'transection_date_timestamp'=> date('Y-m-d h:i:s')
            );
            
            $this->common_model->insert('transections',$transections_data);
            $where = array(
                'id' => $this->request->getVar('confirm_id',FILTER_SANITIZE_STRING),
                'session_id' => $this->session->get('isLogIn')
            );
            $savedata = array(
                'status' => 0
            );
            $this->common_model->update('verify_tbl',$where,$savedata);
         
            $this->session->setFlashdata('message', display('withdraw_successfull'));

            echo $result['withdraw_id'];

        } else {
            echo '';
        }
        
    }



    public function withdraw_recite($id=NULL)
    {
        $data['v'] = $this->finance_model->get_verify_data($id);

        $data['title']   = display('withdraw_recite'); 
        $data['my_info'] = $this->Profile_model->my_info();

        $data['content'] = $this->load->view('customer/pages/withdraw_recite', $data, true);
        
        $this->load->view('customer/layout/main_wrapper', $data);
    }

    /*
    |-----------------------------------
    |   Balance Check
    |-----------------------------------
    */

    public function check_balance($amount=NULL)
    {
        $data = $this->finance_model->get_cata_wais_transections();
        $amount += $this->fees_load($amount,NULL,'withdraw');
        
        if($amount < $data['balance']){
            return true;
        } else {
            return false;
        }
    }



    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
    */    
    

}
