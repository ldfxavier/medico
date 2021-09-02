<?php

	namespace App\Classes\ApiPadrao;

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Authorization, Token, Content-Type, Accept');

	use System\Controller as ControllerPadrao;

	abstract class Controller extends ControllerPadrao {

		protected $DADO;

		protected function metodo_permitido($metodo){

			header('Access-Control-Allow-Methods: '.implode(', ', $metodo));

		}

		protected function listar(){

			if(__METODO != 'GET'):
				return Mensagem_codigo(405, '', 405);
			elseif(empty($this->GET())):
				return Mensagem_codigo(704, '', 400);
			endif;

			return $this->MODEL->listar($this->GET());

		}

		protected function id($id){

			if(__METODO != 'GET'):
				return Mensagem_codigo(405, '', 405);
			elseif(empty($id)):
				return Mensagem_codigo(707, '', 400);
			endif;

			return $this->MODEL->buscar($id);

		}

		protected function salvar(){

			if(__METODO != 'POST'):
				return Mensagem_codigo(405, '', 405);
			elseif(empty($this->POST())):
				return Mensagem_codigo(705, '', 400);
			endif;

			return $this->MODEL->salvar($this->POST());

		}

		protected function atualizar($uuid){

			if(__METODO != 'PUT'):
				return Mensagem_codigo(405, '', 405);
			elseif(empty($this->PUT())):
				return Mensagem_codigo(706, '', 400);
			endif;

			return $this->MODEL->atualizar($this->PUT(), $uuid);

		}

		protected function deletar($id){

			if(__METODO != 'DELETE'):
				return Mensagem_codigo(405, '', 405);
			elseif(empty($id)):
				return Mensagem_codigo(707, '', 400);
			endif;

			return $this->MODEL->deletar($id);

		}

	}