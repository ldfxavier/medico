<?php

	/*
    |--------------------------------------------------------------------------
    | CONFIG LINK
    |--------------------------------------------------------------------------
	|
	| Gera os defines baseado no arquivo de configuração em config/link.php
	|
	*/

	function __config_link(){

		$config_link = require_once __ROOT.'/config/link.php';

		__gerar_define([
			'link_site' => $config_link['site'],
			'link_api' => $config_link['api'],
			'link_painel' => $config_link['painel'],
			'link_arquivo' => $config_link['arquivo']
		]);

	}
	__config_link();
