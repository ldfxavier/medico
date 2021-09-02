<?php
	
	namespace App\Controllers\Painel;

	use System\Controller;
	
	class Pagina extends Controller {


		public function app($app, $pagina){

			$_SESSION['PAGINA_'.str_replace('-', '_', $app)] = $pagina;

			return location(LINK_PAINEL.'/app/'.$app);

		}

	}