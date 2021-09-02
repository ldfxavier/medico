<?php

	Route::grupo('login',  function(){

        Route::view('index', '/login', 'Login@index');
        

        Route::view('deslogar', '/sair', 'Restrito@sair', [
            '!middlewares' => '\Auth:validar(RESTRITO)'
        ]);
    
    });
    
