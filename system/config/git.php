<?php
	
	/*
    |--------------------------------------------------------------------------
    | CONFIG HOOK
    |--------------------------------------------------------------------------
	|
	| Verifica se o repositório GIT foi startado e se o hook pre-commit
	| foi copiado para o diretório do GIT
	|
	*/

	if('localhost' == SISTEMA):
		if(!file_exists(__ROOT.'/.git')):
			trigger_error('Inicie o seu repositório GIT para usar o Framework.');
			exit();
		elseif(!file_exists(__ROOT.'/.git/hooks/pre-commit')):
			trigger_error('Copie o Hook do diretório files/git/ para .git/hooks.');
			exit();
		endif;
	endif;