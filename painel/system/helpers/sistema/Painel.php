<?php
    class Painel {

        public static function index_normal($painel_app, $painel_titulo, $painel_lista, $painel_permissao, $painel_registro, $painel_where, $painel_order, $painel_pagina, $painel_busca){
            include('painel/index_normal.php');
        }
        public static function index_lista($painel_app, $painel_titulo, $painel_lista, $painel_permissao, $painel_registro, $painel_where, $painel_order, $painel_pagina, $painel_busca){
            include('painel/index_lista.php');
        }
        public static function index_galeria($painel_app, $painel_titulo, $painel_permissao, $painel_registro, $painel_where, $painel_order, $painel_pagina, $painel_busca){
            include('painel/index_galeria.php');
        }


        public static function visualizar_header($painel_app, $painel_dado, $painel_pre_visualizacao){
            include('painel/visualizar_header.php');
        }
        public static function visualizar_footer($painel_app, $painel_cod, $painel_historico = true, $painel_historico_id = null, $historico_booleano = null){
            include('painel/visualizar_footer.php');
        }

        public static function visualizar_mensagem_header($painel_app, $painel_dado, $painel_pre_visualizacao){
            include('painel/visualizar_mensagem_header.php');
        }
        public static function visualizar_mensagem_footer($painel_app, $painel_cod, $painel_historico = true, $painel_historico_id = null){
            include('painel/visualizar_mensagem_footer.php');
        }


        public static function form_header($painel_app, $r, $painel_input = [], $painel_volta = null){
            include('painel/form_header.php');
        }
        public static function form_add($painel_app, $r, $painel_coluna = null){
            include('painel/form_add.php');
        }
        public static function form_editar($painel_app, $r, $painel_coluna = null){
            include('painel/form_editar.php');
        }
        public static function form_add_ajax($painel_app, $r, $painel_coluna = null){
            include('painel/form_add_ajax.php');
        }
        public static function form_editar_ajax($painel_app, $r, $painel_coluna = null){
            include('painel/form_editar_ajax.php');
        }


        public static function busca_header($painel_app, $painel_link = null){
            include('painel/busca_header.php');
        }
        public static function busca_footer(){
            include('painel/busca_footer.php');
        }


        public static function download($painel_app, $painel_coluna){
            include('painel/download.php');
        }


        public static function header($painel_app, $titulo, $dado = []){
            include('painel/header.php');
        }
    }
