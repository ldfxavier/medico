<?php
	namespace Tdd\Mysql;
	use \Tdd\TDD;
	
	final class Admin_Auditoria extends TDD {
		public function __construct(){
			parent::__construct(TABELA['admin_auditoria']);
		}

		public function validar() {
			// tipo, tamanho, obrigatorio, validar, download, nome
			$this->validar_campo_tabela([
				'id' => ['int', 11, true, [], true, 'ID'],
				'uuid' => ['char', 36, true, [], true, 'Código'],
				'id_equipe' => ['int', 11, false, [], true, 'Id da equipe'],
				'id_usuario' => ['int', 11, false, [], true, 'Id do usuário'],
				'tabela_banco' => ['varchar', 30, true, [], true, 'Tabela'],
				'acao_crud' => ['varchar', 10, true, [], true, 'Ação'],
				'use_agent' => ['text', 0, false, [], true, 'Agent'],
				'ip_usuario' => ['varchar', 15, true, [], true, 'IP'],
				'data_criacao' => ['datetime', 0, true, [], true, 'Data de criação'],
				'dado_executado' => ['json', 0, true, [], true, 'Dados']
			]);
			return $this->mensagem;
		}
	}