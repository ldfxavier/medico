<?php

	namespace App\Controllers\Painel;

	use \System\Controller;

	final class Busca extends Controller {

		public function index(){}

		public function normal($app){

			if(file_exists(__ROOT.'/resources/views/painel/'.$app.'/models/buscaNormal.php')):
				include(__ROOT.'/resources/views/painel/'.$app.'/models/buscaNormal.php');
			endif;

			$this->criar_sessao_com_busca($app, $busca ?? []);

			return $this->retornar_para_o_app($app);

		}

		public function especial($app){

			if(file_exists(__ROOT.'/resources/views/painel/'.$app.'/models/buscaEspecial.php')):
				include(__ROOT.'/resources/views/painel/'.$app.'/models/buscaEspecial.php');
			endif;

			$this->criar_sessao_com_busca($app, $busca ?? []);

			return $this->retornar_para_o_app($app);

		}

		public function remover($app, $campo){

			if(isset($_SESSION['BUSCA_'.$app][$campo])):
				unset($_SESSION['BUSCA_'.$app][$campo]);
			endif;

			return $this->retornar_para_o_app($app);

		}

		public function limpar($app){

			if(isset($_SESSION['BUSCA_'.$app])):
				unset($_SESSION['BUSCA_'.$app]);
			endif;

			return $this->retornar_para_o_app($app);

		}

		private function criar_sessao_com_busca($app, $dado){

			if($dado):
				$_SESSION['BUSCA_'.$app] = $dado;
			endif;

		}

		private function retornar_para_o_app($app){

			return location(LINK_PAINEL.'/app/'.$app);

		}

	}
