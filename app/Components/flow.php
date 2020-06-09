<?php

namespace App\Components;

use Log;
use Exception;
use Ixudra\Curl\Facades\Curl;


class Flow
{
    protected $apiKey;
    protected $secretKey;
    
    function __construct() {
        $this->apiKey = config('flow.api_key');
		$this->secretKey = config('flow.secret_key');
    }


    /**
	 * Servicio del Api de Flow
	 * @param string    $service -> Nombre del servicio a ser invocado
	 * @param array     $params  -> Datos a ser enviados
	 * @param string    $method  -> Metodo http a utilizar
	 * @return string JSON
	 * @throws Exception
	 */
    public function send($service, $params, $method = "GET")
    {
        $method = strtoupper($method);
        $url    = config('flow.api_url') . "/" . $service;
        $params = array("apiKey" => $this->apiKey) + $params;
        $params["s"] = $this->sign($params);

        if($method == "GET") {
			$response = $this->httpGet($url, $params);
		} else {
			$response = $this->httpPost($url, $params);
        }

        if(isset($response["info"])) {
			$code = $response["info"]["http_code"];
			if (!in_array($code, array("200", "400", "401"))) {
				throw new Exception("Unexpected error occurred. HTTP_CODE: " .$code , $code);
			}
        }
        
        $body = json_decode($response["output"], true);
        
		return $body;
    }

    /**
	 * Firma los parametros
	 * @param string    $params -> Parametros a firmar
	 * @return string   Firma
	 * @throws Exception
	 */
	private function sign($params) {

        $keys = array_keys($params);
        sort($keys);
        $toSign = "";

        foreach ($keys as $key) {
            $toSign .= $key . $params[$key];
        }

        if(!function_exists("hash_hmac")) {
            Log::channel('flowlog')->info('Function hash_hmac not exist');

            throw new Exception("Function hash_hmac not exist", 1);
        }
        return hash_hmac('sha256', $toSign , $this->secretKey);
    }
    
    /**
	 * Curl HTTP GET
	 * @param string    $url    ->  url a invocar
	 * @param array     $params -> Datos a enviar
	 * @return array    Resultado
	 * @throws Exception
	 */
    private function httpGet($url, $params) {

        $url = $url . "?" . http_build_query($params);

		$ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$output = curl_exec($ch);
        
        if($output === false) {
			$error = curl_error($ch);
			throw new Exception($error, 1);
		}
        
        $info = curl_getinfo($ch);
		        curl_close($ch);
        
        return array("output" =>$output, "info" => $info);
	}
	
	/**
	 * Curl HTTP POST
	 * @param string    $url    -> url a invocar
	 * @param array     $params -> los datos a enviar
	 * @return array    Resultado
	 * @throws Exception
	 */
    private function httpPost($url, $params ) {

		$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            $output = curl_exec($ch);

            if($output === false) {
                $error = curl_error($ch);
                throw new Exception($error, 1);
            }
            $info = curl_getinfo($ch);
            curl_close($ch);
        

        return array("output" =>$output, "info" => $info);
        
	}
}