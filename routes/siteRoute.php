<?php

Route::grupo('index', function () {

    Route::view('index', '/', 'Index@index', [
        'js' => 'login_index',
        'css' => 'login,login_index'
    ]);
    
    Route::view('cadastro', '/cadastro', 'Index@cadastro', [
        'js' => 'login_cadastro',
        'css' => 'login,login_cadastro'
    ]);

    Route::view('popup_especialidade', '/popup/especialidade', 'Index@popup_especialidade', [
        'get' => ['ajax'],
    ]);


    Route::post('salvar_cadastro', '/cadastro/salvar', 'Index@salvar_cadastro', [
        'post' => ['login' ,'senha' ,'confirmar_senha' ,'nome' ,'cpf' ,'email' ,'confirmar_email', 'cep' ,'logradouro' ,'numero' ,'complemento' ,'referencia' ,'bairro' ,'cidade' ,'estado', 'telefone', 'celular'],
    ]);
});

