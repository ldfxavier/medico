<?php
	return [

		/* APP */
		'app' => [
			'header' => [
				'titulo' => 'USUÁRIO'
			],
			'botao' => [
				'add' => true,
				'relatorio' => true,
				'download' => true,
				'deletar' => true
			]
		],

		/* ADD */
		'add' => [
			'header' => [
				'titulo' => 'ADD',
				'subtitulo' => [
					LINK_PAINEL.'/app/'.$app => 'USUÁRIO',
					LINK_PAINEL.'/app/teste/'.$app => 'teste',
				],
				'voltar' => LINK_PAINEL.'/app/'.$app
			]
		]

	];
