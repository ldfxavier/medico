<?php
    final class Criar {

        /**
         * CRIA UM CÓDIGO ALEATORIO
        **/
        public static function codigo($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
            $caracteres = 'abcdefghijklmnopqrstuvwxyz';
            $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $num = '1234567890';
            $simb = '!@#$%*-';

            $retorno = '';

            if($maiusculas) $caracteres .= $lmai;
            if($numeros) $caracteres .= $num;
            if($simbolos) $caracteres .= $simb;
            $len = strlen($caracteres);

            for($n=1;$n<=$tamanho;$n++):
                $rand = mt_rand(1, $len);
                $retorno .= $caracteres[$rand-1];
            endfor;

            return $retorno;
        }

        /**
         * CRIA UM HASH
        **/
        public static function hash(){
            return md5(uniqid(time()));
        }

        /**
         * CRIA UMA SENHA
        **/
        public static function password($password){
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        }

        /**
         * CRIA UM VALOR INTEIRO
        **/
        public static function inteiro($min = 1000, $max = 9999){
            return rand($min, $max);
        }

        /**
         * CRIA UM QRCODE
        **/
        public static function qrcode($url, $width = 200, $height = 200){
            return 'http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$width.'x'.$height;
        }
    }
