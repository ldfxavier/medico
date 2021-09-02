<?php
	class System {

		private $_url;
		protected $_explode;
		private $_controller;
		protected $_action;
		private $_parametro;
		protected $_limite = 1;
		protected $_limite_forcar = true;

		public function __construct(){
			$this->setUrl();
			$this->setExplode();
			$this->setController();
			$this->setAction();
			$this->setPar();
		}

		private function setUrl(){
			$this->_url = (isset($_GET['url']) ? $_GET['url'] : "index/index");
		}

		private function setExplode(){
			$this->_explode = explode("/", $this->_url);
		}

		private function setController(){
			$this->_controller = str_replace('-', '_', $this->_explode[0]).'Controller';
		}

		private function setAction(){
			$this->_action = (!isset($this->_explode[1]) || empty($this->_explode[1])) ? "index" : str_replace('-', '_', $this->_explode[1]);
		}

		private function setPar(){
			$explode = $this->_explode;
			unset($explode[0], $explode[1]);

			if(end($explode) == null) array_pop($explode);

			$indices = array();
			$valores = array();
			$i = 0;
			if(!empty($explode)):
				foreach($explode as $val):
					if($i % 2 == 0) $indices[] = $val;
					else $valores[] = $val;
					$i++;
				endforeach;
			endif;

			if(count($indices) == count($valores) && !empty($indices) && !empty($valores)) $this->_parametro = array_combine($indices, $valores);
			else $this->_parametro = array();
		}

		public function setLimite($limite, $forcar = true){
			$this->_limite = $limite;
			$this->_limite_forcar = ($forcar == true) ? true : false;
		}

		public function getSep($numero = null){
			if($this->_limite != '*') $this->_limite = $numero;
			if(isset($this->_explode[$numero])):
				return $this->_explode[$numero];
			else:
				return false;
			endif;
		}

		public function getPar($nome = null){
			$this->_limite = '*';
			if($nome != null && isset($this->_parametro[$nome])):
				return $this->_parametro[$nome];
			else:
				return false;
			endif;
		}

		protected function pagina_erro(){
			$_SERVER['REDIRECT_STATUS'] = 404;
			$pagina = '404_html';
			if(strstr($this->_url, '.')):
				$ext = explode('.', $this->_url);
				$ext = mb_strtolower(end($ext), 'UTF-8');
				if(in_array($ext, array('png', 'gif', 'jpg', 'jpeg', 'svg'))) $pagina = '404_imagem';
				elseif(in_array($ext, array('mp3', 'mp4', 'wave'))) $pagina = '404_musica';
				elseif(in_array($ext, array('rar', 'zip'))) $pagina = '404_zip';
				elseif(strlen($ext) == 3 || strlen($ext) == 4) $pagina = '404_arquivo';
			endif;
			include('system/.erro/'.$pagina.'.php');
			exit();
		}

		public function run(){
			$controller_path = CONTROLLERS.$this->_controller.'.php';

			if(substr(str_replace(' ', '+', $this->_controller), 0, 1) == '+' && file_exists(CONTROLLERS.'perfilController.php')):
				require_once(CONTROLLERS.'perfilController.php');
				$this->_controller = 'perfilController';
				$app = new $this->_controller();
			elseif(!file_exists($controller_path) && file_exists(CONTROLLERS.'erroController.php')):
				$_SERVER['REDIRECT_STATUS'] = 404;
				require_once(CONTROLLERS . "erroController.php");
				$this->_controller = 'erroController';
				$app = new $this->_controller();
			elseif(!file_exists($controller_path) && !file_exists(CONTROLLERS.'erroController.php')):
				$this->pagina_erro();
			else:
				require_once($controller_path);
				$app = new $this->_controller();
			endif;

			if(!method_exists($app, $this->_action) && method_exists($app, 'detalhe')):
				$app = new $this->_controller();
				$app->init();
				$app->detalhe();
			elseif(!method_exists($app, $this->_action) && file_exists(CONTROLLERS.'erroController.php')):
				require_once(CONTROLLERS . "erroController.php");
				$app = new erroController();
				$app->index();
			elseif(!method_exists($app, $this->_action) && !file_exists(CONTROLLERS.'erroController.php')):
				$this->pagina_erro();
			else:
				$action = $this->_action;
				$app->init();
				$app->$action();
			endif;
		}

	}
