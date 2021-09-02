<?php
	namespace Tdd\Mysql;
	use \Tdd\TDD;
	
	final class Geral_Exemplo extends TDD {
		public function __construct(){
			parent::__construct(TABELA['geral_exemplo']);
		}

		public function validar(): Array {
			// tipo, tamanho, obrigatorio, validar, download, nome
			$this->validar_campo_tabela([
				'id' => ['int', 11, true, [], true, 'ID'],
				'uuid' => ['char', 36, true, [], true, 'Código'],
				'nome_contato' => ['varchar', 50, true, [], true, 'Nome'],
				'telefone_contato' => ['bigint', 11, true, ['telefone'], true, 'Telefone'],
				'email_contato' => ['varchar', 70, true, ['email'], true, 'E-mail'],
				'cpf_contato' => ['bigint', 11, true, ['cpf'], true, 'CPF'],
				'permissao_contato' => ['json', 0, true, [], true, 'Permissão'],
				'data_criacao' => ['datetime', 0, true, [], true, 'Data de criação'],
				'data_atualizacao' => ['datetime', 0, false, [], true, 'Data de atualização'],
				'status' => ['int', 2, true, [], true, 'Status']
			]);
			return $this->mensagem;
		}
	}