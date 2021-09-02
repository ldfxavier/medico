<?php
	class EnderecoModel extends Model {

		public $_tabela = "geral_endereco";

		private function montar($dados){
			$array = array();
			if($dados):
				foreach($dados as $r):
					$completo = $r->logradouro;
					if(!empty($r->numero)) $completo .= ', '.$r->numero;
					if(!empty($r->complemento)) $completo .= ', '.$r->complemento;
					if(!empty($r->referencia)) $completo .= ', '.$r->referencia;
					if(!empty($r->bairro)) $completo .= ' - '.$r->bairro;
					if(!empty($r->cidade)) $completo .= ', '.$r->cidade.'/'.$r->estado;
					$array[] = (object)array(
						'id' => $r->id,
						'cod' => $r->cod,
						'nome' => $r->nome,
						'cep' => (object)array(
							'br' => Converter::cep($r->cep),
							'valor' => $r->cep
						),
						'completo' => $completo,
						'logradouro' => $r->logradouro,
						'numero' => $r->numero,
						'complemento' => $r->complemento,
						'referencia' => $r->referencia,
						'bairro' => $r->bairro,
						'cidade' => $r->cidade,
						'estado' => $r->estado,
						'mapa' => (object)array(
							'latitude' => $r->latitude,
							'longitude' => $r->longitude,
						),
						'principal' => $r->principal
					);
				endforeach;
			endif;
			return $array;
		}

		public function lista($cod, $tabela, $local = 1){
			return $this->montar($this->read("`cod` = '{$cod}' AND `tabela` = '{$tabela}' AND `local` = '{$local}'"));
		}

		public function id($id){
			$dado = $this->montar($this->read("`id` = '{$id}'"));
			if($dado) return $dado[0];
		}

		public function salvar($dados){
			if(isset($dados['id'])) unset($dados['id']);
			$dados['tabela'] = str_replace('_novo', '', $dados['tabela']);
			$dados['data_criacao'] = date('Y-m-d H:i:s');
			$dados['tabela'] = str_replace('_novo', '', $dados['tabela']);
			return $this->insert($dados);
		}
		public function editar($dados){
			if(!isset($dados['id'])) return Mensagem::erro('Erro', 'Sem id para atualização.');
			$dados['tabela'] = str_replace('_novo', '', $dados['tabela']);
			$dados['data_atualizacao'] = date('Y-m-d H:i:s');
			$id = $dados['id'];
			unset($dados['id']);

			return $this->update($dados, "`id` = '{$id}'");
		}
		public function deletar($id){
			return $this->delete('id', $id);
		}

	}
