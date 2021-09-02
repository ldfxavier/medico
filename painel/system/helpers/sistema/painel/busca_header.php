<?php
    $painel_link = !empty($painel_link) ? $painel_link : PAINEL.'/post-busca/'.$painel_app;
?>
<form action="<?= $painel_link ?>" method="post" class="bloco_busca_ajax form_geral">
    <header>
        <h1>BUSCAR</h1>
        <i class="but_fechar_ajax"></i>
    </header>
	<div class="corpo">
