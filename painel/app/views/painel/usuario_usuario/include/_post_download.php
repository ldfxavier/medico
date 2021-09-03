<?php

$array = [];

foreach($coluna as $ind => $val) $array[0][$ind] = $val;

$i = 1;
foreach($lista as $r):
    $i++;
    if(isset($r->status) && !empty($r->status) && $r->status == '1'):
        $r->status = 'Ativo';
    elseif(isset($r->status) && !empty($r->status) && $r->status == '2'):
        $r->status = 'Desativado';
    endif;
endforeach;
