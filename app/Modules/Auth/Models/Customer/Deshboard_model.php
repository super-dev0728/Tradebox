<?php

namespace App\Modules\Auth\Models\customer;

class Deshboard_model
{
	public function __construct()
	{
		$this->db = db_connect();
		$this->session = \Config\Services::session();
	}
	public function get_cata_wais_transections()
	{

		// My Payout
		$builder = $this->db->table('earnings');
		$my_payout = $builder->select("sum(amount) as earns2")
			->where('user_id', $this->session->get('user_id'))
			->where('earning_type', 'type2')
			->get()
			->getRow();
		$pay = $my_payout->earns2;

		//Package Commission
		$commission = $builder->select("sum(amount) as earns1")
			->where('user_id', $this->session->get('user_id'))
			->where('earning_type', 'type1')
			->get()
			->getRow();
		$pack_commission = $commission->earns1;

		//user lavel bonus
		$levelbuilder = $this->db->table('user_level');
		$bonus = $levelbuilder->select("sum(bonus) as bonuss")
			->where('user_id', $this->session->get('user_id'))
			->get()
			->getRow();
		$team_bonus = $bonus->bonuss;

		//total earning
		@$total_earn = @$pay + @$pack_commission + @$team_bonus;


		//team bonus
		$teambuilder = $this->db->table('team_bonus');
		$teambonus = $teambuilder->select("*")
			->where('user_id', $this->session->get('user_id'))
			->get()
			->getRow();

		$sponser_commission = @$teambonus->sponser_commission;
		$team_commission    = @$teambonus->team_commission;


		$transactionbuilder = $this->db->table('transections');
		$data = $transactionbuilder->select('*')
			->where('user_id', $this->session->get('user_id'))
			->where('status', 1)
			->get()
			->getResult();

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

			if (@$value->transection_category == 'deposit') {

				$deposit = $this->getFees('deposit', $value->releted_id);
				@$dep_f = $dep_f + $deposit->fees;
				$individule['d_fees'] = $dep_f;

				$dep = $dep + $value->amount;
				$individule['deposit'] = $dep;
			}

			if (@$value->transection_category == 'withdraw') {

				$withdraw = $this->getFees('withdraw', $value->releted_id);
				@$w_f = $w_f + $withdraw->fees;
				$individule['w_fees'] = $w_f;

				$we = $we + $value->amount;
				$individule['withdraw'] = $we;
			}

			if (@$value->transection_category == 'transfer') {

				$transfer = $this->getFees('transfer', $value->releted_id);
				@$t_f = $t_f + $transfer->fees;
				$individule['t_fees'] = $t_f;

				$tras = $tras + $value->amount;
				$individule['transfar'] = $tras;
			}

			if (@$value->transection_category == 'investment') {
				$invest = $invest + $value->amount;
				$individule['investment'] = $invest;
			}

			if (@$value->transection_category == 'reciver') {
				$reciver = $reciver + $value->amount;
				$individule['reciver'] = $reciver;
			}
		}


		$individule['commission']           = @$pack_commission;
		$individule['my_earns']             = @$pay;
		$individule['team_bonus']           = @$team_bonus;
		$individule['team_commission']      = @$team_commission;
		$individule['sponser_commission']   = @$sponser_commission;

		//TOTAL FEES
		//remove under the line d_fees for showing accurate result
		$total_fees = (@$individule['w_fees'] + @$individule['t_fees']);

		$individule['balance'] = (@$individule['deposit'] + @$total_earn + @$individule['reciver']) - (@$individule['withdraw'] + @$individule['investment'] + @$individule['transfar'] + @$total_fees);

		return $individule;
	}

	public function getFees($table, $id)
	{
		$builder = $this->db->table($table);
		return $builder->select('*')
			->where($table . '_id', $id)
			->get()
			->getRow();
	}


	public function all_package()
	{
		$builder = $this->db->table('package');
		return $builder->select("*")
			->get()
			->getResult();
	}

	public function my_info()
	{
		$builder = $this->db->table('user_registration');
		$user_id = $this->session->get('user_id');

		$my_info = $builder->select('*')
			->where('user_id', $user_id)
			->get()
			->getRow();

		$sponser_info = $builder->select('*')
			->where('user_id', @$my_info->sponsor_id)
			->get()
			->getRow();

		return array('my_info' => $my_info, 'sponser_info' => $sponser_info);
	}


	public function my_sales()
	{
		$user_id = $this->session->get('user_id');
		$builder = $this->db->table('user_registration');

		$result1 = $builder->select("*")
			->where('sponsor_id', $user_id)
			->limit(5)
			->orderBy('created', 'DESC')
			->get()
			->getResult();
		return $result1;
	}


	public function my_payout()
	{
		$builder = $this->db->table('earnings');
		$user_id = $this->session->get('user_id');

		$result1 = $builder->select("*")
			->where('user_id', $user_id)
			->where('earning_type', 'type2')
			->limit(5)
			->orderBy('date', 'DESC')
			->get()
			->getResult();

		return $result1;
	}



	public function my_total_investment($user_id)
	{
		$builder = $this->db->table('investment');
		$result = $builder->select("sum(amount) as total_amount")
			->where('user_id', $user_id)
			->get()
			->getRow();
		return $result;
	}

	public function pending_withdraw()
	{
		$builder = $this->db->table('withdraw');
		$user_id = $this->session->get('user_id');
		return $builder->select("*")
			->where('status', 1)
			->where('user_id', $user_id)
			->limit(5)
			->orderBy('request_date', 'DESC')
			->get()
			->getResult();
	}

	public function my_level_information($user_id)
	{
		$builder = $this->db->table('team_bonus');
		return $builder->select('level')
			->where('user_id', $user_id)
			->get()
			->getRow();
	}
}