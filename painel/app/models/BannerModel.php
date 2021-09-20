<?php
    class BannerModel extends Model {

        public $_tabela = 'publicidade_banner';

        public function montar($dados){
            $array = array();
            if($dados):
                $Status = new StatusModel;
                foreach($dados as $r):
                    $array[] = (object)array(
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'titulo' => $r->titulo,
                        'texto' => $r->texto,
                        'link' => $r->link,
						'target' => $r->target,
                        'imagem' => (object)array(
                            'valor' => $r->imagem,
                            'link' => ARQUIVO.'/banner/'.$r->imagem
                        ),
						'local' => $r->local,
						'data' => (object)array(
                            'postagem_inicio' => (object)array(
                                'br' => Converter::data($r->data_postagem_inicio, 'd/m/Y'),
                                'valor' => $r->data_postagem_inicio
                            ),
                            'postagem_final' => (object)array(
                                'br' => Converter::data($r->data_postagem_final, 'd/m/Y'),
                                'valor' => $r->data_postagem_final
                            ),
                            'criacao' => (object)array(
                                'br' => Converter::data($r->data_criacao, 'd/m/Y'),
                                'valor' => $r->data_criacao
                            ),
                            'atualizacao' => (!empty($r->data_atualizacao) && $r->data_atualizacao != '0000-00-00 00:00:00') ? Converter::data($r->data_atualizacao, 'd/m/Y H:i') : ''
                        ),
						'ordem' => $r->ordem,
                        'tipo' => $Status->padrao($r->tipo),
                        'status' => $Status->padrao($r->status)
                    );
                endforeach;
            endif;
            return $array;
        }

        public function verificar_ordem($ordem, $cod)
        {
            $noticia = $this->montar($this->read("`ordem` = '{$ordem}' AND `cod` != '{$cod}'"));

            return $noticia[0] ?? [];
        }

    }
