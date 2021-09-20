<?php

	namespace App\Models\Site;

	use System\Model;

	final class PublicidadeBanner extends Model {

        private $where, $where_or;
		public function __construct(){

			parent::__construct(TABELA_PUBLICIDADE_BANNER);


			$agora = date('Y-m-d H:i:s');

			$this->where = [
				['status', 1],
				['data_postagem_inicio', '<=', $agora]
			];
			$this->where_or = [
				['data_postagem_final', '>=', $agora],
				['data_postagem_final', 'isnull']
			];

		}

		private function validar_erro($busca){

			if(!$busca || isset($busca['erro'])):
				return false;
			endif;

			return true;

		}
		public function topo(){
			
			$agora = date('Y-m-d H:i:s');

			$busca = $this->select()->campo(['cod', 'imagem', 'titulo', 'texto', 'link', 'target'])->where([
				['status', 1],
				['local', 1],
				['data_postagem_inicio', '<=', $agora],
				['data_postagem_final', '>=', $agora]
			])->order('ordem', 'ASC')->get();

			if(!$this->validar_erro($busca)):
				return [];
			endif;
			
			$array = [];

			foreach($busca as $r):

				$array[] = (Object)[
					'id' => $r->cod,
					'titulo' => $r->titulo,
					'texto' => $r->texto,
					'imagem' => LINK_ARQUIVO.'/banner/'.$r->imagem,
					'url' => (object)[
						'target' => $r->target,
						'link' => $r->link
					],
				];

			endforeach;

			return $array;

        }

		public function localizacao(){
			
			$agora = date('Y-m-d H:i:s');

			$busca = $this->select()->campo(['cod', 'imagem', 'titulo', 'texto', 'link', 'target'])->where([
				['status', 1],
				['local', 2],
				['data_postagem_inicio', '<=', $agora],
				['data_postagem_final', '>=', $agora]
			])->order('ordem', 'ASC')->get();

			if(!$this->validar_erro($busca)):
				return [];
			endif;
			
			$array = [];

			foreach($busca as $r):

				$array[] = (Object)[
					'id' => $r->cod,
					'titulo' => $r->titulo,
					'texto' => $r->texto,
					'imagem' => LINK_ARQUIVO.'/banner/'.$r->imagem,
					'url' => (object)[
						'target' => $r->target,
						'link' => $r->link
					],
				];

			endforeach;

			return $array;

        }
        

	}
