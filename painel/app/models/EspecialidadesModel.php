<?php
class EspecialidadesModel extends Model
{

    public $_tabela = 'especialidades';
    private $_where = "`status` = '1'";

    public function montar($dados)
    {
        $array = array();
        if ($dados) :
            $Status = new StatusModel;
            foreach ($dados as $r) :
                $array[] = (object)array(
                    'id' => $r->id,
                    'cod' => $r->cod,
                    'titulo' => $r->titulo,
                    'texto' => $r->texto,
                    'imagem' => (object)array(
                        'link' => !empty($r->imagem) ? ARQUIVO . '/especialidades/' . $r->imagem : '',
                        'valor' => $r->imagem
                    ),
                    'video' => (object)array(
                        'iframe' => !empty($r->video) ? Converter::video($r->video) : '',
                        'valor' => $r->video
                    ),
                    'url' => (object)[
                        'link' => LINK . '/especialidades/' . $r->url,
                        'valor' => $r->url
                    ],
                    'link' => LINK . '/especialidades/detalhe/' . $r->cod,
                    'data' => (object)array(
                        'postagem_inicio' => (object)array(
                            'br' => Converter::data($r->data_postagem_inicio, 'd/m/Y'),
                            'valor' => $r->data_postagem_inicio
                        ),
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

    public function montar_basico($dados)
    {
        $array = array();
        if ($dados) :
            foreach ($dados as $r) :
                $array[] = (object)array(
                    'id' => $r->id,
                    'titulo' =>  $r->titulo,
                    'texto' => $r->texto,
                    'imagem' => (object)array(
                        'link' => !empty($r->imagem) ? ARQUIVO . '/especialidades/' . $r->imagem : '',
                        'valor' => $r->imagem
                    ),
                    'url' => (object)[
                        'link' => LINK . '/especialidades/' . $r->url,
                        'valor' => $r->url
                    ]
                );
            endforeach;
        endif;
        return $array;
    }

    public function lista($pagina = 1, $limite = 18)
    {
        $paginas = ($pagina - 1) * $limite;

        $quantidade = $this->contar($this->_where);
        $quantidade_pagina = ceil($quantidade / $limite);

        if ($pagina > $quantidade_pagina) return false;
        $dados = $this->montar_basico($this->read($this->_where, "`data_criacao` DESC", $paginas . "," . $limite));
        return (object)[
            'lista' => $dados,
            'pagina' => (object)[
                'atual' => $pagina,
                'total' => $quantidade_pagina
            ]
        ];
    }

    public function url($url)
    {
        $dado = $this->montar($this->read("`url` = '{$url}' AND " . $this->_where));
        if ($dado) return $dado[0];
        return false;
    }

    public function cod($cod)
    {
        $noticia = $this->montar($this->read("`cod` = '{$cod}' AND `status` = '1'"));
        return $noticia[0];
    }
}
