<?php

	/*
    |--------------------------------------------------------------------------
    | CONFIG DATABASE
    |--------------------------------------------------------------------------
	|
	| Gera os defines baseado no arquivo de configuração em config/database.php
	|
	*/

	function __config_database(){
		$config_database = require_once __ROOT.'/config/database.php';

		__gerar_define([
			'db_host' => $config_database['host'],
			'db_banco' => $config_database['banco'],
			'db_usuario' => $config_database['usuario'],
			'db_senha' => $config_database['senha']
		]);
	}

	__config_database();