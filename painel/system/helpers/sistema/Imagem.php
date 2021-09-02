<?php
	require('image/WideImage.php');

	class Imagem {
		public function upload($file, $diretorio, $tipo, $ext_lista, $width = null, $height = null){

			if(!$file) return Mensagem::erro('Erro!', 'Nenhum arquivo enviado.');
			elseif(empty($diretorio)) return Mensagem::erro('Erro!', 'Nenhum diretorio enviado.');
			elseif(empty($tipo)) return Mensagem::erro('Erro!', 'Nenhum tipo de procedimento enviado.');
			elseif(!is_array($ext_lista) || empty($ext_lista)) return Mensagem::erro('Erro!', 'Nenhuma extensão enviada.');
			elseif(in_array($tipo, array('cortar', 'redimencionar')) && (empty($width) || empty($height)))  return Mensagem::erro('Erro!', 'Largura e altura são obrigatórios.');

			$arquivo = $file['tmp_name'];
			$e_ext = explode('/', $file['type']);
			$ext = str_replace('jpeg', 'jpg', Converter::caixa(isset($e_ext[1]) ? $e_ext[1] : '', 'a'));
			$nome = md5(uniqid(time())).".".$ext;

			if(!in_array($ext, $ext_lista)):
				$implode = implode(' | ', $ext_lista);
				return Mensagem::erro('Arquivo incorreto!', 'Envie um arquivo no formato correto ('.$implode.').');
			endif;
			$target = DIRETORIO.'/'.$diretorio.'/'.$nome;

			if($tipo == 'arquivo'):
				move_uploaded_file($arquivo, $target);
			elseif($tipo == 'cortar'):
				$this->cortar($arquivo, $target, $width, $height);
			elseif($tipo == 'redimencionar'):
				$this->redimencionar($arquivo, $target, $width, $height);
			else:
				$this->salvar($arquivo, $target, $width, $height);
			endif;

			if(!file_exists($target)):
				return Mensagem::erro('Erro de permissão!', 'O arquivo não foi enviado, verifique a permissão da pasta.');
			else:
				return json_encode(array(
					'erro' => false,
					'arquivo' => $nome,
					'link' => ARQUIVO.'/'.$diretorio.'/'.$nome
				));
			endif;
		}


		/**
		 * @var $imagem 	string 	Imagem a ser redirecionada e salva
		 * @var $largura	int		Largura da imagem
		 * @var $altura	int		Altura da imagem
		 * @var $destino	string	Diretorio completo de onde será salvo a imagem
		 */
		public function redimencionar($imagem, $destino, $largura = null, $altura = null){
			$img = WideImage::load($imagem);
			$img = $img->resize($largura, $altura, 'inside', 'down');
			$img->saveToFile($destino);
		}

		/**
		 * @var $imagem 	string 	Imagem a ser redirecionada e salva
		 * @var $destino	string	Diretorio completo de onde será salvo a imagem
		 */
		public function salvar($imagem, $destino, $width = null, $height = null){
			if($width != null && $height != null):
				list($img_width, $img_height) = getimagesize($imagem);
				if($width != $img_width || $height != $img_height):
					echo json_encode(array(
						'erro' => true,
						'titulo' => 'Tamanho incorreto.',
						'texto' => 'A imagem deve ter o tamanho de '.$width.'x'.$height.' pixels'
					));
					exit();
				endif;
			endif;
			$img = WideImage::load($imagem);
			$img->saveToFile($destino);
		}

		/**
		 * @var $imagem 	string 	Imagem a ser redirecionada e salva
		 * @var $largura	int		Largura da imagem
		 * @var $altura	int		Altura da imagem
		 * @var $destino	string	Diretorio completo de onde será salvo a imagem
		 */
		public function cortar($imagem, $destino, $largura = null, $altura = null){
			$img = WideImage::load($imagem);
			$img = $img->resize($largura, $altura, 'outside')->crop('50% - '.($largura/2), '50% - '.($altura/2), $largura, $altura);
			$img->saveToFile($destino);
		}

		public static function post($nome = null, $imagem, $texto = null, $posicao, $fonte, $cor, $top = 0, $left = 0){
			if(is_array($imagem) && $imagem):
				$diretorio = DIRETORIO.'/foto/';
				$i = 0;
				foreach($imagem as $foto):
					if($i == 0):
						$img = WideImage::load($diretorio.$foto);
					else:
						$temp = WideImage::load($diretorio.$foto);
						$img = $img->merge($temp, 'top', 'left');
					endif;
					$i++;
				endforeach;

				if(!empty($texto)):
					$canvas = $img->getCanvas();
					if($posicao == 1) $p_y = 'top+'.$top;
					elseif($posicao == 2) $p_y = 'center';
					elseif($posicao == 3) $p_y = 'bottom-'.$top;

					$font_file = 'app.ttf';

					if($cor == 'branco') $cor = $img->allocateColor(255, 255, 255);
					elseif($cor == 'preto') $cor = $img->allocateColor(0, 0, 0);

					$canvas->useFont('css/fonts/post/'.$font_file, $fonte, $cor);
					$canvas->writeText('left+'.$left, $p_y, $texto);
				endif;
				$nome = ($nome == null) ? 'post_'.date('Y-m-d').'_'.Criar::codigo(8, false, false).'.png' : $nome.'.png';
				$img->saveToFile(DIRETORIO.'/post/'.$nome);

				if(file_exists(DIRETORIO.'/post/'.$nome)):
					return json_encode([
						'erro' => false,
						'imagem' => ARQUIVO.'/post/'.$nome.'?cache='.md5(uniqid(time())),
						'nome' => $nome
					]);
				else:
					return Mensagem::erro('Erro no imagem', 'Ocorreu um erro na criação da imagem, por favor, tente novamente.');
				endif;
			else:
				return Mensagem::erro('Campo obrigatório!', 'Para gerar um post, por favor, enviar uma foto.');
			endif;
		}
	}
