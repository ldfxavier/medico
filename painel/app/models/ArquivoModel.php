<?php
    class ArquivoModel extends Model {

        public $_tabela = 'geral_arquivo';

        public function montar($dados){
            $array = array();
            if($dados):
                foreach($dados as $r):
                    $array[] = (object)array(
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'local' => $r->local,
                        'titulo' => $r->titulo,
                        'arquivo' => (object)array(
                            'valor' => $r->arquivo,
                            'link' => ARQUIVO.'/arquivo/'.$r->arquivo
                        ),
                        'imagem' => Converter::ext($r->arquivo)
                    );
                endforeach;
            endif;
            return $array;
        }

        public function lista($cod, $local = 1){
            return $this->montar($this->read("`cod` = '{$cod}' AND `local` = '{$local}'"));
        }

        public function salvar($cod, $arquivo, $arquivo_nome, $local){
            return $this->insert(array(
                'cod' => $cod,
                'local' => $local,
                'arquivo' => $arquivo,
                'titulo' => $arquivo_nome,
                'data_criacao' => date('Y-m-d H:i:s')
            ), true);
        }
    }
