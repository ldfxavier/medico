<?php
	// Título
	$titulo = 'STATUS';
	// Lista
	$lista = [
		'id' => [
			'titulo' => '#ID',
			'ordem' => 'id',
			'campo' => ['id']
		],
		'tabela' => [
			'titulo' => 'TABELA',
			'ordem' => 'tabela',
			'campo' => ['tabela']
		],
		'campo' => [
			'titulo' => 'CAMPO',
			'ordem' => 'campo',
			'campo' => ['campo']
		],
		'nome' => [
			'titulo' => 'NOME',
			'ordem' => 'nome',
			'campo' => ['nome']
		],
		'valor' => [
			'titulo' => 'VALOR',
			'ordem' => 'valor',
			'campo' => ['valor']
		],
		'cor' => [
			'titulo' => 'COR',
			'tipo' => 'cor',
			'ordem' => 'cor',
			'campo' => ['cor']
		],
		'ordem' => [
			'titulo' => 'ORDEM',
			'ordem' => 'ordem',
			'campo' => ['ordem']
		],
	];

	// Botões
	$permissao = [
		'add' => true,
		'add_ajax' => true,
		'visualizar_ajax' => true,
		'relatorio' => false,
		'download' => true,
		'historico' => true,
		'deletar' => true,
		'selecao' => true,
		'imprimir' => true,
		'busca' => true
	];

	// CRUD
	$registro = 50;
	$order = !empty($_order) ? $_order : '`id` DESC';
	$where = $_where;

	$busca = !empty($where) ? true : false;

	Painel::index_normal($_app, $titulo, $lista, $permissao, $registro, $where, $order, $_pagina, $busca);
?>
