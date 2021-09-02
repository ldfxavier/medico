<?php
	namespace Tdd\Model;
	use \Tdd\TDD;
	use \Helpers\{Curl, Mensagem};
	
	final class Geral_Exemplo extends TDD {
		private $curl, $salvar, $atualizar, $id;
		public function  __construct(){
			$this->curl = new Curl(LINK.'/exemplos');
			$this->salvar = ['nome' => 'Nome de teste', 'telefone' => '61900000000', 'email' => 'ola@mundo.com', 'cpf' => 71845128125, 'permissao' => json_encode([1,2,3]), 'status' => 1];
			$this->atualizar = ['nome' => 'Nome de teste 2', 'telefone' => '61900000002', 'email' => 'ola@mundo2.com', 'cpf' => 76484544166, 'permissao' => json_encode([1,2,3,4]), 'status' => 2];
		}

		private function assert_salvou_o_exemplo(){
			$validar = $this->curl->dado($this->salvar)->post('/salvar');
			$this->id = (Int)$validar['id'] ?? NULL;
			
			$this->assert_bool(
				__FUNCTION__,
				$validar['erro'] ?? true,
				false,
				$validar
			);
		}
		private function assert_nao_validou_o_cpf_ao_cadastrar(){
			$validar = $this->curl->dado($this->salvar)->dado(['cpf' => 2341271774])->post('/salvar');
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				916,
				$validar
			);
		}
		private function assert_nao_validou_o_telefone_ao_cadastrar(){
			$validar = $this->curl->dado($this->salvar)->dado(['telefone' => 6198177773])->post('/salvar');
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				908,
				$validar
			);
		}
		private function assert_nao_validou_o_email_ao_cadastrar(){
			$validar = $this->curl->dado($this->salvar)->dado(['email' => 'andre@andre.'])->post('/salvar');
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				909,
				$validar
			);
		}
		private function assert_nao_validou_o_permissao_ao_cadastrar(){
			$validar = $this->curl->dado($this->salvar)->dado(['permissao' => '123'])->post('/salvar');
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				910,
				$validar
			);
		}

		private function assert_atualizou_o_exemplo(){
			$validar = $this->curl->dado($this->atualizar)->put('/atualizar/'.$this->id);
			$this->assert_bool(
				__FUNCTION__,
				$validar['erro'] ?? true,
				false,
				$validar
			);
		}
		private function assert_id_da_atualizacao_nao_e_um_numero_inteiro(){
			$validar = $this->curl->dado($this->atualizar)->put('/atualizar/a');
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				901,
				$validar
			);
		}
		private function assert_nao_validou_o_cpf_ao_atualizar(){
			$validar = $this->curl->dado($this->atualizar)->dado(['cpf' => 2341271774])->put('/atualizar/'.$this->id);
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				916,
				$validar
			);
		}
		private function assert_nao_validou_o_telefone_ao_atualizar(){
			$validar = $this->curl->dado($this->atualizar)->dado(['telefone' => 6198177773])->put('/atualizar/'.$this->id);
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				908,
				$validar
			);
		}
		private function assert_nao_validou_o_email_ao_atualizar(){
			$validar = $this->curl->dado($this->atualizar)->dado(['email' => 'andre@andre.'])->put('/atualizar/'.$this->id);
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				909,
				$validar
			);
		}
		private function assert_nao_validou_o_permissao_ao_atualizar(){
			$validar = $this->curl->dado($this->atualizar)->dado(['permissao' => '123'])->put('/atualizar/'.$this->id);
			$this->assert_int(
				__FUNCTION__,
				$validar['codigo'] ?? 0,
				910,
				$validar
			);
		}

		private function assert_buscar_exemplo_com_sucesso(){
			$validar = $this->curl->dado(['id' => $this->id])->get('/buscar');
			$this->assert_int(
				__FUNCTION__,
				$validar['lista'][0]['id'] ?? false,
				$this->id,
				$validar
			);
		}

		private function assert_buscar_exemplo_sem_sucesso(){
			$validar = $this->curl->dado(['id' => -1])->get('/buscar');
			$this->assert_array(
				__FUNCTION__,
				$validar['lista'] ?? false,
				[],
				$validar
			);
		}

		private function assert_exemplo_deletado_com_sucesso(){
			$validar = $this->curl->delete('/deletar/'.$this->id);
			$this->assert_bool(
				__FUNCTION__,
				$validar['erro'] ?? true,
				false,
				$validar
			);
		}

		private function assert_exemplo_ja_foi_deletado(){
			$validar = $this->curl->delete('/deletar/'.$this->id);
			$this->assert_string(
				__FUNCTION__,
				$validar['texto'] ?? '',
				'O registro não existe ou foi deletado.',
				$validar
			);
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