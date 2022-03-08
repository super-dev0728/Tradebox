<?php 
namespace App\Modules\Paypal\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){
        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();
        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();  
        if ($method=='paypal') {

            /******************************
            * Paypal Payment Gateway API
            ******************************/
            if ( $gateway ) {

                require APPPATH.'Modules/Paypal/Libraries/paypal/vendor/autoload.php';

                // After Step 1
                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        @$gateway->public_key,     // ClientID
                        @$gateway->private_key     // ClientSecret
                    )
                );

                // Step 2.1 : Between Step 1 and Step 2
                $apiContext->setConfig(
                    array(
                        'mode' => @$gateway->secret_key,
                        'log.LogEnabled' => true,
                        'log.FileName' => 'PayPal.log',
                        'log.LogLevel' => 'FINE'
                    )
                );

                // After Step 2
                $payer = new \PayPal\Api\Payer();
                $payer->setPaymentMethod('paypal');

                $item1 = new \PayPal\Api\Item();
                $item1->setName('setName');
                $item1->setCurrency('USD');
                $item1->setQuantity(1);
                $item1->setPrice((float)@$sdata->deposit_amount+(float)@$sdata->fees);

                $itemList = new \PayPal\Api\ItemList();
                $itemList->setItems(array($item1));

                $amount = new \PayPal\Api\Amount();
                $amount->setCurrency("USD");
                $amount->setTotal((float)@$sdata->deposit_amount+(float)@$sdata->fees);

                $transaction = new \PayPal\Api\Transaction();
                $transaction->setAmount($amount);
                $transaction->setItemList($itemList);
                $transaction->setDescription('Description');

                $redirectUrls = new \PayPal\Api\RedirectUrls();
                $redirectUrls->setReturnUrl(base_url('customer/payment_callback/paypal_confirm'))->setCancelUrl(base_url('customer/payment_callback/paypal_cancel'));

                $payment = new \PayPal\Api\Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);

                // After Step 3
                try {

                    $payment->create($apiContext);                

                    $data['payment']     =  $payment;
                    $data['approval_url']=  $payment->getApprovalLink();

                    return $data;
                }
                catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    // This will print the detailed information on the exception.
                    //REALLY HELPFUL FOR DEBUGGING
                    $this->session->setFlashdata('exception', $message->error_description);
   
                }

            }
            else{
                return false;

            }

        }
    }
}