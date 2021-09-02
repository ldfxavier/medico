<?php
	class StatusModel extends Model {

		public $_tabela = "admin_status";

		public function montar($dados){
			$array = array();
			if($dados):
				foreach($dados as $r):
					$array[] = (object)array(
						'id' => $r->id,
						'cod' => $r->cod,
						'tabela' => $r->tabela,
						'campo' => $r->campo,
						'nome' => $r->nome,
						'valor' => $r->valor,
						'cor' => $r->cor,
						'ordem' => $r->ordem,
					);
				endforeach;
			endif;
			return $array;
		}

		public function padrao($valor){
			return (object)array(
				'texto' => $valor == 1 ? 'Ativo' : 'Inativo',
				'valor' => $valor == 1 ? 1 : 2,
				'cor' => $valor == 1 ? '#16A085' : '#E05D6F'
			);
		}

		public function nome($tabela, $campo, $valor){
			$dado = $this->read("`tabela` = '{$tabela}' AND `campo` = '{$campo}' AND `valor` = '{$valor}'");
			if($dado) return $dado[0]->nome;
			else return '';
		}

		public function valor($tabela, $campo, $valor){
			$dado = $this->read("`tabela` = '{$tabela}' AND `campo` = '{$campo}' AND `valor` = '{$valor}'");
			if($dado):
				return (object)array(
					'texto' => $dado[0]->nome,
					'valor' => $dado[0]->valor,
					'cor' => $dado[0]->cor
				);
			else:
				return (object)array(
					'texto' => '',
					'valor' => '',
					'cor' => ''
				);
			endif;
		}

		public function lista($tabela, $campo){
			return $this->read("`tabela` = '{$tabela}' AND `campo` = '{$campo}'");
		}

		public function select($tabela, $campo, $titulo = array()){
			$array = array();
			if($titulo) foreach($titulo as $ind => $val) $array[$ind] = $val;
			$dado = $this->read("`tabela` = '{$tabela}' AND `campo` = '{$campo}'");
			if($dado) foreach($dado as $r) $array[$r->valor] = $r->nome;
			return $array;
		}


	}
