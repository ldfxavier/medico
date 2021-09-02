<?php
	namespace Tdd\Model;
	use \Tdd\TDD;
	use \Helpers\{Mensagem};
	use \Model\Ceral_Contato as ContatoModel;
	
	final class Geral_Exemplo extends TDD {
		private $MODEL, $salvar, $atualizar, $id;
		public function  __construct(){
			$this->MODEL = new ContatoModel;
			$this->salvar = [
				'vinculo' => '2a3948c8-18fe-41f1-9773-c0b98d799662', 'nome' => 'Contato de teste',
				'telefone' => [
					[
						'tipo' => 1,
						'numero' => '(61) 98000-0000',
						'whatsapp' => 1
					],
					[
						'tipo' => 'Financeiro',
						'numero' => '(61) 0000-0000',
						'whatsapp' => 2
					]
				],
				'email' => [
					[
						'tipo' => 6,
						'email@teste.com'
					],
					[
						'tipo' => 7,
						'email_2@teste.com'
					]
				],
				'endereco' => [
					[
						'tipo' => 2,
						'endereco' => 'SIG QD 01 LOTE 386, Brasília/DF. CEP: 72302-208',
						'latitude' => 47.000,
						'longitude' => 14.000
					]
				]
			];
			$this->atualizar = [];
		}

		private function assert_salvar_contato(){
			$validar = $this->MODEL->salvar($this->salvar);
		}



		// =================== //
		// PADRÃO DA CLASS TDD //
		// =================== //
		public function validar(){
			foreach($this->pegar_teste(get_class_methods(__CLASS__)) as $metodo):
				$this->$metodo();
			endforeach;
			return $this->mensagem;
		}
	}