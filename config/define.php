<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DEFINES DO SISTEMA
    |--------------------------------------------------------------------------
    |
    | Cria uma define para cada indice da lista abaixo
    |
     */
    'recaptcha_site' => env('RECAPTCHA_SITE', ''),
    'recaptcha_secret' => env('RECAPTCHA_SECRET', ''),
    'client_id' => env('CLIENT_ID', ''),
    'secret_id' => env('SECRET_ID', ''),
    'template' => env('APP_TEMPLATE', 'padrao'),
    'arquivo' => env('LINK_ARQUIVO', ''),
    'diretorio' => '/public/arquivos',

];
