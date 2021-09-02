<?php
	namespace Tdd;
	use \System\Model;
	
	abstract class TDD extends Model {
		protected $mensagem = [];
		public function __construct(String $tabela = ''){
			if(!empty($tabela)):
				parent::__construct($tabela);
			endif;
		}

		protected function assert($nome, $resultado, $esperado, $teste){
			$status = $resultado === $esperado;
			$retorno = '';
			if(!empty($teste) && !$status):
				$retorno = is_array($teste) || is_object($teste) ? json_encode($teste) : $teste;
			endif;
			if($resultado === false):
				$resultado = 'false';
			elseif($resultado === true):
				$resultado = 'true';
			elseif(is_array($resultado)):
				$resultado = json_encode($resultado);
			endif;
			if($esperado === false):
				$esperado = 'false';
			elseif($esperado === true):
				$esperado = 'true';
			elseif(is_array($esperado)):
				$esperado = json_encode($esperado);
			endif;
			$this->mensagem[] = [$status, ucfirst(mb_strtolower(str_replace(['assert_', '_'], ['', ' '], $nome), 'UTF-8')).'.', $resultado, $esperado, $retorno];

			return false;
		}
		protected function assert_string($nome, $resultado, $esperado, $teste){
			$resultado = is_string($resultado) ? $resultado : 'Resultado não é uma string';
			$esperado = is_string($esperado) ? $esperado : 'Valor esperado não é uma string';
			$this->assert($nome, $resultado, $esperado, $teste);
			return false;
		}
		protected function assert_int($nome, $resultado, $esperado, $teste){
			$resultado = is_int($resultado) ? $resultado : 'Resultado não é um inteiro';
			$esperado = is_int($esperado) ? $esperado : 'Valor esperado não é um inteiro';
			$this->assert($nome, $resultado, $esperado, $teste);
			return false;
		}
		protected function assert_bool($nome, $resultado, $esperado, $teste){
			$resultado = is_bool($resultado) ? $resultado : 'Resultado não é um booleano';
			$esperado = is_bool($esperado) ? $esperado : 'Valor esperado não é um booleano';
			$this->assert($nome, $resultado, $esperado, $teste);
			return false;
		}
		protected function assert_array($nome, $resultado, $esperado, $teste){
			$resultado = is_array($resultado) ? $resultado : 'Resultado não é um array';
			$esperado = is_array($esperado) ? $esperado : 'Valor esperado não é um array';
			$this->assert($nome, $resultado, $esperado, $teste);
			return false;
		}
		protected function assert_float($nome, $resultado, $esperado, $teste){
			$resultado = is_float($resultado) ? $resultado : 'Resultado não é um float';
			$esperado = is_float($esperado) ? $esperado : 'Valor esperado não é um float';
			$this->assert($nome, $resultado, $esperado, $teste);
			return false;
		}
		protected function assert_null($nome, $resultado, $esperado, $teste){
			$resultado = is_null($resultado) ? $resultado : 'Resultado não é um NULL';
			$esperado = is_null($esperado) ? $esperado : 'Valor esperado não é um NULL';
			$this->assert($nome, $resultado, $esperado, $teste);
			return false;
		}

		protected function validar_campo_tabela(Array $dado) {
			$coluna = $this->pegar_coluna_banco();
			foreach($dado as $ind => $val):
				if(!isset($coluna[$ind])):
					$this->assert('Coluna <b>'.$ind.'</b> existe no banco', $ind, '', [$ind => '']);
				else:
					$this->assert('Coluna <b>'.$ind.'</b> existe no banco', $ind, $ind, [$ind => $ind]);
					
					$campo = $coluna[$ind];
					$validar_retorno = [];
					if(!empty($campo->validar) && is_array($campo->validar)):
						asort($campo->validar);
						$validar_retorno[] = $campo->validar;
					endif;
					if(!empty($val[3]) && is_array($val[3])):
						asort($val[3]);
						$validar_retorno[] = $val[3];
					endif;
					$validar_retorno = !empty($validar_retorno) ? json_encode($validar_retorno) : '';

					$this->assert_string('Validar tipo do campo <b>'.$ind.'</b>', $campo->tipo, $val[0], $campo->tipo.' != '.$val[0]);
					$this->assert_int('Validar tamanho do campo <b>'.$ind.'</b>', $campo->tamanho, $val[1], $campo->tamanho.' != '.$val[1]);
					$this->assert_bool('Validar obrigatório do campo <b>'.$ind.'</b>', $campo->obrigatorio, $val[2], $campo->obrigatorio.' != '.$val[2]);
					$this->assert_array('Validar validação do campo <b>'.$ind.'</b>', $campo->validar, $val[3], $validar_retorno);
					$this->assert_bool('Validar download do campo <b>'.$ind.'</b>', $campo->download, $val[4], $campo->download.' != '.$val[4]);
					$this->assert_string('Validar título do campo <b>'.$ind.'</b>', $campo->titulo, $val[5], $campo->titulo.' != '.$val[5]);
				endif;
			endforeach;
			return $this;
		}

		protected function pegar_teste(Array $metodo): Array {
			$array = [];
			foreach($metodo as $teste):
				if(substr($teste, 0, 7) == 'assert_' && !in_array($teste, ['assert_string', 'assert_int', 'assert_bool', 'assert_array', 'assert_float', 'assert_null'])):
					$array[] = $teste;
				endif;
			endforeach;
			return $array;
		}
	}