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

    Route::view('popup_especialidade', '/popup/especialidade/{url}', 'Index@popup_especialidade', [
        'get' => ['ajax'],
    ]);

    Route::view('popup_sobre', '/popup/sobre', 'Index@popup_sobre', [
        'get' => ['ajax'],
    ]);

	Route::post('salvar', '/contato', 'Index@salvar', [
		'post' => ['ajax', 'nome', 'mensagem', 'telefone', 'email']
	]);

});

