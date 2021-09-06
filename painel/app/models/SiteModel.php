<?php
    class SiteModel extends Model {

        public $_tabela = 'site';

        public function montar($dados){
            $array = array();
            if($dados):
                $Status = new StatusModel;
                foreach($dados as $r):
                    $array[] = (object)array(
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'imagem' => (object)array(
                            'link' => !empty($r->imagem) ? ARQUIVO.'/perfil/'.$r->imagem : '',
                            'valor' => $r->imagem
                        ),
                        'mapa' => $r->mapa,
                        'endereco' => $r->endereco,
                        'telefone' => (object)[
                            'br' => Converter::telefone($r->telefone),
                            'valor' => $r->telefone
                        ],
                        'titulo_email' => $r->titulo_email,
                        'sobre_chamada' => $r->sobre_chamada,
                        'agendamento' => $r->agendamento,
                        'sobre' => $r->sobre,
                        'email' => $r->email,
                        'email_formulario' => $r->email_formulario,
                        'facebook' => $r->facebook,
                        'instagram' => $r->instagram,
                        'twitter' => $r->twitter,
                        'youtube' => $r->youtube,
                        'whatsapp' => $r->whatsapp,
                        'link_agendamento' => $r->link_agendamento,
                        'data' => (object)array(
                            'atualizacao' => (!empty($r->data_atualizacao) && $r->data_atualizacao != '0000-00-00 00:00:00') ? Converter::data($r->data_atualizacao, 'd/m/Y H:i') : ''
                        ),
                    );
                endforeach;
            endif;
            return $array;
        }

        public function dados(){
            return $this->montar($this->read());
        }
    }
