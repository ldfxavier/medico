<?php

	namespace System;

	final class Painel {

		private $html = [];
		private $acao, $app, $config, $valor, $option;
		private $permissao, $admin;
		private $menu_ultimo;

		public function __construct($option){

			$this->app = $option['app'] ?? '';
			$this->acao = $option['acao'] ?? '';
			$this->config = $option['config'] ?? [];

			$this->option = $option;

			$this->permissao = $_SESSION['EQUIPE']->permissao ?? [];
			$this->admin = isset($_SESSION['EQUIPE']->admin) && true === $_SESSION['EQUIPE']->admin ? true : false;

		}

		public function valor($dado){

			$this->valor = $dado;

		}

		public function header(){
			
			$app = $this->app;
			
			if($this->acao == 'buscar'):
				require __DIR__.'/../files/painel/buscar_header.php';
			endif;

		}

		public function footer(){

			$app = $this->app;
			
			if($this->acao == 'buscar'):
				require __DIR__.'/../files/painel/buscar_footer.php';
			endif;

		}

		public function app(){
			
			$app = str_replace('-', '_', $this->app);

			$add = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/add.php')):
				$add = true;
			endif;
			$add_ajax = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/add_ajax.php')):
				$add_ajax = true;
			endif;
			$relatorio = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/relatorio.php')):
				$relatorio = true;
			endif;
			$download = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/download.php')):
				$download = true;
			endif;
			$historico = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/historico.php')):
				$historico = true;
			endif;
			$buscar = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/buscar.php')):
				$buscar = true;
			endif;
			$filtrar = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/filtrar.php')):
				$filtrar = true;
			endif;
			$deletar = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/models/deletar.php')):
				$deletar = true;
			endif;

			$editar = true;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/editar_ajax.php')):
				$editar = true;
			endif;
			$editar_ajax = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/editar_ajax.php')):
				$editar_ajax = true;
			endif;
			
			$visualizar = true;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/visualizar.php')):
				$visualizar = true;
			endif;
			$visualizar_ajax = false;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/visualizar_ajax.php')):
				$visualizar_ajax = true;
			endif;
			
			$previa = true;
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/previa.php')):
				$previa = true;
			endif;

			$dado = [];
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/models/app.php')):
				require __DIR__.'/../resources/views/painel/'.$app.'/models/app.php';
			endif;

			$lista = $this->config['lista'] ?? [];
			$where = $this->option['where'];

			require __DIR__.'/../files/painel/app_padrao_header.php';
			
			if(file_exists(__DIR__.'/../resources/views/painel/'.$app.'/views/listar.php')):
				require __DIR__.'/../resources/views/painel/'.$app.'/views/listar.php';
			else:
				require __DIR__.'/../files/painel/app_padrao_listar.php';
			endif;

			require __DIR__.'/../files/painel/app_padrao_footer.php';

		}


		// LISTA DE DADOS DO APP
		private function td($include, $indice, $option){

			$order = $option['order'] ?? false;
			$flex = $option['flex'] ?? false;
			$app = str_replace('_', '-', $this->app);
			$titulo = $option['titulo'] ?? '';
			$centralizar = $option['centralizar'] ?? '';
			$tamanho = $option['tamanho'] ?? '';
			$copiar = $option['copiar'] ?? '';
			$campo = $option['campo'] ?? $indice;
			$valor = $this->valor->$campo ?? '';

			if(true == $flex):
				$flex = 'flex_grow';
			else:
				$flex = '';
			endif;

			if(is_numeric($tamanho)):
				$tamanho = 'style="width: '.$tamanho.'px"';
			else:
				$tamanho = '';
			endif;

			if($centralizar):
				$centralizar = 'centralizar';
			endif;

			$order_class = '';
			if($order):
				
				$order_atual = $_SESSION['ORDER_'.$this->app] ?? [];
				$order_atual_campo = $order_atual[0] ?? '';
				$order_atual_tipo = $order_atual[1] ?? '';
				
				$order_tipo = 'ASC';
				$order_icone = '&#xe810;';

				if($order_atual_campo == $campo && $order_atual_tipo == 'ASC'):
					$order_tipo = 'DESC';
					$order_icone = '&#xf106;';
				endif;

				if($order_atual_campo == $campo):
					$order_class = 'order';
				endif;

				$order = [$indice, $order_tipo, $order_icone];
			endif;

			require __DIR__.'/../files/painel/'.$include.'.php';

		}

		public function selecao($lista){

			if($this->acao == 'titulo' && $lista):
				require __DIR__.'/../files/painel/app_titulo_selecao.php';
			elseif($this->acao == 'titulo' && !$lista):
				require __DIR__.'/../files/painel/app_titulo_selecao_limpo.php';
			else:
				require __DIR__.'/../files/painel/app_lista_selecao.php';
			endif;

		}
		public function ordem($indice, $option){

			if($this->acao == 'titulo'):
				require __DIR__.'/../files/painel/app_titulo_ordem.php';
			else:
				require __DIR__.'/../files/painel/app_lista_ordem.php';
			endif;

		}
		public function normal($indice, $option){

			if($this->acao == 'titulo'):
				$this->td('app_titulo_normal', $indice, $option);
			else:
				$this->td('app_lista_normal', $indice, $option);
			endif;

		}
		public function status($indice, $option){

			if($this->acao == 'titulo'):
				$this->td('app_titulo_status', $indice, $option);
			else:
				$this->td('app_lista_status', $indice, $option);
			endif;

		}
		public function imagem($indice, $option){

			if($this->acao == 'titulo'):
				$this->td('app_titulo_imagem', $indice, $option);
			else:
				$this->td('app_lista_imagem', $indice, $option);
			endif;

		}
		public function numero($indice, $option){

			if($this->acao == 'titulo'):
				$this->td('app_titulo_numero', $indice, $option);
			else:
				$this->td('app_lista_numero', $indice, $option);
			endif;

		}
		public function id($indice, $option){
			
			if($this->acao == 'titulo'):
				$this->td('app_titulo_id', $indice, $option);
			else:
				$this->td('app_lista_id', $indice, $option);
			endif;

		}




		// MENU PRINCIPAL
		public function titulo($titulo){

			if($this->acao == 'menu'):
				
				if($this->menu_ultimo == 'titulo'):
					array_pop($this->menu);
				endif;
				
				$this->html[] = require __DIR__.'/../files/painel/menu_titulo.php';
				$this->menu_ultimo = 'titulo';

			endif;

			return $this;
		}

		public function menu($option){

			if(!isset($option['titulo']) || !isset($option['icone']) || !isset($option['app'])):
				return $this;
			endif;

			$titulo = $option['titulo'];
			$icone = $option['icone'];
			$app = str_replace('-', '_', $option['app']);

			$link = LINK_PAINEL.'/app/'.$option['app'];
			if(isset($option['link'])):
				$link = LINK_PAINEL.$option['link'];
			endif;

			$hover = $app == $this->app ? 'hover' : '';
			$class = $option['class'] ?? '';

			$permissao = $option['permissao'] ?? $app;

			if(in_array($permissao.'_app', $this->permissao) || true === $this->admin):
				$this->html[] = require __DIR__.'/../files/painel/menu_normal.php';
				$this->menu_ultimo = 'menu';
			endif;

			return $this;

		}

		public function dropdown($option){

			if(!isset($option[0]['titulo']) || !isset($option[0]['icone']) || !isset($option[1])):
				return $this;
			endif;

			$titulo_principal = $option[0]['titulo'];
			$icone = $option[0]['icone'];
			$class_principal = $option[0]['class'] ?? '';
			$hover_principal = '';

			unset($option[0]);
			
			$menu_usado = [];
			foreach($option as $r):

				if(isset($r['titulo']) && isset($r['app'])):
					$titulo = $r['titulo'];
					$app = str_replace('-', '_', $r['app']);

					$link = LINK_PAINEL.'/app/'.$r['app'];
					if(isset($r['link'])):
						$link = LINK_PAINEL.$r['link'];
					endif;

					$hover = '';
					if($app == $this->app):
						$hover = 'hover';
						$hover_principal = 'hover';
					endif;
					$class = $r['class'] ?? '';

					$permissao = $r['permissao'] ?? $app;

					if(in_array($permissao.'_app', $this->permissao) || true === $this->admin):
						$menu_usado[] = require __DIR__.'/../files/painel/menu_dropdown_conteudo.php';
						$this->menu_ultimo = 'dropdown';
					endif;
				endif;
			endforeach;

			if($menu_usado):
				$header[] = require __DIR__.'/../files/painel/menu_dropdown_header.php';
				$footer[] = require __DIR__.'/../files/painel/menu_dropdown_footer.php';

				$this->html[] = implode('', array_merge($header, $menu_usado, $footer));
			endif;

			return $this;

		}

		public function get(){

			if($this->acao == 'menu'):
				return implode('', $this->html);
			endif;

		}

	}