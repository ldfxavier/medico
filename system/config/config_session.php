<?php

	/*
    |--------------------------------------------------------------------------
    | FUNÇÃO SESSION
    |--------------------------------------------------------------------------
	|
	| Função para criar sessions baseada em um array
	|
	*/

	function __gerar_session($array){
		foreach($array as $ind => $val):
			$_SESSION[mb_strtoupper($ind, 'UTF-8')] = str_replace('{{LINK}}', $_SESSION['__LINK'], $val);
		endforeach;
	}

	/*
    |--------------------------------------------------------------------------
    | CARREGA DEFINES DO USUÁRIO
    |--------------------------------------------------------------------------
	|
	| Cria os defines com os dados passados pelo usuário no
	| arquivo config/define.php
	|
	*/
	function __config_session($session){
		if($session['lista']):
			__gerar_session($session['lista']);
		endif;
	}
	
	$__config_session = include __ROOT.'/config/session.php';
	__config_session($__config_session);