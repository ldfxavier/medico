<?php

	namespace App\Middlewares\Site;

	class Menu {
	
		public function validar(String $local){

			if(!isset($_SESSION['CLUBE']) || !is_object($_SESSION['CLUBE']) || !isset($_SESSION['CLUBE']->menu->$local) || false === $_SESSION['CLUBE']->menu->$local):
				return mensagem_codigo(404);
			endif;

			return true;

		}

	}