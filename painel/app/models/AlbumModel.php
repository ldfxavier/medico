<?php
    class AlbumModel extends Model {

        public $_tabela = 'multimidia_album';

        public function montar($dados){
            $array = [];
            if($dados):
                $Foto = new FotoModel;
                $Status = new StatusModel;
                foreach($dados as $r):
                    $data_atualizacao = '';
                    if($r->data_criacao < $r->data_atualizacao):
                        $data_atualizacao = Converter::data($r->data_atualizacao, 'd/m/Y H:i');
                    endif;
                    $array[] = (Object)[
                        'cod' => $r->cod,
                        'id' => $r->id,
                        'titulo' => $r->titulo,
                        'texto' => $r->texto,
                        'url' => $r->url,
                        'data' => (object)array(
                            'postagem_inicio' => (object)array(
                                'br' => Converter::data($r->data_postagem_inicio, 'd/m/Y'),
                                'valor' => $r->data_postagem_inicio
                            ),
                            'postagem_atualizacao' => (object)array(
                                'br' => Converter::data($r->data_postagem_atualizacao, 'd/m/Y'),
                                'valor' =>  (!empty($r->data_postagem_atualizacao) && $r->data_postagem_atualizacao != '0000-00-00 00:00:00') ? Converter::data($r->data_postagem_atualizacao, 'd/m/Y H:i:s') : ''
                            ),
                            'criacao' => (object)array(
                                'br' => Converter::data($r->data_criacao, 'd/m/Y'),
                                'valor' => $r->data_criacao
                            ),
                            'atualizacao' => (!empty($r->data_atualizacao) && $r->data_atualizacao != '0000-00-00 00:00:00') ? Converter::data($r->data_atualizacao, 'd/m/Y H:i') : ''
                        ),
                        'lista' => $Foto->lista($r->cod),
                        'status' => $Status->padrao($r->status)
                    ];
                endforeach;
            endif;
            return $array;
        }

        public function cod($cod){
            $dados = $this->montar($this->read("`cod` = '{$cod}' AND `status` = 1"));
            if(!$dados) return false;

            $Foto = new Foto;
            $dados[0]->lista = $Foto->lista($dados[0]->cod);

            return $dados[0];
        }
        public function lista(){
            $dados = $this->montar($this->read());
            if(!$dados) return false;

            $Foto = new FotoModel;
            $array = [];
            foreach($dados as $r):
                $r->capa = $Foto->capa($r->cod);
                $array[] = $r;
            endforeach;

            return $array;
        }
    }
