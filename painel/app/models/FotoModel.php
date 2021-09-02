<?php
    class FotoModel extends Model {

        public $_tabela = 'geral_foto';

        public function capa($cod){
            $dado = $this->read("`vinculo` = '{$cod}' AND `status` = 1 AND `destaque` = 1");
            return $dado ? ARQUIVO.'/foto/'.$dado[0]->imagem : PAINEL.'/images/painel/imagem_padrao.png';
        }

        public function lista($cod){
            $dado = $this->read("`vinculo` = '{$cod}' AND `status` = 1");

            $array = [];
            if($dado):
                foreach($dado as $r):
                    $array[] = (object)[
                        'id' => $r->id,
                        'foto_titulo' => $r->foto_titulo,
                        'imagem' => (object)[
                            'link' => ARQUIVO.'/foto/'.$r->imagem,
                            'valor' => $r->imagem
                        ]
                    ];
                endforeach;
            endif;
            return $array;
        }

        public function atualizar_capa($id, $cod){
            $this->update(['destaque' => 2], "`vinculo` = '{$cod}'");
            return $this->update(['destaque' => 1], "`id` = '{$id}'");
        }
        public function deletar($id){
            return $this->delete('id', $id);
        }

        public function salvar($dados){
            return $this->insert($dados, true);
        }

        public function id($id){
            $dado = $this->read("`id` = '{$id}'");
            if($dado):
                return $dado[0];
            endif;
            return false;
        }

        
		public function galeria(String $id_vinculo, String $diretorio){
			$dado = $this->read("`vinculo` = '{$id_vinculo}'");

			if(!$dado):
				return [];
			endif;

			$array = [];
            foreach($dado as $r):
				$array[] = (Object)[
					'id' => $r->id,
					'cod' => $r->cod,
					'foto_titulo' => $r->foto_titulo,
					'imagem' => (object)[
						'link' => ARQUIVO.'/'.$diretorio.'/'.$r->imagem,
						'valor' => $r->foto_titulo
					]
				];
			endforeach;
		
			return $array;
        }
    }
