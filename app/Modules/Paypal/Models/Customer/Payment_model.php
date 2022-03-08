<?php 
namespace App\Modules\Paypal\Models\Customer;

class Payment_model {
    function __construct() {
        $this->db = db_connect();
        $this->session = \Config\Services::session();
    }

    //All payment Log Data
    public function bitcoinPaymentLog($data = array()){
       

    }
    public function create($data = array())
    {
                $builder=$this->db->table('ext_exchange');
                return $builder->insert($data);
         
    }
    public function payeerPaymentLog($data = array()){

       return $this->db->insert('payeer_payments', $data);

    }
    public function paypalPaymentLog($data = array()){

             

    }
    public function stripePaymentLog($data = array()){

        

    }
    public function coinpaymentsPaymentLog($data = array()){

        $this->db->insert("coinpayments_payments",$data);

    }

    //All payment Data
    public function paymentStore($data = array()){
        $builder=$this->db->table('deposit');
        return  $builder->insert($data);

    }
    //All payment Data
    public function transections($data = array()){
       
        $builder=$this->db->table('transections');
        return  $builder->insert($data);

    }
    //All payment Data
    public function save_transections($data = array()){
  
        $builder=$this->db->table('deposit');
             $builder->insert($data);
        return  $this->db->insertId();

    }

    //Add User Balance
    //Add User Balance
    public function balanceAdd($data = array()){
 
        $check_user_balance = $this->db->table('dbt_balance')
                      ->where('user_id', $data->user_id)
                      ->where('currency_symbol', $data->currency_symbol)
                      ->get()
                      ->getRow();

          if ($check_user_balance) {

              $updatebalance = array(
                  'balance'     => $data->deposit_amount+$check_user_balance->balance,
              );

              $this->db->table('dbt_balance')
                      ->set($updatebalance)
                      ->where('user_id', $data->user_id)
                      ->where('currency_symbol', $data->currency_symbol)
                      ->update();

              return  $check_user_balance->id;

          } else {

              $insertbalance = array(
                  'user_id'         => $data->user_id,
                  'currency_id'     => 0,
                  'currency_symbol' => $data->currency_symbol,
                  'balance'         => $data->deposit_amount,
                  'last_update'     => date('Y-m-d h:i:s'),
              );

              $builder = $this->db->table('dbt_balance');
              $builder->insert($insertbalance);
              return $this->db->insertID();
        }
    }


    public function coinpayments_balanceAdd($data = array()){

        $check_user_balance = $this->db->select('*')->from('dbt_balance')->where('user_id', $data['user_id'])->where('currency_symbol', $data['currency_symbol'])->get()->row();
        
        if ($check_user_balance) {

            $updatebalance = array(
                'balance'     => $data['amount']+$check_user_balance->balance,
            );

            $this->db->where('user_id', $data['user_id'])->where('currency_symbol', $data['currency_symbol'])->update("dbt_balance", $updatebalance);

            return  $check_user_balance->id;

        }else{

            $insertbalance = array(
                'user_id'         => $data['user_id'],
                'currency_id'     => '',
                'currency_symbol' => $data['currency_symbol'],
                'balance'         => $data['amount'],
                'last_update'     => date('Y-m-d h:i:s'),
            );
            $this->db->insert('dbt_balance', $insertbalance);

            return  $this->db->insert_id();

        }
        

    }

    //Balance Log
    public function balancelog($data = array()){
       
        return $this->db->insert('transections', $data);

    }

    public function checkBalance($key, $user=null)
    {
        if ($user==null) {
            $user = $this->session->userdata('user_id');
        }

        return $this->db->select('*')
            ->from('dbt_balance')
            ->where('user_id', $user)
            ->where('currency_symbol', $key)
            ->get()
            ->row();

    }

    public function confirm_coinpayment_deposit($data = array()){

        $updatedata = array(
            'deposit_date'  =>$data['depositdate'],
            'approved_date' =>$data['depositdate'],
            'status'        =>1
        );

        $wheredata = array(
            'user_id'           =>$data['user_id'],
            'comment'           =>$data['comment'],
            'currency_symbol'   =>$data['currency_symbol']
        );

        $this->db->where($wheredata);
        $this->db->update('dbt_deposit', $updatedata);

    }


}