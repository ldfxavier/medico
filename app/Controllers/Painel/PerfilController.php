<?php

	namespace App\Controllers\Painel;

	use App\Classes\PainelPadrao\Controller as Padrao;

	final class Perfil extends Padrao {

		public function index(){

			$config = $this->config('perfil');

			return view('painel.perfil.views.index', [
				'config' => $config['app'] ?? []
			]);

		}

		public function dados(){

			$config = $this->config('perfil');

			return view('painel.perfil.views.dados', [
				'config' => $config['dados'] ?? []
			]);

		}

		public function senha(){

			return view('painel.perfil.views.senha');

		}

		public function configuracoes(){

			return view('painel.perfil.views.configuracoes');

		}

		public function facebook(){

			return view('painel.perfil.views.facebook');

		}

		public function google(){

			return view('painel.perfil.views.google');

		}

	}
