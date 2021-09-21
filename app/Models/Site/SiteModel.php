<?php

	namespace App\Models\Site;

	use System\Model;
	use App\Helpers\Converter;

	final class Site extends Model {

        private $where, $where_or;
		public function __construct(){

			parent::__construct(TABELA_SITE);

		}

		private function validar_erro($busca){

			if(!$busca || isset($busca['erro'])):
				return false;
			endif;

			return true;

		}
		public function home(){
			

			$busca = $this->select()->campo(['cod', 'imagem', 'endereco', 'mapa', 'telefone', 'titulo_email', 'email', 'email_formulario', 'sobre', 'sobre_chamada', 'agendamento', 'facebook', 'instagram', 'twitter', 'youtube', 'whatsapp', 'link_agendamento'])->get();

			if(!$this->validar_erro($busca)):
				return [];
			endif;
			
			$array = [];

			foreach($busca as $r):
				$converter = new Converter;

				$array[] = (Object)[
					'id' => $r->cod,
					'endereco' => $r->endereco,
					'mapa' => $r->mapa,
					'telefone' => $converter->valor($r->telefone)->telefone()->r(),
					'titulo_email' => $r->titulo_email,
					'email' => $r->email,
					'email_formulario' => $r->email_formulario,
					'sobre' => $r->sobre,
					'sobre_chamada' => $r->sobre_chamada,
					'agendamento' => $r->agendamento,
					'facebook' => $r->facebook,
					'instagram' => $r->instagram,
					'twitter' => $r->twitter,
					'youtube' => $r->youtube,
					'whatsapp'  => (object)[
						'link' => 'https://api.whatsapp.com/send/?phone=55'.preg_replace("/[^0-9]/", "", $r->whatsapp),
						'valor' => (new Converter)->valor($r->whatsapp)->telefone()->r()
					], 
					'link_agendamento' => $r->link_agendamento,
					'imagem' => LINK_ARQUIVO.'/site/'.$r->imagem
				];

			endforeach;

			return $array[0];

       
		}
		
		public function sobre(){
			

			$busca = $this->select()->campo(['cod', 'sobre'])->get();

			if(!$this->validar_erro($busca)):
				return [];
			endif;
			
			$array = [];

			foreach($busca as $r):
				$converter = new Converter;

				$array[] = (Object)[
					'id' => $r->cod,
					'sobre' => $r->sobre,
				];

			endforeach;

			return $array[0];

        }
		
		public function galeria(){
			

			$FotoGaleria = new GeralFoto('site/galeria');
			$busca = $this->select()->campo(['cod'])->get();

			if(!$this->validar_erro($busca)):
				return [];
			endif;
			
			$array = [];

			foreach($busca as $r):
				$converter = new Converter;

				$array[] = (Object)[
					'id' => $r->cod,
					'lista' => $FotoGaleria->listar_galeria($r->cod, 'site'),
				];

			endforeach;

			return $array[0];

        }
        
        

	}
