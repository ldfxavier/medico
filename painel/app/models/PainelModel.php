<?php
	class PainelModel extends Model {

		public function p_id($app, $id){
			if(empty($id)) return false;

			$model = Permissao::model($app);

			$Model = new $model;

			$dado = $Model->montar($Model->read("`id` = '{$id}'"));
			if($dado) return $dado[0];
		}

		public function p_cod($app, $cod){
			if(empty($cod)) return false;

			$model = Permissao::model($app);
			$Model = new $model;

			$dado = $Model->montar($Model->read("`cod` = '{$cod}'"));
			if($dado) return $dado[0];
		}

		public function p_coluna($app){
			$model = Permissao::model($app);
			$Model = new $model;
			return $Model->coluna();
		}

		public function p_previsualizacao($app, $dados){
			$model = Permissao::model($app);
			$Model = new $model;
			$dado = $Model->montar(array((object)$dados));
			if($dado) return $dado[0];
		}

		public function p_campo($app, $campo, $where, $order = null){
			$model = Permissao::model($app);
			$Model = new $model;
			$dado = $Model->read($where, $order, "0,1");
			if($dado) return $dado[0]->$campo;
			else return '';
		}

		public function p_read($app, $where = null, $order = null, $limit = null, $limpo = false){
			$model = Permissao::model($app);
			$Model = new $model;
			if($limpo) return $Model->read($where, $order, $limit);
			else return $Model->montar($Model->read($where, $order, $limit));
			exit();
		}

		public function p_contar($app, $where){
			$model = Permissao::model($app);
			$Model = new $model;
			return $Model->contar($where);
        }
            
        public function p_query($query, $retorno = '')
        {   
            return $this->query($query, $retorno);
        }


		public function p_join($tabela_1, $tabela_2, $lista_1 = [], $lista_2 = [], $on = null, $where = null, $order = null, $limit = null){
			return $this->join($tabela_1, $tabela_2, $lista_1, $lista_2, $on, $where, $order, $limit);
		}

		public function p_insert($app, $dados, $retorno = false){
			$model = Permissao::model($app);
			$Model = new $model;
			return $Model->insert($dados, $retorno);
		}
		public function p_update($app, $dados, $where, $retorno = false){
			$model = Permissao::model($app);
			$Model = new $model;
			return $Model->update($dados, $where, $retorno);
		}

		public function p_atualizar($app, $id, $nome, $valor){
			$model = Permissao::model($app);
			$Model = new $model;
			return $Model->update(
				array(
					$nome => $valor,
					'data_atualizacao' => date('Y-m-d H:i:s')
				),
				"`id` = '{$id}'"
			);
		}
		public function p_salvar($app, $dados){
			if(isset($dados['url'])):
				if(!empty($dados['url'])):
					$dados['url'] = Converter::acento($dados['url'], '-');
				elseif(isset($dados['titulo'])):
					$dados['url'] = Converter::acento($dados['titulo'], '-');
				elseif(isset($dados['nome'])):
					$dados['url'] = Converter::acento($dados['nome'], '-');
				else:
					$dados['url'] = md5(uniqid(time()));
				endif;
			endif;
			if(isset($dados['salt'])):
				if(!empty($dados['salt'])):
					$dados['salt'] = password_hash($dados['salt'], PASSWORD_DEFAULT, ['cost' => 11]);
				else:
					unset($dados['salt']);
				endif;
			endif;

			$model = Permissao::model($app);
			$Model = new $model;
			if(isset($dados['id']) && !empty($dados['id'])):
				$id = $dados['id'];
				unset($dados['id']);
				$dados['data_atualizacao'] = date('Y-m-d H:i:s');
                $update = $Model->update($dados, "`id` = '{$id}'", true);
                $this->p_log('', $dados, $update, $app);
				return $update;
			else:
				if(isset($dados['id'])) unset($dados['id']);
				$dados['data_criacao'] = date('Y-m-d H:i:s');
                $insert = $Model->insert($dados, true);
                $this->p_log('', $dados, $insert, $app);
				return $insert;
			endif;
		}

		public function p_deletar($app, $dados){
			$model = Permissao::model($app);
			$Model = new $model;

			if($dados):
                foreach($dados as $id):
                    $deletar = $Model->delete('id', $id);
                    $this->p_log('', $dados, $deletar, $app);
                endforeach;
            endif;
		}

		public function p_select($app, $indice, $valor, $titulo = null, $where = '', $limit = ''){
			$model = Permissao::model($app);
			$Model = new $model;

			$dado = $Model->read($where, "`{$valor}` ASC", $limit);
			$array = array();
			if($titulo) foreach($titulo as $ind => $val) $array[$ind] = $val;
			if($dado) foreach($dado as $r) $array[$r->$indice] = $r->$valor;
			return $array;
		}

		public function p_lista($app, $indice, $valor = [], $titulo = [], $where = '', $order = '', $limit = ''){
			$model = Permissao::model($app);
			$Model = new $model;

			$dado = $Model->read($where, $order, $limit);

			$array = [];
			if($titulo) foreach($titulo as $ind => $val) $array[$ind] = $val;
			if($dado):
				foreach($dado as $r):
					$dado_novo = [];
					foreach($valor as $val):
						$dado_novo[$val] = $r->$val;
					endforeach;
					$array[$r->$indice] = (object)$dado_novo;
				endforeach;
			endif;
			return $array;
		}

		public function p_download($app, $coluna_inicial){
			$model = Permissao::model($app);
			$Model = new $model;

			$empresa_existe = false;
			$empresa_array = [];
			$empresa_lista = [];

			$usuario_existe = false;
			$usuario_array = [];
			$usuario_lista = [];

			$coluna = [];
			foreach($coluna_inicial as $valor):
				$explode = explode('|', $valor);
				$coluna[$explode[0]] = $explode[1];

				if($explode[0] == 'empresa') $empresa_existe = true;
				if($explode[0] == 'usuario') $usuario_existe = true;
			endforeach;

			$where = isset($_SESSION['WHERE_'.$app]) ? $_SESSION['WHERE_'.$app] : '';
			$order = isset($_SESSION['ORDER_'.$app]) ? $_SESSION['ORDER_'.$app] : '';
			if(file_exists('app/views/painel/'.$app.'/include/_post_download_lista.php')):
				include('app/views/painel/'.$app.'/include/_post_download_lista.php');
			else:
				$lista = $Model->read($where, $order);
			endif;

			if(!$lista):
				echo 'Sua busca não retornou nenhum resultado, você só pode fazer download se tiver um ou mais dados.';
				exit();
			endif;

			if(file_exists('app/views/painel/'.$app.'/include/_post_download_complemento.php')):
				include('app/views/painel/'.$app.'/include/_post_download_complemento.php');
			endif;

			if(file_exists('app/views/painel/'.$app.'/include/_post_download.php')):
				include('app/views/painel/'.$app.'/include/_post_download.php');
			else:
				$array = array();
				$i = 0;
				foreach($coluna as $ind => $val):
					$array[$i][] = $val;
				endforeach;

				if($empresa_existe || $usuario_existe):
					foreach($lista as $r):
						foreach($coluna as $ind => $val):
							if($empresa_existe && $ind == 'empresa') $empresa_array[] = $r->$ind;
							if($usuario_existe && $ind == 'usuario') $usuario_array[] = $r->$ind;
						endforeach;
					endforeach;
					if($usuario_array):
						$usuario = [];
						foreach($usuario_array as $r_u):
							if(is_numeric($r_u)):
								$usuario[] = $r_u;
							elseif(is_array(json_decode($r_u, true))):
								foreach(json_decode($r_u, true) as $r_u2) $usuario[] = $r_u2;
							endif;
						endforeach;
						if($usuario):
							$usuario = array_unique($usuario);
							$usuario_where = "(`id` = '".implode("' OR `id` = '", $usuario)."')";
							$usuario_lista = $this->p_select('usuario_usuario', 'id', 'nome', null, $usuario_where);
						endif;
					endif;
					if($empresa_array):
						$empresa = [];
						foreach($empresa_array as $r_e):
							if(is_numeric($r_e)):
								$empresa[] = $r_e;
							elseif(is_array(json_decode($r_e, true))):
								foreach(json_decode($r_e, true) as $r_e2) $empresa[] = $r_e2;
							endif;
						endforeach;
						if($empresa):
							$empresa = array_unique($empresa);
							$empresa_where = "(`id` = '".implode("' OR `id` = '", $empresa)."')";
							$empresa_lista = $this->p_select('administrativo_empresa', 'id', 'nome_fantasia', null, $empresa_where);
						endif;
					endif;
				endif;
			endif;

			foreach($lista as $r):
				$i++;
				foreach($coluna as $ind => $val):
					if($empresa_existe && $ind == 'empresa'):
						if(isset($empresa_lista[$r->$ind]) && !empty($empresa_lista[$r->$ind]) && is_numeric($r->$ind)):
							$array[$i][] = $empresa_lista[$r->$ind];
						elseif(is_array(json_decode($r->$ind, true))):
							$array_temp_lista = [];
							foreach(json_decode($r->$ind, true) as $r_e_a):
								if(isset($empresa_lista[$r_e_a]) && !empty($empresa_lista[$r_e_a])):
									$array_temp_lista[] = $empresa_lista[$r_e_a];
								else:
									$array_temp_lista[] = 'Sem nome ('.$r_e_a.')';
								endif;
							endforeach;
							$array[$i][] = implode(' / ', $array_temp_lista);
						else:
							$array[$i][] = 'Sem nome ('.$r->$ind.')';
						endif;
					elseif($usuario_existe && $ind == 'usuario'):
						if(isset($usuario_lista[$r->$ind]) && !empty($usuario_lista[$r->$ind]) && is_numeric($r->$ind)):
							$array[$i][] = $usuario_lista[$r->$ind].' ('.$r->$ind.')';
						elseif(is_array(json_decode($r->$ind, true))):
							$array_temp_lista = [];
							foreach(json_decode($r->$ind, true) as $r_u_a):
								if(isset($usuario_lista[$r_u_a]) && !empty($usuario_lista[$r_u_a])):
									$array_temp_lista[] = $usuario_lista[$r_u_a].' ('.$r_u_a.')';
								else:
									$array_temp_lista[] = 'Sem nome ('.$r_u_a.')';
								endif;
							endforeach;
							$array[$i][] = implode(' / ', $array_temp_lista);
						else:
							$array[$i][] = 'Sem nome ('.$r->$ind.')';
						endif;
					else:
						$array[$i][] = $r->$ind;
					endif;
				endforeach;
			endforeach;
            
			$nome = Converter::caixa('download_'.$app.'_'.date('Y_m_d_H_i').'_'.Criar::codigo(8, false), 'a').'.xls';
            $this->p_log('', $coluna_inicial, $array, $app);
			Excel::gerar($nome, $array);
		}

		public function p_download_historico($app, $titulo, $equipe = null, $data_inicial = null, $data_final = null){

			$equipe = (isset($equipe) && !empty($equipe)) ? " AND `equipe` = '{$equipe}'" : "";
			$data_inicial = (isset($data_inicial) && !empty($data_inicial)) ? $data_inicial : "";
			$data_final = (isset($data_final) && !empty($data_final)) ? $data_final : "";
			$data = (!empty($data_inicial) && !empty($data_final)) ? " AND (`data_criacao` >= '".Converter::data($data_inicial, 'Y-m-d')." 00:00:00' AND `data_criacao` <= '".Converter::data($data_final, 'Y-m-d')." 23:59:59')" : "";

			$tabela = str_replace('_novo', '', Permissao::tabela($app));
			$Model = new HistoricoModel;
			$Equipe = new EquipeModel;

			$where = "`tabela` LIKE '%{$tabela}%'{$equipe}{$data}";
			$order = "cod ASC";

			$lista = $Model->read($where, $order);

			if(file_exists('app/views/painel/'.$app.'/include/_post_download_historico.php')):
				include('app/views/painel/'.$app.'/include/_post_download_historico.php');
			else:
				$array['1'] = [
					'ID',
					Converter::caixa($titulo, 'A'),
					'EQUIPE',
					'TEXTO',
					'DATA CRIAÇÃO'
				];
				$i = 2;
				foreach($lista as $r):
					$_cod = json_decode($r->cod);
					$cod = "";

					foreach($_cod as $r_cod):
						$cod .= "`cod` = '{$r_cod}' AND ";
					endforeach;

					$cod = substr($cod,0,-5);
					$_titulo = $this->p_read($app, $cod);

					$array[$i] = [
						$r->id,
						(isset($_titulo[0]->$titulo) && !empty($_titulo[0]->$titulo)) ? $_titulo[0]->$titulo : "",
						utf8_decode($Equipe->nome($r->equipe)),
						utf8_decode($r->texto),
						Converter::data($r->data_criacao, 'd/m/Y H:i:s')
					];
					$i++;
				endforeach;
			endif;

			$nome = Converter::caixa('historico_'.$app.'_'.date('Y_m_d_H_i').'_'.Criar::codigo(8, false), 'a').'.xls';
			Excel::gerar($nome, $array);
		}



		public function p_log($url, $dado = null, $retorno  = null, $app = null){

			if(!isset($_SESSION['EQUIPE'])):
				return false;
			endif;

			$Log = new DataLogModel;

            $Log->salvar($url,$dado,$retorno,$app);
		}

	}
