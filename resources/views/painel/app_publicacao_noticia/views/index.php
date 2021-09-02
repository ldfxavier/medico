<?php

	(new \System\Painel([
		'acao' => 'app_padrao',
		'app' => $app,
		'config' => $config,
		'where' => $where
	]))->app();


?>