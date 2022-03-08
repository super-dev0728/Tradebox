<?php 
namespace App\Modules\Paystack\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){
        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();
        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();
        $external_api_setup = $this->db->table('external_api_setup')->select('*')->where('name','Free Currency Converter')->get()->getRow();
        $apikey = json_decode($external_api_setup->data);

        if ($method=='paystack') {
            
            $url     = "https://free.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=$apikey->api_key";
            if ($gateway->secret_key=='premium') {
                $url = "https://api.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=$apikey->api_key";
            }
            
            $curl    = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => "GET",
            ));

            $response   = curl_exec($curl);
            $err        = curl_error($curl);
            curl_close($curl);
            $obj        = json_decode($response, true); 

            if (!$response || isset($obj['status']) == 400) {
                die('Invalid API returned error');
            }

            $val            = floatval($obj['USD_NGN']);
            $total          = $val * (float)@$sdata->deposit_amount+(float)@$sdata->fees;
            $deposit_amount = number_format($total, 2, '.', '');
            $deposit_amount = $deposit_amount*100;
            
            $builder = $this->db->table('dbt_user');
            $user_mail = $builder->select('email')->where('user_id', $sdata->user_id)->where('status', 1)->get()->getrow();

            $paystack = array(
              "secret_key"      => @$gateway->private_key,
              "publishable_key" => @$gateway->public_key
            );

            $curl       = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode([
                'amount'=> $deposit_amount,
                'email' => $user_mail->email,
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer ".$paystack['secret_key'],
                "content-type: application/json",
                "cache-control: no-cache"
            ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if($err){
                die('Curl returned error: ' . $err);
            }

            $tranx = json_decode($response, true);

            if(!$tranx['status']){
                print_r('API returned error: ' . $tranx['message']);
            }
            
            return $tranx['data']['authorization_url'];
             
        }
    }
}