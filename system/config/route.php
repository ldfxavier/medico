<?php
	require_once __SYSTEM.'/Route.php';

	function __route(){
		$__url = isset($_SERVER['PATH_INFO']) ? str_replace('/url=', '', $_SERVER['PATH_INFO']) : '';

		$__explode_padrao = explode('/', $__url);
		if(end($__explode_padrao) == null):
			array_pop($__explode_padrao);
		endif;

		$__explode = $__explode_padrao;
		if((count($__explode) == 1 && empty($__explode[0])) || count($__explode) == 0):
			$__explode = ['index', 'index'];
		elseif(count($__explode) == 1):
			$__explode[] = 'index';
		endif;

		$__rota_principal = env('ROTA_PRINCIPAL');
		$__rota_diretorio = $__rota_principal;
		if(empty($__rota_diretorio)):
			$__rota_diretorio = 'site';
		endif;

		$__controller = $__explode[0];
		$__action = $__explode[1];

		$__expressao_diretorio = '/^'.preg_replace("/[^A-Za-z]/", "", $__controller).'$/i';
		if(preg_grep($__expressao_diretorio, array_diff(scandir(__CONTROLLERS), ['..', '.', $__rota_diretorio]))):
			unset($__explode[0]);
			unset($__explode_padrao[0]);
			$__rota_diretorio = $__controller;
			$__controller = $__action;
			$__action = isset($__explode[2]) && !empty($__explode[2]) ? $__explode[2] : 'index';
		endif;

		if(strstr($__controller, '&')):
			$__controller = explode('&', $__controller)[0];
			$__action = 'index';
		elseif(strstr($__action, '&')):
			$__action = explode('&', $__action)[0];
		endif;

		define('__URL_EXPLODE', array_values($__explode_padrao));
		define('__ROUTE_DIRETORIO', $__rota_diretorio);
		define('__ROUTE_CONTROLLER', $__controller);
		define('__ROUTE_ACTION', $__action);

	}
	__route();

	Route::diretorio(__ROUTE_DIRETORIO);
	require_once __ROOT.'/routes/'.__ROUTE_DIRETORIO.'Route.php';

	if(__ROUTE_DIRETORIO == env('ROTA_PRINCIPAL')):
		define('LINK', $_SESSION['__LINK']);
	else:
		define('LINK', $_SESSION['__LINK'].'/'.__ROUTE_DIRETORIO);
	endif;

	define('LINK_PADRAO', $_SESSION['__LINK']);

	unset($_SESSION['__LINK']);

	define('__ROUTE_USO', Route::pegar_rota(__METODO, __ROUTE_CONTROLLER, __ROUTE_ACTION));