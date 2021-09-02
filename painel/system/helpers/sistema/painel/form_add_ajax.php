<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/layout.css')): ?>
<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/layout.css"/>
<?php endif; ?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/all.js')): ?>
<script src="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/all.js" type="text/javascript"></script>
<?php endif; ?>
<div class="app_geral_add app_geral_ajax">
    <header class="header_principal volta">
		<a class="voltar but_fechar_ajax" href="#voltar"></a>
        <h1>ADICIONAR</h1>
    </header>

	<form class="form_geral" id="form_geral" action="<?= PAINEL ?>/post-salvar" method="post">
		<?php include('app/views/painel/'.$painel_app.'/form.php') ?>
	</form>
</div>
