<?php 
namespace App\Modules\Payeer\Models\Customer;

class Buy_model {
        
        function __construct() {
            $this->db = db_connect();
        }
	public function create($data = array())
	{
                $builder=$this->db->table('ext_exchange');
                return $builder->insert($data);
		 
	}

	public function findCurrency($cid = null)
	{       
                $builder = $this->db->table('crypto_currency');
		return $builder->select('price_usd')
			->where('cid', $cid)
			->where('status', 1)
			->get()
			->getRow();
	}
	public function findExcCurrency()
	{
                $builder = $this->db->table('ext_exchange_wallet');
		return $builder->select('*')
			->where('status', 1)
			->get()
			->getResult();
	}
	public function findlocalCurrency()
	{       
                $builder = $this->db->table('local_currency');
		return $builder->select('usd_exchange_rate, currency_name, currency_iso_code, currency_symbol, currency_position')
			->where('currency_id', 1)
			->get()
			->getRow();
	}
	public function findExchangeCurrency($coin_id = null)
	{       
                $builder = $this->db->table('ext_exchange_wallet');
		return $builder->select('buy_adjustment, wallet_data, coin_name')
			->where('coin_id', $coin_id)
			->where('status', 1)
			->get()
			->getRow();
	}
	
}
