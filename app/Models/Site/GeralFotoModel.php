<?php

	namespace App\Models\Site;
	
	use System\Model;

	final class GeralFoto extends Model {

		public function __construct(){

			parent::__construct(TABELA_GERAL_FOTO);

		}

		public function lista($vinculo){

			$busca = $this->select()->campo(['foto_titulo', 'imagem'])->where([
				['status', 1],
				['vinculo', $vinculo]
			])->order('id', 'DESC')->get();

			if(!$this->validar_busca($busca)):
				return [];
			endif;

			$array = [];
			
			foreach($busca as $r):

				$array[] = (object)[
					'titulo' => $r->foto_titulo,
					'imagem' => LINK_ARQUIVO.'/foto/'.$r->imagem
				];

			endforeach;

			return $array;

		}

		public function listar_galeria($id_vinculo, $diretorio){
			$busca = $this->select()->campo(['foto_titulo', 'imagem'])->where([
				['status', 1],
				['vinculo', $id_vinculo]
			])->order('id', 'ASC')->get();

			if(!$this->validar_busca($busca)):
				return [];
			endif;

			$array = [];
			
			foreach($busca as $r):

				$array[] = (object)[
					'titulo' => $r->foto_titulo,
					'imagem' => LINK_ARQUIVO.'/'.$diretorio.'/galeria/'.$r->imagem
				];

			endforeach;

			return $array;
		}
		

	}
