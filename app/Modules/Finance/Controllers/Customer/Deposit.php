<?php 
namespace App\Modules\Finance\Controllers\Customer;

class Deposit extends BaseController
{

    /*
    |-----------------------------------
    |   Add new Deposit form
    |-----------------------------------
    */
    public function index(){  

        $data['title']   = display('diposit');
     
        $date           = new \DateTime();
        $deposit_date   = $date->format('Y-m-d H:i:s');      
      
        $data['payment_gateway'] = $this->common_model->payment_gateway();
        $data['content'] = $this->BASE_VIEW . '\Deposit\deposit';
        return $this->template->customer_layout($data);

    }

    public function payment_gateway(){ 

        if ($this->session->get('deposit')) {
            $this->session->remove('deposit');
        }
        
        $this->validation->setRule('amount', display('amount'), 'required|numeric');
        $this->validation->setRule('method', display('payment_method'), 'required|alpha_numeric');
        $this->validation->setRule('fees', display('fees'), 'required|numeric');
        
        $date           = new \DateTime();
        $deposit_date   = $date->format('Y-m-d H:i:s');
        $method         = $this->request->getVar('method', FILTER_SANITIZE_STRING);  
        $amount = $this->request->getVar('amount', FILTER_SANITIZE_STRING);
        $fees = $this->request->getVar('fees', FILTER_SANITIZE_STRING);
       
        if ($this->validation->withRequest($this->request)->run()){

            $sdata['deposit'] = (object)$userdata = array(
                'deposit_id'     => @$deposit['deposit_id'],
                'user_id'        => $this->session->get('user_id'),
                'deposit_amount' => $amount,
                'deposit_method' => $method,
                'fees'           => $fees,
                'comments'       => $this->request->getVar('comments', FILTER_SANITIZE_STRING),
                'deposit_date'   => $deposit_date,
                'deposit_ip'     => $this->request->getIPAddress()
            );
            $this->session->set($sdata);
            $this->session->set('payment_type','deposit');

            return redirect()->to(base_url("customer/payment_gateway/$method"));
            
        }
        
    }

    /*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    public function deposit_list($user_id = null)
    { 
        $table = 'deposit';
        $column_order = array(null, 'deposit_amount','deposit_method','fees','comments','deposit_date','status'); //set column field database for datatable orderable
        $column_search = array('deposit_amount','deposit_method','fees','comments','deposit_date','status');//set column field database for datatable searchable 

        $order = array('deposit_id' => 'DESC'); // default order   
        $where = array('user_id' => $user_id);
        $list = $this->finance_model->get_datatables($table,$column_order,$column_search,$order,$where);
        
        $data = array();
        $no = $this->request->getvar('start');
        foreach ($list as $deposit) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $deposit->deposit_amount;
            $row[] = $deposit->deposit_method;
            $row[] = $deposit->fees;
            $row[] = $deposit->comments;
            $row[] = $deposit->deposit_date;
            if($deposit->status==0){
                $row[] = '<i class="fas fa-spinner fa-spin text-warning"></i>';
            }else if($deposit->status==1){
                $row[] = '<i class="fas fa-check text-success"></i>';
            }else{
                $row[] = '<i class="fas fa-times text-danger"></i>';
            }
             
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
    /*
    |-----------------------------------
    |   View deposit list
    |-----------------------------------
    */

    public function show()
    {   
        $data['title']   = display('deposit_list');

        #-------------------------------#
         #pagination starts
        #-------------------------------#
         $page           = ($this->uri->getSegment(3)) ? $this->uri->getSegment(3) : 0;
         $page_number    = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
         $data['user_id']   = $this->session->userdata('user_id'); 
         #------------------------
         #pagination ends
         #------------------------
         $data['content'] = $this->BASE_VIEW . '\Deposit\deposit_list';
        return $this->template->customer_layout($data);
         
    }


}