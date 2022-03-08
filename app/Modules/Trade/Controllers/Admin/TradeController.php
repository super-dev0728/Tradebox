<?php namespace App\Modules\Trade\Controllers\Admin;


class TradeController extends BaseController
{
    
    public function open_order(){


        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['open_trade']  = $this->common_model->get_all('dbt_biding', array('status' => 2), 'id','desc',20,($page_number-1)*20);
        $total            = $this->common_model->countRow('dbt_biding', array('status' => 2));
        $data['pager']    = $this->pager->makeLinks($page_number, 20, $total);


        $data['title']  = 'Open Order List';
        $data['content'] = $this->BASE_VIEW . '\exchange\open_order';
        return $this->template->admin_layout($data);
    } 

    public function trade_history(){


        $page_number            = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $total                  = $this->common_model->countRow('dbt_biding', array());
        $data['trade_history']  = $this->trade_model->get_trade_history(20,($page_number-1)*20);
        $data['pager']          = $this->pager->makeLinks($page_number, 20, $total);

        $data['content'] = $this->BASE_VIEW . '\exchange\trade_history';
        return $this->template->admin_layout($data);
    }
    
}
