<?php

$Banner = new BannerModel;


function erro($titulo, $texto){

    echo json_encode(['erro' => true, 'titulo' => $titulo, 'texto' => $texto]);
    exit();

}

if(isset($dados['ordem']) && empty($dados['ordem'])):

    erro('Atenção!', 'Selecione a ordem do banner');

endif;

if(isset($dados['data_postagem_inicio']) && empty($dados['data_postagem_inicio'])):

    erro('Atenção!', 'Selecione a data início do banner');

endif;

if(isset($dados['tipo']) && empty($dados['tipo'])):

    erro('Atenção!', 'Selecione onde o banner será publicado');

endif;

