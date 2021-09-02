<?php
	
	namespace App\Helpers;

	final class Converter {

		private $retorno = '';

		public function __construct($valor = null){
			if(!empty($valor)) $this->retorno = $valor;
		}

		public function __toString(){
			$retorno = (string)$this->retorno;
			$this->retorno = '';

			if(!empty($retorno)) return $retorno;
			return '';
		}

		public function r(){
			$retorno = $this->retorno;
			$this->retorno = '';
			return $retorno;
		}

		public function valor($valor){
			$this->retorno = $valor;
			return $this;
		}

		private function validar($valor = null){
			if(!is_null($valor)):
				$this->retorno = $valor;
			endif;

			if(empty($this->retorno)):
				$this->retorno = null;
				return false;
			endif;
			return true;
		}

		public function estado($valor = null){
			if(!$this->validar($valor)):
				return $this;
			endif;

			$Lista = new Lista;
			$tamanho = strlen($this->retorno);
			if($tamanho == 2):
				$estado = $Lista->estado(false)->lista;
				$this->retorno = $this->caixa('A', $this->retorno)->r();
			else:
				$estado = $Lista->estado(false)->lista;
				if(is_array($estado) && $estado) $estado = array_flip($estado);
				$this->retorno = $this->caixa('Aa Aa', $this->retorno)->r();
			endif;

			$this->retorno = isset($estado[$this->retorno]) ? $estado[$this->retorno] : null;

			return $this;
		}

		public function remover_acento($slug = '-', $valor = null) {
			if(!$this->validar($valor)):
				return $this;
			endif;
			$valor = $this->retorno;

			$valor = preg_replace('/[áàãâä]/ui', 'a', $valor);
			$valor = preg_replace('/[éèêë]/ui', 'e', $valor);
			$valor = preg_replace('/[íìîï]/ui', 'i', $valor);
			$valor = preg_replace('/[óòõôö]/ui', 'o', $valor);
			$valor = preg_replace('/[úùûü]/ui', 'u', $valor);
			$valor = preg_replace('/[ç]/ui', 'c', $valor);
			$valor = trim(preg_replace('/[^a-z0-9]/i', ' ', $valor));
			if(!empty($slug)):
				$valor = preg_replace('/[^a-z0-9]/i', $slug, $valor);
				$valor = preg_replace('/'.$slug.'+/', $slug, $valor);
			endif;

			$this->retorno = $valor;
			return $this;
		}

		public function iframe_video($link){
			$link = $this->caixa('a', $link)->r();
			if(strstr($link, 'youtube')):
				$explode = explode('v=', $link);
				return '<iframe src="https://www.youtube.com/embed/'.end($explode).'?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
			elseif(strstr($link, 'vimeo')):
				$explode = explode('/', $link);
				return '<iframe src="https://player.vimeo.com/video/'.end($explode).'?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			endif;
			return false;
		}

		public function cortar_string($tamanho, $simbolo = '...', $forca = false, $valor = null){
			if(!$this->validar($valor)) return $this;
			$valor = $this->retorno;

			if(strlen($valor) > $tamanho && $forca == true) $valor = substr($valor, 0, $tamanho).$simbolo;
			elseif(strlen($valor) > $tamanho) $valor = substr($valor, 0, strrpos(substr($valor, 0, $tamanho), ' ')).$simbolo;

			$this->retorno = $valor;

			return $this;
		}

		public function caixa($tipo = 'A', $valor = null){
			if(!$this->validar($valor)) return $this;

			if($tipo == "A") $this->retorno = mb_strtoupper($this->retorno, 'UTF-8');
			elseif($tipo == "a") $this->retorno = mb_strtolower($this->retorno, 'UTF-8');
			elseif($tipo == "Aa") $this->retorno = ucfirst(mb_strtolower($this->retorno, 'UTF-8'));
			elseif($tipo == "Aa Aa") $this->retorno = ucwords(mb_strtolower($this->retorno, 'UTF-8'));

			return $this;
		}

		public function documento($valor = null){
			if(!$this->validar($valor)):
				return $this;
			endif;

			$valor = preg_replace("/[^0-9]/", "", $this->retorno);
			if(!empty($valor) && strlen($valor) == 11):
				$valor = substr($valor, 0, 3).'.'.substr($valor, 3, 3).'.'.substr($valor, 6, 3).'-'.substr($valor, 9, 2);
			elseif(!empty($valor) && strlen($valor) == 14):
				$valor = substr($valor, 0, 2).'.'.substr($valor, 2, 3).'.'.substr($valor, 5, 3).'/'.substr($valor, 8, 4).'-'.substr($valor, 12, 2);
			endif;
			$this->retorno = $valor;

			return $this;
		}
		public function cpf($valor = null){
			if(!$this->validar($valor)):
				return $this;
			endif;

			$valor = preg_replace("/[^0-9]/", "", $this->retorno);
			if(!empty($valor) && strlen($valor) == 11):
				$valor = substr($valor, 0, 3).'.'.substr($valor, 3, 3).'.'.substr($valor, 6, 3).'-'.substr($valor, 9, 2);
			endif;
			$this->retorno = $valor;

			return $this;
		}
		public function cnpj($valor = null){
			if(!$this->validar($valor)):
				return $this;
			endif;

			$valor = preg_replace("/[^0-9]/", "", $this->retorno);
			if(!empty($valor) && strlen($valor) == 14):
				$valor = substr($valor, 0, 2).'.'.substr($valor, 2, 3).'.'.substr($valor, 5, 3).'/'.substr($valor, 8, 4).'-'.substr($valor, 12, 2);
			endif;
			$this->retorno = $valor;

			return $this;
		}

		public function so_numero($valor = null){
			if(!$this->validar($valor)):
				return $this;
			endif;

			$this->retorno = preg_replace("/[^0-9]/", "", $this->retorno);
			return $this;
		}

		public function decimal($numero){
			if(is_numeric(preg_replace("/[^0-9]/", "", $numero))):
				if(substr_count($numero, ',') == 1 && strlen($numero)-strripos($numero, ',') == 3):
					return number_format(str_replace(array('.', ','), array('', '.'), $numero), 2, '.', '');
				else:
					return number_format(str_replace(',', '', $numero), 2, '.', '');
				endif;
			endif;
			return $numero;
		}

		public function telefone($padrao = null, $valor = null){
			if(!$this->validar($valor)):
				return $this;
			endif;

			$numero = preg_replace("/[^0-9]/", "", $this->retorno);
			$quantidade = strlen($numero);

			if($padrao != null):
				$padrao_quant = strlen($padrao);
				$numero_i = 0;
				$numero_final = '';
				for($i=0;$i<$padrao_quant; $i++):
					if($padrao[$i] == 'x'):
						$numero_final .= $numero[$numero_i];
						$numero_i++;
					else:
						$numero_final .= $padrao[$i];
					endif;
				endfor;
				$this->retorno = $numero_final;
			elseif($quantidade == 8 && (substr($numero, 0, 4) == "3003" || substr($numero, 0, 4) == "4004")):
				$this->retorno = substr($numero, 0, 4).'-'.substr($numero, 4, 4);
			elseif($quantidade == 10):
				$this->retorno = '('.substr($numero, 0, 2).') '.substr($numero, 2, 4).'-'.substr($numero, 6, 4);
			elseif($quantidade == 11 && (substr($numero, 2, 1) == "9")):
				$this->retorno = '('.substr($numero, 0, 2).') '.substr($numero, 2, 5).'-'.substr($numero, 7, 4);
			elseif(substr($numero, 0, 4) == "0800"):
				$this->retorno = substr($numero, 0, 4).' '.substr($numero, 4, 3).' '.substr($numero, 7, 4);
			endif;

			return $this;

		}

		public function dinheiro($tipo = 'R$', $valor = null){
			if(!$this->validar($valor)) return $this;

			$valor = $this->retorno;
			$real = preg_replace("/[^0-9]/", "", substr($valor, 0, -3));
			$separador = substr($valor, -3, 1);
			$centavo = substr($valor, -2, 2);

			if(!in_array($separador, ['.', ','])):
				$this->retorno = '';
				return $this;
			endif;
			if(!is_numeric($centavo)):
				$this->retorno = '';
				return $this;
			endif;

			if(in_array($tipo, ['R$', 'r$'])):
				$this->retorno = number_format($real.'.'.$centavo, 2, ',', '.');
			elseif(in_array($tipo, ['U$', 'u$', '$'])):
				$this->retorno = number_format($real.'.'.$centavo, 2, '.', '');
			endif;

			return $this;
		}

		public function cep($valor = null){
			if(!$this->validar($valor)) return $this;

			$valor = preg_replace("/[^0-9]/", "", $this->retorno);
			if(strlen($valor) == 8) $this->retorno = substr($valor, 0, 5).'-'.substr($valor, 5, 3);
			else $this->retorno = '';

			return $this;
		}

		public function json($json){
			$json = json_decode($json, true);
			if(is_array($json)):
				$json = array_filter($json);
				if(!empty($json)):
					return $json;
				endif;
			endif;
			return [];
		}

        public function porcentagem($total, $valor, $tipo = true){
            if($valor == 0 || $total == 0) return 0;
            if($tipo) return round((($valor * 100) / $total), 2);
            else return round((($valor * $total) / 100), 2);
        }


	}
