<?php
	require('image/WideImage.php');

	class Upload {
		public function enviar($file, $diretorio, $tipo, $ext_lista, $width = null, $height = null){

			if(!$file) return Mensagem::erro('Erro!', 'Nenhum arquivo enviado.');
			elseif(in_array($file['error'], array(1,2))) return Mensagem::erro('Erro!', 'O arquivo enviado excede o limite de tamanho.');
			elseif($file['error'] == 4) return Mensagem::erro('Erro!', 'Nenhum arquivo enviado.');
			elseif(in_array($file['error'], array(3,5,6,7,8))) return Mensagem::erro('Erro!', 'Erro no envio do arquivo.');
			elseif($file['error'] != 0) return Mensagem::erro('Erro!', 'Erro no envio do arquivo.');
			elseif(empty($diretorio)) return Mensagem::erro('Erro!', 'Nenhum diretorio enviado.');
			elseif(empty($tipo)) return Mensagem::erro('Erro!', 'Nenhum tipo de procedimento enviado.');
			elseif(!is_array($ext_lista) || empty($ext_lista)) return Mensagem::erro('Erro!', 'Nenhuma extensão enviada.');
			elseif(in_array($tipo, array('cortar', 'redimencionar')) && (empty($width) || empty($height)))  return Mensagem::erro('Erro!', 'Largura e altura são obrigatórios.');

			$arquivo = $file['tmp_name'];
			$nome_arquivo = explode(strrchr($file['name'], '.'), $file['name']);
			$e_ext = explode('/', $file['type']);
			if($e_ext[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document'):
				$ext = 'doc';
			elseif($e_ext[1] == 'msword'):
				$ext = 'doc';
			elseif($e_ext[1] == 'excel'):
				$ext = 'xls';
			elseif($e_ext[1] == 'vnd.ms-excel'):
				$ext = 'xls';
			elseif($e_ext[1] == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet'):
				$ext = 'xls';
			else:
				$ext = str_replace('jpeg', 'jpg', Converter::caixa(isset($e_ext[1]) ? $e_ext[1] : '', 'a'));
			endif;
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
				$this->salvar($arquivo, $target);
			endif;

			if(!file_exists($target)):
				return Mensagem::erro('Erro de permissão!', 'O arquivo não foi enviado, verifique a permissão da pasta.');
			else:
				return json_encode(array(
					'erro' => false,
					'arquivo' => $nome,
					'titulo' => $nome_arquivo[0],
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
		public function salvar($imagem, $destino){
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

		public static function gerar($bg, $imagem, $chamada, $rodape, $linha_01, $linha_02){
			$diretorio = DIRETORIO.'/foto/';
			$img = WideImage::load($diretorio.$bg);
			if(!empty($chamada)):
				$temp = WideImage::load($diretorio.$chamada);
				$img = $img->merge($temp, 'top', 'left');
			endif;
			if(!empty($imagem)):
				$temp = WideImage::load($diretorio.$imagem);
				$img = $img->merge($temp, 'top', 'left');
			endif;

			$temp = WideImage::load($diretorio.$rodape);
			$img = $img->merge($temp, 'bottom', 'left');

			if(!empty($linha_01) || !empty($linha_02)):
				$canvas = $img->getCanvas();
				if(!empty($linha_01)):
					$canvas->useFont('system/.arquivos/fonts/site/font_app.ttf', 28, $img->allocateColor(100, 100, 115) );
					$canvas->writeText('left+20', 'bottom-42', $linha_01);
				endif;
				if(!empty($linha_02)):
					$bottom = empty($linha_01) ? 30 : 14;
					$canvas->useFont('system/.arquivos/fonts/site/font_app.ttf', 18, $img->allocateColor(100, 100, 115) );
					$canvas->writeText('left+20', 'bottom-'.$bottom, $linha_02);
				endif;
			endif;
			$nome = 'post_'.date('Y-m-d').'_'.Criar::codigo(8, false, false).'.png';
			$img->saveToFile(DIRETORIO.'/post/'.$nome);

			if(file_exists(DIRETORIO.'/post/'.$nome)) return json_encode(array('erro' => false, 'imagem' => ARQUIVO.'/post/'.$nome, 'arquivo' => ARQUIVO.'/post/'.$nome, 'nome' => $nome));
			else return Mensagem::erro('Erro no imagem', 'Ocorreu um erro na criação da imagem, por favor, tente novamente.');
		}
	}
