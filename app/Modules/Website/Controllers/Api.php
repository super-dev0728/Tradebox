<?php namespace App\Modules\Website\Controllers;

class Api extends BaseController
{
    //chart api function satart
    public function config()
    {

        $test = array(
            "supports_search" => true,
            "supports_group_request" => false,
            "supports_marks" => true,
            "supports_timescale_marks" => true,
            "supports_time" => true,
            "exchanges" => [array(
                "value" => "",
                "name" => "",
                "desc" => ""
            ) ],
            "supported_resolutions" => [1,15,"1D", "2D", "3D", "5D", "W", "3W", "M", "6M"]
        );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($test, JSON_UNESCAPED_UNICODE);
        exit;

    }

    public function symbols()
    {
   
        $settings =  $this->db->table('setting')->select('time_zone')->get()->getRow();
        $symbol   = $this->request->getGet('symbol', FILTER_SANITIZE_STRING);
        $data = array(
            "name"            => $symbol?$symbol:"LEZ_USDT", //this symbol are show in chart and pass as a paramiter
            "exchange-traded" => "",
            "exchange-listed" => "",
            "timezone"        => $settings->time_zone,
            "minmov"          => 1,
            "minmov2"         => 0,
            "pointvalue"      => 1,
            "session"         => "0100-2359:1234567",
            "has_intraday"    => false,
            "has_no_volume"   => false,
            "description"     => "",
            "type"            => "stock",
            "supported_resolutions" => [1,15,"1D", "2D", "3D", "5D", "W", "3W", "M", "6M"],
            "pricescale"            => 1000000,
            "ticker"                => $symbol?$symbol:"LEZ_USDT"
        );
       
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    private function getPair()
    {
        return $this->market_symbol;
    }

    public function search()
    {

      $limit =  $this->request->getGet('limit');

      $data = array();
      $symbol       = [];
      $full_name    = [];
      $description  = [];
      $exchange     = [];
      $type         = [];

      $coin_pairs   = $this->common_model->get_all('dbt_coinpair', array('status' => 1),  'id','desc', 0, $limit);


      foreach ($coin_pairs as $key => $value) {

         $symbol      = $value->symbol;
         $full_name   = $value->symbol;
         $description = "Pair";
         $exchange    = "Exchange";
         $type        = $value->currency_symbol;

         $data2 = ['symbol' => $symbol, 'full_name' => $full_name, 'description' => $description, 'exchange' => $exchange, 'type' => $type];

         array_push($data, $data2);
      }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;

    }

    public function time()
    {
        $data = array();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function symbol_info()
    {

        $settings =  $this->db->table('setting')->select('time_zone')->get()->getRow();

        $data = array (
            'symbol' => ["BTC","USDT","ETH"],
            'description'=>["btc","USDT","ETH"],
            'exchange-listed'=>"",
            'exchange-traded'=>"",
            'minmov'=>1,
            'minmov2'=>0,
            'pointvalue'=>1,
            'pricescale'=>[1,1,100],
            'has-dwm'=>true,
            'has-intraday'=>true,
            'has-no-volume'=>[false,false,true],
            'type'=>["stock","stock","stock"],
            'ticker'=>["BTC~USDT","BTC~LTC","BTC~ETH"],
            'timezone'=>$settings->time_zone,
            'session-premarket'=>"0100-2359:1234567",
            'session-regular'=>"0100-2359:1234567",
            'session-postmarket'=>"0100-2359:1234567"
        );
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function history()
    {

      $market_symbol = $this->request->getGet('symbol', FILTER_SANITIZE_STRING);
      $from          = date("Y-m-d", $this->request->getGet('from', FILTER_SANITIZE_STRING));
      $to            = date("Y-m-d", $this->request->getGet('to', FILTER_SANITIZE_STRING));

      $coinhistory   = $this->db->table('dbt_coinhistory')->select('DATE(date) as date')->selectSum('open')->selectSum('price_high_24h')->selectSum(' price_low_24h')->selectSum('close')->selectSum('volume_1h')->where('market_symbol', $market_symbol)->where('DATE(date) >=',$from)->where('DATE(date) <=', $to)->groupBy('DATE(date)')->orderBy('date', 'asc')->get()->getResult();     

      $id       = [];
      $time     = [];
      $open     = [];
      $high     = [];
      $low      = [];
      $close    = [];
      $volume   = [];

      foreach ($coinhistory as $key => $value) {

          $timestamp = strtotime(DATE($value->date));
          
          array_push($time, $timestamp);
          array_push($open, number_format($value->open, 2, '.', ''));
          array_push($high, number_format($value->price_high_24h, 2, '.', ''));
          array_push($low, number_format($value->price_low_24h, 2, '.', ''));
          array_push($close, number_format($value->close, 2, '.', ''));
          array_push($volume,  number_format($value->volume_1h, 0, '.', ''));
      }

      $generatedArray = ['t' => $time, 'o' => $open, 'h' => $high, 'l' => $low, 'c' => $close, 'v' => $volume, 's' => "ok"];
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($generatedArray, JSON_UNESCAPED_UNICODE);
      exit;
    }

    

    public function quotes()
    {
      $data = array();

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      exit;
    }

    public function marks()
    {

      $data = [];

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      exit;

    }

    public function timescale_marks()
    {

      $data = [];

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      exit;
    }
    //chart api function end
}

