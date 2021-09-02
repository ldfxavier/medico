<?php
    class VideosModel extends Model {

        public $_tabela = 'multimidia_video';

        public function montar($dados){
            $array = array();
            if($dados):
                $Status = new StatusModel;
                foreach($dados as $r):
                    $array[] = (object)array(
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'titulo' => $r->titulo,
                        'texto' => (object)[
                            'principal' => $r->texto,
                            'chamada' => $r->chamada
                            ],
                        'video' => (object)array(
                            'iframe' => !empty($r->video) ? Converter::video($r->video) : '',
                            'valor' => $r->video
                        ),
                        'url' => (object)[
                            'link' => LINK.'/videos/'.$r->url,
                            'valor' => $r->url
                            ],
                        'link' => LINK.'/videos/detalhe/'.$r->cod,
                        'data' => (object)array(
                            'postagem_inicio' => (object)array(
                                'br' => Converter::data($r->data_postagem_inicio, 'd/m/Y'),
                                'valor' => $r->data_postagem_inicio
                            ),
                            'postagem_final' => (object)array(
                                'br' => Converter::data($r->data_postagem_final, 'd/m/Y'),
                                'valor' => $r->data_postagem_final
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
                        'destaque' => (object)array(
                            'valor' => $r->destaque == 1 ? 1 : 2,
                            'texto' => $r->destaque == 1 ? 'Ativo' : 'Inativo',
                            'cor' => $r->destaque == 1 ? '#16A085' : '#E05D6F'
                        ),
                        'status' => (object)array(
                            'valor' => $r->status == 1 ? 1 : 2,
                            'texto' => $r->status == 1 ? 'Ativo' : 'Inativo',
                            'cor' => $r->status == 1 ? '#16A085' : '#E05D6F'
                        )
                    );
                endforeach;
            endif;
            return $array;
        }

        public function video($cod){
            $video = $this->montar($this->read("`cod` = '{$cod}' AND `status` = '1'"));
            return $video[0];
        }
    }
