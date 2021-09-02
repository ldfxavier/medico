<?php

	/*
    |--------------------------------------------------------------------------
    | CONFIGURA INI
    |--------------------------------------------------------------------------
	|
	| Seta as configurações do sistema baseado no arquivo de
	| configuração em config/app.php
	|
	*/

	ini_set('expose_php', 0);
	ini_set('allow_url_fopen', 0);
	ini_set('register_globals', 0);

	if(!empty(TIMEZONE)):
		date_default_timezone_set(TIMEZONE);
	endif;

	if(!DEBUG):
		ini_set('display_errors', 0);
		ini_set('display_startup_erros', 0);
		error_reporting(E_NOTICE);
	else:
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);
	endif;