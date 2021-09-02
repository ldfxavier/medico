<?php
	session_start();

	ini_set('display_errors', 1);
	ini_set('display_startup_erros', 1);
	error_reporting(E_ALL);

	include('system/Function.php');

	// Carrega todas as classes e models
	spl_autoload_register(function($file){
		if(file_exists(MODELS . $file . ".php")) require_once(MODELS . $file . ".php");
		else if(file_exists(HELPERS . $file . ".php")) require_once(HELPERS . $file . ".php");
		else if(file_exists(HELPERS .'sistema/'. $file . ".php")) require_once(HELPERS .'sistema/'. $file . ".php");
	});

	// Inclui as paginas de configuração do sistema
	require_once(".config/config.php");
	$config = new config();

	// Define as pastas padrões do sistema
	define('CONTROLLERS', 'app/controllers/');
	define('VIEWS', 'app/views/');
	define('MODELS', 'app/models/');
	define('TEMPLETES', 'app/templates/');
	define('HELPERS', 'system/helpers/');

	// Seta o fuso horário do sistema se ele foi passado
	if(!empty($config->getConfig()->fuso)) date_default_timezone_set($config->getConfig()->fuso);

	// Abilita o erro do PHP se estiver marcado como true
	if(!$config->getConfig()->erro):
		ini_set('display_errors', 0);
		ini_set('display_startup_erros', 0);
		error_reporting(E_NOTICE);
	endif;

	// Verifica se a versão (WWWW) está correta, se não, redireciona
	if($config->getConfig()->www === true && !strstr(LINK, 'www.')):
		header('LOCATION: '.str_replace('://', '://www.', LINK));
	elseif($config->getConfig()->www === false && strstr(LINK, 'www.')):
		header('LOCATION: '.str_replace('://www.', '://', LINK));
	endif;

	require_once("system/system.php");
	require_once("system/controller.php");
	require_once("system/model.php");
	require_once("system/config.php");

	$start = new System;
	$start->run();
