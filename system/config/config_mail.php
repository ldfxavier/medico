<?php

/*
    |--------------------------------------------------------------------------
    | CONFIG MAIL
    |--------------------------------------------------------------------------
	|
	| Gera os defines baseado no arquivo de configuração em config/app.php
	|
	*/

	function __config_mail(){
		$config_mail = require_once __ROOT.'/config/mail.php';

		__gerar_define([
			'mail_host' => $config_mail['mail_host'],
			'mail_porta' => $config_mail['mail_porta'],
			'mail_envio' => $config_mail['mail_envio'],
			'mail_resposta' => $config_mail['mail_resposta'],
			'mail_usuario' => $config_mail['mail_usuario'],
			'mail_senha' => $config_mail['mail_senha'],
			'mail_debug' => $config_mail['mail_debug'] == 'true' ? 1 : false,
			'mail_sistema' => $config_mail['mail_sistema']
		]);
	}

	__config_mail();