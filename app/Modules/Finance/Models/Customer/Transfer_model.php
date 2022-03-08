<?php 
namespace App\Modules\Finance\Models\Customer;

class Transfer_model {

        public function __construct()
        {
            $this->db = db_connect();
            $this->session = \Config\Services::session();
            $this->request = \Config\Services::request();
        }
        
	
        public function transfer($data)
	{
                $builder=$this->db->table('transfer');
                $builder->insert($data);
		return array('transfer_id'=>$this->db->insertId());
	}
        
        public function get_send($id){
                $builder = $this->db->table('transfer');
                
		return $builder->select('transfer.*,user_registration.*')
                                ->join('user_registration','user_registration.user_id=transfer.receiver_user_id')
                                ->where('transfer.sender_user_id',$this->session->userdata('user_id'))
                                ->where('transfer.transfer_id',$id)
                                ->get()
                                ->getRow();
	}
        
        public function get_recieved($id){
         
        $builder = $this->db->table('transfer');
		return $builder->select('transfer.*,user_registration.*')
                                ->join('user_registration','user_registration.user_id=transfer.receiver_user_id')
                                ->where('transfer.receiver_user_id',$this->session->userdata('user_id'))
                                ->where('transfer.transfer_id',$id)
                                ->get()
                                ->getrow();
	}
        
        public function save_transfer_verify($data)
	{
            $builder=$this->db->table('verify_tbl');
                    $builder->insert($data);
                    return array('id'=>$this->db->insertId());
	}
	public function get_verify_data($id)
	{
                $builder = $this->db->table('verify_tbl');
		$v = $builder->select('*')
                            ->where('id',$id)
                            ->where('session_id', $this->session->userdata('isLogIn'))
                            ->where('ip_address', $this->request->getIPAddress())
                            ->get()
                            ->getRow();

		if($v != NULL){

		$data = (json_decode($v->data)); 
                $userBuilder  = $this->db->table('user_registration');
		$u =$userBuilder->select('user_id,f_name,l_name,email,phone')
                                ->where('user_id',@$data->receiver_user_id)
                                ->get()
                                ->getrow();
		return array('v' =>$v,'u'=>$u);
		} else {

			return 0;
		}
		
	}

        public function get_cata_wais_transections($user_id="")
	{
		if ($user_id!="") {
			$user_id = $user_id;
		}
		else{
			$user_id = $this->session->userdata('user_id');
		}
                $builder= $this->db->table("transections");
		$data = $builder->select('*')
                                ->where('user_id', $user_id)
                                ->get()
                                ->getresult();
		
		$dep = 0;
		$dep_f = 0;
		$w_f = 0;
		$t_f = 0;
		$we = 0;
		$invest = 0;
		$tras = 0;
		$reciver = 0;
		$individule = array();

		foreach ($data as $value) {

			if(@$value->transection_category=='deposit'){

				$deposit = $this->getFees('deposit',$value->releted_id);
				$dep_f = $dep_f + $deposit->fees;
				$individule['d_fees'] = $dep_f;

				$dep = $dep + $value->amount;
				$individule['deposit'] = $dep;
			}

			if(@$value->transection_category=='withdraw'){

				$withdraw = $this->getFees('withdraw',$value->releted_id);
				$w_f = $w_f + $withdraw->fees;
				$individule['w_fees'] = $w_f;

				$we = $we+$value->amount;
				$individule['withdraw'] = $we;

			}

			if(@$value->transection_category=='transfer'){

				$transfer = $this->getFees('transfer',$value->releted_id);
				$t_f = $t_f + $transfer->fees;
				$individule['t_fees'] = $t_f;

				$tras = $tras+$value->amount;
				$individule['transfar'] = $tras;
			}

			if(@$value->transection_category=='investment'){
				$invest = $invest+$value->amount;
				$individule['investment'] = $invest;
			}

			if(@$value->transection_category=='reciver'){
				$reciver = $reciver+$value->amount;
				$individule['reciver'] = $reciver;
			}
		}

			// My Payout
                        $mypayout_builder= $this->db->table("earnings");
			$my_payout = $mypayout_builder->select("sum(amount) as earns2")
                                                    ->where('user_id',$this->session->userdata('user_id'))
                                                    ->where('earning_type','type2')
                                                    ->get()
                                                    ->getrow();
			$individule['my_payout'] = $my_payout->earns2;

			//Package Commission
                        $mypayout_commission= $this->db->table("earnings");
			$commission = $mypayout_commission->select("sum(amount) as earns1")
                                                            ->where('user_id',$this->session->userdata('user_id'))
                                                            ->where('earning_type','type1')
                                                            ->get()
                                                            ->getrow();
			$individule['commission'] = $commission->earns1;

			//team bonus
                        $bonus_builder = $this->db->table("user_level"); 
			$bonus = $bonus_builder->select("sum(bonus) as bonuss")
                                                ->where('user_id',$this->session->userdata('user_id'))
                                                ->get()
                                                ->getrow();

			$individule['bonuss'] = $bonus->bonuss;


			// total earning
			$total_earn =  $individule['my_payout']+$individule['commission']+$individule['bonuss'];
			$individule['earn'] = $total_earn;
			#-----------------------
			//TOTAL FEES
			$total_fees = (@$individule['w_fees']+@$individule['t_fees']);
			#-----------------------
			#---------------------------
			# TOTAL GRAND BALENCE
			$individule['balance'] = (@$individule['deposit']+@$individule['reciver']+@$total_earn)-(@$individule['withdraw']+@$individule['investment']+@$individule['transfar']+@$total_fees);
			
			#----------------------------
			return $individule;

	}
        public function getFees($table,$id)
	{
                $builder=$this->db->table("$table");
		return $builder ->select('*')
                                ->where($table.'_id',$id)
                                ->get()
                                ->getrow();
	}
	public function findById($table, $where){
                $builder = $this->db->table($table);
		return $builder->select('*')
		->where($where)
		->get()
                ->getrow();
	}


}
 