<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/layout.css')): ?>
<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/layout.css"/>
<?php endif; ?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/all.js')): ?>
<script src="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/all.js" type="text/javascript"></script>
<?php endif; ?>

<header class="header_principal volta header_principal_animacao header_principal_absolute">
	<a class="voltar" href="<?= PAINEL ?>/app/<?= $painel_app ?>"></a>
    <h1><?= $titulo ?></h1>
	<?php if(isset($dado['editar'])): ?>
	<a class="editar" href="<?= $dado['editar'] ?>" data-ajuda="Editar dados"></a>
	<?php endif; ?>
</header>
