<?php
	
	/*
    |--------------------------------------------------------------------------
    | CONFIG TABLE
    |--------------------------------------------------------------------------
	|
	| Faz a criação do define de tabelas baseado no arquivo de
	| configuração em config/table.php
	|
	*/

	function __config_table(){
		$config_table = require_once __ROOT.'/config/table.php';
		if($config_table):
			$array = [];
			foreach($config_table as $ind => $val):
				$array['tabela_'.$ind] = $val;
			endforeach;
			__gerar_define($array);
		endif;
	}
	__config_table();