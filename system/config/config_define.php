<?php

	/*
    |--------------------------------------------------------------------------
    | DEFINES PADRÕES
    |--------------------------------------------------------------------------
	|
	| Defines com os dados padrões do framework
    |
	*/

	define('__CONTROLLERS', __ROOT.'/app/Controllers');
	define('__MODELS', __ROOT.'/app/Models');
	define('__HELPERS', __ROOT.'/app/Helpers');
	define('__MIDDLEWARES', __ROOT.'/app/Middlewares');
	define('__CONFIG', __ROOT.'/config');
	define('__FILES', __ROOT.'/files');
	define('__DATABASE', __ROOT.'/database');
	define('__VIEWS', __ROOT.'/resources/views');
	define('__TEMPLETES', __ROOT.'/resources/templates');
	define('__PUBLIC', __ROOT.'/public');
	define('__ROUTE', __ROOT.'/routes');
	define('__SYSTEM', __ROOT.'/system');
	define('__TEST', __ROOT.'/test');
	if(!isset($_SESSION['HASH'])):
		$_SESSION['HASH'] = hash_md5();
	endif;
	define('HASH', $_SESSION['HASH']);

	/*
    |--------------------------------------------------------------------------
    | FUNÇÃO DEFINE
    |--------------------------------------------------------------------------
	|
	| Função para criar defines baseada em um array
	|
	*/

	function __gerar_define($array){

		foreach($array as $ind => $val):
			$ind = mb_strtoupper($ind, 'UTF-8');
			define($ind, str_replace('{{LINK}}', $_SESSION['__LINK'], env($ind, $val)));
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
	function __config_define(){
		$config_define = include __ROOT.'/config/define.php';
		if($config_define):
			__gerar_define($config_define);
		endif;
	}
	__config_define();