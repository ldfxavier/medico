<?php
    class exemplosController extends Controller {

        public function init(){
            if(SISTEMA == 'producao') $this->erro();
        }

        public function index(){
            $Notificacao = new NotificacaoModel;
            $Notificacao->salvar([1,2], ['convenio_parceiro' => 123], 'NOVA INDICAÇÃO NO PAINEL', 'Aqui vai um teste de texto para o e-mail de notificações do sistema.', PAINEL.'/visualizar/convenio_parceiro/123', true);
        }

        public function formulario(){
            $this->view('exemplos.formulario');
        }

        public function pagina(){
            $this->view('exemplos.pagina');
        }
        public function pagina_conteudo(){
            sleep(1);
            $dados['titulo'] = $this->getSep(2);
            $this->view('!exemplos.pagina_conteudo', $dados);
        }

        public function alerta(){
            $this->view('exemplos.alerta');
        }

        public function banner(){
            $this->view('exemplos.banner');
        }

        public function galeria(){
            $this->view('exemplos.galeria');
        }

        public function css(){
            $this->view('exemplos.css');
        }
    }
