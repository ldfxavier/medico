<?php

	namespace App\Models\Site;

	use App\Marktclub\Api;
	use App\Models\Site\ConvenioParceiro;

	final class GeralRedirecionar {

		private function pegar_link_do_parceiro($url){

			return (new Api)->get('/parceiro/'.$url)->object()->contato->site ?? LINK.'/convenios';

		}
		private function pegar_link_do_cashback($url){
			
			return (new Api)->get('/cashback/'.$url)->object()->link ?? LINK.'/cashback';

		}

		public function pegar_link_de_redirecionamento($tipo, $url){

			if($tipo == 'parceiro'):
				return $this->pegar_link_do_parceiro($url);
			elseif($tipo == 'cashback'):
				return $this->pegar_link_do_cashback($url);
			endif;

		}

	}