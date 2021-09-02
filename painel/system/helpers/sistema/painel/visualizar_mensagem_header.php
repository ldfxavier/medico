<?php
    $equipe = $_SESSION['EQUIPE'];
    $permissao = $equipe->permissao->lista;
    $desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;

    $r = $painel_dado;
?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/layout.css')): ?>
<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/layout.css"/>
<?php endif; ?>
<?php if(file_exists('app/views/painel/'.$painel_app.'/scripts/all.js')): ?>
<script src="<?= LINK ?>/app/views/painel/<?= $painel_app ?>/scripts/all.js" type="text/javascript"></script>
<?php endif; ?>
<div class="app_visualizar_mensagem">
	<?php if(!$painel_pre_visualizacao): ?>
    <header class="header_principal volta header_principal_animacao header_principal_absolute">
		<a class="voltar" href="<?= PAINEL ?>/app/<?= $painel_app ?>"></a>
        <h1>VISUALIZAR</h1>
		<?php if($desenvolvedor || in_array(Permissao::nome($painel_app).'_editar', $permissao)): ?>
		<a class="editar" href="<?= PAINEL ?>/editar/<?= $painel_app ?>/<?= $r->cod ?>" data-ajuda="Editar dados"></a>
		<?php endif; ?>
    </header>
	<div class="header_principal_false"></div>
	<?php endif; ?>
