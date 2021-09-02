<?php

	$Usuario = new UsuarioModel;
	$Painel = new PainelModel;

	$cod = (isset($_post['cod']) && !empty($_post['cod'])) ? $_post['cod'] : '';

	$dados['dependente'] = (isset($_post['dependente']) && !empty($_post['dependente'])) ? $_post['dependente'] : '';
	$usuario = $Usuario->cod($cod);
	
	$id = $usuario->id;

	if($_POST['acao'] == 'add'):

		$Painel->p_update("usuario_usuario", ['filiacao_dependente' => json_encode($dados['dependente'])], "`id` = {$id}");

	elseif($_POST['acao'] == 'editar'):
		
		$Painel->p_update("usuario_usuario", ['filiacao_dependente' => json_encode($dados['dependente'])], "`id` = {$id}");
	endif;



	echo json_encode(['erro' => false]);