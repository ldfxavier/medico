<?php
	unset($_coluna['google']);
	unset($_coluna['facebook']);
	unset($_coluna['salt']);
	unset($_coluna['salt_old']);
	unset($_coluna['password_old']);
	unset($_coluna['data_email']);
	
	Painel::download($_app, $_coluna);
?>

