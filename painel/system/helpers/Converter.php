<?php
    final class Converter {

        /**
         * LISTA DOS ESTADOS BRASILEIROS
        **/
        public static function estado($sigla, $caixa = false){
            $sigla = Converter::caixa($sigla, 'a');
            $siglas = Lista::estado(null, $caixa);
            if(isset($siglas[$sigla])) return $siglas[$sigla];
        }

        /**
    	 * REMOVE TODOS OS CARACTERES, ACENTOS, ESPAÇOS E AFINS
    	**/
        public static function acento($string, $slug = false) {
            $string = utf8_decode(Converter::caixa($string, 'a'));
            // Código ASCII das vogais
            $ascii['a'] = range(224, 230);
            $ascii['e'] = range(232, 235);
            $ascii['i'] = range(236, 239);
            $ascii['o'] = array_merge(range(242, 246), array(240, 248));
            $ascii['u'] = range(249, 252);
            // Código ASCII dos outros caracteres
            $ascii['b'] = array(223);
            $ascii['c'] = array(231);
            $ascii['d'] = array(208);
            $ascii['n'] = array(241);
            $ascii['y'] = array(253, 255);

            foreach ($ascii as $key=>$item):
                $acentos = '';
                foreach ($item AS $codigo) $acentos .= chr($codigo);
                $troca[$key] = '/['.$acentos.']/i';
            endforeach;
            $string = preg_replace(array_values($troca), array_keys($troca), $string);
            // Slug?
            if($slug):
                // Troca tudo que não for letra ou número por um caractere ($slug)
                $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
                // Tira os caracteres ($slug) repetidos
                $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
                $string = trim($string, $slug);
            endif;
            return $string;
        }

        public static function porcentagem($total, $valor, $tipo = true){
            if($valor == 0) return 0;
            if($tipo) return round((($valor * 100) / $total), 2);
            else return round((($valor * $total) / 100), 2);
        }

        /**
         * RETONA O NOME DO MES
        **/
        public static function mes($mes){
            $lista = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            return $lista[(int)$mes-1];
        }
        public static function semana($semana){
            $lista = ['Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado'];
            return $lista[$semana];
        }
        public static function dia($dia, $tipo = 'simples'){
            if($tipo == 'completo') $lista = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'];
            else $lista = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'];
            $retorno = isset($lista[(int)$dia-1]) ? $lista[(int)$dia-1] : '';

            return (is_numeric($tipo) && !empty($retorno)) ? substr($retorno, 0, $tipo) : $retorno;
        }

        /**
         * CONVERTE O ID DO VÍDEO EM IFRAME
        **/
        public static function video($video){
            $link = Converter::caixa($video, 'a');
            if(strstr($link, 'youtube')):
                $explode = explode('v=', $video);
                return '<iframe src="https://www.youtube.com/embed/'.end($explode).'" frameborder="0" allowfullscreen></iframe>';
            elseif(strstr($link, 'vimeo')):
                $explode = explode('/', $video);
                return '<iframe src="https://player.vimeo.com/video/'.end($explode).'?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            endif;
        }

        /**
         * CONTA O TEXTO
        **/
        public static function limite($str, $tamanho, $simbolo = '...', $forca = false){
    	    if(strlen($str) > $tamanho && $forca == true) return substr($str, 0, $tamanho).$simbolo;
    		elseif(strlen($str) > $tamanho) return substr($str, 0, strrpos(substr($str, 0, $tamanho), ' ')).$simbolo;
    		else return $str;
    	}

        /**
    	 * CONVERTE O TEXTO NA CAIXA PASSADA
    	 */
    	public static function caixa($string, $tipo){
            if($tipo == "A") return mb_strtoupper($string, 'UTF-8');
    		elseif($tipo == "a") return mb_strtolower($string, 'UTF-8');
    		elseif($tipo == "Aa") return ucfirst(mb_strtolower($string, 'UTF-8'));
    	}

        /**
         * CONVERTE CPF OU CNPJ PARA VERSÃO COM PONTOS
         */
        public static function documento($str){
            $str = preg_replace("/[^0-9]/","", $str);
			if(in_array($str, array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888','99999999999'))) return '';
            elseif(!empty($str) && strlen($str) == 11) return substr($str, 0, 3).'.'.substr($str, 3, 3).'.'.substr($str, 6, 3).'-'.substr($str, 9, 2);
            elseif(!empty($str) && strlen($str) == 14) return substr($str, 0, 2).'.'.substr($str, 2, 3).'.'.substr($str, 5, 3).'/'.substr($str, 8, 4).'-'.substr($str, 12, 2);
            else return $str;
        }

        /**
         * RETORNA STRING COM APENAS NÚMEROS
        **/
        public static function sonumeros($numero){
            return preg_replace("/[^0-9]/", "", $numero);
        }

        /**
         * CONVERTE TELEFONE
        **/
        public static function telefone($telefone, $padrao = null){
            $numero = preg_replace("/[^0-9]/", "", $telefone);
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
                return $numero_final;
            elseif($quantidade == 8 && (substr($numero, 0, 4) == "3003" || substr($numero, 0, 4) == "4004")):
                return substr($numero, 0, 4).'-'.substr($numero, 4, 4);
            elseif($quantidade == 10):
                return '('.substr($numero, 0, 2).') '.substr($numero, 2, 4).'-'.substr($numero, 6, 4);
            elseif($quantidade == 11 && (substr($numero, 2, 1) == "9")):
                return '('.substr($numero, 0, 2).') '.substr($numero, 2, 5).'-'.substr($numero, 7, 4);
            elseif(substr($numero, 0, 4) == "0800"):
                return substr($numero, 0, 4).' '.substr($numero, 4, 3).' '.substr($numero, 7, 4);
            else:
                return $telefone;
            endif;
        }

        /**
         * CONVERTE DECIMAL EM MOEDA
        **/
        public static function dinheiro($numero){
            return number_format($numero, 2, ',', '.');
        }

        /**
         * CONVERTE NÚMERO PARA DECIMAL
        **/
        public static function decimal($numero){
            if(is_numeric(preg_replace("/[^0-9]/", "", $numero))):
                if(substr_count($numero, ',') == 1 && strlen($numero)-strripos($numero, ',') == 3) return number_format(str_replace(array('.', ','), array('', '.'), $numero), 2, '.', '');
                else return number_format(str_replace(',', '', $numero), 2, '.', '');
            endif;
            return $numero;
        }

        /**
         * CONVERTE CEP
        **/
        public static function cep($string){
            $cep = preg_replace("/[^0-9]/", "", $string);
            if(strlen($cep) == 8) return substr($cep, 0, 5).'-'.substr($cep, 5, 3);
            else return $string;
        }

        /**
         * CONVERTE A DATA PARA O PADRAO ENVIADO
         */
        public static function data($data, $modelo = 'd/m/Y H:i:s'){
            if(empty($data) || preg_replace("/[^0-9]/", "", $data) == '00000000' || preg_replace("/[^0-9]/", "", $data) == '00000000000000'):
                return '';
            else:
                return date($modelo, strtotime(str_replace('/', '-', $data)));
            endif;
        }

        public static function aniversario($data, $ano = null){
            $ano = $ano != null ? $ano : date('Y');
            $data = date('Y', strtotime(str_replace('/', '-', $data)));
            return $ano-$data;

        }

        /**
         * RETONAR A DIFERENCA ENTRE DUAS DATAS
        **/
        public static function tempo($data_inicial, $data_final, $retorno = null, $vazio = false){
            $data_inicial_2 = new DateTime($data_inicial);
            $data_final_2 = new DateTime($data_final);
            $intervalo = $data_inicial_2->diff($data_final_2);

            if($retorno == 's'):
                $retorno = ($intervalo->d*86400) + ($intervalo->h*3600) + ($intervalo->i*60) + $intervalo->s;
            elseif($retorno == 'i'):
                $retorno = round(($intervalo->d*1440) + ($intervalo->h*60) + $intervalo->i + ($intervalo->s/60), 2);
            elseif($retorno == 'h'):
                $retorno = round(($intervalo->d*24) + $intervalo->h + ($intervalo->i/60) + ($intervalo->s/3600), 2);
            elseif($retorno == 'd'):
                $retorno = (int)floor((strtotime($data_final)-strtotime($data_inicial)) / (60 * 60 * 24));
            elseif($retorno == 'nome'):
                $retorno = array();
                if($intervalo->y > 0 || $vazio):
                    $retorno['ano(s)'] = $intervalo->y;
                endif;
                if($intervalo->m > 0 || $vazio):
                    $retorno['mês(s)'] = $intervalo->m;
                endif;
                if($intervalo->d > 0 || $vazio):
                    $retorno['dia(s)'] = $intervalo->d;
                endif;
                if($intervalo->h > 0 || $vazio):
                    $retorno['hora(s)'] = $intervalo->h;
                endif;
                if($intervalo->i > 0 || $vazio):
                    $retorno['minuto(s)'] = $intervalo->i;
                endif;
                if($intervalo->s > 0 || $vazio):
                    $retorno['segundo(s)'] = $intervalo->s;
                endif;
            elseif($retorno == 'sigla'):
                $retorno = array();
                if($intervalo->y > 0 || $vazio):
                    $retorno['ano'] = $intervalo->y;
                endif;
                if($intervalo->m > 0 || $vazio):
                    $retorno['mês'] = $intervalo->m;
                endif;
                if($intervalo->d > 0 || $vazio):
                    $retorno['dia'] = $intervalo->d;
                endif;
                if($intervalo->h > 0 || $vazio):
                    $retorno['h'] = $intervalo->h;
                endif;
                if($intervalo->i > 0 || $vazio):
                    $retorno['min'] = $intervalo->i;
                endif;
                if($intervalo->s > 0 || $vazio):
                    $retorno['seg'] = $intervalo->s;
                endif;
            else:
                $retorno = array();
                if($intervalo->y > 0 || $vazio):
                    $retorno['y'] = $intervalo->y;
                endif;
                if($intervalo->m > 0 || $vazio):
                    $retorno['m'] = $intervalo->m;
                endif;
                if($intervalo->d > 0 || $vazio):
                    $retorno['d'] = $intervalo->d;
                endif;
                if($intervalo->h > 0 || $vazio):
                    $retorno['h'] = $intervalo->h;
                endif;
                if($intervalo->i > 0 || $vazio):
                    $retorno['i'] = $intervalo->i;
                endif;
                if($intervalo->s > 0 || $vazio):
                    $retorno['s'] = $intervalo->s;
                endif;
            endif;
            return $retorno;
        }

        /**
         * ADICIONA OU REMOVE QUANTIDADE DE DIAS DA DATA
        **/
        public static function dataadd($data = null, $tempo, $saida = 'Y-m-d H:i:s'){
            return date($saida, strtotime(str_replace('/', '-', $data)." {$tempo}"));
        }

        /**
         * CONVERTE JSON EM ARRAY
        **/
        public static function json($json){
            $json = json_decode($json, true);
            if(is_array($json)):
                $json = array_filter($json);
                if(!empty($json)) return $json;
            endif;
            return array();
        }

        /**
         * CONVERTE NOME DO ARQUIVO PARA IMAGEM DA EXTENSAO
        **/
        public static function ext($ext){
            $explode = explode('.', Converter::caixa($ext, 'a'));
            $ext = end($explode);
            $icone = 'file';
            if(in_array($ext, array('ai', 'eps', 'cdr', 'svg'))) $icone = 'ai';
            elseif(in_array($ext, array('doc', 'docx'))) $icone = 'doc';
            elseif(in_array($ext, array('gif'))) $icone = 'gif';
            elseif(in_array($ext, array('jpg', 'jpeg'))) $icone = 'jpg';
            elseif(in_array($ext, array('mp3', 'wave'))) $icone = 'mp3';
            elseif(in_array($ext, array('pdf'))) $icone = 'pdf';
            elseif(in_array($ext, array('png'))) $icone = 'png';
            elseif(in_array($ext, array('psd'))) $icone = 'psd';
            elseif(in_array($ext, array('txt'))) $icone = 'txt';
            elseif(in_array($ext, array('xls', 'xlsx'))) $icone = 'xls';
            elseif(in_array($ext, array('zip', 'rar'))) $icone = 'zip';

            return LINK.'/images/ext/'.$icone.'.png';
        }
    }
