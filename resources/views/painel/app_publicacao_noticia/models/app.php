<?php
	
	$where = $_SESSION['BUSCAR_'.$app] ?? [];
	$pagina = $_SESSION['PAGINA_'.$app] ?? 1;
	$order = $_SESSION['ORDER_'.$app] ?? ['id', 'DESC'];
	
	$dado = (new App\Models\Painel\PublicacaoNoticia)->listar($pagina, $where, $order);