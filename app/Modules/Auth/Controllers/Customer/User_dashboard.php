<?php

namespace App\Modules\Auth\Controllers\Customer;

use \CodeIgniter\HTTP\URI;

helper('date');
class User_dashboard extends BaseController
{
    public function index()
    {
        $data    = $this->dashboard_model->get_cata_wais_transections();

        $data['title']              = "Home";
        $data['package']            = $this->dashboard_model->all_package();
        $data['info']               = $this->dashboard_model->my_info();
        $data['my_payout']          = $this->dashboard_model->my_payout();
        $data['my_sales']           = $this->dashboard_model->my_sales();
        $data['pending_withdraw']   = $this->dashboard_model->pending_withdraw();
        $data['level_info']         = $this->dashboard_model->my_level_information($this->USER_ID);
        $data['investment']         = $this->dashboard_model->my_total_investment($this->USER_ID);

        $data['content'] = $this->BASE_VIEW . '\dashboard';
        return $this->template->customer_layout($data);
    }
}