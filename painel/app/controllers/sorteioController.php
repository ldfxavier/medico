<?php
    class sorteioController extends Controller {

        public function index(){}

        public function sindireceita(){
            $Sorteio = new SorteioModel;
            $regiao = isset($_POST['regiao']) ? $_POST['regiao'] : '';
            $ganhador = false;
            if(!empty($regiao)):
                $ganhador = $Sorteio->buscar($regiao);
            endif;
            $dados['ganhador'] = $ganhador;
            $this->view('!sorteio.sindireceita', $dados);
        }

    }
