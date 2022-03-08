<?php 
namespace App\Modules\Gourl\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){


        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();

        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();        

        if ($method=='bitcoin') {            

            /********************************
            * GoUrl Cryptocurrency Payment API
            *********************************/
            if ($gateway) {

                $coin = 'bitcoin';
                if($sdata->currency_symbol=='BCH'){
                    $coin = 'bitcoincash';
                }elseif($sdata->currency_symbol=='LTC'){
                    $coin = 'litecoin';
                }elseif($sdata->currency_symbol=='DASH'){
                    $coin = 'dash';
                }elseif($sdata->currency_symbol=='DOGE'){
                    $coin = 'dogecoin';
                }elseif($sdata->currency_symbol=='SPD'){
                    $coin = 'speedcoin';
                }elseif($sdata->currency_symbol=='RDD'){
                    $coin = 'reddcoin';
                }elseif($sdata->currency_symbol=='POT'){
                    $coin = 'potcoin';
                }elseif($sdata->currency_symbol=='FTC'){
                    $coin = 'feathercoin';
                }elseif($sdata->currency_symbol=='VTC'){
                    $coin = 'vertcoin';
                }elseif($sdata->currency_symbol=='PPC'){
                    $coin = 'peercoin';
                }elseif($sdata->currency_symbol=='MUE'){
                    $coin = 'monetaryunit';
                }elseif($sdata->currency_symbol=='UNIT'){
                    $coin = 'universalcurrency';
                }else{
                    $coin = 'bitcoin';
                }

                DEFINE("CRYPTOBOX_PHP_FILES_PATH", site_url('app/Modules/Gourl/Libraries/gourl/lib/'));
                DEFINE("CRYPTOBOX_IMG_FILES_PATH", site_url('app/Modules/Gourl/Libraries/gourl/images/'));
                DEFINE("CRYPTOBOX_JS_FILES_PATH", site_url('app/Modules/Gourl/Libraries/gourl/js/'));
                
                // Change values below
                // --------------------------------------
                DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");
                DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");
                DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");

                // Open Source Bitcoin Payment Library
                require FCPATH.'app/Modules/Gourl/Libraries/gourl/lib/cryptobox.class.php';
                    
                /*********************************************************/
                /****  PAYMENT BOX CONFIGURATION VARIABLES  ****/
                /********************************************************/
                $paytype = $this->session->get('payment_type');


                $userID         = $sdata->user_id;     // place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
                                                      // You can use php $_SESSION["userABC"] for store userID, amount, etc
                                                      // You don't need to use userID for unregistered website visitors - $userID = "";
                                                      // if userID is empty, system will autogenerate userID and save it in cookies
                    $userFormat     = "COOKIE";       // save userID in cookies (or you can use IPADDRESS, SESSION, MANUAL)
                    $orderID        = "inv".$sdata->user_id.time().'_'.(float)@$sdata->fees;    // invoice #000383
                    $amountUSD      = (float)@$sdata->deposit_amount + (float)@$sdata->fees;           // invoice amount - 0.12 USD; or you can use - $amountUSD = convert_currency_live("EUR", "USD", 22.37); // convert 22.37EUR to USD
                    
                    $period                 = "NOEXPIRY";     // one time payment, not expiry
                    $def_language           = "en";           // default Language in payment box
                    $data['def_language']   = "en";
                    $def_coin               = $coin;      // default Coin in payment box
                    $data['def_coin']       = $coin;
                    
                    
                    
                    // List of coins that you accept for payments
                    //$coins = array('bitcoin', 'bitcoincash', 'litecoin', 'dash', 'dogecoin', 'speedcoin', 'reddcoin', 'potcoin', 'feathercoin', 'vertcoin', 'peercoin', 'monetaryunit', 'universalcurrency');


                    $coins = array($coin);  // for example, accept payments in bitcoin, bitcoincash, litecoin, dash, speedcoin 
                    $data['coins'] = array($coin); 

                    // Create record for each your coin - https://gourl.io/editrecord/coin_boxes/0 ; and get free gourl keys
                    // It is not bitcoin wallet private keys! Place GoUrl Public/Private keys below for all coins which you accept

                    $pub_key = unserialize($gateway->public_key);
                    $pri_key = unserialize($gateway->private_key);
                    $pub_val = '';
                    $piv_val = '';
                    foreach ($pub_key as $key => $value) { 
                        if ($coin == $key && $value!='') $pub_val = $value;

                    }
                    foreach ($pri_key as $key => $value) { 
                        if ($coin == $key && $value!='') $piv_val = $value;

                    }

                             
                    // Demo Keys; for tests (example - 5 coins)
                    $all_keys = array(  $coin => array( "public_key" => $pub_val,  
                                                        "private_key" => $piv_val));

                    //  IMPORTANT: Add in file /lib/cryptobox.config.php your database settings and your gourl.io coin private keys (need for Instant Payment Notifications) -
                    /* if you use demo keys above, please add to /lib/cryptobox.config.php - 
                        $cryptobox_private_keys = array("25654AAo79c3Bitcoin77BTCPRV0JG7w3jg0Tc5Pfi34U8o5JE", 
                                    "25656AAeOGaPBitcoincash77BCHPRV8quZcxPwfEc93ArGB6D", "25657AAOwwzoLitecoin77LTCPRV7hmp8s3ew6pwgOMgxMq81F", 
                                    "25658AAo79c3Dash77DASHPRVG7w3jg0Tc5Pfi34U8o5JEiTss", "20116AA36hi8Speedcoin77SPDPRVNOwjzYNqVn4Sn5XOwMI2c");
                        Also create table "crypto_payments" in your database, sql code - https://github.com/cryptoapi/Payment-Gateway#mysql-table
                        Instruction - https://gourl.io/api-php.html         
                    */                 
                    
                    
                    
                    
                    // Re-test - all gourl public/private keys
                    $def_coin = strtolower($def_coin);
                    if (!in_array($def_coin, $coins)) $coins[] = $def_coin;  
                    foreach($coins as $v)
                    {
                        if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) die("Please add your public/private keys for '$v' in \$all_keys variable");
                        elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
                        elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
                        elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false) 
                                die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file /lib/cryptobox.config.php.");
                    }
                    
                    // Current selected coin by user
                    $coinName = cryptobox_selcoin($coins, $def_coin);
                    
                    // Current Coin public/private keys
                    $public_key  = $all_keys[$coinName]["public_key"];
                    $private_key = $all_keys[$coinName]["private_key"];
                    
                    /** PAYMENT BOX **/
                    $options = array(
                        "public_key"    => $public_key,
                        "private_key"   => $private_key,
                        "webdev_key"    => "DEV1124G19CFB313A993D68G453342148", 
                        "orderID"       => $orderID,
                        "userID"        => $userID,
                        "userFormat"    => $userFormat,
                        "amount"        => $amountUSD,
                        "amountUSD"     => 0,
                        "period"        => $period,
                        "language"      => $def_language
                    );

                    // Initialise Payment Class
                    $box = new \Cryptobox ($options);

                    $data['box'] = $box;

                    // coin name
                    $coinName = $box->coin_name();


                    // php code end :)
                    // ---------------------
                    
                    // NOW PLACE IN FILE "lib/cryptobox.newpayment.php", function cryptobox_new_payment(..) YOUR ACTIONS -
                    // WHEN PAYMENT RECEIVED (update database, send confirmation email, update user membership, etc)
                    // IPN function cryptobox_new_payment(..) will automatically appear for each new payment two times - payment received and payment confirmed
                    // Read more - https://gourl.io/api-php.html#ipn

                    //require_once(FCPATH . "gourl/lib/cryptobox.newpayment.php" );    



                    $order = $box->get_json_values();

                    $data['coinImageSize'] = 70;
                    $data['qrcodeSize'] = 200;
                    $data['show_languages'] = true;
                    $data['logoimg_path'] = "default";
                    $data['resultimg_path'] = "default";
                    $data['resultimgSize'] = 250;
                    $data['redirect'] = base_url("customer/payment_callback/bitcoin_confirm/".@$order['order']);
                    $data['method'] = "ajax";
                    $data['debug'] = false;

                    // Text above payment box
                    $data['custom_text']  = "";

                return $data;

            }else{
            return false;

            }

        }
    }
}