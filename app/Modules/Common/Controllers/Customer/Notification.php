<?php namespace App\Modules\Common\Controllers\Customer;
class Notification extends BaseController 
{


    public function index()
    {   
        $data['title']   = display('notification'); 
        $user_id = $this->session->userdata('user_id');
        

        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
         $pagewhere = array( 
                 'user_id'            => $user_id
             );
         $data['notification'] = $this->common_model->get_all('notifications', $pagewhere,20,($page_number-1)*20,'notification_id','DESC');
         $total           = $this->common_model->countRow('notifications',$pagewhere);
         $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);  
         #------------------------
         #pagination ends
         #------------------------

         $data['content'] = $this->BASE_VIEW . '\email_sms\email_notification';
        return $this->template->customer_layout($data);
        
    }



    public function email_details($notification_id)
    {   
        $user_id = $this->session->userdata('user_id');
        $where = array(
            'user_id'         => $user_id,
            'notification_id' => $notification_id
        );
        $savedata = array(
            'status' => 1
        );
        $this->common_model->update('notifications',$where,$savedata);
        $data['notification']=$this->common_model->read('notifications',$where);
        $data['title']   = display('notification'); 
        
        $data['content'] = $this->BASE_VIEW . '\email_sms\email_details';
        return $this->template->customer_layout($data);
    }

}
