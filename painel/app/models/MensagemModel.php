<?php
    class MensagemModel extends Model {

        public $_tabela = 'mensagem';

        public function montar($dados){
            $array = array();
            if($dados):
                $Status = new StatusModel;
                foreach($dados as $r):
                    $array[] = (object)array(
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'nome' => $r->nome,
                        'telefone' => (object)array(
                            'valor' => $r->telefone,
                            'texto' => Converter::telefone($r->telefone)
                        ),
                        'email' => $r->email,
                        'texto' => $r->texto,
                        'data' => (object)array(
                            'criacao' => Converter::data($r->data_criacao, 'd/m/Y H:i'),
                            'atualizacao' => Converter::data($r->data_atualizacao, 'd/m/Y H:i')
                        ),
                        'status' => $Status->valor('mensagem', 'status', $r->status)
                    );
                endforeach;
            endif;
            return $array;
        }

        public function salvar($dados){

            $email = new Email;
            $Site = new SiteModel;

            $site = $Site->dados();
            $site = $site[0];

            unset($dados['ajax']);
            $dados['cod'] = md5(uniqid(time()));
            $dados['status'] = 1;
            $dados['data_criacao'] = date('Y-m-d H:i:s');
            $telefone = $dados['telefone'];
            $dados['telefone'] = preg_replace("/[^0-9]/", "", $telefone);
            $insert = $this->insert($dados, true);
            $html = "Nome: {$dados['nome']} <br> WhatsApp: {$telefone} <br> Mensagem: {$dados['texto']}";

            if($insert['erro'] == false):
                $dados_email = [
                    'titulo' => $site->titulo_email,
                    'email' => $site->email_formulario,
                    'nome' => $dados['nome'],
                    'mensagem' => $html
                ];
                $email->enviar($dados_email);
            endif;

            echo json_encode($insert);
        }

    }
