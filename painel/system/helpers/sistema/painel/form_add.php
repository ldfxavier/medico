<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/layout.css')): ?>
<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/layout.css"/>
<?php endif; ?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/all.js')): ?>
<script src="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/all.js" type="text/javascript"></script>
<?php endif; ?>
<div class="app_geral_add">
    <header class="header_principal header_principal_animacao header_principal_absolute">
		<a class="voltar" href="<?= PAINEL ?>/app/<?= $painel_app ?>"></a>
        <h1>ADICIONAR</h1>
		<button id="but_add_geral"><i data-font="&#xf0ee;"></i><span>SALVAR</span></button>
    </header>
    <div class="header_principal_false"></div>

	<form class="form_geral" id="form_geral" action="<?= PAINEL ?>/post-salvar" method="post">
		<?php include('app/views/painel/'.$painel_app.'/form.php') ?>
	</form>
</div>
