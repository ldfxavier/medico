<?php

	namespace App\Controllers\Painel;

	use \System\Controller;
	use App\Models\Painel\{PublicacaoNoticia, GeralArquivo, UsuarioCliente};

	final class Script extends Controller {

		public function index(){
		}

		public function noticia(){
			
			return false;
			// return (new PublicacaoNoticia)->migrar();

		}

		public function imagem(){
			
			return false;
			// return (new GeralArquivo)->migrar();

		}

		public function galeria(){

			return false;
			// return (new GeralArquivo)->galeria();

		}

		public function usuario(){

			return false;
			// return (new UsuarioCliente)->migrar();

		}

	}
