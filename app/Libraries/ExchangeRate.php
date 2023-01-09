<?php
namespace App\Libraries;

use Carbon\Carbon;
use PhpParser\JsonDecoder;

class ExchangeRate {
    private $api = 'https://api.apilayer.com/exchangerates_data/convert';
    private $key = 'Sa3X4jekJqNM5j3ldbcOWXG5Jvm9ROUM';
    private $_response;
    private $_params;

    public function __construct()
    {
        $exchangeRates = \App\Models\ExchangeRate::all();

        foreach ($exchangeRates as $exchangeRate)
        {
            $this->setParams($exchangeRate->TargetCurrency, $exchangeRate->SourceCurrency);
            $this->curl();
            if ($this->_response->success)
            {
                $exchangeRate->Value = (double)$this->_response->result;
                $exchangeRate->TradingDate = Carbon::now();
                $exchangeRate->save();
            }
        }
    }

    private function curl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api . $this->_params,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: " . $this->key
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $this->_response = json_decode($response);
    }

    private function setParams($target, $source)
    {
        $this->_params = '?to='. $target .'&from='. $source .'&amount=1';
    }
}
