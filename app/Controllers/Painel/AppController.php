<?php

	namespace App\Controllers\Painel;

	use App\Classes\PainelPadrao\Controller as Padrao;

	final class App extends Padrao {

		public function index($app){

			$app = $this->converter_nome_app($app);

			if(file_exists(__ROOT.'/resources/views/painel/'.$app.'/models/app.php')):
				include(__ROOT.'/resources/views/painel/'.$app.'/models/app.php');
			endif;

			$config = $this->config($app);

			if(!isset($_SESSION['ORDER_'.$app])):
				$_SESSION['ORDER_'.$app] = $config['app']['order'] ?? [];
			endif;

			return view('painel.app_'.$app.'.views.index', [
				'dado' => $dado ?? [],
				'app' => $app,
				'config' => $config['app'] ?? [],
				'where' => $this->montar_busca($app)
			]);

		}

		public function editar($app, $uuid){
			
			$app = $this->converter_nome_app($app);

			if(!file_exists(__ROOT.'/resources/views/painel/'.$app.'/models/editar.php')):
				return error404();
			endif;

			include(__ROOT.'/resources/views/painel/'.$app.'/models/editar.php');

			$config = $this->config($app);

			return view('painel.'.$app.'.views.editar', [
				'dado' => $dado,
				'config' => $config['editar'] ?? [],
				'app' => $app
			]);

		}

		public function add($app){

			$app = $this->converter_nome_app($app);

			if(file_exists(__ROOT.'/resources/views/painel/'.$app.'/models/add.php')):
				include(__ROOT.'/resources/views/painel/'.$app.'/models/add.php');
			endif;

			$config = $this->config($app);

			return view('painel.'.$app.'.views.add', [
				'dado' => $dado ?? [],
				'config' => $config['add'] ?? [],
				'app' => $app
			]);

		}

		public function buscar($app){
			
			$app = $this->converter_nome_app($app);

			$config = $this->config($app);

			return view('!painel.'.$app.'.views.buscar', [
				'config' => $config['add'] ?? [],
				'app' => $app
			]);

		}

		public function popup($app, $pagina){

			$app = $this->converter_nome_app($app);

			return view('!painel.'.$app.'.view.'.$pagina, [
				'app' => $app
			]);

		}

		



		private function montar_busca($app){
			
			$busca = $_SESSION['BUSCAR_'.$app] ?? [];
			if(!$busca):
				return [];
			endif;

			$config = $this->config($app);
			$titulo = $config['app']['buscar'] ?? [];

			$array = [];

			foreach($busca as $ind => $val):
				$array[] = (Object)[
					'titulo' => isset($titulo[$ind]) ? $titulo[$ind].':' : '',
					'valor' => $val,
					'campo' => $ind
				];
			endforeach;

			return $array;

		}

		public function post_salvar($app){
			
			
		}

		public function delete_deletar($app){

		}

		public function put_atualizar($app){

		}

	}
