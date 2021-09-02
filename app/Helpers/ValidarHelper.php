<?php
    namespace App\Helpers;

    final class Validar {

		private $par = ['valor', 'campo', 'mensagem', 'erro_status', 'erro_codigo', 'erro'];

		/**
		 * CONSTRUTOR DA CLASS
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function __construct(){
			$this->erro = false;
			$this->erro_codigo = 0;
			$this->erro_status = 200;
		}
		// Método mágico padrão __get
		public function __get(String $par){
			if(in_array($par, $this->par)):
				return $this->$par;
			endif;
			return NULL;
		}
		// Método mágico padrão __set
		public function __set(String $par, $val){
			if(in_array($par, $this->par)):
				return $this->$par = $val;
			endif;
		}

		/**
		 * PEGA O RETORNO DO ERRO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @return Array :Array com a mensagem de erro
		**/
		public function erro(): Array {
			if($this->erro):

				$mensagem = Mensagem_codigo($this->erro_codigo, $this->campo, 400);

				if(!empty($this->mensagem)):
					$mensagem['texto'] = $this->mensagem;
				endif;

				return $mensagem;
			endif;
			return [];
		}
		/**
		 * PEGA O RETORNO EM BOOLEAN
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @return Bool :True para erro ou False para correto
		**/
		public function b(): Bool {
			return (true === $this->erro) ? false : true;
		}

		/**
		 * SETA O VALORES PARA VALIDAR
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param String $valor :Valor a ser tratado
		 * @param String $campo :Nome do campo a ser tratado
		 * @param String $mensagem :Seta a mensagem de erro
		 * @return this :Retorna o próprio método
		**/
        public function valor($valor, String $campo = null, String $mensagem = null) {
			if($this->erro):
				return $this;
			endif;

			$this->valor = $valor;
			$this->campo = !empty($campo) ? $campo : '';
			$this->mensagem = !empty($mensagem) ? $mensagem : '';

			return $this;
		}

		/**
		 * SETA O ERRO E A MENSAGEM PARA O RETORNO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param Int $codigo :Código da mensagem de erro
		 * @param String $mensagem :Mensagem de erro
		 * @return Bool :Retorna sempre true
		**/
		private function set_erro(Int $codigo): Bool {
			$this->erro = true;
			$this->erro_codigo = $codigo;

			return true;
		}

		/**
		 * VALIDA SE O VALOR ESTÁ VAZIO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function vazio(){
			if($this->erro):
				return $this;
			endif;

			if(false === $this->valor):
				return $this;
			elseif(empty($this->valor)):
				$this->set_erro(900);
			endif;
			return $this;
		}

		/**
		 * APENAS OS VALORES DO ARRAY
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param Array $array :Array para comparar
		**/
		public function diff($array){
			if($this->erro):
				return $this;
			endif;

			$diff = array_diff(array_keys($this->valor), $array);
			if($diff):
				$this->campo = implode(', ', $diff);
				$this->set_erro(920);
			endif;
			return $this;
		}

		/**
		 * VALIDA SE EXISTE O VALOR
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function obrigatorio(){
			if($this->erro):
				return $this;
			endif;

			if(false === $this->valor):
				$this->set_erro(919);
			endif;
			return $this;
		}

		/**
		 *  VALIDA SE O VALOR É INTEIRO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function int(){
			$this->is_int();
			return $this;
		}
		public function inteiro(){
			$this->is_int();
			return $this;
		}
		public function is_int(){
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !filter_var($valor, FILTER_VALIDATE_INT)):
				$this->set_erro(901);
			endif;

			return $this;
		}
		/**
		 *  VALIDA SE O VALOR É DECIMAL (10,2)
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function decimal(){
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !preg_match("/^[0-9]*\.[0-9]{2}$/", $valor)):
				$this->set_erro(902);
			endif;

			return $this;
		}
		/**
		 *  VALIDA SE O VALOR É UM FLOAT
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function float(){
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && (!filter_var($valor, FILTER_VALIDATE_FLOAT) || !strstr($valor, '.') || substr($valor, -1) == '.')):
				$this->set_erro(903);
			endif;

			return $this;
		}

		/**
		 * VALIDA O TAMANHO MAXIMO PASSADO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function tamanho(String $operador, Int $tamanho){
			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(is_int($valor) || is_float($valor)):
				$strlen = $valor;
			elseif(is_string($valor)):
				$strlen = mb_strlen($valor, 'UTF-8');
			elseif(is_array($valor)):
				$strlen = count($valor);
			elseif(is_object($valor)):
				$strlen = count((Array)$valor);
			endif;

			if(!empty($valor) && (
				!in_array($operador, ['>=', '>', '=', '==', '!=', '<=', '<']) ||
				($operador == '>=' && $strlen < $tamanho) ||
				($operador == '>' && $strlen <= $tamanho) ||
				(in_array($operador, ['=', '==']) && $strlen != $tamanho) ||
				($operador == '!=' && $strlen == $tamanho) ||
				($operador == '<=' && $strlen > $tamanho) ||
				($operador == '<' && $strlen >= $tamanho)
			)):
				$this->set_erro(907);
			endif;

			return $this;
		}

		/**
		 * VALIDA EXISTE O VALOR NO ARRAY
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param Array $array :Array com a lista permitida
		**/
		public function in_array(Array $array){
			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !in_array($valor, $array)):
				$this->set_erro(905);
			endif;

			return $this;
		}
		/**
		 * VALIDA EXISTE O VALOR NO ARRAY
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param Array $array :Array com a lista permitida
		**/
		public function array(){
			$this->is_array();
			return $this;
		}
		public function is_array(){
			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !is_array($valor)):
				$this->set_erro(910);
			endif;

			return $this;
		}

		/**
		 * VALIDA VALIDA PARA VER SE É NUMERICO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function numero(){
			$this->is_numeric();
			return $this;
		}
		public function numeric(){
			$this->is_numeric();
			return $this;
		}
		public function is_numeric(){
			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !is_numeric($valor)):
				$this->set_erro(904);
			endif;

			return $this;
		}
		/**
		 * VALIDA VALIDA PARA VER SE É STRING
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function texto(){
			$this->is_string();
			return $this;
		}
		public function string(){
			$this->is_string();
			return $this;
		}
		public function is_string(){
			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && (!is_string($valor) || is_numeric($valor))):
				$this->set_erro(922);
			endif;

			return $this;
		}

		/**
		 * VALIDA VALIDA PARA VER SE É OBJECT
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function object(){
			$this->is_object();
			return $this;
		}
		public function objeto(){
			$this->is_object();
			return $this;
		}
		public function is_object(){
			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !is_object($valor)):
				$this->set_erro(923);
			endif;

			return $this;
		}

		/**
		 * VALIDA O TELEFONE
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function telefone(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			if(!is_string($this->valor) && !is_numeric($this->valor)):
				$this->set_erro(908);
				return $this;
			endif;

			$valor = preg_replace("/[^0-9]/", "", $this->valor);
			$strlen = mb_strlen($valor, 'UTF-8');
			if(
				($strlen == 8 && in_array(substr($valor, 0, 4), ["4004", "4003", "3003"])) ||
				($strlen == 11 && (in_array(substr($valor, 0, 4), ["0800", "0300"]) || substr($valor, 2, 1) == 9)) ||
				($strlen == 10 && substr($valor, 2, 1) != 9)
			):
				return $this;
			endif;

			$this->set_erro(908);
			return $this;
		}

		/**
		 * VALIDA O EMAIL
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function email(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !filter_var($valor, FILTER_VALIDATE_EMAIL)):
				$this->set_erro(909);
			endif;
			return $this;
		}

		/**
		 * VALIDA O EMAIL
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function senha(String $salt){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !password_verify($valor, $salt)):
				$this->set_erro(911);
			endif;

			return $this;
		}

		/**
		 * VALIDA SE O VALOR É IGUAL
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function igual($comparacao){

			// Valida se já existe um erro
			if($this->erro):
				return $this;
			endif;

			$valor = $this->valor;
			if($valor != $comparacao):
				$this->set_erro(912);
			endif;

			return $this;
		}

		/**
		 * VALIDA SE O VALOR É BOOLEANO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function booleano(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;


			if(
				!empty($valor) &&
				(
					(true !== $valor && 'true' != $valor) &&
					(false !== $valor && 'false' != $valor) &&
					(!is_numeric($valor) || !in_array($valor, [0,1]))
				)
			):
				$this->set_erro(921);
			endif;

			return $this;
		}

		/**
		 * VALIDA SE O VALOR É DIFERÊNTE
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function diferente($comparacao){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;

			if(!empty($valor) && $valor == $comparacao):
				$this->set_erro(913);
			endif;

			return $this;
		}

		/**
		 * VALIDA SE O VALOR É UM JSON
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function json(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !is_array(json_decode($valor, true))):
				$this->set_erro(914);
			endif;

			return $this;
		}

		/**
		 * VALIDA SE O VALOR E UMA DATA PADRÃO EUA
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function date(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !preg_match('/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $valor)):
				$this->set_erro(915);
			endif;

			return $this;
		}
		/**
		 * VALIDA SE O VALOR E UMA DATA PADRÃO BR
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function data(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/', $valor)):
				$this->set_erro(915);
			endif;

			return $this;
		}
		/**
		 * VALIDA SE O VALOR E UMA DATA E HORA PADRÃO EUA
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function datetime(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $valor)):
				$this->set_erro(915);
			endif;

			return $this;
		}
		/**
		 * VALIDA SE O VALOR E UMA DATA E HORA PADRÃO BR
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function datahora(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && !preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $valor)):
				$this->set_erro(915);
			endif;

			return $this;
		}

		/**
		 * VALIDA SE O VALOR É UM CPF OU CPNJ VÁLIDO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param String $tipo :cpf para CPF, cnpj para CNPJ ou auto
		**/
		public function cpf(){

			$this->documento('cpf');
			return $this;

		}
		public function cnpj(){

			$this->documento('cnpj');
			return $this;

		}
		public function documento(String $tipo = 'auto'){

			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$documento_verificar = preg_replace("/[^0-9]/", "", $this->valor);
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
			elseif(!empty($this->_valor)):
				$erro = false;
            endif;

			if($erro === false):
				$this->set_erro(916);
			endif;

			return $this;
		}
		/**
		 * METODO PRIVADO PARA CALCULAR O CNPJ
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		 * @param String $cnpj :CNPJ para validar
		 * @param Int $posicao :Posição para multiplicar
		 * @return Int :O valor do calculo
		**/
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

		/**
		 * VALIDA SE O VALOR É POSITIVO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function positivo(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && is_numeric($valor) && $valor < 0):
				$this->set_erro(917);
			endif;

			return $this;
		}
		/**
		 * VALIDA SE O VALOR É NEGATIVO
		 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
		 * @version 1.0.0
		**/
		public function negativo(){
			// Valida se já existe um erro
			if($this->erro || empty($this->valor)):
				return $this;
			endif;

			$valor = $this->valor;
			if(!empty($valor) && is_numeric($valor) && $valor >= 0):
				$this->set_erro(918);
			endif;

			return $this;
		}


    }
