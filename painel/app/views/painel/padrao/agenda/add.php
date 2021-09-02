<?php
	$cod = $_cod;
?>
<header>
	<h1>DATA</h1>
	<i class="fechar" data-font=""></i>
</header>
<form class="form_geral" action="{{PAINEL}}/post-agenda">
	<input type="hidden" name="cod" value="{{$cod}}">
	<input type="hidden" name="app" value="{{$_app}}">
	<input type="hidden" name="bloco" value="{{$_bloco}}">
	<input type="hidden" name="local" value="{{$_local}}">

	{{Form::data('data', null, null, true)}}
	<input type="text" name="hora" data-mascara="00:00" placeholder="00:00" value="">
	{{Form::select('valor', ['' => 'Escolha um contato'])}}
	<input type="text" name="texto" placeholder="Observação" value="">

	<footer>
		<button class="botao" id="but_data_salvar">SALVAR</button>
	</footer>
</form>
