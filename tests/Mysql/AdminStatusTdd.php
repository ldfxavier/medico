<?php
	namespace Tdd\Mysql;
	use \Tdd\TDD;
	
	final class Admin_Status extends TDD {
		public function __construct(){
			parent::__construct(TABELA['admin_status']);
		}

		public function validar(): Array {
			// tipo, tamanho, obrigatorio, validar, download, nome
			$this->validar_campo_tabela([
				'id' => ['int', 11, true, [], true, 'ID'],
				'uuid' => ['char', 36, true, [], true, 'Código'],
				'tabela_banco' => ['varchar', 30, true, [], true, 'Tabela'],
				'coluna_tabela' => ['varchar', 30, true, [], true, 'Coluna da tabela'],
				'valor_interno' => ['int', 3, true, [], true, 'Valor'],
				'valor_publico' => ['varchar', 50, true, [], true, 'Título'],
				'cor_publica' => ['char', 7, true, [], true, 'Cor'],
				'data_criacao' => ['datetime', 0, true, [], true, 'Data de criação'],
				'data_atualizacao' => ['datetime', 0, false, [], true, 'Data de atualização'],
				'ordem_registro' => ['int', 3, false, [], true, 'Ordem']
			]);
			return $this->mensagem;
		}
	}