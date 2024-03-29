<?php

	namespace App\Models\Site;

	use System\Model;
	use App\Helpers\{Data};

	final class Formulario extends Model {

		private $where, $where_or;

		public function __construct(){

			parent::__construct(TABELA_FORMULARIO);


			$this->where = [
				['status', 1]
			];

		}

		private function montar_pequeno($dado){
			
			$array = [];

			foreach($dado as $r):

				$array[] = (Object)[
					'id' => $r->cod,
					'titulo' => $r->titulo,
					'link' => LINK_ARQUIVO.'/formulario/'.$r->arquivo
				];

			endforeach;

			return $array;
		}

		public function url(){

			$busca = $this->select()->campo(['cod', 'titulo', 'arquivo', 'data_criacao', 'status', 'local'])
			->where([
				['status', 1]
			])
			->get() ?? [];

			if(!$busca):
				return [];
			endif;

			return $this->montar_pequeno($busca);

		}

	}
