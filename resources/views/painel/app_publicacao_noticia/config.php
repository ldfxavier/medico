<?php
	return [

		/* APP */
		'app' => [
			'header' => [
				'titulo' => 'NOTÍCIAS'
			],
			'lista' => [
				'selecao' => true,
				'id' => [
					'titulo' => '#ID',
					'order' => true,
					'tipo' => 'id'
				],
				'titulo' => [
					'titulo' => 'TÍTULO',
					'order' => true,
					'flex' => true,
					'campo' => 'titulo_chamada'
				],
				'data' => [
					'titulo' => 'POSTADA',
					'order' => true,
					'centralizar' => true,
					'tamanho' => 180,
					'campo' => 'data_postagem_inicio'
				],
				'banner' => [
					'titulo' => 'BANNER PRINCIPAL',
					'order' => true,
					'tipo' => 'status',
					'campo' => 'banner_principal'
				],
				'status' => [
					'titulo' => 'STATUS',
					'order' => true,
					'tipo' => 'status'
				]
			],
			'buscar' => [
				'pesquisa' => 'Pesquisa',
			],
			'order' => ['id', 'DESC'],
			'responsivo' => [
				1000 => ['id', 'titulo', 'status'],
				600 => ['titulo', 'status']
			]
		],

		/* ADD */
		'add' => [
			'header' => [
				'titulo' => 'ADD',
				'subtitulo' => [
					LINK_PAINEL.'/app/'.$app => 'USUÁRIO'
				],
				'voltar' => LINK_PAINEL.'/app/'.$app
			]
		]

	];
