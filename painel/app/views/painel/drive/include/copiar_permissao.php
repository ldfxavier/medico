<?php
	$equipe = $_post['equipe'];
	$Equipe = new EquipeModel;
	echo json_encode($Equipe->permissao($equipe));
?>
