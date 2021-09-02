<?php

	namespace App\Controllers\Site;

	use System\Controller;

	class Fazemos extends Controller {
		
		public function index($pagina = 1){


			return view('site.fazemos_lista', [
                'menu' => 'fazemos'
            ]);

		}

		public function pagina($pagina){

			if($pagina == 1):
				return location(LINK.\Route::link('fazemos.index'));
			endif;

			return $this->index($pagina);

		}


		public function detalhe($url){

			return view('site.fazemos_detalhe', [
                'menu' => 'fazemos'
            ]);

		}

	}