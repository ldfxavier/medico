<?php

	Route::grupo('index', function(){

		Route::view('index', '/');

	});

	Route::grupo('app', function(){

		Route::view('/app/*/{app}', 'App@index', [
			'get' => '*'
		]);
		Route::view('/app/add/{app}', 'App@add', [
			'get' => '*'
		]);
		Route::view('/app/editar/{app}/{uuid}', 'App@editar', [
			'get' => '*'
		]);
		Route::view('/app/visualizar/{app}', 'App@visualizar', [
			'get' => '*'
		]);
		Route::view('/app/popup/{app}/{pagina}', 'App@popup', [
			'get' => '*'
		]);
		Route::view('/app/buscar/{app}', 'App@buscar', [
			'get' => ['ajax']
		]);

		Route::view('/pagina/*/{app}/{pagina}', 'Pagina@app');
		Route::view('/order/*/{app}/{campo}/{tipo}', 'Order@app');
		
		Route::get('/pesquisa/rapida', 'Pesquisa@rapida', [
			'get' => ['pesquisa', 'app']
		]);
		Route::get('/pesquisa/remover/{app}/{pesquisa}', 'Pesquisa@remover');

	});

	Route::grupo('perfil', function(){

		Route::view('/perfil', 'Perfil@index');

		Route::view('/perfil/dados', 'Perfil@dados');

		Route::view('/perfil/senha', 'Perfil@senha');

		Route::view('/perfil/configuracoes', 'Perfil@configuracoes');

		Route::view('/perfil/facebook', 'Perfil@facebook');

		Route::view('/perfil/google', 'Perfil@google');

	});
