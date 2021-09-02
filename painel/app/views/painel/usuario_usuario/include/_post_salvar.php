<?php
	if($dados['primeiro_acesso'] == 1):
    	$dados['data_acesso'] = NULL;
	endif;

    if(isset($dados['nome_conjuge']) && isset($dados['documento_conjuge'])  && (!empty($dados['nome_conjuge']) || !empty($dados['documento_conjuge']))):
        $dados_conjuge[] = [
            'nome' => $dados['nome_conjuge'],
            'documento' => $dados['documento_conjuge']
        ];
        $dados['filiacao_conjuge'] = json_encode($dados_conjuge);
    elseif(isset($dados['nome_conjuge']) && isset($dados['documento_conjuge'])  && (empty($dados['nome_conjuge']) || empty($dados['documento_conjuge']))):

        $dados['filiacao_conjuge'] = NULL;
    endif;

unset($dados['nome_conjuge']);
unset($dados['documento_conjuge']);
unset($dados['nome_dependente']);
unset($dados['documento_dependente']);
unset($dados['rg_dependente']);
unset($dados['emissor_dependente']);
unset($dados['data_nascimento_dependente']);
unset($dados['parentesco_dependente']);