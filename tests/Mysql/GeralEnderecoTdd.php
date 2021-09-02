<?php
	namespace Tdd\Mysql;
	use \Tdd\TDD;
	
	final class Geral_Endereco extends TDD {
		public function __construct(){
			parent::__construct(TABELA['geral_endereco']);
		}

		public function validar(): Array {
			// tipo, tamanho, obrigatorio, validar, download, nome
			$this->validar_campo_tabela([
				'id' => ['int', 11, true, [], true, 'ID'],
				'uuid' => ['char', 36, true, [], true, 'Código'],
				'id_vinculo' => ['char', 36, true, [], true, 'Vínculo'],
				'local_usado' => ['int', 1, true, [], true, 'Local'],
				'nome_reponsavel' => ['varchar', 50, false, [], true, 'Nome do responsável'],
				'cep_endereco' => ['int', 8, false, [], true, 'CEP'],
				'logradouro_endereco' => ['varchar', 50, true, [], true, 'Logradouro'],
				'complemento_endereco' => ['varchar', 50, false, [], true, 'Complemento'],
				'referencia_endereco' => ['varchar', 50, false, [], true, 'Referência'],
				'numero_endereco' => ['int', 11, false, [], true, 'Número'],
				'bairro_endereco' => ['varchar', 50, false, [], true, 'Bairro'],
				'cidade_endereco' => ['varchar', 50, true, [], true, 'Cidade'],
				'estado_endereco' => ['char', 2, false, [], true, 'Estado'],
				'latitude_endereco' => ['float', 0, false, [], true, 'Latitude'],
				'longitude_endereco' => ['float', 0, false, [], true, 'Longitude'],
				'data_criacao' => ['datetime', 0, true, [], true, 'Data de criação'],
				'data_atualizacao' => ['datetime', 0, false, [], true, 'Data de atualização'],
				'endereco_principal' => ['int', 1, true, [], true, 'Endereço principal']
			]);
			return $this->mensagem;
		}
	}