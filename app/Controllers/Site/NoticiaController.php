<?php

	namespace App\Controllers\Site;

	use System\Controller;

	class Noticia extends Controller {
		
		public function index($pagina = 1){


			return view('site.noticia_lista', [
                'menu' => 'noticia'
            ]);

		}

		public function pagina($pagina){

			if($pagina == 1):
				return location(LINK.\Route::link('noticia.index'));
			endif;

			return $this->index($pagina);

		}


		public function detalhe($url){

			return view('site.noticia_detalhe', [
                'menu' => 'noticia'
            ]);

		}

	}