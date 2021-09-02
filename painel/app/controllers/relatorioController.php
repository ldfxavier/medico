<?php
    class relatorioController extends Controller {

        public function index(){}

        public function mensagem_indicacao_novo_aberto(){
            echo '<pre>';
            include('app/views/painel/padrao/relatorio/mensagem_indicacao_novo_aberto.php');
            if(!empty($texto)):
                Email::padrao('RELATÓRIO INDICACAO', 'COMERCIAL', GERENTE_COMERCIAL_EMAIL, $texto);
            endif;
        }

        public function solicitacao_carro_aberto(){

        }

        public function convenio_parceiro_bloquear(){
            $Parceiro = new ParceiroModel;
            $parceiro = $Parceiro->bloquear_parceiro();

            include('app/views/painel/padrao/relatorio/convenio_parceiro_bloquear.php');

            if(!empty($texto) && (isset($parceiro) && !empty($parceiro))):
                $email = [GERENTE_CONVENIO_EMAIL];
                Email::padrao('RELATÓRIO - PRAZO FECHAMENTO', 'CONVÊNIO', $email, $texto);
            else:
                exit();
            endif;
        }
    }
