<?php

	namespace System;

	abstract class Controller {

		protected function GET(String $parametro = '', $padrao = null){

			$metodo = __METODO == 'GET';

			if(!$metodo):
				trigger_error('Você está pedindo um GET em uma requisição '.__METODO.'.');
			elseif($metodo && !empty($parametro) && !isset(__GET[$parametro]) && is_null($padrao)):
				trigger_error('O '.$parametro.' não existe.');
				return false;
			elseif($metodo && !empty($parametro) && isset(__GET[$parametro])):
				return __GET[$parametro];
			elseif($metodo && !empty($parametro) && !isset(__GET[$parametro]) && !is_null($padrao)):
				return $padrao;
			elseif($metodo && empty($parametro)):
				return __GET;
			endif;

			trigger_error('O indice '.$parametro.' não pode ser resolvido no método '.__METODO.'.');

		}
		protected function POST(String $parametro = '', $padrao = null){

			$metodo = __METODO == 'POST';

			if(!$metodo):
				trigger_error('Você está pedindo um POST em uma requisição '.__METODO.'.');
			elseif($metodo && !empty($parametro) && !isset(__POST[$parametro]) && is_null($padrao)):
				trigger_error('O '.$parametro.' não existe.');
				return false;
			elseif($metodo && !empty($parametro) && isset(__POST[$parametro])):
				return __POST[$parametro];
			elseif($metodo && !empty($parametro) && !isset(__POST[$parametro]) && !is_null($padrao)):
				return $padrao;
			elseif($metodo && empty($parametro)):
				return __POST;
			endif;

			trigger_error('O indice '.$parametro.' não pode ser resolvido no método '.__METODO.'.');

		}
		protected function PUT(String $parametro = ''){

			$metodo = __METODO == 'PUT';

			if(!$metodo):
				trigger_error('Você está pedindo um PUT em uma requisição '.__METODO.'.');
			elseif($metodo && !empty($parametro) && !isset(__PUT[$parametro]) && is_null($padrao)):
				trigger_error('O '.$parametro.' não existe.');
				return false;
			elseif($metodo && !empty($parametro) && isset(__PUT[$parametro])):
				return __PUT[$parametro];
			elseif($metodo && !empty($parametro) && !isset(__PUT[$parametro]) && !is_null($padrao)):
				return $padrao;
			elseif($metodo && empty($parametro)):
				return __PUT;
			endif;

			trigger_error('O indice '.$parametro.' não pode ser resolvido no método '.__METODO.'.');

		}

	}
