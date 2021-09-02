<?php
	class P {
		/**
         * FILTRO PARA ISSET
        **/
        public static function filtro($valor, $resposta, $caixa = 'A'){
            if(is_array($valor)) $valor = (isset($valor[0]) && !empty($valor[0])) ? $valor[0] : $resposta;
            else $valor = (!empty($valor)) ? $valor : $resposta;
            return Converter::caixa($valor, $caixa);
        }

		/**
		 * IMPRIMEM VALOR DO R
		**/
		public static function r($dados, $campo, $padrao = ''){
			if($dados && !empty($campo)):
				$explode = explode('->', $campo);
				$valor = $dados;
				foreach($explode as $linha):
					$valor = $valor->$linha;
				endforeach;
				return $valor;
			endif;
			return $padrao;
		}
	}
