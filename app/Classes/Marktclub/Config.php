<?php
	namespace App\Marktclub;

	abstract class Config {

		private $link = LINK_API;
		private $client_id = CLIENT_ID;
		private $secret_id = SECRET_ID;

		protected function link(){

			return $this->link;

		}

		protected function client_id(){

			return $this->client_id;

		}

		protected function secret_id(){

			return $this->secret_id;

		}

	}
