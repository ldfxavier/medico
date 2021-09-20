<link rel="stylesheet" href="<?= LINK; ?>/app/views/painel/<?= $_app; ?>/scripts/layout.css"/>
<?php
	$equipe = $_SESSION['EQUIPE'];

	$r = isset($_dado) ? $_dado : '';

	if(isset($r->cod)) $cod = $r->cod;
    else $cod = md5(uniqid(time()));
    
	$coluna = (object)$_coluna;

	$volta = PAINEL.'/app/'.$_app;
?>

<input type="hidden" id="form_app_geral" value="<?= $_app; ?>">
<input type="hidden" id="form_volta_geral" value="<?= $volta; ?>">

<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">
<?php if(isset($r->id)): ?>
<input type="hidden" name="id" value="<?= $r->id; ?>">
<?php endif; ?>
<input type="hidden" name="cod" value="<?= $cod; ?>">

<div class="linha_grande" style="background:#FFF; margin-top: 20px">
	<div class="capa">
		<?= Form::imagem('BANNER', 'imagem', P::r($r, 'imagem->valor'), 'banner', 'jpg/jpeg/png', 1500, 395, 'redimencionar', 'img'); ?>
	</div>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">DADOS</div>

		<label>Data inicio:</label>
		<?= Form::datahora('data_postagem_inicio', P::r($r, 'data->postagem_inicio->valor'), null, true); ?>

		<label>Data final:</label>
		<?= Form::datahora('data_postagem_final', P::r($r, 'data->postagem_final->valor'), null, true); ?>
	</fieldset>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">LINKS</div>

		<label>Link:</label>
		<input type="text" name="link" value="<?= P::r($r, 'link'); ?>" placeholder="Digite um link">

		<label>Target:</label>
		<?= Form::select('target', ['' => 'Escolha um target:', '_blank' => 'Link externo', '_self' => 'Link interno'], P::r($r, 'target')); ?>
	</fieldset>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">Local</div>

		<label>Local:</label>
		<?= Form::select('local', ['' => 'Escolha um local:', '1' => 'Topo', '2' => 'Localização'], P::r($r, 'local')); ?>
	</fieldset>
</div>

<div class="linha">
	<fieldset class="bloco_checkbox_todos" id="bloco_equipe_permissao">
		<div class="legenda">CONFIGURAÇÕES</div>
		<label>Ordem:</label>
		<input type="text" name="ordem" value="<?= P::r($r, 'ordem'); ?>" placeholder="Digite uma ordem">
		
		<label>Status:</label>
		<?php
			$Status = new StatusModel;
			echo Form::select('status', $Status->select('banner', 'status', array('' => 'Escolha uma opção')), P::r($r, 'status->valor'));
		?>
	</fieldset>
</div>
