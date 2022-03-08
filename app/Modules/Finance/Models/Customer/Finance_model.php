<?php

namespace App\Modules\Finance\Models\Customer;

class Finance_model
{
	public function __construct()
	{
		$this->db = db_connect();
		$this->session = \Config\Services::session();
		$this->request 		 = \Config\Services::request();
	}

		/*
    |----------------------------------------------
    |   Datatable Ajax data Pagination+Search
    |----------------------------------------------     
    */
    
	function get_datatables($table,$column_order=array(),$column_search=array(),$order,$where=array(),$join=null,$secondtable=null)
	{ 
  		//print_r($column_search);

        $builder = $this->db->table($table);
		
		$i = 0;
		foreach ($column_search as $item) // loop column 
		{
                    
			if($_POST['search']['value']) // if datatable send POST for search
			{
                            
                                
				if($i===0) // first loop
				{
					$builder->groupStart(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$builder->like($item, $_POST['search']['value']);
				}
				else
				{
					$builder->orLike($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i) //last loop
					$builder->groupEnd(); //close bracket
			}
			$i++;
		}
		if($join != null){
			$builder->select('*');
			$builder->join($secondtable,$join,'left');
		}
		if($where != null) // here order processing
		{
			$builder->where($where);
		}

		if(isset($_POST['order'])) // here order processing
		{
			$builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($order))
		{
			$order = $order;
			$builder->orderBy(key($order), $order[key($order)]);
		}
		if($this->request->getvar('length') != -1)
		$builder->limit($this->request->getvar('length'), $this->request->getvar('start'));
		$query = $builder->get();
		return $query->getResult();
	}

	function count_filtered($table,$column_order=array(),$column_search=array(),$order,$where=array())
	{
            $this->get_datatables($table,$column_order,$column_search,$order);
            $db      = db_connect();
            $builder = $db->table($table);
			$builder->where($where);
			return $builder->countAllResults();
	}

	public function count_all($table,$where=array())
	{

            $db      = db_connect();
            $builder = $db->table($table);
			$builder->where($where);
			return $builder->countAllResults();
			
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

		return $v;
	}
	public function get_withdraw_by_id($id)
	{
                $builder = $this->db->table('withdraw');
		return $builder->select('*')
		->where('withdraw_id',$id)
		->where('user_id',$this->session->userdata('user_id'))
		->get()->getRow();
	}
	public function withdraw($data)
	{
                $builder=$this->db->table('withdraw');
                $builder->insert($data);
		return array('withdraw_id'=>$this->db->insertId());
	}
}