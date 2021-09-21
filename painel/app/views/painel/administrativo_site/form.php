<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;

	$r = isset($_dado) ? $_dado : '';

	if(isset($r->cod)) $cod = $r->cod;
	else $cod = md5(uniqid(time()));

	$coluna = (object)$_coluna;

	$volta = PAINEL.'/app/'.$_app;
?>
<link rel="stylesheet" href="<?= LINK; ?>/app/views/painel/<?= $_app; ?>/scripts/layout.css"/>

<input type="hidden" id="form_app_geral" value="<?= $_app; ?>">
<input type="hidden" id="form_volta_geral" value="<?= $volta; ?>">

<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">
<?php if(isset($r->id)): ?>
<input type="hidden" name="id" value="<?= $r->id; ?>">
<?php else: ?>
<input type="hidden" name="id" data-falso="1" value="">
<?php endif; ?>
<input type="hidden" name="cod" value="<?= $cod; ?>">

<div class="center">

	<fieldset>
		<div class="legenda">IMAGEM DE PERFIL</div>
		<?= Form::imagem('ENVIAR IMAGEM DE PERFIL <span>(Será redirecionada para 650px)</span>', 'imagem', P::r($r, 'imagem->valor'), 'site', 'jpg/jpeg/png', 650, '30000', 'redimencionar', 'img');?>
	</fieldset>

	<fieldset>
		<div class="legenda">DADOS</div>

		<label>Mapa:</label>
		<input type="text" name="mapa" value="<?= P::r($r, 'mapa');?>" placeholder="Digite a url do google maps">
		
		<label>Endereço:</label>
		<input type="text" name="endereco" value="<?= P::r($r, 'endereco');?>" placeholder="Digite um endereço">

		<label>E-mail:</label>
		<input type="text" name="email" value="<?= P::r($r, 'email');?>" placeholder="Digite um e-mail">

		<label>Telefone:</label>
		<input type="text" data-mascara="celular" name="telefone" value="<?= P::r($r, 'telefone->br');?>" placeholder="Digite o telefone">

		<label>Título do e-mail:</label>
		<input type="text" name="titulo_email" value="<?= P::r($r, 'titulo_email');?>" placeholder="Digite um título para o e-mail enviado pelo site">

		<label>E-mail do formulário de contato:</label>
		<input type="text" name="email_formulario" value="<?= P::r($r, 'email_formulario');?>" placeholder="Digite um e-mail para o envio do formulário de contato">

		<fieldset>
			<div class="legenda">Sobre Home</div>
			<textarea data-ckeditor="1" name="sobre_chamada" id="editor_texto" class="form-control ckeditor"><?= P::r($r, 'sobre_chamada'); ?></textarea>
		</fieldset>

		<fieldset>
			<div class="legenda">Sobre</div>
			<textarea data-ckeditor="2" name="sobre" id="editor_texto2" class="form-control ckeditor"><?= P::r($r, 'sobre'); ?></textarea>
		</fieldset>
		</br>

		<fieldset>
			<div class="legenda">Agendamento</div>
			<textarea data-ckeditor="3" name="agendamento" id="editor_texto3" class="form-control ckeditor"><?= P::r($r, 'agendamento'); ?></textarea>
		</fieldset>
		</br>

		<label>Link agendamento:</label>
		<input type="text" name="link_agendamento" value="<?= P::r($r, 'link_agendamento');?>" placeholder="Digite o link para agendamentos">

		<label>Facebook:</label>
		<input type="text" name="facebook" value="<?= P::r($r, 'facebook');?>" placeholder="Digite a url do seu Facebook">

		<label>Instagram:</label>
		<input type="text" name="instagram" value="<?= P::r($r, 'instagram');?>" placeholder="Digite a url do seu instagram">

		<label>Twitter:</label>
		<input type="text" name="twitter" value="<?= P::r($r, 'twitter');?>" placeholder="Digite a url do seu Twitter">

		<label>YouTube:</label>
		<input type="text" name="youtube" value="<?= P::r($r, 'youtube');?>" placeholder="Digite a url do seu Twitter">

		<label>WhatsApp:</label>
		<input type="text" name="whatsapp" value="<?= P::r($r, 'whatsapp');?>" placeholder="Digite a url do seu WhatsApp">

	</fieldset>

	<fieldset>
		<div class="legenda">GALERIA</div>
		<?= Form::imagem_lista($_app, $cod, "Enviar imagem", P::r($r, 'galeria'), "site/galeria", "jpg/jpeg/png"); ?>
	</fieldset>
</div>
