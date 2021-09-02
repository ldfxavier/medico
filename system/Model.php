<?php
	namespace System;
	use \PDO;

	abstract class Model {

		private $_tabela, $_tabela_atual, $db, $paginacao = false, $paginacao_lista = [];
		private $dado, $query, $select, $where = '', $having = '', $value = [], $limit, $pagina = 1, $quantidade = 20, $order = [], $group, $campo = [], $join = [];
		private $query_erro_status, $query_erro_texto;
		private $condicao = ['>', '>=', '=', '<>', '<', '<=', '!=', 'like', 'notlike', 'null', 'isnull', 'notnull', '!null', 'isnotnull', 'in', 'notin', 'between', 'notbetween'];
		private $execute_erro = ['status' => false, 'dado' => [], 'texto' => ''];
		private $rollback = false;

		private $traduzir_erro = [
			'Table' => 'Tabela',
			'doesn\'t exist' => 'não existe.',
			'Duplicate entry' => 'Valor duplicado',
			'for key' => 'para o campo',
			'Out of range value' => 'Valor maior que o permitido',
			' at row 1' => '.',
			'Incorrect decimal value:' => 'Incorreto valor decimal',
			'Incorrect datetime value:' => 'Incorreto valor datetime',
			'for column' => 'na coluna',
			'Column' => 'Coluna',
			'cannot be null' => 'não pode ser nula',
			'Unknown column' => 'Não existe a coluna',
			'in' => 'na',
			'\'field list\'' => 'tabela.',
			'Field' => 'Campo',
			'doesn\'t have a default value' => 'não contém um valor padrão.'
		];

		public function __construct(String $tabela, Array $conn = [], Array $option = []){

			$this->_tabela = $tabela;
			$this->_tabela_atual = $tabela;

			if(empty($option)):
				$option[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
			endif;

			$host = $conn['host'] ?? DB_HOST;
			$banco = $conn['banco'] ?? DB_BANCO;
			$usuario = $conn['usuario'] ?? DB_USUARIO;
			$senha = $conn['senha'] ?? DB_SENHA;

			$this->db = new PDO('mysql:host='.$host.';dbname='.$banco, $usuario, $senha, $option);

		}

		protected function debug(){
			if(in_array(SISTEMA, ['localhost', 'homologacao'])):
				return [
					'erro' => [
						'status' => $this->query_erro_status,
						'texto' => $this->query_erro_texto
					],
					'query' => $this->montar_query(),
					'mysql' => $this->montar_mysql(),
					'select' => $this->select,
					'where' => $this->where,
					'having' => $this->having,
					'value' => $this->value,
					'limit' => $this->limit,
					'order' => $this->order,
					'group' => $this->group,
					'campo' => implode(', ', $this->campo),
					'pagina' => $this->pagina,
					'join' => $this->join
				];
			endif;
		}

		private function montar_query(): String {
			$select = !empty($this->select) ? $this->select : "SELECT {{PAGINACAO}} {{CAMPO}} FROM `{$this->_tabela}`";
			$campo = !empty($this->campo) ? implode(', ', $this->campo) : '*';
			$where = !empty($this->where) ? ' WHERE '.$this->where : '';
			$having = !empty($this->having) ? ' HAVING '.$this->having : '';
			$group = !empty($this->group) ? ' GROUP BY '.$this->group : '';
			$order = !empty($this->order) ? ' ORDER BY '.implode(', ', $this->order) : '';
			$limit = !empty($this->limit) ? ' LIMIT '.$this->limit : '';
			$pagina = true === $this->paginacao ? 'SQL_CALC_FOUND_ROWS' : '';
			$join = !empty($this->join) ? implode(' ', $this->join) : '';
			
			$query = str_replace(['{{PAGINACAO}}', '{{CAMPO}}'], [$pagina, $campo], $select.' '.$join.' '.$where.' '.$having.' '.$group.' '.$order.' '.$limit);

			return $query;
		}
		private function montar_mysql(){

			$query = $this->montar_query();

			$de = [];
			$por = [];

			if($this->value):
				foreach($this->value as $ind => $val):
					$de[] = ':'.$ind;
					$por[] = "'".$val."'";
				endforeach;
			endif;

			return str_replace($de, $por, $query);

		}
		private function query_limpar(){
			$this->value = [];
			$this->campo = [];
			$this->select = '';
			$this->where = '';
			$this->limit = '';
			$this->quantidade = '';
			$this->order = [];
			$this->group = '';
			$this->pagina = false;
			$this->join = [];
			$this->total = '';
		}

		protected function contar(): Int {

			$where = !empty($this->where) ? ' WHERE '.$this->where : '';
			$campo = !empty($this->campo) ? implode(', ', $this->campo).', ' : '*';

			$sql = $this->execute('SELECT COUNT(*) FROM `'.$this->_tabela_atual.'`'.$where, $this->value);

			$this->query_limpar();

			return $sql->fetchColumn();

		}
		protected function existe(): Bool {

			$where = !empty($this->where) ? ' WHERE '.$this->where : '';

			$sql = $this->execute('SELECT COUNT(*) FROM `'.$this->_tabela_atual.'`'.$where, $this->value);

			$this->query_limpar();

			return $sql->fetchColumn() > 0 ? true : false;

		}

		protected function get(): Array {
			if($this->query_erro_status):
				return [
					'erro' => true,
					'titulo' => 'Erro na query!',
					'texto' => $this->query_erro_texto
				];
			endif;

			$query = $this->montar_query();

			$sql = $this->execute($query, $this->value);
			if(true === $this->execute_erro['status']):
				return ['erro' => true, 'titulo' => 'Erro ao buscar!', 'texto' => $this->execute_erro['texto']];
			endif;
			$sql->setFetchMode(PDO::FETCH_OBJ);
			$dado = $sql->fetchAll();

			if(true === $this->paginacao):
				$total = $this->db->query("SELECT FOUND_ROWS()");
				$total->setFetchMode(PDO::FETCH_OBJ);
				$total = $total->fetchAll();
				$string_numero = 'FOUND_ROWS()';
				$total = $total[0]->$string_numero;

				$pagina_total = $total == 0 ? 0 : ceil($total / $this->quantidade);
				$pagina_atual = $total == 0 ? 0 : $this->pagina;
				$paginacao = [];

				if($pagina_total <= 7):
					for($i=1; $i<=$pagina_total; ++$i):
						$paginacao[] = $i;
					endfor;
				else:
					if($pagina_atual+3 > $pagina_total):
						for($i=0; $i<7; ++$i):
							$paginacao[] = $pagina_total-$i;
						endfor;
						$paginacao = array_reverse($paginacao, false);
					else:
						$comeco = $pagina_atual-3 < 1 ? 1 : $pagina_atual-3;
						for($i=0; $i<7; ++$i):
							$paginacao[] = $comeco+$i;
						endfor;
					endif;
				endif;

				$this->paginacao_lista = (Object)[
					'registro' => (Object)[
						'total' => (Int)$total,
						'atual' => $total == 0 ? 0 : count((Array)$dado)
					],
					'pagina' => (Object)[
						'total' => $pagina_total,
						'atual' => $pagina_atual,
						'paginacao' => $paginacao
					]
				];
			endif;

			$this->query_limpar();

			return $dado;
		}

		protected function paginacao($lista = []) {

			if($this->paginacao_lista):

				$paginacao = $this->paginacao_lista;
				$paginacao->lista = $lista;

				return $paginacao;

			else:
				return [];
			endif;
		}

		protected function dado(Array $dado){

			$this->query_limpar();

			if(!is_array($dado) || empty($dado)):
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Você precisa enviar um array no método dado.';
				return $this;
			endif;

			$this->dado = $dado;

			return $this;

		}

		protected function teste(Bool $status){

			$this->rollback = $status;

			return $this;

		}

		protected function select(String $select = ''){

			$this->query_limpar();

			if(!empty($select) && stristr($select, 'FROM')):
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Você não pode passar um FROM no select.';
				return $this;
			endif;

			$this->select = !empty($select) ? str_replace('SELECT', 'SELECT {{PAGINACAO}} {{CAMPO}}', $select.' FROM `'.$this->_tabela.'`') : "SELECT {{PAGINACAO}} {{CAMPO}} FROM `{$this->_tabela}`";

			return $this;

		}
		protected function campo($dado, String $as = NULL){
			if(is_array($dado)):
				$lista = [];
				foreach($dado as $val):
					if(is_string($val)):
						$as_campo = $as != NULL ? ' AS `'.$as.'_'.$val.'`' : '';
						$lista[] = '`'.$this->_tabela_atual.'`.`'.$val.'`'.$as_campo;
					elseif(is_array($val) && count($val) == 2):
						$lista[] = "`{$this->_tabela_atual}`.`{$val[0]}` AS `{$val[1]}`";
					else:
						$this->query_erro_status = true;
						$this->query_erro_texto = 'Campo com formato inválido.';
						break;
					endif;
				endforeach;
				$this->campo[] = implode(', ', $lista);
			elseif(is_string($dado)):
				$this->campo[] = $dado;
			endif;
			return $this;
		}
		public function tabela(String $tabela){
			$this->_tabela_atual = $tabela;
			return $this;
		}
		protected function join(String $param_1, $param_2, $param_3 = NULL){
			
			$campo_tabela_atual = $param_1;
			$campo_tabela = $param_3 == null ? $param_2 : $param_3;
			$condicao = $param_3 == null ? '=' : $param_2;

			$tabela = $this->_tabela;
			if(is_array($campo_tabela) && count($campo_tabela) == 2):
				$tabela = $campo_tabela[1];
				$campo_tabela = $campo_tabela[0];
			elseif(is_array($campo_tabela)):
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Valor do campo da tabela incorreto. ('.$campo_tabela.')';
				return $this;
			endif;

			$condicao = !empty($condicao) ? $condicao : '=';
			$condicao_lista = $this->condicao;

			if(!in_array($condicao, $condicao_lista)):
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Valor de condição incorreto. ('.$condicao.')';
				return $this;
			elseif($this->_tabela == $this->_tabela_atual):
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Você deve mudar a tabela para o Join';
				return $this;
			endif;

			$this->join[] = "INNER JOIN `{$this->_tabela_atual}` ON `{$this->_tabela_atual}`.`{$campo_tabela_atual}` {$condicao} `{$tabela}`.`{$campo_tabela}`";
			
			return $this;
		}

		protected function having($lista, $separador = 'AND'){
			if(is_array($lista)):
				$array = [];
				if(
					(count($lista) == 2 && is_string($lista[0]) && is_string($lista[1])) ||
					(count($lista) == 3 && is_string($lista[0]) && is_string($lista[1]) && is_string($lista[2]))
				):
					if(count($lista) == 2):
						$indice = $lista[0];
						$condicao = '=';
						$valor = $lista[1];
					elseif(count($lista) == 3):
						$indice = $lista[0];
						$condicao = $lista[1];
						$valor = $lista[2];
					endif;

					$array[] = "`{$indice}` {$condicao} '{$valor}'";
				elseif($lista):
					foreach($lista as $r):
						if(!is_array($r)):
							$this->query_erro_status = true;
							$this->query_erro_texto = 'O having passado não é um array';

							return $this;
						endif;

						if(count($r) == 2):
							$indice = $r[0];
							$condicao = '=';
							$valor = $r[1];
						elseif(count($r) == 3):
							$indice = $r[0];
							$condicao = $r[1];
							$valor = $r[2];
						else:
							$this->query_erro_status = true;
							$this->query_erro_texto = 'O Array do having deve ter 2 ou 3 valores';

							return $this;
						endif;

						$array[] = "`{$indice}` {$condicao} '{$valor}'";
					endforeach;
				endif;

				$this->having = implode($separador, $array);

			elseif(is_string($lista)):
				$this->having = $lista;
			endif;

			return $this;

		}

		protected function where($lista, $separador = 'AND'){

			if(empty($lista)):
				return $this;
			endif;

			$where = $this->where_geral($lista, $separador);

			if(!$this->query_erro_status):
				if(!empty($this->where)):
					$this->where .= ' AND '.$where;
				else:
					$this->where .= $where;
				endif;
			endif;

			return $this;

		}

		protected function where_and($lista){

			if(empty($lista)):
				return $this;
			endif;

			$this->where($lista, 'AND');
			return $this;

		}
		protected function where_or($lista){

			if(empty($lista)):
				return $this;
			endif;

			$this->where($lista, 'OR');
			return $this;

		}

		protected function and(){
			$this->where .= ' AND ';
			return $this;
		}
		protected function or(){
			$this->where .= ' OR ';
			return $this;
		}
		protected function group(String $campo){

			if(!empty($campo)):
				$this->group = "`{$this->_tabela_atual}`.`{$campo}`";
			endif;

			return $this;
		}
		protected function limit(Int $inicio, Int $quantidade){
			$this->limit = $inicio.', '.$quantidade;
			return $this;
		}
		protected function pagina(Int $pagina, Int $quantidade = 20){
			$this->pagina = $pagina;
			$this->quantidade = $quantidade;
			$this->limit = ($pagina-1)*$quantidade.', '.$quantidade;
			$this->paginacao = true;
			return $this;
		}

		private function order_montar($campo, $padrao = NULL){

			$verificar = mb_strtolower($campo, 'UTF-8');
			$padrao = $padrao != NULL ? ' '.$padrao : '';
			
			if(in_array($verificar, ['rand', 'rand()'])):
				$this->order = ['RAND()'];
			elseif((stristr($verificar, "`") || stristr($verificar, ".") || stristr($verificar, "field(")) && empty($padrao)):
				$this->order[] = $campo;
			else:
				$this->order[] = '`'.$this->_tabela_atual.'`.`'.$campo.'`'.$padrao;
			endif;

		}
		protected function order($campo, String $padrao = NULL){

			if(is_string($campo)):

				$this->order_montar($campo, $padrao);

			elseif(is_array($campo) && isset($campo[0]) && is_string($campo[0])):

				foreach($campo as $lista):
					$this->order_montar($lista, $padrao);
				endforeach;

			elseif(is_array($campo) && isset($campo[0]) && is_array($campo[0])):

				foreach($campo as $lista):

					$this->order_montar($lista[0], $lista[1] ?? $padrao);

				endforeach;

			endif;

			return $this;
		}
		protected function order_rand(){
			$this->order[] = 'RAND()';
			return $this;
		}
		protected function order_field(String $campo, Array $valor){
			$order = 'FIELD(`'.$this->_tabela_atual.'`.`'.$campo.'`, \''.implode("', '", $valor).'\')';

			$this->order[] = !empty($this->order) ? ', '.$order : $order;

			return $this;
		}

		private function execute(String $query, Array $dado = []){

			$this->db->beginTransaction();

			$sql = $this->db->prepare($query);
			if($dado):
				foreach($dado as $ind => $valor):
					$null = null;
					if(!is_numeric($dado[$ind]) && empty($dado[$ind])):
						$sql->bindValue(":{$ind}", $null, PDO::PARAM_NULL);
					elseif(filter_var($valor, FILTER_VALIDATE_INT)):
						$sql->bindValue(":{$ind}", $valor, PDO::PARAM_INT);
					elseif(filter_var($valor, FILTER_VALIDATE_BOOLEAN)):
						$sql->bindValue(":{$ind}", $valor, PDO::PARAM_BOOL);
					elseif(is_string($valor)):
						$sql->bindValue(":{$ind}", $valor, PDO::PARAM_STR);
					else:
						$sql->bindValue(":{$ind}", $valor);
					endif;
				endforeach;
			endif;
			$run = $sql->execute();
			
			if(!$run):
				
				$erro = $sql->errorInfo();
				$erro_texto = $erro[2] ?? 'Ocorreu um erro ao executar ação, recarregue o navegador e tente novamente.';

				$this->execute_erro = [
					'status' => true,
					'dado' => $erro,
					'texto' => $this->traduzir_erro($erro_texto)
				];

				$this->db->rollBack();

			else:
				
				if(true === $this->rollback):
					$this->db->rollBack();
				else:
					$this->db->commit();
				endif;

			endif;

			return $sql;

		}

		private function salvar_auditoria($dado, $acao){
			// if(in_array($this->_tabela, AUDITORIA['geral']) || (isset($_SESSION['EQUIPE']->id) && in_array($this->_tabela, AUDITORIA['equipe'])) || (isset($_SESSION['USUARIO']->id) && in_array($this->_tabela, AUDITORIA['usuario']))):
			// 	$dado = [
			// 		'uuid' => $this->uuid(),
			// 		'id_equipe' => isset($_SESSION['EQUIPE']->id) ? $_SESSION['EQUIPE']->id : NULL,
			// 		'id_usuario' => isset($_SESSION['USUARIO']->id) ? $_SESSION['USUARIO']->id : NULL,
			// 		'acao_crud' => $acao,
			// 		'tabela_banco' => $this->_tabela,
			// 		'use_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
			// 		'ip_usuario' => $_SERVER['REMOTE_ADDR'],
			// 		'data_criacao' => date('Y-m-d H:i:s'),
			// 		'dado_executado' => json_encode($dado)
			// 	];
			// 	$query = "INSERT INTO `".TABELA['admin_auditoria']."` (".implode(', ', array_keys($dado)).") VALUES (:".implode(', :', array_keys($dado)).")";

			// 	if(!$this->execute($query, $dado)):
			// 		//print_r($this->execute_erro);
			// 	endif;
			// endif;
		}

		private function uuid(): String {
			return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
				mt_rand( 0, 0xffff ),
				mt_rand( 0, 0x0fff ) | 0x4000,
				mt_rand( 0, 0x3fff ) | 0x8000,
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
		}

		protected function insert(): Array {
			if($this->query_erro_status):
				return ['erro' => true, 'titulo' => 'Erro na query!', 'texto' => $this->query_erro_texto];
			elseif(empty($this->dado)):
				return ['erro' => true, 'titulo' => 'Campo obrigatório!', 'texto' => 'Você precisa passar algum dado para salvar.'];
			endif;

			$dado = $this->dado;
			$coluna = $this->pegar_coluna_banco();

			$coluna_uuid = $coluna['uuid'] ?? false;
			$dado_uuid = $dado['uuid'] ?? false;
			if(false !== $coluna_uuid && false === $dado_uuid):
				$dado['uuid'] = uuid();
			elseif(false !== $coluna_uuid && false === $dado_uuid):
				$dado['cod'] = uuid();
			endif;

			$coluna_data_criacao = $coluna['data_criacao'] ?? false;
			$dado_data_criacao = $dado['data_criacao'] ?? false;
			if(false !== $coluna_data_criacao && false === $dado_data_criacao):
				$dado['data_criacao'] = date('Y-m-d H:i:s');
			endif;
			
			$dado = $this->validar_dado($dado, $coluna);
			
			$validar_erro = $dado['erro'] ?? false;
			if(true === $validar_erro):
				return $dado;
			endif;

			foreach($dado as $ind => $val):
				$campos_ini[] = $ind;
			endforeach;

			$campos = "`".implode("`, `", $campos_ini)."`";
			$valores = ":".implode(", :", $campos_ini);
			$query = "INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores})";

			$sql = $this->execute($query, $dado);

			if(false === $this->execute_erro['status']):
			
				$insert = ['erro' => false, 'id' => $dado['uuid'] ?? $dado['cod'] ?? ''];
				$this->salvar_auditoria(['dado' => $dado], 'insert');

				$this->query_limpar();

				return $insert;

			else:
				return ['erro' => true, 'titulo' => 'Erro ao salvar!', 'texto' => $this->execute_erro['texto']];
			endif;
		}

		protected function update(): Array {
			if($this->query_erro_status):
				return ['erro' => true, 'titulo' => 'Erro na query!', 'texto' => $this->query_erro_texto];
			elseif(empty($this->dado)):
				return ['erro' => true, 'titulo' => 'Campo obrigatório!', 'texto' => 'Você precisa passar algum dado para atualizar.'];
			elseif(empty($this->where) || empty($this->value)):
				return ['erro' => true, 'titulo' => 'Campo obrigatório!', 'texto' => 'Você precisa passar uma where.'];
			elseif(!$this->validar_existe()):
				return ['erro' => true, 'titulo' => 'Registro não existe!', 'texto' => 'O registro não existe ou foi deletado.'];
			endif;

			$dado = $this->dado;
			$coluna = $this->pegar_coluna_banco();

			$coluna_data_atualizacao = $coluna['data_atualizacao'] ?? false;
			$dado_data_atualizacao = $dado['data_atualizacao'] ?? false;
			if(false !== $coluna_data_atualizacao && false === $dado_data_atualizacao):
				$dado['data_atualizacao'] = date('Y-m-d H:i:s');
			endif;

			$dado = $this->validar_dado($dado, $coluna);
			
			$validar_erro = $dado['erro'] ?? false;
			if(true === $validar_erro):
				return $dado;
			endif;

			$campo_lista = array_keys($dado);
			$campo = [];
			foreach($campo_lista as $ind):
				$campo[] = "`".$ind."` = :".$ind;
			endforeach;
			$campo = implode(", ", $campo);

			$query = "UPDATE `{$this->_tabela}` SET {$campo} WHERE {$this->where}";

			$value = array_merge($dado, $this->value);
			$this->execute($query, $value);
			if($this->execute_erro['status'] ===  false):

				$this->query_limpar();

				$this->salvar_auditoria(['dado' => $dado, 'where' => $this->where], 'update');

				return ['erro' => false];

			else:
				return ['erro' => true, 'titulo' => 'Erro ao atualizar!', 'texto' => $this->execute_erro['texto']];
			endif;
		}

		protected function delete(){
			if(empty($this->where) || empty($this->value)):
				return ['erro' => true, 'titulo' => 'Campo obrigatório!', 'texto' => 'Você precisa passar uma where.'];
			elseif(!$this->validar_existe($this->where, $this->value)):
				return ['erro' => true, 'titulo' => 'Registro não existe!', 'texto' => 'O registro não existe ou já foi deletado.'];
			endif;

			$query = "DELETE FROM `{$this->_tabela}` WHERE {$this->where}";
			$this->execute($query, $this->value);
			if($this->execute_erro['status'] ===  false):

				$this->salvar_auditoria(['where' => $this->where], 'delete');

				$this->query_limpar();

				return ['erro' => false];

			else:
				return ['erro' => true, 'titulo' => 'Erro ao deletar!', 'texto' => $this->execute_erro['texto']];
			endif;
		}

		protected function pegar_coluna_banco(){
			$query = $this->db->query("SHOW FULL COLUMNS FROM `{$this->_tabela}`");
			$query->setFetchMode(PDO::FETCH_OBJ);
			$lista = $query->fetchAll();
			$array = [];
			foreach($lista as $r):
				if(mb_detect_encoding($r->Comment , 'UTF-8, ISO-8859-1')):
					$comment = utf8_encode($r->Comment);
				else:
					$comment = $r->Comment;
				endif;
				$validar = [];
				$comentario = mb_strtolower($comment, 'UTF-8');
				preg_match('/\[(.*?)\]/', $comment, $titulo);
				$titulo = $titulo[1] ?? '';
				$tipo = $r->Type;
				$tamanho = false;
				if(strstr($comentario, '{validar')):
					preg_match('/\{validar,(.*?)\}/', $comentario, $validar_temp);
					$validar_temp = $validar_temp[1] ?? false;
					if($validar_temp):
						$validar = explode(',', $validar_temp);
					endif;
				endif;
				if(!empty($r->Type) && strstr($r->Type, '(')):
					$explode = explode('(', $r->Type);
					$tipo = $explode[0];
					$tamanho = preg_replace("/[^0-9]/", "", $explode[1]);
				endif;

				$array[$r->Field] = (object)[
					'campo' => $r->Field,
					'tipo' => $tipo,
					'tamanho' => (Int)$tamanho,
					'obrigatorio' => ($r->Null == 'YES') ? false : true,
					'padrao' => $r->Default,
					'validar' => $validar,
					'download' => strstr($comentario, '{download}') ? true : false,
					'titulo' => $titulo
				];
			endforeach;
			return $array;
		}


		protected function validar_busca($busca){

			if(!$busca || isset($busca['erro'])):
				return false;
			endif;

			return true;

		}

		private function validar_dado(Array $dado, Array $coluna): Array {
			foreach($dado as $ind => $valor):
				if(!isset($coluna[$ind])):
					return [
						'erro' => true,
						'titulo' => 'Erro no banco!',
						'texto' => 'A coluna '.$ind.' não existe no banco de dado.'
					];
				endif;

				$titulo = !empty($coluna[$ind]->titulo) ? $coluna[$ind]->titulo : $ind;

				if(!empty($valor) && in_array($coluna[$ind]->tipo, ['int', 'bigint'])):
					$valor = preg_replace("/[^0-9]/", "", $valor);
				elseif(!empty($valor) && $coluna[$ind]->tipo == 'date'):
					$valor = date('Y-m-d', strtotime(str_replace('/', '-', $valor)));
				elseif(!empty($valor) && $coluna[$ind]->tipo == 'datetime'):
					$valor = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $valor)));
				elseif(!empty($valor) && $coluna[$ind]->tipo == 'time'):
					$valor = date('H:i:s', strtotime(str_replace('/', '-', $valor)));
				elseif(!empty($valor) && is_array($valor)):
					$valor = json_encode($valor);
				endif;

				if($coluna[$ind]->obrigatorio == true && empty($valor) || (($coluna[$ind]->tipo == 'date' && preg_replace("/[^0-9]/", "", $valor) == '00000000') || ($coluna[$ind]->tipo == 'datetime' && preg_replace("/[^0-9]/", "", $valor) == '00000000000000') || ($coluna[$ind]->tipo == 'time' && preg_replace("/[^0-9]/", "", $valor) == '000000'))):
					return [
						'erro' => true,
						'titulo' => 'Campo obrigatório!',
						'texto' => 'O campo '.$titulo.' é obrigatório.'
					];
				elseif(is_numeric($coluna[$ind]->tamanho) && $coluna[$ind]->tamanho > 0 && mb_strlen($valor, 'UTF-8') > $coluna[$ind]->tamanho):
					$diferenca = mb_strlen($valor, 'UTF-8')-$coluna[$ind]->tamanho;
					return [
						'erro' => true,
						'titulo' => 'Tamanho maior que o permitido!',
						'texto' => 'O campo '.$titulo.' tem '.$diferenca.' caracteres a mais que o permitido.'
					];
				elseif(!empty($valor) && in_array($coluna[$ind]->tipo, ['int', 'bigint']) && !filter_var($valor, FILTER_VALIDATE_INT)):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um número inteiro.'
					];
				elseif($coluna[$ind]->validar && in_array('cep', $coluna[$ind]->validar) && !empty($valor) && mb_strlen($valor, 'UTF-8') != 8):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um CEP válido.'
					];
				elseif(!empty($valor) && $coluna[$ind]->tipo == 'json' && (!is_array(json_decode($valor, true)) && !is_array($valor))):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é uma string json.'
					];
				elseif(!empty($valor) && $coluna[$ind]->tipo == 'mediumblob' && !is_file($valor)):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um arquivo permitido.'
					];
				elseif(!empty($valor) && $coluna[$ind]->tipo == 'mediumblob' && !in_array($this->pegar_extensao($valor), $coluna[$ind]->validar)):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é uma extensão permitida.'
					];
				elseif($coluna[$ind]->validar && in_array('cpf', $coluna[$ind]->validar) && !empty($valor) && !$this->validar_documento(str_pad($valor, 11, '0', STR_PAD_LEFT), 'cpf')):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um CPF válido.'
					];
				elseif($coluna[$ind]->validar && in_array('cnpj', $coluna[$ind]->validar) && !empty($valor) && !$this->validar_documento(str_pad($valor, 14, '0', STR_PAD_LEFT), 'cnpj')):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um CNPJ válido.'
					];
				elseif($coluna[$ind]->validar && in_array('telefone', $coluna[$ind]->validar) && !empty($valor) && !$this->validar_telefone($valor)):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um telefone válido.'
					];
				elseif($coluna[$ind]->validar && in_array('email', $coluna[$ind]->validar) && !empty($valor) && !filter_var($valor, FILTER_VALIDATE_EMAIL)):
					return [
						'erro' => true,
						'titulo' => 'Formato incorreto!',
						'texto' => 'O campo '.$titulo.' não é um e-mail válido.'
					];
				elseif($coluna[$ind]->tipo == 'time' && !empty($valor) && !preg_match("/^([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $valor)):
					return [
						'erro' => true,
						'titulo' => 'Campo incorreto!',
						'texto' => 'O campo '.$titulo.' não é um formato de hora válido.'
					];
				elseif($coluna[$ind]->tipo == 'date' && !empty($valor) && preg_replace("/[^0-9]/", "", $valor) != '00000000' && !preg_match('/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $valor)):
					return [
						'erro' => true,
						'titulo' => 'Campo incorreto!',
						'texto' => 'O campo '.$titulo.' não está no formato 00/00/0000.'
					];
				elseif($coluna[$ind]->tipo == 'datetime' && !empty($valor) && preg_replace("/[^0-9]/", "", $valor) != '00000000000000' && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $valor)):
					return [
						'erro' => true,
						'titulo' => 'Campo incorreto!',
						'texto' => 'O campo '.$titulo.' não está no formato 00/00/0000 00:00:00.'
					];
				elseif($coluna[$ind]->tipo == 'decimal' && !empty($valor) && !preg_match("/^[0-9]*\.[0-9]{2}$/", $valor)):
					return [
						'erro' => true,
						'titulo' => 'Campo incorreto!',
						'texto' => 'O campo '.$titulo.' não está no formato 0.00.'
					];
				elseif($coluna[$ind]->tipo == 'float' && filter_var($valor, FILTER_VALIDATE_FLOAT)):
					return [
						'erro' => true,
						'titulo' => 'Campo incorreto!',
						'texto' => 'O campo '.$titulo.' não está no formato float.'
					];
				endif;
				if(!empty($valor) && $coluna[$ind]->tipo == 'mediumblob'):
					$valor = LOAD_FILE($valor);
				else:
					$dado[$ind] = $valor;
				endif;
			endforeach;
			return $dado;
		}

		private function validar_documento(String $valor, String $tipo = 'auto'){
			$documento_verificar = preg_replace("/[^0-9]/", "", $valor);
			$quantidade = strlen($documento_verificar);

			$erro = false;
			if(!is_numeric($documento_verificar) || in_array($documento_verificar, ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888','99999999999'])):
				$erro = false;
            elseif($quantidade == 11 && ($tipo == 'auto' || $tipo == 'cpf')):
                $cpf = $documento_verificar;
                $dv_informado = substr($cpf, 9,2);
				for($i=0; $i<=8; $i++) $digito[$i] = substr($cpf, $i,1);
				$posicao = 10;
				$soma = 0;
				for($i=0; $i<=8; $i++):
					$soma = $soma + $digito[$i] * $posicao;
					$posicao = $posicao - 1;
				endfor;
				$digito[9] = $soma % 11;
				if($digito[9] < 2) $digito[9] = 0;
				else $digito[9] = 11 - $digito[9];
				$posicao = 11;
				$soma = 0;
				for ($i=0; $i<=9; $i++):
					$soma = $soma + $digito[$i] * $posicao;
					$posicao = $posicao - 1;
				endfor;
				$digito[10] = $soma % 11;
				if ($digito[10] < 2) $digito[10] = 0;
				else $digito[10] = 11 - $digito[10];
				$dv = $digito[9] * 10 + $digito[10];
				if ($dv == $dv_informado):
					$erro = true;
				else:
					$erro = false;
				endif;
            elseif($quantidade == 14 && in_array($tipo, ['auto', 'cnpj'])):
                $cnpj = $documento_verificar;
                $cnpj_original = $documento_verificar;
                $primeiros_numeros_cnpj = substr($cnpj, 0, 12);
                $primeiro_calculo = $this->multiplica_cnpj($primeiros_numeros_cnpj);
                $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
                $primeiros_numeros_cnpj .= $primeiro_digito;
                $segundo_calculo = $this->multiplica_cnpj($primeiros_numeros_cnpj, 6);
                $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
				$cnpj = $primeiros_numeros_cnpj . $segundo_digito;

				if($cnpj === $cnpj_original):
					$erro = true;
				else:
					$erro = false;
				endif;
			elseif(!empty($valor)):
				$erro = false;
            endif;

			return $erro;
		}
		private function multiplica_cnpj(String $cnpj, Int $posicao = 5): int {
			$calculo = 0;
			for( $i = 0; $i < strlen($cnpj); $i++ ):
				$calculo = $calculo + ($cnpj[$i] * $posicao);
				$posicao--;
				if($posicao < 2):
					$posicao = 9;
				endif;
			endfor;
			return $calculo;
		}
		private function validar_telefone($valor){
			$valor = preg_replace("/[^0-9]/", "", $valor);
			$strlen = mb_strlen($valor, 'UTF-8');
			if(
				($strlen == 8 && in_array(substr($valor, 0, 4), ["4004", "4003", "3003"])) ||
				($strlen == 11 && (in_array(substr($valor, 0, 4), ["0800", "0300"]) || substr($valor, 2, 1) == 9)) ||
				($strlen == 10 && substr($valor, 2, 1) != 9)
			):
				return true;
			endif;
			return false;
		}
		public function validar_select(String $query): Array {
			if(
				(stristr($query, 'DELETE') && stristr($query, 'FROM')) ||
				(stristr($query, 'UPDATE') && stristr($query, 'SET')) ||
				(stristr($query, 'INSERT') && stristr($query, 'INTO'))
			):
				return ['erro' => true, 'titulo' => 'Erro!', 'texto' => 'Ocorreu um erro na execução, recarregue o navegador e tente novamente.'];
			endif;
			return ['erro' => false];
		}
		private function validar_existe(): Bool {
			$sql = $this->execute("SELECT `id` FROM `{$this->_tabela}` WHERE {$this->where}", $this->value);
			$sql->setFetchMode(PDO::FETCH_OBJ);
			return $sql->fetchAll() ? true : false;
		}
		private function validar_data(String $data): Bool {
			if((preg_replace("/[^0-9]/", "", $data) != '00000000' && preg_match('/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data)) || (preg_replace("/[^0-9]/", "", $data) != '00000000000000' && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data))):
				return true;
			endif;
			return false;
		}

		private function traduzir_erro($erro){
			return str_replace(array_keys($this->traduzir_erro), array_values($this->traduzir_erro), $erro);
		}

		private function where_montar_condicao(String $campo, String $condicao, $valor){

			$condicao_lista = $this->condicao;

			if(false === $valor && !in_array($condicao, $condicao_lista)):
				$valor = $condicao;
				$condicao = '=';
			endif;

			$condicao = str_replace(' ', '', mb_strtolower($condicao, 'UTF-8'));

			if(!in_array($condicao, $condicao_lista)):

				$this->query_erro_status = true;
				$this->query_erro_texto = 'Valor da condição da WHERE incorreto. ('.$condicao.')';
				return false;

			endif;

			$hash = md5(uniqid(time()));
			
			if(in_array($condicao, ['null', 'isnull'])):
				return "`{$this->_tabela_atual}`.`$campo` IS NULL";
			elseif(in_array($condicao, ['notnull', 'isnotnull', '!null'])):
				return "`{$this->_tabela_atual}`.`$campo` IS NOT NULL";
			elseif($condicao == 'in'):
				if(is_array($valor) && count($valor) > 0):
					$in = [];
					foreach($valor as $in_ind => $in_val):
						$in[] = $hash.'_in_'.$in_ind;
						$this->value[$hash.'_in_'.$in_ind] = $in_val;
					endforeach;
					return "`{$this->_tabela_atual}`.`$campo` IN(:".implode(', :', $in).")";
				else:
					$this->query_erro_status = true;
					$this->query_erro_texto = 'Valor do IN incorreto. ('.$campo.')';
					return false;
				endif;
			elseif($condicao == 'notin'):
				if(is_array($valor) && count($valor) > 1):
					$in = [];
					foreach($valor as $in_ind => $in_val):
						$in[] = $hash.'_notin_'.$in_ind;
						$this->value[$hash.'_notin_'.$in_ind] = $in_val;
					endforeach;
					return "`{$this->_tabela_atual}`.`$campo` NOT IN(:".implode(', :', $in).")";
				else:
					$this->query_erro_status = true;
					$this->query_erro_texto = 'Valor do NOT IN incorreto. ('.$campo.')';
					return false;
				endif;
			elseif($condicao == 'between'):
				if(is_array($valor) && count($valor) == 2):
					$this->value[$hash.'_bet_0'] = $valor[0];
					$this->value[$hash.'_bet_1'] = $valor[1];
					if($this->validar_data($valor[0]) && $this->validar_data($valor[1])):
						return "`{$this->_tabela_atual}`.`$campo` BETWEEN DATE(:{$hash}_bet_0) AND DATE(:{$hash}_bet_1)";
					else:
						return "`{$this->_tabela_atual}`.`$campo` BETWEEN :{$hash}_bet_0 AND :{$hash}_bet_1";
					endif;
				else:
					$this->query_erro_status = true;
					$this->query_erro_texto = 'Valor do BETWEEN incorreto. ('.$campo.')';
					return false;
				endif;
			elseif($condicao == 'notbetween'):
				if(is_array($valor) && count($valor) == 2):
					$this->value[$hash.'_notbet_0'] = $valor[0];
					$this->value[$hash.'_notbet_1'] = $valor[1];
					if($this->validar_data($valor[0]) && $this->validar_data($valor[1])):
						return "`{$this->_tabela_atual}`.`$campo` NOT BETWEEN DATE(:{$hash}_notbet_0) AND DATE(:{$hash}_notbet_1)";
					else:
						return "`{$this->_tabela_atual}`.`$campo` NOT BETWEEN :{$hash}_notbet_0 AND :{$hash}_notbet_1";
					endif;
				else:
					$this->query_erro_status = true;
					$this->query_erro_texto = 'Valor do NOT BETWEEN incorreto. ('.$campo.')';
					return false;
				endif;
			elseif($condicao == 'like' AND is_string($valor)):
				$this->value[$hash] = $valor;
				return "`{$this->_tabela_atual}`.`$campo` LIKE :{$hash}";
			elseif($condicao == 'notlike' AND is_string($valor)):
				$this->value[$hash] = $valor;
				return "`{$this->_tabela_atual}`.`$campo` NOT LIKE :{$hash}";
			elseif(!is_array($valor)):
				$this->value[$hash] = $valor;
				return "`{$this->_tabela_atual}`.`$campo` {$condicao} :{$hash}";
			else:
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Valor deve ser uma string. ('.$campo.')';
				return false;
			endif;

			return true;

		}

		private function where_montar_grupo($lista, String $implode){

			$array = [];

			$implode_grupo = mb_strtoupper($implode, 'UTF-8');
			$implode_lista = ['OR', 'AND'];

			if(isset($lista[0]) && is_string($lista[0]) && in_array($lista[0], $implode_lista)):
				$implode = mb_strtoupper($lista[0], 'UTF-8');
				unset($lista[0]);
			endif;

			foreach($lista as $r):

				$primeiro_registro = current($r);
				if(is_string($primeiro_registro)):
					$primeiro_registro = mb_strtoupper($primeiro_registro, 'UTF-8');
				endif;

				if(is_string($primeiro_registro) && count($r) == 2 && !in_array($primeiro_registro, $implode_lista)):

					$array[] = $this->where_montar_condicao($r[0], $r[1], false);

				elseif(is_string($primeiro_registro) && count($r) == 3 && !in_array($primeiro_registro, $implode_lista)):

					$array[] = $this->where_montar_condicao($r[0], $r[1], $r[2]);

				elseif(is_array($primeiro_registro) || (in_array($primeiro_registro, $implode_lista) && count($r) > 1)):
					
					if(is_string($primeiro_registro) && in_array($primeiro_registro, $implode_lista)):
						$implode_grupo = $primeiro_registro;
						unset($r[0]);
					endif;

					$array[] = $this->where_montar_grupo($r, $implode_grupo);

				else:

					$this->query_erro_status = true;
					$this->query_erro_texto = 'Valor do WHERE incorreto.';
					return false;
					
				endif;

			endforeach;

			return '('.implode(' '.$implode.' ', $array).')';

		}
		private function where_geral($lista, String $implode) {

			if(is_object($lista)):
				$lista = (Array)$lista;
			endif;

			if(is_string($lista)):
				return $lista;
			elseif(!is_array($lista)):
				$this->query_erro_status = true;
				$this->query_erro_texto = 'Valor do WHERE incorreto. ('.$lista.')';
				return false;
			endif;

			$implode_lista = ['OR', 'AND'];

			if(is_string(current($lista)) && !in_array(current($lista), $implode_lista) && count($lista) == 2):

				return $this->where_montar_condicao($lista[0], $lista[1], false);

			elseif(is_string(current($lista)) && !in_array(current($lista), $implode_lista) && count($lista) == 3):

				return $this->where_montar_condicao($lista[0], $lista[1], $lista[2]);
			
			elseif(!is_array(current($lista)) && !in_array(current($lista), $implode_lista)):

				$this->query_erro_status = true;
				$this->query_erro_texto = 'Valor do WHERE incorreto. ('.$lista.')';
				return false;

			endif;

			return $this->where_montar_grupo($lista, $implode);

		}

		private function pegar_extensao_arquivo(String $arquivo): String {
			$mime_type_lista = [
				'video/x-msvideo' => 'avi',
				'text/csv' => 'csv',
				'text/x-comma-separated-values' => 'csv',
				'text/comma-separated-values' => 'csv',
				'application/msword' => 'doc',
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
				'application/epub+zip' => 'epub',
				'image/gif' => 'gif',
				'text/html' => 'htm',
				'text/html' => 'html',
				'image/x-icon' => 'ico',
				'image/jpeg' => 'jpg',
				'image/jpg' => 'jpg',
				'application/json' => 'json',
				'audio/midi' => 'mid',
				'video/mpeg' => 'mpeg',
				'audio/mpeg' => 'mp3',
				'audio/mpg' => 'mp3',
				'audio/mpeg3' => 'mp3',
				'audio/mp3' => 'mp3',
				'mp4' => 'video/mp4',
				'application/vnd.oasis.opendocument.presentation' => 'odp',
				'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
				'application/vnd.oasis.opendocument.text' => 'odt',
				'audio/ogg' => 'oga',
				'video/ogg' => 'ogv',
				'image/png' => 'png',
				'application/pdf' => 'pdf',
				'application/vnd.ms-powerpoint' => 'ppt',
				'application/x-rar-compressed' => 'rar',
				'image/svg+xml' => 'svg',
				'audio/webm' => 'weba',
				'video/webm' => 'webm',
				'image/webp' => 'webp',
				'application/excel' => 'xls',
				'application/vnd.ms-excel' => 'xls',
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
				'application/xml' => 'xml',
				'application/zip' => 'zip',
				'application/x-zip' => 'zip',
				'application/x-zip-compressed' => 'zip',
				'video/3gpp' => '3gp',
				'audio/3gpp' => '3gp'
			];

			$mime_type = $arquivo["type"];
			$extensao = $mime_type_lista[$mime_type] ?? 'erro';

			if(in_array($extensao, ['jpg', 'png', 'gif'])):
				$tamanho = getimagesize($arquivo["tmp_name"]);
				if(empty($tamanho[0]) || empty($tamanho)):
					return 'erro';
				endif;
			endif;

			return $extensao;
		}
	}
