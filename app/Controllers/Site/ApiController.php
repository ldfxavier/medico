<?php

	namespace App\Controllers\Site;

	use System\Controller;
	use App\Helpers\{Localizacao, Validar};

	class Api extends Controller {

		public function get_geocode(){

			return (new Localizacao)->endereco($this->GET('valor'))->geolocalizacao();

			(new Api)->parametro([
				'nome' => 'documento-cpf'
			])->arquivo([
				'arquivo' => $_FILES['arquivo']['tmp_name']
			]);

		}

		public function get_documento(){

			$documento = $this->GET('documento');

			if(empty($documento)):
				return ['erro' => true];
			endif;

			return [
				'erro' => !(new Validar)->valor($documento, '')->obrigatorio()->vazio()->cpf()->b()
			];

		}

	}
