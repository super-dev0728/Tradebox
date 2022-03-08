<?php namespace App\Modules\Finance\Controllers;
class Internal_api extends BaseController
{


    /*********************
    |Websites Internal API|
    **********************/

    /*public function getStream()
    { 
        $cryptocoins    = $this->db->select("Symbol")
                            ->from('cryptolist')
                            ->order_by('SortOrder', 'asc')
                            ->limit(200, 0)
                            ->get()
                            ->result();

        $coin_stream = array();
        foreach ($cryptocoins as $coin_key => $coin_value) {
            array_push($coin_stream, "5~CCCAGG~".$coin_value->Symbol."~USD");
        }
          
        echo json_encode($coin_stream);
    }*/

   

    public function gateway()
    { 
        $builder = $this ->db->table('payment_gateway');
        $gateway        = $builder->select('*')
                            ->where('id', 4)
                            ->where('status', 1)
                            ->get()
                            ->getRow();
          
        echo json_encode($gateway);
    }


    
    /*public function getemailsmsgateway()
    {
        
        $db=  db_connect();
        $builder=$db->table("email_sms_gateway");
        $sms    =   $builder->select('*')->where('es_id', 1)->get()->getrow();
        echo json_encode($sms);
    }
    
    public function barchartdata($year='')
    {
        $current_year = date('Y');
        
        $this->db=  db_connect();
        if(!empty($year))
        {
           
             $investment = $this->db->query("SELECT MONTHNAME(`invest_date`) as month, SUM(`amount`) as investment FROM `investment` WHERE YEAR(`invest_date`) = '".$year."' GROUP BY '".$year."', MONTH(`invest_date`)")->getresult();

            $roi        = $this->db->query("SELECT MONTHNAME(`date`) as month, SUM(`amount`) as roi FROM `earnings` WHERE YEAR(`date`) = '".$year."' GROUP BY '".$year."', MONTH(`date`)")->getresult();

        }
        else
        {
            $investment = $this->db->query("SELECT MONTHNAME(`invest_date`) as month, SUM(`amount`) as investment FROM `investment` WHERE YEAR(`invest_date`) = '".$current_year."' GROUP BY YEAR(CURDATE()), MONTH(`invest_date`)")->getresult();
            $roi        = $this->db->query("SELECT MONTHNAME(`date`) as month, SUM(`amount`) as roi FROM `earnings` WHERE YEAR(`date`) = '".$current_year."' GROUP BY YEAR(CURDATE()), MONTH(`date`)")->getresult();

        }
        
        $monthsi      = array();
        $monthsr      = array();
        $investamount = array();
        $roiamount    = array();
        if(!empty($investment)){
            foreach ($investment as $key => $value) {
                array_push($investamount,$value->investment);
                array_push($monthsi,$value->month);
            }
        }

        if(!empty($roi)){
            foreach ($roi as $key => $value) {
                array_push($roiamount,$value->roi);
                array_push($monthsr,$value->month);
            }
        }
            
        $months = array_merge($monthsi, $monthsr);
        
        echo json_encode(array('investamount'=>$investamount,'roiamount'=>$roiamount,'months'=>$months));
    }

    public function getpiechartdata($value='')
    {
        $year= $value;

        $current_year = date('Y');
        $this->db=  db_connect();
        if(!empty($year)){
             $transections       = $this->db->query("SELECT `transection_category` as transection_category, SUM(`amount`) as transections FROM `transections` WHERE status=1 AND (transection_category='deposit' OR transection_category='withdraw' OR transection_category='investment') AND YEAR(`transection_date_timestamp`) = '".$year."' GROUP BY `transection_category`")->getresult();
        }else {
             $transections = $this->db->query("SELECT `transection_category` as transection_category, SUM(`amount`) as transections FROM `transections` WHERE status=1 AND (transection_category='deposit' OR transection_category='withdraw' OR transection_category='investment') AND YEAR(`transection_date_timestamp`) = '".$current_year."' GROUP BY `transection_category`")->getresult();
        }
        
        $transactioncat    = array();
        $transactionamount = array();
        foreach ($transections as $key => $value) {
            array_push($transactioncat,$value->transection_category);
            array_push($transactionamount,$value->transections);
        }

        echo json_encode(array('transactioncat'=>$transactioncat,'transactionamount'=>$transactionamount));
    }*/
    

}