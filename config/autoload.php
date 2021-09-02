<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ALIAS DO AUTO LOAD
    |--------------------------------------------------------------------------
    |
    | Cria alias para os namespace das classes
    |
     */

    'alias' => [
        'App/Marktclub' => 'app/Classes/Marktclub',
        'System/' => 'system/',
        'Routes/' => 'routes/',
        'App/' => 'app/',
        'api' => 'Api',
        'site' => 'Site',
        'painel' => 'Painel',
        'Firebase' => 'app/Classes/Firebase/JWT',
    ],

    /*
    |--------------------------------------------------------------------------
    | COMPLEMENTO DO AUTO LOAD
    |--------------------------------------------------------------------------
    |
    | Coloca um sufixo no final da class quando ela estiver no
    | namespace passado
    |
     */

    'complemento' => [
        'App/Controllers' => 'Controller',
        'App/Models' => 'Model',
        'Routes' => 'Route',
        'App/Helpers' => 'Helper',
        'App/Middlewares' => 'Middleware',
    ],

];
