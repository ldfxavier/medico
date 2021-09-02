<?php
	class emailController extends Controller {

		/**
		 * E-MAIL PARA ROTINAS DO USUÁRIO
		**/
		public function rotina_usuario_indicacao(){
			$dados['dia'] = $this->getSep(2);
			$this->view('!email.rotina_usuario_indicacao', $dados);
		}

		public function aviso_parceiro(){
			$dados['parceiro'] =  $this->getSep(2);
			$dados['empresa'] = $this->getSep(3);

			$this->view('!email.aviso_parceiro', $dados);
		}

		public function aviso_indicacao(){
			$dados['cod'] = $this->getSep(2);
			$this->view('!email.aviso_indicacao', $dados);
		}
		public function status_negativo_indicacao(){
			$id = $this->getSep(2);

			$Construtor = new ConstrutorModel;

			$empresa = $Construtor->p_empresa($id);

			$dados['cor'] = $empresa->cor;
			$dados['logo'] = $empresa->imagem->logo->link;
			$dados['indicacao'] = $empresa->link->site."/convenios/lista#indicar-parceiro";
			$this->view('!email.status_negativo_indicacao', $dados);
		}

		public function status_positivo_indicacao(){
			$id = $this->getSep(2);
			$cod = $this->getSep(3);

			$Construtor = new ConstrutorModel;
			$Parceiro = new ParceiroModel;

			$empresa = $Construtor->p_empresa($id);
			$parceiro = $Parceiro->cod($cod);

			$dados['link'] = $empresa->link->site;
			$dados['cor'] = $empresa->cor;
			$dados['logo'] = $empresa->imagem->logo->link;
			$dados['parceiro'] = $dados['link']."/convenios/".$parceiro->url->valor;

			$this->view('!email.status_positivo_indicacao', $dados);
		}
	}
