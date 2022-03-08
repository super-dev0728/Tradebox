<?php namespace App\Modules\Finance\Controllers\Admin;


class Deposit extends BaseController {
 	
 
	public function index()
	{  
            
            
		    $data['title'] = display('deposit_list');
           #-------------------------------#
            #pagination starts
           #-------------------------------#
            $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
            $page_number    = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
            $pagewhere = array( 
                    'status'            => 1,
                    'deposit_method'    => 'phone'
                );
            $data['deposit'] = $this->common_model->get_all('deposit', $pagewhere,20,($page_number-1)*20,'deposit_id','DESC');
            $total           = $this->common_model->countRow('deposit',$pagewhere);
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
           
            $data['content'] = $this->BASE_VIEW . '\Deposit\list';
            return $this->template->admin_layout($data);
	}


	public function pending_deposit()
	{
           
            $data['title']  = display('pending_deposit');
            
            #-------------------------------#
            #pagination starts
            #-------------------------------#
            $page           = ($this->uri->getSegment(2)) ? $this->uri->getSegment(2) : 0;
            $page_number    = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
            $pagewhere = array( 
                    'status'            => 0,
                    'deposit_method'    => 'phone'
                );
            $data['deposit'] = $this->common_model->get_all('deposit', $pagewhere,20,($page_number-1)*20,'deposit_id','DESC');
            $total           = $this->common_model->countRow('deposit',$pagewhere);
            $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
            #------------------------
            #pagination ends
            #------------------------
            $data['content'] = $this->BASE_VIEW . '\Deposit\list';
            return $this->template->admin_layout($data);
	}


	public function confirm_deposit()
	{
              
            $set_status = $_GET['set_status'];
            $user_id = $_GET['user_id'];
            $id = $_GET['id'];
            $data = array(
                    'status' => $set_status,
            );
            
            $table="deposit";
            $updatewhere = array(
                           'user_id'    => $user_id,
                           'deposit_id' => $id,
                   );

            $this->common_model->update($table,$updatewhere,$data);
            $readwhere = array(
                            'deposit_id' => $id,
                    );
            $data= $this->common_model->read($table,$readwhere,$limit=0,$offset=0);
            $table="user_registration";
            $where = array(
                            'user_id'    => $user_id,
                    );
            $userdata=$this->common_model->read($table,$where,$limit=0,$offset=0);
          
            if($data!=NULL){

                $transections_data = array(
                'user_id'                   => $data->user_id,
                'transection_category'      => 'deposit',
                'releted_id'                => $data->deposit_id,
                'amount'                    => $data->deposit_amount,
                'comments'                  => "Deposite by OM Mobile",
                'transection_date_timestamp'=> date('Y-m-d h:i:s')
                );
                $table="transections";
                $this->common_model->insert($table,$transections_data);
            }
            
            //setting method for email
            $smsmethod=array(
              'method'  =>   'SMS'
            );
            $method=array(
              'method'  =>   'email'
            );
            //check sms method
            $set =$this->common_model->read('sms_email_send_setup',$method);
            //check sms method
            $setsms =$this->common_model->read('sms_email_send_setup',$smsmethod);
            $appSetting = $this->common_model->get_setting();
            
            // get balance
            $balance = $this->common_model->get_cata_wais_transections($userdata->user_id);
            
            #----------------------------
            #    Start  email verify smtp
            #----------------------------
            
            if($set->deposit!=NULL){

                $template = array( 
                    'fullname'      => $userdata->f_name." ". $userdata->l_name,
                    'amount'        => $data->deposit_amount,
                    'balance'       => @$balance['balance'],
                    'pre_balance'   => @$balance['balance'],
                    'new_balance'   => @$balance['balance'],
                    'user_id'       => $userdata->user_id,
                    'receiver_id'   => $userdata->user_id,
                    'verify_code'   => @$varify_code,
                    'date'          => date('d F Y')
                );
                $config_var = array( 
                    'template_name' => 'deposit_success',
                    'template_lang' => $userdata->language=='english'?'en':'fr',
                );
                $message    = $this->common_model->email_msg_generate($config_var, $template);
                $send_email = array(
                    'title'         => $appSetting->title,
                    'to'            => $userdata->email,
                    'subject'       => $message['subject'],
                    'message'       => $message['message'],
                );
                $send_email = $this->common_model->send_email($send_email);

                if($send_email){
                    $n = array(
                        'user_id'                => $userdata->user_id,
                        'subject'                => $message['subject'],
                        'notification_type'      => 'deposit',
                        'details'                => $message['message'],
                        'date'                   => date('Y-m-d h:i:s'),
                        'status'                 => '0'
                    );
                    $this->common_model->insert('notifications',$n);    
                }
 
            }
            #----------------------------
            #     End email verify smtp
            #----------------------------
            
            #----------------------------
            #     Start SMS Setting
            #----------------------------
            if($setsms->deposit!=NULL){

                $template = array( 
                    'fullname'      => $userdata->f_name." ". $userdata->l_name,
                    'amount'        => $data->deposit_amount,
                    'balance'       => @$balance['balance'],
                    'pre_balance'   => @$balance['balance'],
                    'new_balance'   => @$balance['balance'],
                    'user_id'       => $userdata->user_id,
                    'receiver_id'   => $userdata->user_id,
                    'verify_code'   => @$varify_code,
                    'date'          => date('d F Y')
                );
                $config_var = array( 
                    'template_name' => 'deposit_success',
                    'template_lang' => $userdata->language=='english'?'en':'fr',
                );

                #------------------------------
                #   SMS Sending
                #------------------------------
                $send_sms = $this->sms_lib->send(array(
                    'to'              => $userdata->phone, 
                    'message'         => $message['message']
                ));

                if($send_sms){
                    $message_data = array(
                        'sender_id'     => 1,
                        'receiver_id'   => $userdata->user_id,
                        'subject'       => $message['subject'],
                        'message'       => $message['message'],
                        'datetime'      => date('Y-m-d h:i:s'),
                    );
                    $this->common_model->insert('message',$message_data);    
                }
                 
             
            }
            #----------------------------
            #     END SMS Setting
            #----------------------------

            $this->session->setFlashdata('message', display('deopsit_add_msg'));
            return redirect()->to('deposit/pending_deposit');


	}


        public function cancel_deposit()
        {
            $set_status = $_GET['set_status'];
            $user_id = $_GET['user_id'];
            $id = $_GET['id'];
            $data = array(
                'status' => $set_status,
            );
            $table="deposit";
            $updatewhere = array(
              'user_id'    => $user_id,
              'deposit_id' => $id
              );

            $this->common_model->update($table,$updatewhere,$data);
            $this->session->setFlashdata('message', display('payment_cancel'));   
            return redirect()->to('deposit/pending_deposit');
        }
 

}
