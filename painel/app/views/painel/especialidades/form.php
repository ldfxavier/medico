<?php
$equipe = $_SESSION['EQUIPE'];
$permissao = $equipe->permissao->lista;
$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;

$r = isset($_dado) ? $_dado : '';

if (isset($r->cod)) $cod = $r->cod;
else $cod = md5(uniqid(time()));

$coluna = (object)$_coluna;

$volta = PAINEL . '/app/' . $_app;
?>
<link rel="stylesheet" href="<?= LINK; ?>/app/views/painel/<?= $_app; ?>/scripts/layout.css" />

<input type="hidden" id="form_app_geral" value="<?= $_app; ?>">
<input type="hidden" id="form_volta_geral" value="<?= $volta; ?>">

<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">
<?php if (isset($r->id)) : ?>
	<input type="hidden" name="id" value="<?= $r->id; ?>">
<?php else : ?>
	<input type="hidden" name="id" data-falso="1" value="">
<?php endif; ?>
<input type="hidden" name="cod" value="<?= $cod; ?>">
<input type="hidden" name="url" value="<?= P::r($r, 'url->valor'); ?>">

<div class="center">
	<fieldset>
		<div class="legenda">TÍTULOS</div>

		<label>Título:</label>
		<input type="text" data-tamanho="<?= $coluna->titulo->tamanho ?>" name="titulo" value="<?= P::r($r, 'titulo'); ?>" placeholder="Digite um título">


		<div class="cabecalho_data">
			<label>Data:</label>
			<?= Form::data('data_postagem_inicio', P::r($r, 'data->postagem_inicio->br'), null, true); ?>
		</div>
	</fieldset>

	<fieldset>
		<div class="legenda">IMAGEM PRINCIPAL</div>
		<?= Form::imagem('ENVIAR IMAGEM PRINCIPAL <span>(Será redirecionada para 650px)</span>', 'imagem', P::r($r, 'imagem->valor'), 'especialidades', 'jpg/jpeg/png', 650, '30000', 'redimencionar', 'img'); ?>
	</fieldset>

	<fieldset>
		<div class="legenda">VÍDEO</div>
		<?= Form::video('Cole o link do vídeo da plataforma YOUTUBE ou VIMEO', 'video', P::r($r, 'video->valor'), array('placeholder' => 'Cole o link aqui.')); ?>
	</fieldset>

	<fieldset>
		<div class="legenda">TEXTOS</div>
		<label>Texto:</label>
		<textarea data-ckeditor="1" name="texto" id="editor_texto" class="form-control ckeditor"><?= P::r($r, 'texto'); ?></textarea>
	</fieldset>

	<fieldset>
		<div class="legenda">PERMISSÕES</div>
		<?= Form::booleano('status', 'Ativar?', P::r($r, 'status->valor')); ?>
	</fieldset>
</div>