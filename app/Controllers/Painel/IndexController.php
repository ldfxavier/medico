<?php

	namespace App\Controllers\Painel;

	use \System\Controller;

	final class Index extends Controller {

		public function index(){

			return view('dashboard', [
				'app' => 'dashboard'
			]);

		}

	}
