<?php

$array = [];

foreach($coluna as $ind => $val) $array[0][$ind] = $val;

$i = 1;
foreach($lista as $r):
    $i++;
    if(isset($r->delegacia) && !empty($r->delegacia)):
        $Status = new StatusModel;
        $delegacia_replace =  $Status->select('enquete', 'delegacia');
        $r->delegacia = $delegacia_replace[$r->delegacia];
    endif;
    if(isset($r->status) && !empty($r->status) && $r->status == '1'):
        $r->status = 'Ativo';
    elseif(isset($r->status) && !empty($r->status) && $r->status == '2'):
        $r->status = 'Desativado';
    endif;
endforeach;
