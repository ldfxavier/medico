<?php

	namespace System;

	class Erro {

		private $erro_status = false, $erro_titulo = '', $erro_texto = '', $erro_codigo = 0, $erro_status_html = 0, $erro_direto = [];

		public function b(): Bool {
			return $this->erro_status;
		}
		public function erro(): Array {
			
			if(false === $this->erro_status):
				return [];
			endif;

			if($this->erro_direto):
				return $this->erro_direto;
			elseif($this->erro_codigo > 0 && $this->erro_status_html > 0):
				return mensagem_codigo($this->erro_codigo, $this->erro_status_html);
			elseif($this->erro_codigo > 0):
				return mensagem_codigo($this->erro_codigo);
			elseif(!empty($this->erro_titulo) || !empty($this->erro_texto)):
				return mensagem_erro($this->erro_titulo, $this->erro_texto, $this->erro_status_html);
			endif;

		}

		public function setar(){
			
			$this->erro_status = true;
			$this->erro_titulo = '';
			$this->erro_texto = '';
			$this->erro_codigo = 0;
			$this->erro_status_html = 0;
			$this->erro_direto = [];
			
			return $this;

		}

		public function mensagem(String $texto_01, String $texto_02){

			if(false === $this->erro_status):
				$this->setar();
			endif;
			
			if(!empty($texto_01) && !empty($texto_02)):
				$this->erro_titulo = $texto_01;
				$this->erro_texto = $texto_02;
			elseif(!empty($texto_01)):
				$this->erro_texto = $texto_01;
			endif;

			return $this;

		}

		public function direto($erro){

			if(false === $this->erro_status):
				$this->setar();
			endif;

			$this->erro_direto = $erro;

			return $this;

		}

		public function codigo($codigo){

			if(false === $this->erro_status):
				$this->setar();
			endif;

			if(is_numeric($codigo) && $codigo > 0):
				$this->erro_codigo = $codigo;
			endif;

			return $this;

		}

		public function status($status){

			if(false === $this->erro_status):
				$this->setar();
			endif;

			if(
				(in_array($status, range(100, 103))) ||
				(in_array($status, range(200, 208))) ||
				(in_array($status, range(300, 308))) ||
				(in_array($status, range(400, 418))) ||
				(in_array($status, range(421, 426))) ||
				(in_array($status, range(500, 508))) ||
				in_array($status, [226, 428, 429, 431, 451, 510, 511])
			):
				$this->erro_status_html = $status;
			endif;

			return $this;

		}

	}