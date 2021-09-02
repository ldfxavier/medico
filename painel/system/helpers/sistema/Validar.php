<?php
    class Validar {
        public static function hash($str, $array, $post){
            $hash = isset($post['hash']) ? $post['hash'] : '';
            $hash_sistema = HASH;
            $verificar = (isset($_SESSION[$str])) ? $_SESSION[$str] : '';
            $decode = base64_decode($hash);
            $explode = explode('-_-', $decode);

            foreach($array as $valor) if(!isset($post[$valor])) return false;
            if(empty($hash_sistema) || empty($decode) || empty($hash)) return false;
            if($verificar != $hash) return false;
            if(!$decode) return false;
            if(!isset($explode[0]) || !isset($explode[1]) || !isset($explode[2])) return false;
            if($explode[1] != $str || $explode[2] != $hash_sistema) return false;
            if((isset($_SERVER['HTTP_REFERER']) &&
            !stristr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']))) return false;

            return true;
        }

        /**
         * VALIDA VAZIO
         * @var $str        string          String para ser verificada
         * @var $nome       string          Nome do campo obrigatório
         * @var $titulo     string          Título da resposta
         * @var $texto      string          texto da resposta
         * @return          bollean/string  Retornar ou true e false ou Json
         */
        public static function vazio($str, $nome = null, $titulo = null, $texto = null, $return = false){
            if(empty($str) && $return == false):
                $titulo = ($titulo == null) ? 'Campo obrigatório!' : $titulo;
                if($texto == null && $nome == null) $texto = '1 ou mais campos obrigatórios não estão preenchidos.';
                elseif($nome != null) $texto = 'O campo '.$nome.' é obrigatório.';
                echo json_encode(array('erro' => true, 'titulo' => $titulo, 'texto' => $texto));
                exit();
            elseif(!empty($str)):
                return true;
            endif;
            return false;
        }

        public static function diferente($string_1, $string_2, $nome_1 = null, $nome_2 = null, $titulo = null, $texto = null, $return = false){
            if($string_1 != $string_2 && $return == false):
                $titulo = ($titulo == null) ? 'Campos diferentes!' : $titulo;
                if($texto == null && ($nome_1 == null && $nome_2 == null)) $texto = '1 ou mais campos estão preenchidos de forma incorreta.';
                elseif($nome_1 != null && $nome_2 != null) $texto = 'O campo '.$nome_1.' e '.$nome_2.' estão diferentes.';
                echo json_encode(array('erro' => true, 'titulo' => $titulo, 'texto' => $texto));
                exit();
            elseif($string_1 != $string_2):
                return true;
            endif;
            return false;
        }

        /**
         * VALIDA O TELEFONE
         * @var $telefone   string      Telefone para validar
         * @return          bollean     True ou false
         */
        public static function telefone($telefone, $titulo = null, $retorno = false){
            $telefone_verificar = preg_replace("/[^0-9]/", "", $telefone);
            $quantidade = strlen($telefone_verificar);

            if(empty($telefone_verificar)) return false;

            $erro = false;
            if($quantidade == 8 && (substr($telefone_verificar, 0, 4) == "3003" || substr($telefone_verificar, 0, 4) == "4004")) $erro = true;
            elseif($quantidade == 10) $erro = true;
            elseif($quantidade == 11 && (substr($telefone_verificar, 2, 1) == "9" || substr($telefone_verificar, 0, 4) == "0800")) $erro = true;
            else $erro = false;

            if($erro == false && $retorno == false):
                echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um valor válido.'));
                exit();
            endif;
            return $erro;
        }

        public static function senha($senha, $salt, $titulo, $retorno){
            $validar = password_verify($senha, $salt) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não está correto.'));
            exit();
        }

        public static function email($valor, $titulo = null, $retorno = false){
            $validar = filter_var($valor, FILTER_VALIDATE_EMAIL) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um valor válido.'));
            exit();
        }

        public static function int($valor, $titulo = null, $retorno = false){
            $validar = is_numeric($valor) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um valor inteiro.'));
            exit();
        }

        public static function float($valor, $titulo = null, $retorno = false){
            $validar = filter_var($valor, FILTER_VALIDATE_FLOAT) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um valor válido (0.00).'));
            exit();
        }
        public static function decimal($valor, $titulo = null, $retorno = false){
            $validar = preg_match('/^[0-9]+.[0-9]{2}$/', $valor) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um valor decimal (0.00).'));
            exit();
        }

        public static function ip($valor, $titulo = null, $retorno = false){
            $validar = filter_var($valor, FILTER_VALIDATE_IP) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' IP não é um valor válido.'));
            exit();
        }

        public static function mac($valor, $titulo = null, $retorno = false){
            $validar = filter_var($valor, FILTER_VALIDATE_MAC) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um endereço MAC válido.'));
            exit();
        }

        public static function url($valor, $titulo = null, $retorno = false){
            $validar = filter_var($valor, FILTER_VALIDATE_URL) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é uma URL válida.'));
            exit();
        }

        public static function json($valor, $titulo = null, $retorno = false){
            $validar = (is_array(json_decode($valor, true))) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um valor (array) válido.'));
            exit();
        }

        /**
         * VALIDA DATA
         * @var $data       string       Data para validar
         * @return          bollean     True ou false
         */
        public static function data($data, $titulo = null, $tipo = null, $retorno = false){
            if($tipo == 'br'):
                $validar = (preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/', $data)) ? true : false;
            elseif($tipo == 'en'):
                $validar = (preg_match('/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data)) ? true : false;
            else:
                $validar = (
                    preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/', $data) ||
                    preg_match('/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data)
                ) ? true : false;
            endif;

            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é uma data válida.'));
            exit();
        }

        /**
         * VALIDA HORA
         * @var $hora       string      Hora para validar
         * @return          bollean     True ou false
         */
        public static function hora($data, $titulo = null, $retorno = false){
            $validar = (preg_match("/^([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data)) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é uma hora válida.'));
            exit();
        }

        /**
         * VALIDA DATA E HORA
         * @var $data       string      Data e hora para validar
         * @return          bollean     True ou false
         */
        public static function datahora($data, $titulo = null, $tipo = null, $retorno = false){
            if($tipo == 'br'):
                $validar = (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data)) ? true : false;
            elseif($tipo == 'en'):
                $validar = (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data)) ? true : false;
            else:
                $validar = (
                    preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data) || preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data)
                ) ? true : false;
            endif;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é uma data/hora válida.'));
            exit();
        }

        /**
         * VALIDA CEP
         * @var $cep        int/string  Cep para validar
         * @return          bollean     True ou false
         */
        public static function cep($cep, $titulo = null, $retorno = false){
            $validar = (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $cep)) ? true : false;
            if($retorno || $validar) return $validar;
            echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um CEP válido.'));
            exit();
        }

        /**
         * VALIDA DOCUMENTO
         * @var $documento  int         Documento para validar
         * @var $tipo       string      auto, cpf ou cnpj
         * @return          bollean     True ou false
         */
        public static function documento($documento, $titulo = null, $tipo = 'auto', $retorno = false){
            $documento_verificar = preg_replace("/[^0-9]/", "", $documento);
            $quantidade = strlen($documento_verificar);
            $erro = false;

			if(in_array($documento_verificar, array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888','99999999999'))):
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
				if ($dv == $dv_informado) $erro = true;
                else $erro = false;
            elseif($quantidade == 14 && ($tipo == 'auto' || $tipo == 'cnpj')):
                $cnpj = $documento_verificar;
                $cnpj_original = $documento_verificar;
                $primeiros_numeros_cnpj = substr($cnpj, 0, 12);
                if (!function_exists('multiplica_cnpj')):
                    function multiplica_cnpj( $cnpj, $posicao = 5 ) {
                        $calculo = 0;
                        for( $i = 0; $i < strlen( $cnpj ); $i++ ):
                           $calculo = $calculo + ( $cnpj[$i] * $posicao );
                           $posicao--;
                           if($posicao < 2)$posicao = 9;
                       endfor;
                       return $calculo;
                   }
                endif;
                $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
                $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
                $primeiros_numeros_cnpj .= $primeiro_digito;
                $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
                $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
                $cnpj = $primeiros_numeros_cnpj . $segundo_digito;
                if ($cnpj === $cnpj_original) $erro = true;
                else $erro = false;
            endif;

            if($erro == false && $retorno == false):
                $tipo = ($tipo == 'auto') ? 'documento' : Converter::caixa($tipo, 'A');
                echo json_encode(array('erro' => true, 'titulo' => 'Campo incorreto!', 'texto' => 'O campo '.$titulo.' não é um '.$tipo.' válido.'));
                exit();
            endif;
            return $erro;
        }

    }
