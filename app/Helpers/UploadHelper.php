<?php
	namespace app\Helpers;

	require(__ROOT.'/files/wideimage/WideImage.php');

	final class Upload {

		public function salvar(Array $arquivo, String $diretorio, String $tipo, Array $ext_lista, Int $width = 0, Int $height = 0): Array {

			if(!$arquivo):
				return ['erro' => true, 'titulo' => 'Erro!', 'texto' => 'Nenhum arquivo enviado.'];
			elseif(empty($diretorio)):
				return ['erro' => true, 'titulo' => 'Erro!', 'texto' => 'Nenhum diretorio enviado.'];
			elseif(empty($tipo)):
				return ['erro' => true, 'titulo' => 'Erro!', 'texto' => 'Nenhum tipo de procedimento enviado.'];
			elseif(!is_array($ext_lista) || empty($ext_lista)):
				return ['erro' => true, 'titulo' => 'Erro!', 'texto' => 'Nenhuma extensão enviada.'];
			elseif(in_array($tipo, ['cortar', 'redimencionar']) && (empty($width) || empty($height))) :
				return ['erro' => true, 'titulo' => 'Erro!', 'texto' => 'Largura e altura são obrigatórios.'];
			endif;

			$temp = $arquivo['tmp_name'];
			$ext_temp = explode('/', $arquivo['type']);
			$ext = str_replace('jpeg', 'jpg', mb_strtolower(end($ext_temp) , 'UTF-8'));
			$nome = md5(uniqid(time())).".".$ext;

			if(!in_array($ext, $ext_lista)):
				$implode = implode(' | ', $ext_lista);
				return ['erro' => true, 'titulo' => 'Arquivo incorreto!', 'texto' => 'Envie um arquivo no formato correto ('.$implode.').'];
			endif;
			$target = __ROOT.DIRETORIO.'/'.$diretorio.'/'.$nome;

			if($tipo == 'arquivo'):
				move_uploaded_file($temp, $target);
			elseif($tipo == 'cortar'):
				$this->cortar($temp, $target, $width, $height);
			elseif($tipo == 'redimencionar'):
				$this->redimencionar($temp, $target, $width, $height);
			elseif($tipo == 'salvar'):
				$salvar = $this->imagem($temp, $target, $width, $height);
				if($salvar['erro'] == true) return $salvar;
			endif;

			if(!file_exists($target)):
				return ['erro' => true, 'titulo' => 'Erro de permissão!', 'texto' => 'O arquivo não foi enviado, verifique a permissão da pasta.'];
			else:
				return [
					'erro' => false,
					'arquivo' => $nome,
					'link' => ARQUIVO.'/'.$diretorio.'/'.$nome
				];
			endif;
		}

		private function redirecionar(String $imagem, String $target, Int $width, Int $height): Bool {
			$img = WideImage::load($imagem);
			$img = $img->resize($width, $height, 'inside', 'down');
			$img->saveToFile($target);
			return true;
		}

		private function imagem(String $imagem, String $target, Int $width = 0,  Int $height = 0){
			if($width > 0 && $height > 0):
				list($img_width, $img_height) = getimagesize($imagem);
				if($width != $img_width || $height != $img_height):
					return [
						'erro' => true,
						'titulo' => 'Tamanho incorreto.',
						'texto' => 'A imagem deve ter o tamanho de '.$width.'x'.$height.' pixels'
					];
				endif;
			endif;
			$img = WideImage::load($imagem);
			$img->saveToFile($target);
			return true;
		}

		private function cortar(String $imagem, String $target, Int $width, Int $height){
			$img = WideImage::load($imagem);
			$img = $img->resize($width, $height, 'outside')->crop('50% - '.($width/2), '50% - '.($height/2), $width, $height);
			$img->saveToFile($target);
			return true;
		}

	}