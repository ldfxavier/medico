<?php
	
	namespace System;
	use \PDO;

	final class Database {

		private $db, $banco, $estrutura, $propriedade, $tabela;

		public function __construct(){

			if(SISTEMA == 'localhost'):
				$this->banco = env('DB_BANCO');

				$this->db = new PDO('mysql:host='.env('DB_HOST').';dbname='.$this->banco, env('DB_USUARIO'), env('DB_SENHA'), [
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				]);
			endif;

		}

		public function insert($dado, $tabela){
			
			$campos_ini = [];

			if(!isset($dado['uuid'])):
				$dado['uuid'] = uuid();
			endif;
			
			if(!isset($dado['data_criacao'])):
				$dado['data_criacao'] = date('Y-m-d H:i:s');
			endif;

			
			foreach($dado as $ind => $val):
				$campos_ini[] = $ind;
			endforeach;
			
			$campos = "`".implode("`, `", $campos_ini)."`";
			$valores = ":".implode(", :", $campos_ini);
			
			$sql = $this->db->prepare("INSERT INTO `{$tabela}` ({$campos}) VALUES ({$valores})");
			
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
				ppe($sql->errorInfo());
			endif;
		}

		public function create($dado, $tabela){

			if(SISTEMA != 'localhost'):
				return false;
			endif;

			$this->estrutura = [];
			$this->propriedade = [];
			$this->tabela = $tabela;

			foreach($dado as $campo):
				if(is_array($campo)):
					$this->normal($campo);
				else:
					$this->padrao($campo);
				endif;
			endforeach;

			$this->executar_create();

		}

		private function executar_create(){

			$dado = implode(', ', array_merge($this->estrutura, $this->propriedade));

			$drop = "DROP TABLE IF EXISTS `{$this->tabela}`;";
			$query = "CREATE TABLE `{$this->tabela}` (".$dado.") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

			$sql = $this->db->prepare($drop.$query);

			$sql->execute();

			$sql = $this->db->prepare("SELECT `id` FROM `{$this->tabela}` LIMIT 0,1");
			$sql->execute();
			$erro = $sql->errorInfo()[2] ?? '';
			
			if(!empty($erro)):
				trigger_error("
					ERRO AO CRIAR TABELA {$this->tabela}.<br><br>
					".str_replace(["CREATE TABLE `{$this->tabela}` (", ') ENGINE', ','], ["CREATE TABLE `{$this->tabela}` (<br>", '<br>) ENGINE', ',<br>'], $query)."<br>
				");
				exit();
			endif;

		}


		private function padrao($campo){
			if($campo == 'id'):
				$this->estrutura[] = '`id` INT NOT NULL AUTO_INCREMENT';
				$this->propriedade[] = 'PRIMARY KEY (`id`)';
			elseif($campo == 'uuid'):
				$this->estrutura[] = '`uuid` CHAR(36) NOT NULL';
				$this->propriedade[] = 'UNIQUE KEY `uuid` (`uuid`)';
			elseif($campo == 'data_criacao'):
				$this->estrutura[] = "`data_criacao` DATETIME NOT NULL COMMENT '[Data de criação]{download}'";
			elseif($campo == 'data_atualizacao'):
				$this->estrutura[] = "`data_atualizacao` DATETIME COMMENT '[Data de atualização]{download}'";
			elseif($campo == 'status'):
				$this->estrutura[] = "`status` INT NOT NULL COMMENT '[Status]{download}'";
			endif;
		}

		private function normal($campo){
			
			$this->montar([
				'campo' => $campo['campo'] ?? '',
				'nome' => $campo['nome'] ?? '', // []
				'tipo' => $campo['tipo'] ?? '',
				'tamanho' => $campo['tamanho'] ?? '',
				'unico' => $campo['unico'] ?? '',
				'comentario' => $campo['comentario'] ?? '',
				'download' => $campo['download'] ?? '', // {}
				'validar' => $campo['validar'] ?? '', // ()
				'null' => $campo['null'] ?? '',
				'zero' => $campo['zero'] ?? ''
			]);

		}
		
		private function comentario($comentario, $nome, $download, $validar){

			$string = '';
			if(!empty($nome)):
				$string .= '['.$nome.']';
			endif;
			if($download == 1):
				$string .= '{download}';
			endif;
			if(!empty($validar)):
				$string .= '('.$validar.')';
			endif;
			if(!empty($comentario)):
				$string .= $comentario;
			endif;

			if(!empty($string)):
				$string = "COMMENT '".$string."'";
			endif;

			return $string;

		}

		private function montar($array){

			$campo = $array['campo'];
			$tipo = $array['tipo'];
			$tamanho = !empty($array['tamanho']) ? '('.$array['tamanho'].')' : '';
			$null = $array['null'] == 1 ? 'DEFAULT NULL' : 'NOT NULL';
			$comentario = $this->comentario($array['comentario'], $array['nome'], $array['download'], $array['validar']);
			$zero = $array['zero'] == 1 ? 'UNSIGNED ZEROFILL' : '';
			$unico = $array['unico'];

			if($tipo == 'nome'):
				$tipo = 'varchar';
				$tamanho = '(80)';
			elseif($tipo == 'email'):
				$tipo = 'varchar';
				$tamanho = '(100)';
			elseif($tipo == 'telefone'):
				$tipo = 'bigint';
				$tamanho = '(11)';
			elseif($tipo == 'arquivo'):
				$tipo = 'char';
				$tamanho = '(36)';
				$unico = 1;
			endif;

			$this->estrutura[] = '`'.$campo.'` '.$tipo.$tamanho.' '.$zero.' '.$null.' '.$comentario;
			if($unico == 1){
				$this->propriedade[] = 'UNIQUE KEY `'.$array['campo'].'` (`'.$array['campo'].'`)';
			}

		}

	}