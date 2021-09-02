<?php
    $texto = '';

    $Painel = new PainelModel;
    $indicacao = $Painel->p_read("mensagem_indicacao", "`status` < 3", "`status` ASC, `data_criacao` ASC");
    if($indicacao):
        $lista = [];

        $q_total = 0;
        $q_novo = 0;
        $q_andamento = 0;

        $empresa = [];
        $equipe = [];
        $usuario_id = [];
        foreach($indicacao as $r):
            // Quantidade por status
            $q_total++;
            if($r->status->valor == 1) $q_novo++;
            elseif($r->status->valor == 2) $q_andamento++;

            // Quantidade por empresa
            if(!isset($empresa[$r->empresa->texto])) $empresa[$r->empresa->texto] = 1;
            else $empresa[$r->empresa->texto]++;

            // Quantidade por equipe
            if(!isset($equipe[$r->vinculo->equipe->nome])) $equipe[$r->vinculo->equipe->nome] = 1;
            else $equipe[$r->vinculo->equipe->nome]++;

            // Histórico
            $Historico = new HistoricoModel;
            $historico = $Historico->cod('mensagem_indicacao', $r->cod);

            if(isset($r->vinculo->usuario->lista) && $r->vinculo->usuario->lista) foreach($r->vinculo->usuario->lista as $u_id => $u_nome) $usuario_id[$u_id] = $u_id;

            $lista[$r->status->valor][$r->cod] = (object)[
                'tipo' => $r->tipo->texto,
                'usuario' => $r->vinculo->usuario,
                'empresa' => $r->empresa->texto,
                'parceiro' => (object)[
                    'nome' => $r->vinculo->nome,
                    'equipe' => $r->vinculo->equipe->nome,
                    'link' => $r->vinculo->link
                ],
                'tempo' => Converter::tempo(Converter::data($r->data->criacao, 'Y-m-d H:i'), date('Y-m-d H:i'), 'd'),
                'historico' => $historico
            ];
        endforeach;

        $usuario_id = "`id` = '".implode("' OR `id` = '", $usuario_id)."'";
        $diretor = $Painel->p_select('usuario_usuario', 'id', 'diretor_status', null, $usuario_id);

        $texto .= '<span  style="font-size:24px"><b>RELATÓRIO DIÁRIO DE INDICAÇÕES</b></span><br><br>';
        $texto .= '<span style="font-size: 18px"><b>QUANTIDADE DE INDIÇÕES</b></span><br>';
        $texto .= '<span style="font-size: 14px"><b>Novo:</b> '.$q_novo.'</span><br>';
        $texto .= '<span style="font-size: 14px"><b>Andamento:</b> '.$q_andamento.'</span><br>';
        $texto .= '<span style="font-size: 14px"><b>Total:</b> '.$q_total.'</span><br><br>';

        $texto .= '<span style="font-size: 18px"><b>INDICAÇÃO POR CAPTADOR</b></span><br>';
        if($equipe):
            foreach($equipe as $ind => $val):
                $equipe_nome = !empty($ind) ? $ind : 'Sem captador';
                $texto .= '<span style="font-size: 14px"><b>'.$equipe_nome.':</b> '.$val.'</span><br>';
            endforeach;
        else:
            $texto .= '<span style="font-size: 14px">SEM CAPTADORES</span><br>';
        endif;

        $texto .= '<br><span style="font-size: 18px"><b>INDICAÇÃO POR EMPRESA</b></span><br>';
        if($empresa) foreach($empresa as $ind => $val) $texto .= '<span style="font-size: 14px"><b>'.$ind.':</b> '.$val.'</span><br>';
        else $texto .= '<span style="font-size: 14px">SEM EMPRESA</span><br>';

        $texto .= '<br><br><span style="font-size: 18px"><b>LISTA DE INDIÇÕES NOVAS</b></span><br><br>';
        if(isset($lista[1])):
            foreach($lista[1] as $r):
                $parceiro_nome = !empty($r->parceiro->nome) ? $r->parceiro->nome : 'Sem nome';

                $texto .= '<span style="font-size: 14px"><b><a href="'.$r->parceiro->link.'" target="_blank">'.$parceiro_nome.'</a></b></span><br>';
                $texto .= '<span style="font-size: 14px"> - <b>Captador:</b> '.$r->parceiro->equipe.'</span><br>';
                $texto .= '<span style="font-size: 14px"> - <b>Empresa:</b> '.$r->empresa.'</span><br>';
                $texto .= '<span style="font-size: 14px"> - <b>Tipo de indicação:</b> '.$r->tipo.'</span><br>';

                if(isset($r->usuario->lista)):
                    foreach($r->usuario->lista as $ind => $val):
                        $usuario_nome = !empty($val) ? $val : 'Sem nome';
                        if(isset($diretor[$ind]) && $diretor[$ind] == 1):
                            $texto .= '<span style="font-size: 14px"> - <b>Indicado por:</b> <a href="'.PAINEL.'/converter_link/id-cod/usuario_usuario/'.$ind.'" target="_blank">'.$usuario_nome.' <b style="color: #F00">(DIRETOR)</b></a></span><br>';
                        else:
                            $texto .= '<span style="font-size: 14px"> - <b>Indicado por:</b> <a href="'.PAINEL.'/converter_link/id-cod/usuario_usuario/'.$ind.'" target="_blank">'.$usuario_nome.'</a></span><br>';
                        endif;
                    endforeach;
                endif;

                $texto .= '<span style="font-size: 14px"> - <b>Tempo:</b> '.$r->tempo.' dia(s)</span><br>';

                if($r->historico):
                    $texto .= '<span style="font-size: 14px"> - <b>Últ. histórico:</b> '.$r->historico->texto.' em '.$r->historico->data.' por '.$r->historico->nome.'</span>';
                else:
                    $texto .= '<span style="font-size: 14px"> - <b>Últ. histórico:</b> Sem histórico</span>';
                endif;
                $texto .= "<br><br><hr><br>";
            endforeach;
        else:
            $texto .= '<span style="font-size: 14px">SEM INDIÇÕES NOVAS</span><br>';
        endif;

        $texto .= '<br><span style="font-size: 18px"><b>LISTA DE INDIÇÕES EM ANDAMENTO</b></span><br><br>';
        if(isset($lista[2])):
            foreach($lista[2] as $r):
                $parceiro_nome = !empty($r->parceiro->nome) ? $r->parceiro->nome : 'Sem nome';
                $usuario_nome = !empty($r->usuario->nome) ? $r->usuario->nome : 'Sem nome';

                $texto .= '<span style="font-size: 14px"><b><a href="'.$r->parceiro->link.'" target="_blank">'.$parceiro_nome.'</a></b></span><br>';
                $texto .= '<span style="font-size: 14px"> - <b>Captador:</b> '.$r->parceiro->equipe.'</span><br>';
                $texto .= '<span style="font-size: 14px"> - <b>Empresa:</b> '.$r->empresa.'</span><br>';
                $texto .= '<span style="font-size: 14px"> - <b>Tipo de indicação:</b> '.$r->tipo.'</span><br>';

                if(isset($r->usuario->lista)):
                    foreach($r->usuario->lista as $ind => $val):
                        $usuario_nome = !empty($val) ? $val : 'Sem nome';
                        if(isset($diretor[$ind]) && $diretor[$ind] == 1):
                            $texto .= '<span style="font-size: 14px"> - <b>Indicado por:</b> <a href="'.PAINEL.'/converter_link/id-cod/usuario_usuario/'.$ind.'" target="_blank">'.$usuario_nome.' <b style="color: #F00">(DIRETOR)</b></a></span><br>';
                        else:
                            $texto .= '<span style="font-size: 14px"> - <b>Indicado por:</b> <a href="'.PAINEL.'/converter_link/id-cod/usuario_usuario/'.$ind.'" target="_blank">'.$usuario_nome.'</a></span><br>';
                        endif;
                    endforeach;
                else:
                    $texto .= '<span style="font-size: 14px"> - <b>Indicado por:</b> Sem usuário cadastrado</span><br>';
                endif;

                $texto .= '<span style="font-size: 14px"> - <b>Tempo:</b> '.$r->tempo.' dia(s)</span><br>';

                if($r->historico):
                    $texto .= '<span style="font-size: 14px"> - <b>Últ. histórico:</b> '.$r->historico->texto.' em '.$r->historico->data.' por '.$r->historico->nome.'</span>';
                else:
                    $texto .= '<span style="font-size: 14px"> - <b>Últ. histórico:</b> Sem histórico</span>';
                endif;
                $texto .= "<br><br><hr><br>";
            endforeach;
        else:
            $texto .= '<span style="font-size: 14px">SEM INDIÇÕES EM ANDAMENTO</span><br>';
        endif;
    endif;
