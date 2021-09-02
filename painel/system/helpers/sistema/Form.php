<?php
	final class Form {

		/**
		 * LEGEND
		 */
		final public static function legend($titulo){
			return '
				<legend>'.$titulo.'</legend>
			';
		}

		/**
		 * CRIAR UMA HASH
		**/
		final public static function hash($string, $nome = 'hash', $id = null){
            $hash = base64_encode(md5(uniqid(time())).'-_-'.$string.'-_-'.HASH);
            $_SESSION[$string] = $hash;
			$nome = !empty($nome) ? 'name="'.$nome.'"' : '';
			$id = ($id != null) ? 'id="'.$id.'"' : '';
            echo '<input type="hidden" '.$nome.' '.$id.' value="'.$hash.'">';
		}

		/**
		 * LABEL
		**/
		final public static function label($titulo = null, $for = null, $attr = []){
			$for = ($for != null) ? 'for="'.$for.'"' : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';
			return '
				<label '.$for.' '.$attr_string.'>'.$titulo.'</label>
			';
		}

		/**
		 * INPUT
		**/
		final public static function input($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="text" '.$nome.' '.$attr_string.' value="'.$valor.'" />
			';
		}

		/**
		 * EMAIL
		**/
		final public static function email($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="email" '.$nome.' '.$attr_string.' value="'.$valor.'" />
			';
		}

		/**
		 * NUMERO
		**/
		final public static function numero($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="number" data-mascara="numero" '.$nome.' '.$attr_string.' value="'.$valor.'" />
			';
		}

		/**
		 * CEP
		**/
		final public static function cep($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '00000-000';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="text" data-numero="1" data-mascara="cep" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' value="'.$valor.'" />
			';
		}

		/**
		 * TELEFONE
		**/
		final public static function telefone($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '(00) 0000-0000';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="tel" data-mascara="telefone" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' value="'.$valor.'" />
			';
		}

		/**
		 * CELULAR
		**/
		final public static function celular($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '(00) 0000-0000';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="tel" data-mascara="celular" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' value="'.$valor.'" />
			';
		}

		/**
		 * SELECT
		**/
		final public static function select($nome = null, $lista, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			$option = '';
			$selected = '';
			foreach($lista as $ind => $val):
				$selected = (empty($selected) && $valor == $ind) ? 'selected="selected"' : '';
				$option .= '<option '.$selected.' value="'.$ind.'">'.$val.'</option>';
			endforeach;
			return '
				<select '.$nome.' '.$attr_string.'>
					'.$option.'
				</select>
			';
		}

		/**
		 * COR
		**/
		final public static function cor($nome, $valor = null, $attr = []){
			$placeholder = '#COR';
			if(isset($attr['placeholder'])):
				$placeholder = $attr['placeholder'];
				unset($attr['placeholder']);
			endif;

			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<div class="input_cor_geral">
					<input name="'.$nome.'" '.$attr_string.' placeholder="'.$placeholder.'" maxlength="7" value="'.$valor.'" />
					<div class="botao_cor" style="background-color: '.$valor.'"></div>
				</div>
			';
		}

		/**
		 * TEXTAREA
		**/
		final public static function textarea($nome = null, $valor = null, $attr = [], $autoresize = false){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$autoresize = ($autoresize == true) ? 'autoresize="true"' : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<textarea '.$nome.' '.$autoresize.' '.$attr_string.'>'.$valor.'</textarea>
			';
		}

		final public static function tag($titulo = null, $nome, $valor = [], $attr = []){
			$label = !empty($titulo) ? '<label>'.$titulo.'</label>' : '';
			$lista = '';
			if($valor):
				foreach($valor as $valor):
					$lista .= '<li class="bloco_tag_input_li"><span class="bloco_tag_input_span">'.$valor.'</span><input type="hidden" data-array="1" name="'.$nome.'" value="'.$valor.'"><i class="bloco_tag_input_deletar" data-ajuda="De 2 cliques para apagar" data-font="&#xe813;"></i></li>';
				endforeach;
			endif;

			$placeholder = 'Digite a tag';
			if(isset($attr['placeholder'])):
				$placeholder = $attr['placeholder'];
				unset($attr['placeholder']);
			endif;
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			$label = $titulo != null ? '<label>'.$titulo.'</label>' : '';
			return '
				<div class="bloco_tag_input" data-nome="'.$nome.'">
					'.$label.'
					<div class="bloco_tag_input_botao">
						<input class="bloco_tag_input_input" type="text" value="" placeholder="'.$placeholder.'">
						<i class="bloco_tag_input_add" data-font="&#xe809;"></i>
					</div>
					<ul class="bloco_tag_input_botao_ul">
						'.$lista.'
					</ul>
				</div>
			';
		}

		final public static function lista_add($titulo = null, $nome, $valor = [], $tipo = 'simples', $attr = [], $busca = '', $link = ''){
			$label = !empty($titulo) ? '<label>'.$titulo.'</label>' : '';

			$lista = '';
			if($valor && $link):
				if($tipo == 'composto'):
					foreach($valor as $ind => $val) $lista .= '<li class="bloco_lista_input_li"><input type="hidden" name="'.$nome.'" data-array="1" value="'.$ind.'"><a class="bloco_lista_input_nome" href="'.PAINEL.'/converter-link/id-cod/'.$link.'/'.$ind.'" target="_blank">'.$val.'</a><i class="bloco_lista_input_remover" data-ajuda="Remover da lista" data-font="&#xe813;"></i></li>';
				else:
					foreach($valor as $val) $lista .= '<li class="bloco_lista_input_li"><input type="hidden" name="'.$nome.'" data-array="1" value="'.$val.'"><a class="bloco_lista_input_nome" href="'.PAINEL.'/converter-link/id-cod/'.$link.'/'.$val.'" target="_blank">'.$val.'</a><i class="bloco_lista_input_remover" data-ajuda="Remover da lista" data-font="&#xe813;"></i></li>';
				endif;
			elseif($valor):
				if($tipo == 'composto'):
					foreach($valor as $ind => $val) $lista .= '<li class="bloco_lista_input_li"><input type="hidden" name="'.$nome.'" data-array="1" value="'.$ind.'"><div class="bloco_lista_input_nome">'.$val.'</div><i class="bloco_lista_input_remover" data-ajuda="Remover da lista" data-font="&#xe813;"></i></li>';
				else:
					foreach($valor as $val) $lista .= '<li class="bloco_lista_input_li"><input type="hidden" name="'.$nome.'" data-array="1" value="'.$val.'"><div class="bloco_lista_input_nome">'.$val.'</div><i class="bloco_lista_input_remover" data-ajuda="Remover da lista" data-font="&#xe813;"></i></li>';
				endif;
			else:
				$lista = '<li class="bloco_lista_input_zero">SEM USUÁRIO VINCULADO</li>';
			endif;

			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';
			return '
				<div class="bloco_lista_input" data-link="'.$link.'" data-tipo="'.$tipo.'" data-busca="'.$busca.'">
					'.$label.'
					<div class="bloco_lista_input_busca">
						<input class="bloco_lista_input_input" type="text" value="" '.$attr_string.'>
						<i class="bloco_lista_input_botao" data-font="&#xe809;"></i>
					</div>
					<ul class="bloco_lista_input_ul">
						'.$lista.'
					</ul>
				</div>
			';
		}

		/**
		 * EDITOR DE TEXTO
		**/
		final public static function editor($nome = null, $valor = null, $tipo = 'normal', $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<div class="bloco_editor" '.$attr_string.'>
					<textarea '.$nome.' class="textarea_editor_'.$tipo.'" data-editor="1">'.$valor.'</textarea>
				</div>
			';
		}

		/**
		 * ARQUIVO
		**/
		final public static function arquivo($titulo, $nome = null, $valor, $diretorio, $ext, $local = 1){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$display = empty($valor) ? 'hide' : '';
			return '
				<div class="bloco_arquivo" data-diretorio="'.$diretorio.'" data-ext="'.$ext.'" data-local="'.$local.'">
					<div class="titulo_sub">'.$titulo.'</div>
					<div class="botao"><input type="file"><i data-font="&#xf0ee;"></i> UPLOAD</div>
					<div class="lista '.$display.'">
						<a class="download" download="download_arquivo" href="'.ARQUIVO.'/'.$diretorio.'/'.$valor.'" data-ajuda="Download do arquivo"><i data-font="&#xf0ed;"></i></a>
						<a class="deletar" href="#deletar" data-ajuda="Deletar arquivo"><i data-font="&#xe808;"></i></a>
						<input type="hidden" '.$nome.' value="'.$valor.'" />
					</div>
				</div>
			';
		}

		/**
		 * ARQUIVO LISTA
		**/
		final public static function arquivo_lista($cod, $titulo, $diretorio, $arquivos, $ext, $local = 1){
			$lista = '';
			if($arquivos):
				foreach($arquivos as $r):
					$lista .= '
						<li class="arquivo" style="background-image: url('.$r->imagem.')">
							<a class="download" download="'.$r->titulo.'" href="'.$r->arquivo->link.'" target="_blank"><i data-font="&#xf0ed;"></i></a>
							<a class="deletar but_arquivo_deletar" data-id="'.$r->id.'" href="#deletar"><i data-font="&#xe808;"></i></a>
							<input type="text" data-name="titulo" class="but_change_atualizar" data-id="'.$r->id.'" data-app="arquivo" placeholder="Nome do arquivo" value="'.$r->titulo.'">
							<div class="nome">'.$r->titulo.'</div>
						</li>
					';
				endforeach;
			else:
				$lista = '<li class="zero">SEM ARQUIVOS NO MOMENTO</li>';
			endif;
			return '
				<div class="bloco_arquivo_lista" data-cod="'.$cod.'" data-diretorio="'.$diretorio.'" data-ext="'.$ext.'" data-local="'.$local.'">
					<div class="titulo_sub">'.$titulo.'</div>
					<div class="botao"><input type="file"><i data-font="&#xf0ee;"></i> UPLOAD</div>
					<ul class="lista">
						'.$lista.'
					</ul>
				</div>
			';
		}

		/**
		 * IMAGEM
		**/
		final public static function imagem($titulo, $nome, $valor = null, $diretorio, $ext, $width = '', $height = '', $tipo = 'normal', $retorno = 'img'){
			$img = '';
			$css = '';
			if(!empty($valor) && $retorno == 'img') $img = '<img src="'.ARQUIVO.'/'.$diretorio.'/'.$valor.'" >';
			if(!empty($valor) && $retorno == 'css') $css = 'style=" background-image: url('.ARQUIVO.'/'.$diretorio.'/'.$valor.')';

			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$ativo = ($valor != null) ? 'ativo' : '';
			$valor = ($valor != null) ? $valor : '';
			return '
				<div
					class="bloco_imagem '.$ativo.'"
					data-diretorio="'.$diretorio.'"
					data-ext="'.$ext.'"
					data-width="'.$width.'"
					data-height="'.$height.'"
					data-tipo="'.$tipo.'"
					data-retorno="'.$retorno.'"
				>
					<input type="hidden" class="input_imagem" '.$nome.' value="'.$valor.'">
					<i class="fechar" data-font="&#xe813;" data-ajuda="Remover imagem"></i>
					<div class="botao">'.$titulo.'<input type="file"></div>
					<figure '.$css.'>'.$img.'</figure>
				</div>
			';
		}

		final public static function imagem_lista($app, $cod, $titulo, $valor = null, $diretorio, $ext, $width = '', $height = '', $tipo = 'normal', $retorno = 'css'){
			$lista = '';
			if($valor):
				foreach($valor as $r):
					$css = '';
					$img = '';
					if($retorno == 'css') $css = 'style="background-image: url('.$r->imagem->link.')"';
					else $img = '<img src="'.$r->imagem->link.'">';
					$lista .= '<figure '.$css.' data-id="'.$r->id.'">'.$img.'<i class="fechar" data-font="&#xe813;" data-ajuda="Remover imagem"></i></figure>';
				endforeach;
			else:
				$lista = '<div class="zero_geral">SEM IMAGENS ENVIADAS ATÉ O MOMENTO</div>';
			endif;

			return '
				<div
					class="bloco_imagem_lista"
					data-diretorio="'.$diretorio.'"
					data-ext="'.$ext.'"
					data-width="'.$width.'"
					data-height="'.$height.'"
					data-tipo="'.$tipo.'"
					data-retorno="'.$retorno.'"
					data-cod="'.$cod.'"
					data-app="'.$app.'"
				>
					<div class="botao">'.$titulo.'<input type="file"></div>
					<div class="bloco_imagem_lista_conteudo">
						'.$lista.'
					</div>
				</div>
			';
		}

		/**
		 * VIDEO
		**/
		final public static function video($titulo = null, $nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$ativo = ($valor != null) ? 'ativo' : '';
			$valor = ($valor != null) ? $valor : '';
			$titulo = ($titulo != null) ? '<label>'.$titulo.'</label>' : '';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			$iframe = Converter::video($valor, 'a');
			return '
				<div class="bloco_video '.$ativo.'">
					<div class="link_video">
						'.$titulo.'
						<input type="text" '.$nome.' '.$attr_string.' value="'.$valor.'">
					</div>
					<div class="iframe"><div class="responsivo">'.$iframe.'</div></div>
				</div>
			';
		}

		/**
		 * CONTATO
		**/
		final public static function contato($app, $cod, $contato = [], $local = 1){
			$id = 'id_'.md5(uniqid(time()));
			$lista = '';
			if($contato):
				foreach($contato as $r_contato):
					$nome = !empty($r_contato->contato) ? $r_contato->contato : $r_contato->nome->texto;
					$destaque = (isset($r_contato->destaque) && !empty($r_contato->destaque) && $r_contato->destaque == "1") ? '<i data-font="&#xe823;" class="destaque"></i>' : '';
					$lista .= '<li class="lista"><span class="valor">'.$nome.' - '.$r_contato->valor->texto.'</span>'.$destaque.'<i data-font="&#xe807;" class="editar but_editar_contato" data-id="'.$r_contato->id.'" data-local="'.$local.'" data-app="'.$app.'"></i></li>';
				endforeach;
			else:
				$lista = '<li class="zero">SEM CONTATO NO MOMENTO</li>';
			endif;
			return '
				<div class="form_lista" id="'.$id.'">
					<div class="add but_add_contato" data-app="'.$app.'" data-local="'.$local.'" data-cod="'.$cod.'" data-id="#'.$id.'"><i data-font="&#xe809;"></i> ADICIONAR</div>
					<div class="linha"></div>
					<ul class="bloco_conteudo">
						'.$lista.'
					</ul>
				</div>
			';
		}

		/**
		 * ENDERECO
		**/
		final public static function endereco($app, $cod, $endereco = [], $local = 1){
			$id = 'id_'.md5(uniqid(time()));
			$lista = '';
			if($endereco):
				foreach($endereco as $r_endereco):
					$lista .= '<li class="lista"><span class="valor">'.$r_endereco->nome.' - '.$r_endereco->logradouro.'</span><i data-font="&#xe807;" class="editar but_editar_endereco" data-id="'.$r_endereco->id.'" data-local="'.$local.'" data-app="'.$app.'"></i></li>';
				endforeach;
			else:
				$lista = '<li class="zero">SEM ENDEREÇO NO MOMENTO</li>';
			endif;

			return '
				<div class="form_lista" id="'.$id.'">
					<div class="add but_add_endereco" data-app="'.$app.'" data-local="'.$local.'" data-cod="'.$cod.'" data-id="#'.$id.'"><i data-font="&#xe809;"></i> ADICIONAR</div>
					<div class="linha"></div>
					<ul class="bloco_conteudo">
						'.$lista.'
					</ul>
				</div>
			';
		}

		/**
		 * AGENDA
		**/
		final public static function agenda($tabela, $cod, $dados = null, $agenda = []){
			$id = 'id_'.md5(uniqid(time()));
			$dados = ($dados != null) ? $dados : '';
			$lista = '';
			if($agenda):
				foreach($agenda as $r_agenda):
					if($r_agenda->tipo->valor == 1):
	                    $visualizar_tipo = 'visualizar_telefone';
	                    $icone = '&#xe818';
	                    $ajuda = 'Clique para ligar';
	                elseif($r_agenda->tipo->valor == 2):
	                    $visualizar_tipo = 'visualizar_email';
	                    $icone = '&#xf0e0';
	                    $ajuda = 'Clique para ver';
					elseif($r_agenda->tipo->valor == 3):
	                    $visualizar_tipo = 'visualizar_reuniao';
	                    $icone = '&#xe80a';
	                    $ajuda = 'Clique para ver';
					elseif($r_agenda->tipo->valor == 4):
	                    $visualizar_tipo = 'visualizar_entrega';
	                    $icone = '&#xe81a';
	                    $ajuda = 'Clique para ver';
	                endif;
					$valor = !empty($r_agenda->valor->texto) ? ' - '.$r_agenda->valor->texto : '';
					$lista .= '<li class="lista"><span class="valor">'.$r_agenda->titulo.$valor.'</span><i data-font="'.$icone.'" data-href="'.PAINEL.'/incorporar/agenda_calendario/'.$visualizar_tipo.'/par/'.$r_agenda->cod.'" data-ajuda="'.$ajuda.'" class="editar but_bloqueado_ajax"></i></li>';
				endforeach;
			else:
				$lista = '<li class="zero">SEM AGENDAMENTO NO MOMENTO</li>';
			endif;

			return '
				<div class="form_lista">
					<div class="add but_bloco_ajax" data-href="'.PAINEL.'/incorporar/agenda_calendario/add"
						data-post="id,cod,tabela,tipo,titulo,lista,data"
						data-id="#'.$id.'"
						data-cod="'.$cod.'"
						data-tabela="'.$tabela.'"
						data-tipo="auto"
						data-titulo=""
						data-lista="'.$dados.'"
						data-data=""
					><i data-font="&#xe809;"></i> ADICIONAR</div>
					<div class="linha"></div>
					<ul class="bloco_conteudo" id="'.$id.'">
						'.$lista.'
					</ul>
				</div>
			';
		}

		/**
		 * DINHEIRO
		**/
		final public static function dinheiro($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '0,00';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="text" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-dinheiro="1" value="'.$valor.'" />
			';
		}

		/**
		 * CPF
		**/
		final public static function cpf($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? Converter::documento($valor) : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '000.000.000-00';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';
			return '
				<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="cpf" value="'.$valor.'" />
			';
		}

		/**
		 * CNPJ
		**/
		final public static function cnpj($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? Converter::documento($valor) : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '00.000.000/0000-00';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="cnpj" value="'.$valor.'" />
			';
		}

		/**
		 * CPF E CNPJ
		**/
		final public static function documento($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? Converter::documento($valor) : '';
			if(isset($attr['placeholder'])) unset($attr['placeholder']);
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<div class="input_documento_geral">
					<select>
						<option value="cpf" data-mascara="cpf" data-placeholder="000.000.000-00">CPF</option>
						<option value="cnpj" data-mascara="cnpj" data-placeholder="00.000.000/0000-00">CNPJ</option>
					</select>
					<input type="text" data-numero="1" placeholder="000.000.000-00" '.$nome.' '.$attr_string.' data-mascara="cpf" value="'.$valor.'" />
				</div>
			';
		}

		/**
		 * DATA
		**/
		final public static function data($nome = null, $valor = null, $attr = [], $calendario = false){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? Converter::data($valor, 'd/m/Y') : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '00/00/0000';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			if($calendario == true):
				return '
					<div class="bloco_data">
						<div class="botao botao_data"></div>
						<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="data" value="'.$valor.'" />
					</div>
				';
			else:
				return '
					<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="data" value="'.$valor.'" />
				';
			endif;
		}

		/**
		 * DATA E HORA
		**/
		final public static function datahora($nome = null, $valor = null, $attr = [], $calendario = false){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? Converter::data($valor, 'd/m/Y H:i:s') : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '00/00/0000 00:00:00';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			if($calendario == true):
				return '
					<div class="bloco_data">
						<div class="botao botao_data_hora"></div>
						<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="datahora" value="'.$valor.'" />
					</div>
				';
			else:
				return '
					<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="datahora" value="'.$valor.'" />
				';
			endif;
		}

		/**
		 * HORA
		**/
		final public static function hora($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? Converter::data($valor, 'H:i:s') : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : '00:00:00';
			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="text" data-numero="1" placeholder="'.$placeholder.'" '.$nome.' '.$attr_string.' data-mascara="hora" value="'.$valor.'" />
			';
		}

		/**
		 * RADIO
		**/
		final public static function radio($nome = null, $opcoes = [], $valor = null){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$radio = '';
			foreach($opcoes as $ind => $val):
				$checked = ($ind == $valor) ? 'checked="checked"' : '';
				$radio .= '<label type="radio"><input type="radio" '.$nome.' '.$checked.' value="'.$ind.'" /> '.$val.' </label>';
			endforeach;
			return $radio;
		}

		/**
		 * CHECKBOX
		**/
		final public static function checkbox($nome = null, $valor = null, $titulo, $checked = false, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$checked = ($checked) ? 'checked="checked"' : '';
			$id = isset($attr['id']) ? $attr['id'] : 'id_'.md5(uniqid(time()));
			if(isset($attr['id'])) unset($attr['id']);

			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '<input id="'.$id.'" '.$attr_string.' type="checkbox" '.$nome.' '.$checked.' value="'.$valor.'" /><label for="'.$id.'" class="checkbox"><span>'.$titulo.'</span></label>';
		}

		/**
		 * URL
		**/
		final public static function url($nome = null, $valor = null, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : '';
			$placeholder = (isset($attr['placeholder'])) ? $attr['placeholder'] : 'dominio.com.br';

			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			$explode = explode('://', $valor);
			$protocolo = isset($explode[0]) ? $explode[0] : '';
			$dominio = isset($explode[1]) ? $explode[1] : '';
			$select_1 = '';
			$select_2 = '';
			if($protocolo == 'http') $select_1 = 'selected="selected"';
			if($protocolo == 'https') $select_2 = 'selected="selected"';

			return '
				<div class="input_url_geral">
					<input type="hidden" '.$nome.' '.$attr_string.' value="'.$valor.'" />
					<select>
						<option value="http://" '.$select_1.'>http://</option>
						<option value="https://" '.$select_2.'>https://</option>
					</select>
					<input type="url" placeholder="'.$placeholder.'" value="'.$dominio.'" />
				</div>
			';
		}

		/**
		 * BOOLEANO
		**/
		final public static function booleano($nome, $titulo, $valor = false, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';
			$valor = ($valor != null) ? $valor : 2;
			$class = ($valor == 1) ? 'ativo' : 'inativo';

			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<div class="input_booleano_geral '.$class.'">
					<input type="hidden" '.$nome.' '.$attr_string.' value="'.$valor.'" />
					<div class="booleano_titulo">'.$titulo.'</div>
					<div class="booleano_botao"><div class="booleano_bola"></div></div>
				</div>
			';
		}

		/**
		 * PASSWORD
		**/
		final public static function password($nome, $attr = []){
			$nome = ($nome != null) ? 'name="'.$nome.'"' : '';

			$attr_string = '';
			if(!empty($attr)) foreach($attr as $ind => $val) $attr_string .= ' '.$ind.'="'.$val.'"';

			return '
				<input type="password" '.$nome.' value="" '.$attr_string.' />
			';
		}

		/**
		 * PASSWORD COMPLETO
		**/
		final public static function password_completo($nome = [], $attr_1 = [], $attr_2 = []){
			$input = false;
			$nome_1 = (is_array($nome) && isset($nome[0])) ? 'name="'.$nome[0].'"' : '';
			$nome_2 = (is_array($nome) && isset($nome[1])) ? 'name="'.$nome[1].'"' : '';

			$retorno = '';
			$completo = '';
			if($nome_1):
				$input = true;
				$attr_string_1 = '';
				if(is_array($attr_1) && isset($attr_1)) foreach($attr_1 as $ind => $val) $attr_string_1 .= ' '.$ind.'="'.$val.'"';
				$retorno .= '
					<div class="bloco_password">
						<input type="password" '.$nome_1.' value="" '.$attr_string_1.' />
						<div class="but_password_visualizar" data-password="ativo"></div>
					</div>
				';
			endif;
			if($nome_2):
				$completo = 'completo';
				$input = true;
				$attr_string_2 = '';
				if(is_array($attr_2) && isset($attr_2)) foreach($attr_2 as $ind => $val) $attr_string_2 .= ' '.$ind.'="'.$val.'"';
				$retorno .= '
					<div class="bloco_password">
						<input type="password" '.$nome_2.' value="" '.$attr_string_2.' />
						<div class="bloco_verificar incorreto"></div>
					</div>
				';
			endif;

			if($input == true):
				return '
					<div class="input_password_geral '.$completo.'">
						'.$retorno.'
					</div>
				';
			endif;
		}

	}
