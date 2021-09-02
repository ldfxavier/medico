<?php
	class HistoricoModel extends Model {
		public $_tabela = "geral_historico";
		public function montar($dados){
			$array = array();
			if($dados):
				$Equipe = new EquipeModel;
				foreach($dados as $r):
					if($r->tipo == 1 || $r->tipo == 2) $class = 'telefone';
					elseif($r->tipo == 3 || $r->tipo == 4) $class = 'email';
					elseif($r->tipo == 5) $class = 'editar';
					elseif($r->tipo == 6) $class = 'outro';
					$array[] = (object)array(
						'id' => $r->id,
						'class' => $class,
						'nome' => $Equipe->nome($r->equipe),
						'texto' => $r->texto,
						'data' => Converter::data($r->data_criacao, 'd/m/Y H:i')
					);
				endforeach;
			endif;
			return $array;
		}
		public function salvar($dados){
			$dados['equipe'] = $_SESSION['EQUIPE']->id;
			$dados['data_criacao'] = date('Y-m-d H:i:s');
			$dados['cod'] = json_encode(explode(',', $dados['cod']));
            $Painel = new PainelModel;
			if(!empty($dados['tabela'])):
				$tabela = [];
				foreach(explode(',', $dados['tabela']) as $app):
					$valor = str_replace('_novo', '', Permissao::tabela($app));
					$tabela[] = !empty($valor) ? $valor : $app;
				endforeach;
				$dados['tabela'] = json_encode($tabela);
			endif;
            $insert = $this->insert($dados);
            $Painel->p_log('', $dados, $insert, $app);
			return $insert;
		}
		public function lista($app, $cod, $pagina = 1, $quantidade = 5){
			$where = [];
			$tabela = [];
			foreach(explode(',', $app) as $r_app):
				$valor = str_replace('_novo', '', Permissao::tabela($r_app));
				if(!empty($valor)) $tabela[] = $valor;
			endforeach;
			$where[] = $tabela ? "(`tabela` LIKE '%\"".implode("\"%' OR `tabela` LIKE '%\"", $tabela)."\"%')" : '';
			$codigo = [];
			foreach(explode(',', $cod) as $r_cod):
				if(!empty($r_cod)) $codigo[] = $r_cod;
			endforeach;
			$where[] = $codigo ? "(`cod` LIKE '%\"".implode("\"%' OR `cod` LIKE '%\"", $codigo)."\"%')" : '';
			$where = implode(' AND ', $where);
			$limit = ($pagina-1)*$quantidade;
			$dados = $this->montar($this->read($where, "`data_criacao` DESC", $limit.','.$quantidade));
			if($dados):
				$pagina_quantidade = ($pagina = 1) ? ceil($this->contar($where)/$quantidade) : 0;
				return (object)array(
					'lista' => $dados,
					'pagina' => $pagina_quantidade
				);
			endif;
		}
		public function cod($tabela, $cod){
			$dados = $this->montar($this->read("`tabela` LIKE '%\"{$tabela}\"%' AND `cod` LIKE '%\"{$cod}\"%'", "`data_criacao` DESC", "0,1"));
			if($dados) return $dados[0];
		}
	}
