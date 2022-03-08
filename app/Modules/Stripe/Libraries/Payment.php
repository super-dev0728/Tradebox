<?php 
namespace App\Modules\Stripe\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){
        if ($method=='stripe') {
            $this->session  = \Config\Services::session();
            $this->db       =  db_connect();

            $builder        = $this->db->table('payment_gateway');
            $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();
            $amount         = round(($sdata->deposit_amount+$sdata->fees)*100);        
            
            require_once APPPATH.'Modules/Stripe/Libraries/stripe/vendor/autoload.php';
            // Use below for direct download installation  
            \Stripe\Stripe::setApiKey($gateway->private_key);

            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency'  => 'USD',
                        'unit_amount' => $amount,
                        'product_data' => [
                            'name' => 'Deposit'
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => site_url('customer/payment_callback/stripe_confirm/?'). '{CHECKOUT_SESSION_ID}',
                'cancel_url'  => base_url().'/customer/deposit/add_deposit'
            ]);
            return $checkout_session;
        }
    }
}