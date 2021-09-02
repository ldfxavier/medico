<?php
$texto = "";
if(isset($parceiro) && !empty($parceiro)):
    $texto .= "<p>O prazo de fechamento das captações abaixo foi atingido:</p><br>";
    foreach($parceiro as $r):
        $nome = (isset($r->nome)) ? $r->nome : $r->titulo;
        $texto .= "Classificacao: ".$r->classificacao." - <a href='".PAINEL."/visualizar/convenio_parceiro/".$r->cod."' target='_blank'>".$nome."</a><br>";
    endforeach;
endif;
