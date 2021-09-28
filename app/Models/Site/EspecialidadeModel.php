<?php

	namespace App\Models\Site;

	use System\Model;
	use App\Helpers\{Data, Video, Converter};

	final class Especialidade extends Model {

        private $where, $where_or;
		public function __construct(){

			parent::__construct(TABELA_ESPECIALIDADES);

		}

		private function validar_erro($busca){

			if(!$busca || isset($busca['erro'])):
				return false;
			endif;

			return true;

		}
		public function home(){
			
			$agora = date('Y-m-d H:i:s');

			$busca = $this->select()->campo(['cod', 'imagem', 'titulo', 'texto', 'video',  'data_postagem_inicio', 'status', 'url'])->where([
				['status', 1],
				['data_postagem_inicio', '<=', $agora],
			])->order('data_postagem_inicio', 'ASC')->get();

			if(!$this->validar_erro($busca)):
				return [];
			endif;
			
			$array = [];

			foreach($busca as $r):

				$array[] = (Object)[
					'id' => $r->cod,
					'titulo' => $r->titulo,
					'texto' => mb_strimwidth($r->texto, 0, 180, "..."),
					'url' => $r->url,
					'imagem' => LINK_ARQUIVO.'/especialidades/'.$r->imagem,
					'status' => $r->status,
					'video' => (new Video)->link($r->video)->iframe(),
				];

			endforeach;

			return $array;

        }



		private function montar($dado){

			if($dado):


				$Data = new Data;

				$r = $dado;

				$imagem = (isset($r->imagem) && !empty($r->imagem)) ? LINK_ARQUIVO.'/especialidades/'.$r->imagem : "";
			
				
				return (Object)[
					'id' => $r->cod,
					'titulo' => $r->titulo,
					'texto' => $r->texto,
					'imagem' => LINK_ARQUIVO.'/especialidades/'.$r->imagem,
					'data' => (object)[
						'postagem' => $Data->valor($r->data_postagem_inicio)->formato('d/m/Y \à\s H:i')
					],
					'video' => (new Video)->link($r->video)->iframe(),
				];

			endif;

			return [];

		}

		public function url($url){

			$busca = $this->select()->campo(['cod', 'imagem', 'titulo', 'texto', 'video',  'data_postagem_inicio', 'status', 'url'])
			->where([
				['status', 1]
			])->where(['url', $url])
			->get()[0] ?? [];

			if(!$busca):
				return [];
			endif;

			return $this->montar($busca);

		}

	}
