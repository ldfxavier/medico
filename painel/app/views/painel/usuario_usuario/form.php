<?php
	$equipe = $_SESSION['EQUIPE'];
	$r = isset($_dado) ? $_dado : '';
	if(isset($r->cod)) $cod = $r->cod;
	else $cod = md5(uniqid(time()));
	$volta = in_array(Permissao::nome($_app).'_visualizar', $equipe->permissao->lista) ? PAINEL.'/visualizar/'.$_app.'/'.$cod : PAINEL.'/app/'.$_app;
	/* echo '<pre>';
	print_r($r);
	exit(); */ 
?>

<input type="hidden" id="form_app_geral" value="<?= $_app; ?>">
<input type="hidden" id="form_volta_geral" value="<?= $volta; ?>">

<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">
<?php if(isset($r->id)): ?>
<input type="hidden" name="id" value="<?= $r->id; ?>">
<?php endif; ?>
<input type="hidden" name="cod" value="<?= $cod; ?>">

<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/usuario_usuario/scripts/layout.css{{CACHE}}"/>
<div class="linha">
	<fieldset>
		<div class="legenda">DADOS PESSOAIS</div>
		<label>Nome:</label>
		<input type="text" name="nome" value="<?= P::r($r, 'nome->valor'); ?>" placeholder="Digite um nome">

		<label>Telefone:</label>
		<input type="text" data-mascara="celular" name="telefone" value="<?= P::r($r, 'telefone->fixo->br'); ?>" placeholder="Digite um telefone">


		<label>Celular:</label>
		<input type="text" data-mascara="celular" name="celular" value="<?= P::r($r, 'telefone->celular->br'); ?>" placeholder="Digite um celular">

		<?php if(isset($r->email) && !empty($r->email)  && TEMPLATE != 'sinpefpr'): ?>
		<label>E-mail :</label>
		<input type="text" name="email" value="<?= P::r($r, 'email'); ?>" placeholder="Digite um E-mail comercial">
		<?php endif; ?>



	</fieldset>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">ENDEREÇO</div>

		<label>CEP:</label>
		<?php if(isset($r->endereco->cep->br)  || empty($r->endereco->logradouro)): ?>
		<input type="text" name="cep" value="<?= P::r($r, 'endereco->cep->br'); ?>" placeholder="Digite um cep">
		<?php else: ?>
		<input type="text" name="cep" value="<?= P::r($r, 'endereco->cep->br'); ?>" placeholder="Digite um cep">
		<?php endif; ?>

		<?php if(isset($r->endereco->logradouro) || empty($r->endereco->logradouro)): ?>
		<label>Logradouro:</label>
		<input type="text" name="logradouro" value="<?= P::r($r, 'endereco->logradouro'); ?>" placeholder="Digite um logradouro">
		<?php else: ?>
		<label>Logradouro:</label>
		<input type="text" name="logradouro" value="<?= P::r($r, 'endereco->logradouro'); ?>" placeholder="Digite um logradouro">
		<?php endif; ?>

        <?php if(isset($r->endereco->numero) || empty($r->endereco->numero)): ?>
        <label>Número:</label>
        <input type="text" name="numero" value="<?= P::r($r, 'endereco->numero'); ?>" placeholder="Digite um Número">
        <?php else: ?>
        <label>Número:</label>
        <input type="text" name="numero" value="<?= P::r($r, 'endereco->numero'); ?>" placeholder="Digite um Número">
        <?php endif; ?>

		<?php if(isset($r->endereco->complemento) || empty($r->endereco->complemento) ): ?>
		<label>Complemento:</label>
		<input type="text" name="complemento" value="<?= P::r($r, 'endereco->complemento'); ?>" placeholder="Digite um complemento">
		<?php else: ?>
		<label>Complemento:</label>
		<input type="text" name="complemento" value="<?= P::r($r, 'endereco->complemento'); ?>" placeholder="Digite um complemento">
		<?php endif; ?>

		<?php if(isset($r->endereco->bairro)  || empty($r->endereco->bairro)): ?>
		<label>Bairro:</label>
		<input type="text" name="bairro" value="<?= P::r($r, 'endereco->bairro'); ?>" placeholder="Digite um bairro">
		<?php else: ?>
		<label>Bairro:</label>
		<input type="text" name="bairro" value="<?= P::r($r, 'endereco->bairro'); ?>" placeholder="Digite um bairro">
		<?php endif; ?>

		<?php if(isset($r->endereco->cidade)  || empty($r->endereco->cidade) ): ?>
		<label>Cidade:</label>
		<input type="text" name="cidade" value="<?= P::r($r, 'endereco->cidade'); ?>" placeholder="Digite uma cidade">
		<?php else: ?>
		<label>Cidade:</label>
		<input type="text" name="cidade" value="<?= P::r($r, 'endereco->cidade'); ?>" placeholder="Digite uma cidade">
		<?php endif; ?>

		<?php if(isset($r->endereco->estado) || empty($r->endereco->estado) ): ?>
            <label>Estado:</label>
            <?= Form::select('estado', Lista::estado(['' => 'Escolha uma opção']), P::r($r, 'endereco->estado')) ?>
		<?php else: ?>
            <label>Estado:</label>
            <?= Form::select('estado', Lista::estado(['' => 'Escolha uma opção']), P::r($r, 'endereco->estado')) ?>
		<?php endif; ?>

        <?php if(isset($r->endereco->referencia)  || empty($r->endereco->referencia) ): ?>
        <label>Referência:</label>
        <input type="text" name="referencia" value="<?= P::r($r, 'endereco->referencia'); ?>" placeholder="Digite uma referencia">
        <?php else: ?>
        <label>Referência:</label>
        <input type="text" name="referencia" value="<?= P::r($r, 'endereco->referencia'); ?>" placeholder="Digite uma cidade">
        <?php endif; ?>

	</fieldset>
</div>


<div class="linha">
	<fieldset>
		<div class="legenda">ACESSO</div>

		<label>CPF:</label>
		<input type="text" name="login" value="<?= P::r($r, 'login'); ?>" placeholder="Digite um e-mail">

		<label>E-mail:</label>
		<input type="text" name="email" value="<?= P::r($r, 'email'); ?>" placeholder="Digite um e-mail">

		<label>Senha:</label>
		<input type="password" name="senha" value="" placeholder="Digite uma senha">
	</fieldset>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">STATUS</div>

		<label>Status:</label>

		
		<?= Form::select('status', ['' => 'Escolha uma opção', 1 => 'Ativo', 2 => 'Inativo', 3 => 'Bloqueado'],  P::r($r, 'status->valor')) ?>
	</fieldset>
</div>