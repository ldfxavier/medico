<?php
    class FormularioModel extends Model {

        public $_tabela = 'formulario';

        public function montar($dados){
            $array = array();
            if($dados):
                foreach($dados as $r):
                    $array[] = (object)array(
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'titulo' => $r->titulo,
                        'local' => $r->local,
                        'arquivo' => (object)array(
                            'valor' => $r->arquivo,
                            'link' => ARQUIVO.'/arquivo/'.$r->arquivo
                        ),
                        'data' => (object)array(
                            'criacao' => (object)array(
                                'br' => Converter::data($r->data_criacao, 'd/m/Y'),
                                'valor' => $r->data_criacao
                            ),
                            'atualizacao' => (!empty($r->data_atualizacao) && $r->data_atualizacao != '0000-00-00 00:00:00') ? Converter::data($r->data_atualizacao, 'd/m/Y H:i') : ''
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

        public function lista($cod){
            return $this->montar($this->read("`cod` = '{$cod}'"));
        }

        public function salvar($cod, $arquivo){
            return $this->insert(array(
                'cod' => $cod,
                'arquivo' => $arquivo,
                'titulo' => $arquivo,
                'data_criacao' => date('Y-m-d H:i:s')
            ), true);
        }
    }
