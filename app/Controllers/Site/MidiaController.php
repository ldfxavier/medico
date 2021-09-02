<?php

	namespace App\Controllers\Site;

	use System\Controller;

	class Midia extends Controller {
		
		public function index($pagina = 1){


			return view('site.midia_lista', [
                'menu' => 'midia'
            ]);

		}

		public function pagina($pagina){

			if($pagina == 1):
				return location(LINK.\Route::link('midia.index'));
			endif;

			return $this->index($pagina);

		}


		public function detalhe($url){

			return view('site.midia_detalhe');

		}

	}