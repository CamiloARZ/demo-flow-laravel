<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Acceso al API
    |--------------------------------------------------------------------------
    |
    | Production    = https://www.flow.cl/api
    | Sandbox       = https://sandbox.flow.cl/api
    |
    */

    'api_url' => env('FLOW_URL_PAGO', 'https://sandbox.flow.cl/api'),

    /*
    |--------------------------------------------------------------------------
    | Llave privada
    |--------------------------------------------------------------------------
    |
    | Ruta donde se aloja la nuestra llave privada.
    |
    */

    'keys' => base_path(''),

    /*
    |--------------------------------------------------------------------------
    | Api Key
    |--------------------------------------------------------------------------
    |
    | El Api Key corresponde al identificador único de seguridad para ser usado
    | en la integración de tu comercio con Flow.
    |
    */

    'api_key' => env('FLOW_API_KEY', null ),

     /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    |
    | El Secret Key corresponde a una clave de seguridad para asegurar que la 
    | información que se está trasmitiendo viene de una fuente confiable.
    |
    */
    'secret_key' => env('FLOW_SECRET_KEY', null ),

];
