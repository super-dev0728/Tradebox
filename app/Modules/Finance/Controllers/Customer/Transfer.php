<?php 

namespace App\Modules\Finance\Controllers\Customer;

class Transfer extends BaseController
{

    /*
    |-----------------------------------
    |   View transfer 
    |-----------------------------------
    */
    public function index()
    {   
       $data['title']   = display('transfer'); 
       $data['content'] = $this->BASE_VIEW . '\transfer\transfar';
        return $this->template->customer_layout($data);
   }
    /*
    |-----------------------------------
    |   View transfer list
    |-----------------------------------
    */
    public function transfer_list()
    {
        $user_id         = $this->session->userdata('user_id');
        $data['title']   = display('transfer_list');

        #-------------------------------#
        #pagination starts
        #-------------------------------#
        $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
        $page_number    = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $builder        = $this->db->table('transfer');
        $data['transfer'] = $builder->select('transfer.*,user_registration.*')
                            ->join('user_registration','user_registration.user_id=transfer.receiver_user_id')
                            ->where('transfer.sender_user_id',$user_id)
                            ->orWhere('transfer.receiver_user_id',$user_id)
                            ->orderBy('transfer.date',"DESC")
                            ->limit(20,($page_number-1)*20)
                            ->get()
                            ->getresult();

        $total           = $builder->select('transfer.*,user_registration.*')
                            ->join('user_registration','user_registration.user_id=transfer.receiver_user_id')
                            ->where('transfer.sender_user_id',$user_id)
                            ->orWhere('transfer.receiver_user_id',$user_id)
                            ->orderBy('transfer.date',"DESC")
                            ->limit(20, ($page_number-1)*20)
                            ->countAllResults();
        $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
        #------------------------
        #pagination ends
        #------------------------
        $data['content'] = $this->BASE_VIEW . '\transfer\transfar_list';
        return $this->template->customer_layout($data);
    }



    public function send_details($id=NULL)
    {

        $data['title']   = display('transfar_recite'); 
        $data['send']    = $this->transfer_model->get_send($id);
        $where = array(
            'user_id' =>  $this->session->userdata('user_id')
        );
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        $data['content'] = $this->BASE_VIEW . '\transfer\send_recite';
        return $this->template->customer_layout($data);
    }


    public function receive_details($id=NULL)
    {

        $data['title']   = display('transfar_recite'); 
        $data['send']    = $this->transfer_model->get_recieved($id);
        $where = array(
            'user_id' =>  $this->session->userdata('user_id')
        );
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        
        $data['content'] = $this->BASE_VIEW . '\transfer\recived_recite';
        return $this->template->customer_layout($data);

    }

    /*
    |-----------------------------------
    |   transfer  submit
    |-----------------------------------
    */

    public function store()
    {
        
        $this->validation->setRule('receiver_id', display('receiver_id'), 'required');
        $this->validation->setRule('amount', display('amount'), 'required');
        $this->validation->setRule('varify_media','OTP Send To', 'required');
      
        if($this->validation->withRequest($this->request)->run()){

            $varify_media = $this->request->getVar('varify_media',FILTER_SANITIZE_STRING);
            $receiver_id  = $this->request->getVar('receiver_id',FILTER_SANITIZE_STRING);
            $amount       = $this->request->getVar('amount',FILTER_SANITIZE_STRING);
            $varify_code  = $this->randomID();
            $user_lang    = $this->db->table('user_registration')->select('language')->where('user_id', $this->session->userdata('user_id'))->get()->getRow();

            // check balance 
            $blance     = $this->check_balance($amount);
            $appSetting = $this->common_model->get_setting();
            #----------------------------
            if($blance != true){

                $this->session->setFlashdata('exception', display('balance_is_unavailable'));
                return redirect()->to('transfer_amount');

            } else {

                if($varify_media==2){

                    #----------------------------
                    #      email verify smtp mail
                    #----------------------------
                    $template = array(
                        'fullname'      => $this->session->userdata('fullname'),
                        'amount'        => $amount,
                        'balance'       => @$blance['balance'],
                        'pre_balance'   => @$blance['balance'],
                        'new_balance'   => @$blance['balance'],
                        'user_id'       => $this->session->userdata('user_id'),
                        'receiver_id'   => $receiver_id,
                        'verify_code'   => $varify_code,
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'transfer_verification',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->email_msg_generate($config_var, $template);
                    $send_email = array(
                        'title'         => $appSetting->title,
                        'to'            => $this->session->userdata('email'),
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                    );
                    $code_send = $this->common_model->send_email($send_email);

                } else {

                    $template = array( 
                        'fullname'      => $this->session->userdata('fullname'),
                        'amount'        => $amount,
                        'balance'       => @$blance['balance'],
                        'pre_balance'   => @$blance['balance'],
                        'new_balance'   => @$blance['balance'],
                        'user_id'       => $this->session->userdata('user_id'),
                        'receiver_id'   => $receiver_id,
                        'verify_code'   => $varify_code,
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'transfer_verification',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                        'template_data' => $template,
                    );
                    $message = $this->common_model->sms_msg_generate($config_var, $template);
                    $code_send = $this->sms_lib->send(array(
                        'to'            => $this->session->userdata('phone'), 
                        'message'       => $message['message'],
                    ));
                    
                }

                //WHEN YOU COMMENT OUT SMS API YOU HAVE TO WRITE ISNOT ISSET 
                if(isset($code_send)){

                    $fees = $this->fees_load($amount,'transfer');

                    $transfar_data = array(
                        'sender_user_id'   => trim($this->session->userdata('user_id')),
                        'receiver_user_id' => trim($this->request->getVar('receiver_id',FILTER_SANITIZE_STRING)),
                        'amount'           => $this->request->getVar('amount',FILTER_SANITIZE_STRING),
                        'fees'             => @$fees,
                        'request_ip'       => $this->request->getIPAddress(),
                        'date'             => date('Y-m-d h:i:s'),
                        'comments'         => $this->request->getVar('comments',FILTER_SANITIZE_STRING),
                        'status'           => 1,
                    );

                    $varify_data = array(

                        'ip_address'  => $this->request->getIPAddress(),
                        'user_id'     => $this->session->userdata('user_id'),
                        'session_id'  => $this->session->userdata('isLogIn'),
                        'verify_code' => $varify_code,
                        'data'        => json_encode($transfar_data)

                    );

                    $result = $this->transfer_model->save_transfer_verify($varify_data);

                    return redirect()->to('confirm_transfer/'.$result['id']);

                } 
            }

        } else {

            $data['old'] = (object)$_POST;
            $data['title']   = display('transfar'); 
            $data['content'] = $this->BASE_VIEW . '\transfer\transfar';
            return $this->template->customer_layout($data);
        }
    }


        /*
        |---------------------------------
        |   Fees Load and deposit amount 
        |---------------------------------
        */
        public function fees_load($amount=null,$level)
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
    |   transfer verify
    |-----------------------------------
    */

    public function confirm_transfer($id = null)
    {

        $data     = $this->transfer_model->get_verify_data($id);

        $jsondata = json_decode($data['v']->data);

        $receiverinfo = $this->transfer_model->findById('user_registration', array('user_id'=>$jsondata->receiver_user_id));

        if(!empty($receiverinfo)){

            $data['title']   = display('transfar_verify'); 
            $data['content'] = $this->BASE_VIEW . '\transfer\transfar_verify';
            return $this->template->customer_layout($data);

        } else {
            $this->session->setFlashdata('exception', "Your Receiver Id Not Match, Please Try Again!");
            return redirect()->to('customer/transfer/transfer_amount');
        }
    }


    /*
    |-----------------------------------
    |   verify the code
    |-----------------------------------
    */
    public function transfer_verify()
    {
        
        $code = $this->request->getVar('code',FILTER_SANITIZE_STRING);
        $id   = $this->request->getVar('id',FILTER_SANITIZE_STRING);
        $builder = $this->db->table('verify_tbl');
        
        $data = $builder->select('*')
                ->where('verify_code',$code)
                ->where('id',$id)
                ->where('session_id',$this->session->userdata('isLogIn'))
                ->where('status', 1)
                ->get()
                ->getRow();

        if(!empty($data)) {

            $t_data = ((array) json_decode($data->data));
            $result = $this->transfer_model->transfer($t_data);

            $appSetting    = $this->common_model->get_setting();
            $set           = $this->common_model->email_sms('email');
            $smsPermission = $this->common_model->email_sms('email');
            $user_lang    = $this->db->table('user_registration')->select('language')->where('user_id', $this->session->userdata('user_id'))->get()->getRow();
            $blance     = $this->check_balance($t_data['amount']);
            $transections_data = array(
                'user_id'                   => $this->session->userdata('user_id'),
                'transection_category'      => 'transfer',
                'releted_id'                => $result['transfer_id'],
                'amount'                    => $t_data['amount'],
                'comments'                  => $t_data['comments'],
                'transection_date_timestamp'=> date('Y-m-d h:i:s')
            );

            $transections_reciver_data = array(
                'user_id'                   => $t_data['receiver_user_id'],
                'transection_category'      => 'reciver',
                'releted_id'                => $result['transfer_id'],
                'amount'                    => $t_data['amount'],
                'comments'                  => $t_data['comments'],
                'transection_date_timestamp'=> date('Y-m-d h:i:s')
            );
            
            $this->common_model->insert('transections',$transections_data);
            
            $this->common_model->insert('transections',$transections_reciver_data);
            $where = array(
                'id' => $id,
                'session_id' => $this->session->userdata('isLogIn')
            );
            $savedata = array(
                'status' => 0
            );
            $this->common_model->update('verify_tbl',$where,$savedata);

            #----------------------------
            #      email verify smtp
            #----------------------------
            $balance = $this->transfer_model->get_cata_wais_transections();
            if(!empty($set) && $set->transfer == 1){
                $template = array(
                        'fullname'      => $this->session->userdata('fullname'),
                        'amount'        => $t_data['amount'],
                        'balance'       => @$blance['balance'],
                        'pre_balance'   => @$blance['balance'],
                        'new_balance'   => @$blance['balance'],
                        'user_id'       => $this->session->userdata('user_id'),
                        'receiver_id'   => $t_data['receiver_user_id'],
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'transfer_success',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                    );
                    $message    = $this->common_model->email_msg_generate($config_var, $template);
                    $send_email = array(
                        'title'         => $appSetting->title,
                        'to'            => $this->session->userdata('email'),
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                    );
                    $code_send = $this->common_model->send_email($send_email);
            }

            $notifications = array(
                'user_id'           => $this->session->userdata('user_id'),
                'subject'           => display('transfer'),
                'notification_type' => 'transfer',
                'details'           => 'You successfully transfer The amount $'.$t_data['amount'].' to the account '.$t_data['receiver_user_id'].'. Your new balance is $'.$balance['balance'],
                'date'              => date('Y-m-d h:i:s'),
                'status'            => '0'
            );
            $this->common_model->insert('notifications',$notifications); 

            #------------------------------
            #   SMS Sending Confirmation
            #------------------------------
            if(!empty($smsPermission) && $smsPermission->transfer == 1){
                $template = array( 
                        'fullname'      => $this->session->userdata('fullname'),
                        'amount'        => $t_data['amount'],
                        'balance'       => @$blance['balance'],
                        'pre_balance'   => @$blance['balance'],
                        'new_balance'   => @$blance['balance'],
                        'user_id'       => $this->session->userdata('user_id'),
                        'receiver_id'   => $t_data['receiver_user_id'],
                        'date'          => date('d F Y')
                    );
                    $config_var = array( 
                        'template_name' => 'transfer_success',
                        'template_lang' => $user_lang->language=='english'?'en':'fr',
                        'template_data' => $template,
                    );
                    $message = $this->common_model->sms_msg_generate($config_var, $template);
                    $code_send = $this->sms_lib->send(array(
                        'to'            => $this->session->userdata('phone'), 
                        'message'       => $message['message'],
                    ));
            }

            echo $result['transfer_id'];

        } else {

            echo 0;

        }
        
    }


    /*
    |-----------------------------------
    |   Balance Check
    |-----------------------------------
    */

    public function transfer_recite($id=NULL)
    {
        $data = $this->transfer_model->get_verify_data($id);
        $user_id =$this->session->userdata('user_id');
        $data['title']   = display('transfar_recite'); 
        $where = array(
            'user_id' => $user_id
        );
        
        $data['my_info'] = $this->common_model->read('user_registration',$where);
        $data['content'] = $this->BASE_VIEW . '\transfer\transfer_recite';
        return $this->template->customer_layout($data);
     }
    /*
    |-----------------------------------
    |   Balance Check
    |-----------------------------------
    */

    public function check_balance($amount=NULL)
    {
        $data = $this->transfer_model->get_cata_wais_transections();
        $amount += $this->fees_load($amount,'transfer');

        if($amount < $data['balance']){
            $new = $data['balance']-$amount;
            return $balence = array('new_balance'=>$new,'balance'=>$data['balance']);
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