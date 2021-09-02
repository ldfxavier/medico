<?php
	
	namespace App\Controllers\Painel;

	use System\Controller;
	
	class Pesquisa extends Controller {

		public function get_buscar(){

		}

		public function get_rapida(){

			$pesquisa = $this->GET('pesquisa');
			$app = $this->GET('app');

			$_SESSION['BUSCAR_'.$app] = ['pesquisa' => $pesquisa];

			return location(LINK_PAINEL.'/app/'.$app);

		}

		public function get_remover($app, $indice){

			$app_link = $app;
			$app = str_replace('-', '_', $app);

			if($indice == 'todos' && isset($_SESSION['BUSCAR_'.$app])):
				unset($_SESSION['BUSCAR_'.$app]);
			elseif(isset($_SESSION['BUSCAR_'.$app][$indice])):
				unset($_SESSION['BUSCAR_'.$app][$indice]);
			endif;

			return location(LINK_PAINEL.'/app/'.$app);

		}

	}