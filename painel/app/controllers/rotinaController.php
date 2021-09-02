<?php
class rotinaController extends Controller{
    public function index(){}


    /**
     * ROTINAS QUE SÃO ENVIADAS PARA USUÁRIOS
    **/
    public function usuario_indicacao(){
        $Painel = new PainelModel;
        $dia_30 = Converter::dataadd(date('Y-m-d'), '-30 days', 'Y-m-d');
        $dia_60 = Converter::dataadd(date('Y-m-d'), '-60 days', 'Y-m-d');

        $lista_30 = $Painel->p_read('mensagem_indicacao', "`status` = '2' AND `data_criacao` LIKE '{$dia_30}%'");
        $lista_60 = $Painel->p_read('mensagem_indicacao', "`status` = '2' AND `data_criacao` LIKE '{$dia_60}%'");

        if($lista_30) $this->usuario_indicacao_enviar($lista_30, 30);
        if($lista_60) $this->usuario_indicacao_enviar($lista_60, 60);

    }
    private function usuario_indicacao_enviar($lista, $dia){
        $Email = new Email;
        if($lista):
            $usuario = [];
            foreach($lista as $r):
                if(isset($r->usuario->id) && !isset($usuario[$r->usuario->id])):
                    $usuario[$r->usuario->id] = $r->usuario->id;
                    $email = !empty($r->usuario->contato->email->pessoal) ? $r->usuario->contato->email->pessoal : $r->usuario->contato->email->trabalho;
                    if(!empty($email)):
                        $nome = !empty($r->usuario->nome) ? $r->usuario->nome : 'Usuário';
                        $Email->enviar_api('INDICAÇÃO', $nome, $email, LINK.'/email/rotina_usuario_indicacao/'.$dia);
                    endif;
                endif;
            endforeach;
        endif;
    }


    /**
     * ROTINAS QUE SÃO ENVIADAS PARA A EQUIPE
    **/
    public function mensagem_indicacao_alerta_diretor(){
        $Painel = new PainelModel;

        $indicacao = $Painel->p_read('mensagem_indicacao', "`status` = '2'");

        if($indicacao):
            foreach($indicacao as $r):
                if($r->usuario->diretor->status == 1):
                    $lista[] = $r->vinculo->valor;
                endif;
            endforeach;

            if($lista):
                $parceiro_lista = $Painel->p_read('convenio_parceiro', "`cod` = '".implode("' OR `cod` = '", $lista)."'");
                if($parceiro_lista) foreach($parceiro_lista as $r) $parceiro[$r->cod] = $r->equipe->valor;

                $Notificacao = new NotificacaoModel;
                foreach($lista as $cod):
                    if(!isset($parceiro[$cod])):
                        $titulo = 'INDICAÇÃO DE DIRETOR';
                        $texto = 'Você tem uma indicação de diretor que continua em aberto.';
                        $equipe = $parceiro[$cod];

                        $Notificacao->salvar([$equipe], ['mensagem_indicacao' => $cod], $titulo, $texto, PAINEL.'/visualizar/convenio_parceiro/'.$cod, true);
                    else:
                        $titulo = 'INDICAÇÃO DE DIRETOR SEM CAPTADOR';
                        $texto = 'Existe uma indicação de diretor sem captador.';

                        $Notificacao->salvar([GERENTE_CONVENIO_ID, GERENTE_COMERCIAL_ID], ['mensagem_indicacao' => $cod], $titulo, $texto, PAINEL.'/visualizar/convenio_parceiro/'.$cod, true);
                    endif;
                endforeach;
            endif;
        endif;
    }

    public function mensagem_indicacao_novo_2_dias(){

    }

    public function solicitacao_carro_bloquear(){
        $SolicitacaoCarro = new SolicitacaoCarroModel;
        $solicitacaoCarro = $SolicitacaoCarro->bloquear_mensagem();

        $Notificacao = new NotificacaoModel;
        if(isset($solicitacaoCarro['bloqueio_3_dias']) && !empty($solicitacaoCarro['bloqueio_3_dias'])):
            foreach($solicitacaoCarro['bloqueio_3_dias'] as $r_3):
                $titulo = 'COTAÇÃO SEM FINALIZAR';
                $texto = 'Existe uma solicitação (cotação) de automóvel sem finalizar.';

                $Notificacao->salvar([GERENTE_ATENDIMENTO_ID], ['solicitacao_carro' => $r_3->cod], $titulo, $texto, PAINEL.'/visualizar/solicitacao_carro/'.$r_3->cod, true);
            endforeach;
        endif;
        if(isset($solicitacaoCarro['bloqueio_6_dias']) && !empty($solicitacaoCarro['bloqueio_6_dias'])):
            foreach($solicitacaoCarro['bloqueio_6_dias'] as $r_3):
                $titulo = 'COTAÇÃO Á 6 DIAS SEM FINALIZAR';
                $texto = 'Existe uma solicitação (cotação) de automóvel sem finalizar à 6 dias.';

                $Notificacao->salvar([GERENTE_COMERCIAL_ID,GERENTE_ATENDIMENTO_ID], ['solicitacao_carro' => $r_3->cod], $titulo, $texto, PAINEL.'/visualizar/solicitacao_carro/'.$r_3->cod, true);
            endforeach;
        endif;
    }

    public function mensagem_novo_cliente(){
		$Combustivel = new CombustivelModel;
		$Combustivel->lista();
		exit();
		$Painel = new PainelModel;
		$parceiros = $Painel->p_read("convenio_parceiro", "`status` = 4 AND `publicar` = 1");

		foreach($parceiros as $r):
			echo $r->id;
			exit();
			if(isset($r->aviso->email) && !empty($r->aviso->email)):
				$validar = filter_var($r->aviso->email, FILTER_VALIDATE_EMAIL) ? true : false;
				if($validar):
					// sleep(3);
				endif;
			endif;
		endforeach;
		exit();
    }

    public function cotacao(){
        $Cotacao = new CotacaoModel;
        $Notificacao = new NotificacaoModel;
        $cotacao = $Cotacao->lista();

        $data_atual = date("Y-m-d");

        foreach($cotacao as $r):
            $data_criacao = Converter::data($r->data->criacao_valor, "Y-m-d");
            $data[1] = Converter::dataadd($data_atual, "-1 days", "Y-m-d");
            $data[2] = Converter::dataadd($data_atual, "-2 days", "Y-m-d");
            $data[4] = Converter::dataadd($data_atual, "-4 days", "Y-m-d");
            $data[5] = Converter::dataadd($data_atual, "-5 days", "Y-m-d");

            $notificar = false;
            $id = RESPONSAVEL_VEICULO_ID;

            if($data_criacao == $data[1] && $r->status->valor == 1):
                $titulo = 'ENTRAR EM CONTATO';
                $texto = 'Existe uma cotação com necessidade de entrar em contato com a concessionária.';
                $notificar = true;
            elseif($data_criacao == $data[2] && $r->status->valor == 2):
                $titulo = 'COBRAR ORÇAMENTO';
                $texto = 'Existe uma cotação com necessidade de cobrar o orçamento.';
                $notificar = true;
            elseif($data_criacao == $data[4] && $r->status->valor == 3):
                $titulo = 'COBRAR PROPOSTA';
                $texto = 'Existe uma cotação com necessidade de cobrar a proposta.';
                $notificar = true;
            elseif($data_criacao == $data[5] && $r->status->valor == 4):
                $titulo = 'COTAÇÃO PARADA';
                $texto = 'Existe uma cotação à 5 dias sem finalizar.';
                $id = GERENTE_CONVENIO_ID;
                $notificar = true;
            endif;

            if($notificar):
                $Notificacao->salvar([$id], ['cotacao' => $r->cod], $titulo, $texto, PAINEL.'/visualizar/cotacao/'.$r->cod, true);
                sleep(1);
            endif;
        endforeach;
    }

    public function email_clube(){
        $RotinaEmail = new RotinaEmailModel;
        $Painel = new PainelModel;
        $Construtor = new ConstrutorModel;
        $Voucher = new VoucherModel;
        $Email = new Email;

        $rotina = $RotinaEmail->lista("`status` = '1'");

        if($rotina):
            foreach($rotina as $r):
                $cod_update[] = $r->cod;
                $anexo = null;

                $dados['empresa'] = $Construtor->empresa($r->empresa->valor);
                $dados['usuario'] = $r->usuario->dados;

                // Rotina dos voucher
                if(isset($r->tipo) && $r->tipo == 'voucher'):
                    $voucher = $Voucher->id($r->vinculo);
                    if($voucher):
                        $dados['app'] = $Painel->p_id($r->app, $voucher->id);

                        if(isset($r->anexo_nome) && !empty($r->anexo_nome)):
                            $pdf = Voucher::pdf($dados);
                            $anexo = [
                                'arquivo' => 'arquivos/voucher/'.$pdf,
                                'nome' => $r->anexo_nome
                            ];
                        endif;
                    endif;
                // Rotina dos vouchers imovel
                elseif(isset($r->tipo) && $r->tipo == 'imovel'):
                    $dados['app'] = $Painel->p_id($r->app, $r->vinculo);
                    if(isset($r->anexo_nome) && !empty($r->anexo_nome)):
                        $pdf = Voucher::imovel($dados);
                        $anexo = [
                            'arquivo' => 'arquivos/voucher/'.$pdf,
                            'nome' => $r->anexo_nome
                        ];
                    endif;
                // Rotina dos vouchers sala vip 50%
                elseif(isset($r->tipo) && $r->tipo == 'voucher_salavip_50'):
                    $dados['app'] = $Painel->p_id($r->app, $r->vinculo);
        			$dados['quantidade'] = 2;
                    if(isset($r->anexo_nome) && !empty($r->anexo_nome)):
                        $pdf = Voucher::salavip($dados);
                        $anexo = [
                            'arquivo' => 'arquivos/voucher/'.$pdf,
                            'nome' => $r->anexo_nome
                        ];
                    endif;
                // Rotina dos vouchers sala vip 100%
                elseif(isset($r->tipo) && $r->tipo == 'voucher_salavip_100'):
                    $dados['app'] = $Painel->p_id($r->app, $r->vinculo);
                    $dados['quantidade'] = '0';
                    if(isset($r->anexo_nome) && !empty($r->anexo_nome)):
                        $pdf = Voucher::salavip($dados);
                        $anexo = [
                            'arquivo' => 'arquivos/voucher/'.$pdf,
                            'nome' => $r->anexo_nome
                        ];
                    endif;
                endif;
                //Envia o e-mail
                $Email->enviar($r->titulo, $dados['usuario']->empresa->valor, $r->email, $r->link, $anexo);
                sleep(1);
            endforeach;
            //Muda status para 2
            $RotinaEmail->mudar_status('2', $cod_update);
        endif;
    }

    public function atualizar_uf(){
        $Painel = new PainelModel;
        $usuario = $Painel->p_read("usuario_usuario", "`empresa` = 95");

        foreach($usuario as $r):
            $atualizar = $Painel->p_update("usuario_usuario", ['federacao' => $r->endereco->uf], "`id` = {$r->id}");
        endforeach;
        echo "<pre>";
        print_r($atualizar);
        exit();
    }
    public function atualizar_classificacao(){
        exit();

        echo "<pre>";

        $Painel = new PainelModel;
        $parceiro = $Painel->p_read("convenio_parceiro");
        $diretor = "";
        foreach($parceiro as $r):
            if($r->usuario->diretor != '1'):
                $diretor = '2';
            else:
                $diretor = '1';
            endif;
            $Painel->p_update("convenio_parceiro", ['classificacao' => $diretor], "`id` = '".$r->id."'");
        endforeach;
        exit();
    }
    public function alterar_status(){
        $Painel = new PainelModel;
        $parceiro = $Painel->p_read("convenio_parceiro");
        echo "<pre>";
        // 1 \-> 10 \- Com captador
        // 2, 6 \-> 11 \- Proposta enviada
        // 3 \-> 12 \- Proposta respondida
        // 5 \-> 16 \- Sem interesse
        // 7 \-> 18 \- Cancelado
        // 8 \-> 19 \- Finalizado sem terminar contato
        // 9 \-> 17 \- Problema
        foreach($parceiro as $r):
            if($r->status->valor == "1"):
                $dados['status'] = "10";
            elseif($r->status->valor == "2" || $r->status->valor == "6"):
                $dados['status'] = "11";
            elseif($r->status->valor == "3"):
                $dados['status'] = "12";
            elseif($r->status->valor == "5"):
                $dados['status'] = "16";
            elseif($r->status->valor == "7"):
                $dados['status'] = "18";
            elseif($r->status->valor == "8"):
                $dados['status'] = "19";
            elseif($r->status->valor == "9"):
                $dados['status'] = "17";
            else:
                $dados['status'] = $r->status->valor;
            endif;
            $atualizar = $Painel->p_update("convenio_parceiro", $dados, "`id` = '".$r->id."'");
        endforeach;
    }

    public function relatorio_voucher(){
        exit();
        $Painel = new PainelModel;
        $dados = $Painel->p_read("solicitacao_voucher", "`status` = 2 AND `empresa` = 2 AND (data_validacao >= '2018-04-01 00:00:00' AND data_validacao <= '2018-04-30 23:59:59')");

        // echo "<pre>";
        // print_r($dados);
        // exit();

        echo "
        <table>
        <tr>
            <td>Usuário</td>
            <td>CPF</td>
            <td>Código</td>
            <td>Data devalidação</td>
            <td>Data de criação</td>
        </tr>";
        foreach($dados as $r):
            echo "
            <table>
            <tr>
                <td>".$r->usuario->nome."</td>
                <td>".$r->usuario->documento."</td>
                <td>".$r->codigo."</td>
                <td>".$r->data->criacao."</td>
                <td>".$r->data->validacao."</td>
            </tr>
            ";
        endforeach;
        echo "</table>";
    }
}
