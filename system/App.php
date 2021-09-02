<?php

	/*
    |--------------------------------------------------------------------------
    | CONFIGURA A SESSÃO
    |--------------------------------------------------------------------------
	|
	| Starta a session alterando o cache expire e o session name
	|
	*/
	ini_set('session.cookie_httponly', 1);
	session_start();

	require_once __DIR__.'/Function.php';

	require_once __DIR__.'/config/sistema.php';
	require_once __DIR__.'/config/config_session.php';
	require_once __DIR__.'/config/requisicao.php';
	require_once __DIR__.'/config/config_define.php';
	require_once __DIR__.'/config/config_app.php';
	require_once __DIR__.'/config/config_link.php';

	require_once __DIR__.'/config/ini.php';

	require_once __DIR__.'/config/config_database.php';
	require_once __DIR__.'/config/config_mail.php';
	require_once __DIR__.'/config/config_table.php';
	require_once __DIR__.'/config/git.php';
	require_once __DIR__.'/config/config_autoload.php';
	require_once __DIR__.'/config/config_include.php';

	require_once __DIR__.'/config/route.php';

	$app = new \System\System;
	$system = $app->run();

	if(is_object($system)):
		$system = (Array)$system;
	endif;

	if(
		isset($system['erro']) && false === $system['erro'] &&
		isset($system['template'])
	):
		if(isset($system['var']) && is_array($system['var']) && count($system['var']) > 0):
			extract($system['var'], EXTR_OVERWRITE);
		endif;

		if(!empty($system['template']['config'])):
			require_once $system['template']['config'];
		endif;
		if(!empty($system['template']['header'])):
			require_once $system['template']['header'];
		endif;
		if(!empty($system['template']['view'])):
			require_once $system['template']['view'];
		endif;
		if(!empty($system['template']['footer'])):
			require_once $system['template']['footer'];
		endif;
	elseif(
		isset($system['erro']) && false === $system['erro'] &&
		isset($system['acao']) && 'location' == $system['acao'] &&
		isset($system['link']) && !empty($system['link'])
	):
		http_response_code(307);
		header('LOCATION: '.$system['link']);
	elseif(
		isset($system['erro']) && false === $system['erro'] &&
		isset($system['acao']) && 'redirect' == $system['acao'] &&
		isset($system['link']) && !empty($system['link'])
	):
		http_response_code(308);
		header('LOCATION: '.$system['link']);
	elseif(
		isset($system['erro']) && false === $system['erro'] &&
		isset($system['acao']) && 'download' === $system['acao'] &&
		isset($system['extensao']) && !empty($system['extensao']) &&
		isset($system['link']) && !empty($system['link']) &&
		isset($system['nome']) && !empty($system['nome'])
	):
		$arquivo = pathinfo($system['link']);
		$ext_temp = explode('.', $arquivo['basename']);
		$ext = count($ext_temp) > 1 ? end($ext_temp) : 'erro';

		$extensao = $system['extensao'];

		if(!in_array($ext, $extensao)):
			http_response_code(404);
			require_once __VIEWS.'/status/arquivo.php';
		else:
			header('Content-Description: File Transfer');
			header('Content-Disposition: attachment; filename="'.$system['nome'].'.'.$ext.'"');
			header('Content-Type: application/octet-stream');
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Expires: 0');
			readfile($system['link']);
		endif;
	elseif(
		isset($system['erro']) && false === $system['erro'] &&
		isset($system['acao']) && 'status_html' == $system['acao'] &&
		isset($system['codigo'])
	):

		http_response_code($system['codigo']);

		$__metodo_usado = __ROUTE_USO['metodo'] ?? 'VIEW';
		$__header = getallheaders();
		$__content_type = $_SERVER['HTTP_CONTENT_TYPE'] ?? $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_ACCEPT'] ?? $_SERVER['ACCEPT'] ?? $__header['Content-type'] ?? $__header['Content-Type'] ?? $__header['content-type'] ?? $__header['Accept'] ?? $__header['accept'] ?? false;
		$__content_type = explode(',', $__content_type)[0] ?? false;

		$json_get = ((__METODO == 'GET' && $__content_type == 'application/json') || __METODO != 'GET');

		if($__metodo_usado == 'VIEW' && __METODO == 'GET' && $__content_type != 'application/json'):
			require_once __VIEWS.'/status/'.$system['codigo'].'.php';
		elseif(true === $json_get && in_array($system['codigo'], [401, 403])):
			echo json_encode(['erro' => true, 'titulo' => 'Erro de permissão!', 'texto' => 'Você não tem permissão para acessar essa rota.']);
		elseif(true === $json_get && $system['codigo'] == 400):
			echo json_encode(['erro' => true, 'titulo' => 'Erro de requisição!', 'texto' => 'Foi enviado uma requisição ruim (Bad Request), verifique os dados enviado e tente novamente.']);
		elseif(true === $json_get && $system['codigo'] == 404):
			echo json_encode(['erro' => true, 'titulo' => 'Página não existe!', 'texto' => 'Essa página não existe ou foi movida para outra URL.']);
		elseif(true === $json_get && $system['codigo'] >= 500):
			echo json_encode(['erro' => true, 'titulo' => 'Erro interno!', 'texto' => 'Ocorreu um erro interno, por favor, tente novamente.']);
		endif;

	elseif(is_array($system)):

		if(isset($system['status_html'])):

			http_response_code($system['status_html']);
			unset($system['status_html']);

		endif;

		$__header = getallheaders();
		
		$__content_type = $_SERVER['HTTP_CONTENT_TYPE'] ?? $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_ACCEPT'] ?? $_SERVER['ACCEPT'] ?? $__header['Content-type'] ?? $__header['Content-Type'] ?? $__header['content-type'] ?? $__header['Accept'] ?? $__header['accept'] ?? false;
		$__content_type = explode(',', $__content_type)[0] ?? false;

		if(($__content_type == 'application/json' || isset(__GET['ajax'])) || in_array(__METODO, ['POST', 'PUT', 'DELETE'])):

			header('Content-type: application/json');

			echo json_encode($system, JSON_PARTIAL_OUTPUT_ON_ERROR);

		else:

			echo '<!-- '.json_encode($system, JSON_PARTIAL_OUTPUT_ON_ERROR).'-->';

			$codigo = $system['codigo'] ?? 404;

			if(file_exists(__VIEWS.'/status/'.$codigo.'.php')):
				require_once __VIEWS.'/status/'.$codigo.'.php';
			else:
				require_once __VIEWS.'/status/404.php';
			endif;

		endif;

	elseif(is_string($system) || is_numeric($system) || is_bool($system)):

		echo $system;

	endif;

	require_once __DIR__.'/config/api_log.php';
