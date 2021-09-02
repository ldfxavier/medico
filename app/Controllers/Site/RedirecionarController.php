<?php
	
	namespace App\Controllers\Site;

	use System\Controller;
	use App\Models\Site\GeralRedirecionar;

	final class Redirecionar extends Controller {

		public function geral($tipo, $url){

			$link = (new GeralRedirecionar)->pegar_link_de_redirecionamento($tipo, $url);

			return location($link);

		}

	}