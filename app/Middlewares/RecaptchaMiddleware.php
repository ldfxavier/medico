<?php

	namespace App\Middlewares;

	final class Recaptcha {

		private function erro(){

			return mensagem_erro('Ocorreu um erro!', 'Ocorreu um erro ao autentivar, tente novamente.', 400);

		}

		private function validar($recaptcha){

			if(!empty($recaptcha)):
				if(true === recaptcha($recaptcha)):
					return true;
				endif;
			endif;

			return $this->erro();
		}

		public function post(){
			if('POST' === __METODO):
				return $this->validar(__POST['recaptcha'] ?? false);
			endif;
			return $this->erro();
		}

		public function get(){
			if('GET' === __METODO):
				return $this->validar(__GET['recaptcha'] ?? false);
			endif;
			return $this->erro();
		}

	}