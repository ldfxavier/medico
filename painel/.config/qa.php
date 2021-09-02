<?php
	/**
	 * CONFIGURAÇÃO GERAL DO HEADER
	**/
	$qa_header = array(
		'robots' => 'noindex, nofollow',
		'charset' => 'utf-8'
	);

	/**
	 * CONFIGURAÇÕES GERIAS DO SITE
	**/
	$qa_config = array(
		'erro' => true,
		'fuso' => 'America/Sao_Paulo',
		'https' => 'auto',
		'www' => 'auto',
		'emailsistema' => ''
	);

	/**
	 * LINKS DO SISTEMA
	**/
	$qa_link = array(
		'link' => array('localhost'),
		'painel' => '{{LINK}}/painel',
		'arquivo' => 'https://localhost:4002/public/arquivos',
		'diretorio' => '../public/arquivos',
		'template' => 'sinpefrs'
	);

	/**
	 * CONFIGURAÇÃO DO PDO
	**/
	$qa_pdo = array(
		'host' => 'mariadb',
        'banco' => 'parlamentum',
        'usuario' => 'root',
        'senha' => '123456'
	);

	/**
	 * APIs DO GOOGLE
	**/
	$qa_google = [
		'analytics' => true,
		'client_id' => '',
		'client_key' => ''
	];

	/**
	 * API DO FACEBOOK
	**/
	$qa_facebook = [
		'key' => ''
	];

	/**
	 * DADOS OPCIONAIS DO SISTEMA
	**/
	$qa_opcionais = [

	];
