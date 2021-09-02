<?php
	namespace Tdd\Mysql;
	use \Tdd\TDD;
	
	final class Geral_Contato extends TDD {
		public function __construct(){
			parent::__construct(TABELA['geral_contato']);
		}

		public function validar(): Array {
			// tipo, tamanho, obrigatorio, validar, download, nome
			$this->validar_campo_tabela([
				'id' => ['int', 11, true, [], true, 'ID'],
				'uuid' => ['char', 36, true, [], true, 'Código'],
				'id_vinculo' => ['char', 36, true, [], true, 'Vínculo'],
				'nome_contato' => ['varchar', 50, false, [], true, 'Nome'],
				'telefone_lista' => ['json', 0, false, [], true, 'Telefone'],
				'email_lista' => ['json', 0, false, [], true, 'E-mail'],
				'endereco_lista' => ['json', 0, false, [], true, 'Endereço'],
				'data_criacao' => ['datetime', 0, true, [], true, 'Data de criação'],
				'data_atualizacao' => ['datetime', 0, false, [], true, 'Data de atualização']
			]);
			return $this->mensagem;
		}
	}