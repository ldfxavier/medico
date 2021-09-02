<?php
	class ContatoModel extends Model {

		public $_tabela = "geral_contato";
		public $_tipo = array(
			1 => 'Telefone',
			2 => 'E-mail'
		);
		public $_nome = array(
			1 => 'Celular',
			2 => 'Comercial',
			3 => 'Residencial',
			4 => 'Fax',
			5 => '0800',
			6 => 'Outro',
			7 => 'Profissional',
			8 => 'Pessoal',
			9 => 'Funcional',
			10 => 'Whatsapp'
		);

		public $_operadora = array(
			1 => 'OI',
			2 => 'TIM',
			3 => 'CLARO',
			4 => 'VIVO',
			5 => 'NEXTEL',
			6 => 'NET',
			7 => 'EMBRATEL'
		);

		public function montar($dados){
			$array = array();
			if($dados):
				foreach($dados as $r):
					$nome = ($r->nome == 6) ? $r->outro : $this->_nome[$r->nome];

					$valor = ($r->tipo == 1) ? Converter::telefone($r->valor) : $r->valor;
					$valor_nome = !empty($contato) ? $contato : $nome;

					$array[] = (object)array(
						'id' => $r->id,
						'cod' => $r->cod,
						'tabela' => $r->tabela,
						'tipo' => (object)array(
							'valor' => $r->tipo,
							'texto' => $this->_tipo[$r->tipo]
						),
						'contato' => $r->contato,
						'nome' => (object)array(
							'valor' => $r->nome,
							'texto' => $nome,
							'outro' => $r->outro
						),
                        'documento' => (object)[
                            'br' => Converter::documento($r->documento),
                            'valor' => $r->documento
                        ],
						'valor' => (object)[
							'texto' => $valor,
							'valor' => $r->valor,
							'nome' => $valor_nome.' - '.$valor
						],
						'operadora' => (object)array(
							'valor' => $r->operadora,
							'texto' => isset($this->_operadora[$r->operadora]) ? $this->_operadora[$r->operadora] : ''
						),
						'destaque' => ($r->destaque == 1) ? 1 : 2
					);
				endforeach;
			endif;
			return $array;
		}

		public function telefone($cod, $tabela, $local = 1){
			return $this->montar($this->read("`tipo` = '1' AND `tabela` = '{$tabela}' AND `cod` = '{$cod}' AND `local` = '{$local}'", "`tipo` ASC, `destaque` ASC"));
		}
		public function celular($cod, $tabela, $local = 1){
			return $this->montar($this->read("`tipo` = '1' AND `nome` = '1' AND `tabela` = '{$tabela}' AND `cod` = '{$cod}' AND `local` = '{$local}'", "`destaque` ASC"));
		}

		public function email($cod, $tabela, $local = 1){
			return $this->montar($this->read("`tipo` = '2' AND `tabela` = '{$tabela}' AND `cod` = '{$cod}' AND `local` = '{$local}'", "`tipo` ASC, `destaque` ASC"));
		}

		public function lista($cod, $tabela, $local = 1){
			return $this->montar($this->read("`cod` = '{$cod}' AND `tabela` = '{$tabela}' AND `local` = '{$local}'", "`tipo` ASC, `destaque` ASC"));
		}
		public function agenda($cod, $tabela, $local = 1){
			$dados = $this->montar($this->read("`cod` = '{$cod}' AND `tabela` = '{$tabela}' AND `local` = '{$local}'", "`tipo` ASC, `destaque` ASC"));
			if($dados):
				$array = [];
				foreach($dados as $r) $array[] = $r->valor->valor;
				return implode(',', $array);
			endif;
		}

		public function id($id){
			$dado = $this->montar($this->read("`id` = '{$id}'"));
			if($dado) return $dado[0];
		}

		public function salvar($dados){
			if($dados['tipo'] == 1) $dados['valor'] = preg_replace("/[^0-9]/", "", $dados['valor']);
			if(isset($dados['id'])) unset($dados['id']);

			$dados['tabela'] = str_replace('_novo', '', $dados['tabela']);

			$salvar = $this->insert($dados, true);
			if($salvar['erro'] == false && $dados['destaque'] == 1):
				$id = $salvar['id'];
				$tabela = $dados['tabela'];
				$cod = $dados['cod'];
				$tipo = $dados['tipo'];
				$local = $dados['local'];
				$where = "`id` != '{$id}' AND `tabela` = '{$tabela}' AND `cod` = '{$cod}' AND `tipo` = '{$tipo}' AND `local` = '{$local}'";
				$this->update(['destaque' => '2'], $where);
			endif;
			return json_encode($salvar);
		}
		public function editar($dados){
			if($dados['tipo'] == 1) $dados['valor'] = preg_replace("/[^0-9]/", "", $dados['valor']);
			$dados['tabela'] = str_replace('_novo', '', $dados['tabela']);
			if(!isset($dados['id'])) return Mensagem::erro('Erro', 'Sem id para atualização.');
			$id = $dados['id'];
			unset($dados['id']);

			return $this->update($dados, "`id` = '{$id}'");
		}
		public function deletar($id){
			return $this->delete('id', $id);
		}

	}
