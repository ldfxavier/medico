<?php

	/*
    |--------------------------------------------------------------------------
    | CONFIG INCLUDE
    |--------------------------------------------------------------------------
	|
	| Faz includes baseado no arquivo de configuração em config/include.php
	|
	*/

	function __config_include(){
		$config_include = require_once __ROOT.'/config/include.php';

		if($config_include):
			foreach($config_include as $include):
				if(file_exists(__ROOT.'/resources/php/'.$include.'.php')):
					require_once __ROOT.'/resources/php/'.$include.'.php';
				endif;
			endforeach;
		endif;
	}
	__config_include();