<?php

namespace App\Http\Controllers;

use Flow;

use Log;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class FlowController extends Controller
{
    
    public function index()
    {
        // Log::channel('flowlog')->info('Hello world!!');

        return view('home');
    }

    public function order(Request $request)
    {
        
        $optional = array(
            "rut" => "9999999-9",
            "otroDato" => "otroDato"
        );

        $optional = json_encode($optional);
        
        $params = array(
            "commerceOrder" => rand(1100,2000),
            "subject" => "Pago de prueba",
            "currency" => "CLP",
            "amount" => 5000,
            "email" => "cliente@gmail.com",
            "paymentMethod" => 9,
            "urlConfirmation" => route('flow.success'),
            "urlReturn" => route('flow.success'),
            "optional" => $optional
        );

        $serviceName = "payment/create";

        try {

            $response = Flow::send($serviceName, $params, "POST");

            $redirect = $response["url"] . "?token=" . $response["token"];

            return redirect()->away($redirect);

        } catch (Exception $error) {
            return back()->withErrors($error)->withInput();
        }
        
    }


    public function success(Request $request)
    {
        $params = array(
            "token" => $request->token
        );

        $serviceName = "payment/getStatus";

        $response = Flow::send($serviceName, $params, "get");

        dd($response);
    }

    public function error()
    {
        dd('error');
    }

    public function confirmation()
    {
        dd('');
    }

    
}
