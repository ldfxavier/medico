<?php
    class Mensagem {
        /**
         * MENSAGEM DE ERRO PADRÃO DO SISTEMA
         */
        public static function erro($titulo, $texto){
            return json_encode(array('erro' => true, 'titulo' => $titulo, 'texto' => $texto));
        }
        /**
         * MENSAGEM DE OK PADRÃO DO SISTEMA
         */
        public static function ok(){
            return json_encode(array('erro' => false));
        }

    }
