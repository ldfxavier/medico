<?php
    class DataLogModel extends Model {

        public $_tabela = 'data_log';

        public function montar($dados){
            $array = [];
            if($dados):
                foreach($dados as $r):
                    $array[] = (Object)[
                        'cod' => $r->cod,
                        'id' => $r->id
                    ];
                endforeach;
            endif;
            return $array;
        }

        public function salvar($url, $dado, $retorno, $app){

			if(!isset($_SESSION['EQUIPE'])):
				return false;
			endif;

            if(in_array($url, ['post-login', '/painel/painel/post-login'])):
                $tipo = 1;
            else:
                $tipo = 2;
            endif;

            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $metodo = $_SERVER['REQUEST_METHOD'] ?? '';
            $id_usuario = $_SESSION['EQUIPE']->id;
            $status = $_SERVER['REDIRECT_STATUS'] ?? '';

			$dado = [
				'cod' => uuid(),
                'app' => isset($app) ? $app : '',
				'uri_acessada' => $url ? $url : $_SERVER['REQUEST_URI'],
				'tipo' => $tipo,
                'usuario' => $id_usuario,
                'metodo_utilizado' => $metodo,
                'ip_usuario' => $ip,
                'header_enviado' => json_encode(getallheaders()),
                'status_html' => $status,
                'dado_enviado' => !empty($dado) ? json_encode($dado) : '',
                'retorno' =>  is_array($retorno) || is_object($retorno) ? json_encode($retorno) : $retorno,
                'data_criacao' => date('Y-m-d H:i:s')
			];

            $this->insert($dado);

        }
    }
