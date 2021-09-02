<?php
	
	/*
    |--------------------------------------------------------------------------
    | CONFIG APP
    |--------------------------------------------------------------------------
	|
	| Gera os defines baseado no arquivo de configuração em config/app.php
	|
	*/

	function __config_app(){
		$config_app = require_once __ROOT.'/config/app.php';

		$cache = SISTEMA == 'producao' ? $config_app['cache'] : hash_md5();

		__gerar_define([
			'titulo' => $config_app['titulo'],
			'descricao' => $config_app['descricao'],
			'versao' => $config_app['versao'],
			'charset' => $config_app['charset'],
			'cache' => $cache,
			'logo' => $config_app['logo'],
			'debug' => $config_app['debug'] == 'true' ? true : false,
			'timezone' => $config_app['timezone']
		]);
	}
	__config_app();

	