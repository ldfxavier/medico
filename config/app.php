<?php

return [
	/*
    |--------------------------------------------------------------------------
    | TITULO DO APP
    |--------------------------------------------------------------------------
    |
    | Esse será o nome do aplicativo, ele será usado sempre que
    | precisar usar o nome em uma notificação ou seja
    | chamado a constante TITULO
    |
	*/

	'titulo' => env('APP_TITULO', 'Framework X'),

	/*
    |--------------------------------------------------------------------------
    | DESCRIÇÃO DO APP
    |--------------------------------------------------------------------------
    |
    | Esse será a descrição do aplicativo, ele será usado sempre que
    | precisar usar a descrição em uma notificação ou seja
    | chamado a constante DESCRICAO
    |
	*/

	'descricao' => env('APP_DESCRICAO', 'App criado com o Framework X'),

	/*
    |--------------------------------------------------------------------------
    | VERSÃO DO APP
    |--------------------------------------------------------------------------
    |
    | Esse será a versão do aplicativo, ele será usado sempre que
    | precisar usar a versão em algum lugar do APP ou seja
    | chamado a constante VERSAO
    |
	*/

	'logo' => env('APP_LOGO', ''),

	/*
    |--------------------------------------------------------------------------
    | VERSÃO DO APP
    |--------------------------------------------------------------------------
    |
    | Esse será a versão do aplicativo, ele será usado sempre que
    | precisar usar a versão em algum lugar do APP ou seja
    | chamado a constante VERSAO
    |
	*/

	'versao' => env('APP_VERSAO', '1.0.0'),

	/*
    |--------------------------------------------------------------------------
    | URL DO APP
    |--------------------------------------------------------------------------
    |
    | Esse será a URL do aplicativo, ele será usado para definir
    | se o app está em produção, homologação ou localhost
    |
	*/

	'url' => env('APP_URL', 'localhost'),

	/*
    |--------------------------------------------------------------------------
    | CHARSET DO APP
    |--------------------------------------------------------------------------
    |
	| Esse será o charset do aplicativo, ele poderá ser chamada atraves
	| da constante CHARSET
    |
	*/

	'charset' => env('APP_CHARSET', 'utf-8'),

	/*
    |--------------------------------------------------------------------------
    | DEBUG DO APP
    |--------------------------------------------------------------------------
    |
	| O DEBUG libera o ou não do display_error do PHP, passar true
	| para liberar ou false para bloquear
    |
	*/

	'debug' => env('APP_DEBUG', false),

	/*
    |--------------------------------------------------------------------------
    | TIMEZONE DO APP
    |--------------------------------------------------------------------------
    |
	| O DEBUG libera o ou não do display_error do PHP, passar true
	| para liberar ou false para bloquear
    |
	*/

	'timezone' => env('APP_TIMEZONE', 'America/Sao_Paulo'),

	/*
    |--------------------------------------------------------------------------
    | CONTROLLER PRINCIPAL DO APP
    |--------------------------------------------------------------------------
    |
	| Determina qual diretório principal no app/Controllers/
    |
	*/

	'controller' => env('APP_CONTROLLER', 'site'),

	/*
    |--------------------------------------------------------------------------
    | CACHE DO SISTEMA
    |--------------------------------------------------------------------------
    |
	| Pega o cache do sistema
    |
	*/

	'cache' => env('APP_CACHE', md5(uniqid(time()))),

];