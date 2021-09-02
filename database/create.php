<?php
	session_start();

	$humano = true;
	if(!isset($_SERVER['HTTP_HOST'])):
		$humano = false;
		$_SERVER['HTTP_HOST'] = 'localhost';
		$_SERVER['SCRIPT_NAME'] = '/database/index.php';
		$_SERVER['REQUEST_URI'] = '/database/';
		$_SERVER['REQUEST_METHOD'] = 'GET';
	endif;

	require_once __DIR__.'/../system/Function.php';
	require_once __DIR__.'/../system/config/sistema.php';
	require_once __DIR__.'/../system/Database.php';

	if(!isset($_SESSION['DATABASE_HASH_CREATE'])):
		$_SESSION['DATABASE_HASH_CREATE'] = uuid();
		$_SESSION['DATABASE_HASH_CREATE_ERRO'] = 1;
	endif;

	$hash = $_SESSION['DATABASE_HASH_CREATE'];
	$hash_erro = $_SESSION['DATABASE_HASH_CREATE_ERRO'];

	if($humano):
		
		$erro = '';

		$validar = isset($_POST['hash']) ? $_POST['hash'] : '';
		$login = isset($_POST['login']) ? $_POST['login'] : '';
		$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
		$aceito = isset($_POST['aceito']) ? $_POST['aceito'] : 2;

		if($hash_erro > 2):
			require_once __DIR__.'/../resources/views/database/bloqueado.php';
			exit();
		elseif(!empty($validar) && $validar != $hash):
			$erro = 'Erro ao validar!';
		elseif(!empty($validar) && $login != env('DB_USUARIO')):
			$erro = 'Digite um login válido.';
			$_SESSION['DATABASE_HASH_CREATE_ERRO']++;
		elseif(!empty($validar) && $senha != env('DB_SENHA')):
			$erro = 'Digite uma senha válida.';
			$_SESSION['DATABASE_HASH_CREATE_ERRO']++;
		elseif(!empty($validar) && $aceito != 1):
			$erro = 'Marque que você tem ciência que o banco será deletado.';
		endif;

		if(!empty($erro) || empty($login) || empty($senha) || empty($aceito) || empty($validar)):
			require_once __DIR__.'/../resources/views/database/login.php';
			exit();
		endif;

	endif;

	$erro_status = false;
	function erro($mensagem){
		$erro_status = true;
		trigger_error($mensagem);
		exit();
	}

	$lista = [];
	foreach(scandir(__DIR__) as $diretorio):
		if(is_dir(__DIR__.'/'.$diretorio) && !in_array($diretorio, ['.', '..']) && $diretorio[0] != '_'):
			$lista[] = $diretorio;
		endif;
	endforeach;
	sort($lista);

	if(!$lista):
		erro('Não existem base para subir');
	endif;

	function tratar_base($base){

		if(!is_array($base)):
			return [];
		endif;

		$array = [];
		foreach($base as $valor):
			if(strstr($valor, ',') || strstr($valor, ':')):
				$array[] = string_array($valor, 4);
			else:
				$array[] = $valor;
			endif;
		endforeach;

		return $array;

	}

	$Database = new \System\Database;

	foreach($lista as $tabela):
		if(file_exists($tabela.'/base.php')):

			$base = tratar_base(require_once $tabela.'/base.php');
			
			if($base):
				$Database->create($base, $tabela);
			else:
				erro('Ocorreu um erro na base do diretório: '.$tabela);
			endif;

		else:
			erro('Não existe base no diretório: '.$tabela);
		endif;

		if(file_exists($tabela.'/dado.php')):
			$lista = require_once $tabela.'/dado.php';
			
			if($lista):
				foreach($lista as $dado):
					$Database->insert($dado, $tabela);
				endforeach;
			endif;
		endif;
	endforeach;

	if($humano && $erro_status == false):
		require_once __DIR__.'/../resources/views/database/ok.php';
	endif;