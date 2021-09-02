<?php

	namespace App\Classes\PainelPadrao;

	use System\Controller as ControllerPadrao;

	abstract class Controller extends ControllerPadrao {

		protected function config($app){

			if(file_exists(__ROOT.'/resources/views/painel/'.$app.'/config.php')):
				return include(__ROOT.'/resources/views/painel/'.$app.'/config.php');
			endif;

			return [];

		}

		protected function converter_nome_app($app){
			return str_replace('-', '_', $app);
		}

	}
