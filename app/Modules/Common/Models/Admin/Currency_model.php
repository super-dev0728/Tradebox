<?php 
namespace App\Modules\Exchange\Models\Admin;

class Currency_model {
        public function __construct(){
            $this->db = db_connect();
        }

	public function updateCurency($data = array())
	{
                $builder=$this->db->table('crypto_currency');
                return $builder->where('symbol', $data["symbol"])
                               ->update($data);
	}

	public function findlocalCurrency()
	{       
                $builder = $this->db->table('local_currency');
		return $builder->select('usd_exchange_rate, currency_name, currency_iso_code, currency_symbol, currency_position')
			->where('currency_id', 1)
			->get()
			->getRow();
	}
}
