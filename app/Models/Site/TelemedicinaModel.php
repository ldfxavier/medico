<?php

	namespace App\Models\Site;

	use System\Model;
	use App\Helpers\{Data, Video, Converter};

	final class Telemedicina extends Model {

        private $where, $where_or;
		public function __construct(){

			parent::__construct(TABELA_TELEMEDICINA);

		}

		private function validar_erro($busca){

			if(!$busca || isset($busca['erro'])):
				return false;
			endif;

			return true;

		}

		private function montar($dado){

			if($dado):


				$Data = new Data;

				$r = $dado;

				$imagem = (isset($r->imagem) && !empty($r->imagem)) ? LINK_ARQUIVO.'/telemedicina/'.$r->imagem : "";
			
				
				return (Object)[
					'id' => $r->cod,
					'titulo' => $r->titulo,
					'texto' => $r->texto,
					'imagem' => LINK_ARQUIVO.'/telemedicina/'.$r->imagem,
					'data' => (object)[
						'postagem' => $Data->valor($r->data_criacao)->formato('d/m/Y \à\s H:i')
					],
					'video' => (new Video)->link($r->video)->iframe(),
				];

			endif;

			return [];

		}
		public function local($id){

			$busca = $this->select()->campo(['cod', 'imagem', 'titulo', 'texto', 'video',  'data_criacao', 'status', 'local'])
			->where([
				['status', 1],
				['local', $id]
			])->get()[0] ?? [];

			if(!$busca):
				return [];
			endif;

			return $this->montar($busca);

		}

		public function url($url){

			$busca = $this->select()->campo(['cod', 'imagem', 'titulo', 'texto', 'video',  'data_criacao', 'status', 'local'])
			->where([
				['status', 1],
				['cod', $url]
			])->get()[0] ?? [];

			if(!$busca):
				return [];
			endif;

			return $this->montar($busca);

		}

	}
