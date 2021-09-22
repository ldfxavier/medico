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
<input type="hidden" name="url" data-falso="1" value="">
<?php else: ?>
<input type="hidden" name="id" data-falso="1" value="">
<input type="hidden" name="url" value="titulo_grande">
<?php endif; ?>
<input type="hidden" name="cod" value="<?= $cod; ?>">

<div class="center">
	<fieldset>
		<div class="legenda">DADOS</div>

		<label>Título:</label>
		<input type="text" data-tamanho="" name="titulo" value="<?= P::r($r, 'titulo'); ?>" placeholder="Digite um título">


        <fieldset class="lista">
            <legend>IMAGENS PRINCIPAL</legend>
            {{Form::imagem('ENVIAR IMAGEM PRINCIPAL <span>(Será redirecionada para 650px)</span>', 'imagem', P::r($r, 'imagem->valor'), 'telemedicina', 'jpg/jpeg/png', 650, '30000', 'redimencionar', 'img')}}
        </fieldset>


        <fieldset class="lista">
            <label>Texto:</label>
            <?= Form::editor('texto', P::r($r, 'texto'), 'normal'); ?>      
        </fieldset>

		<div class="linha">
			<fieldset>
				<div class="legenda">STATUS</div>
				<?= Form::booleano('status', 'Ativar?', P::r($r, 'status->valor')); ?>
			</fieldset>	
		</div>

	</fieldset>
</div>
