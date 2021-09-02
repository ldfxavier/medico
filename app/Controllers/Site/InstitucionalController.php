<?php

	namespace App\Controllers\Site;

	use System\Controller;

	class Institucional extends Controller {
		
		public function quem_somos(){


			return view('site.quem_somos', [
                'menu' => 'quem somos'
            ]);

		}

		public function prevencao(){


			return view('site.prevencao', [
                'menu' => 'prevenção'
            ]);

		}

		public function oportunidade(){


			return view('site.oportunidade', [
                'menu' => 'oportunidade'
            ]);

		}


		public function dicas(){


			return view('site.dicas', [
                'menu' => 'dicas'
            ]);

		}

	}