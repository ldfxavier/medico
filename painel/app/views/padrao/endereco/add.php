<?php
	$r = isset($_dado) ? $_dado : '';

	if($_acao == 'editar') $cod = $r->cod;
	else $cod = $_cod;
?>
<header class="geral">
	<h1>ENDEREÇO</h1>
	<i class="fechar"></i>
</header>

<div class="dados">
	<?php if(isset($r->id)): ?>
	<input type="hidden" name="id" value="{{$r->id}}">
	<?php endif; ?>
	<input type="hidden" name="cod" value="{{$cod}}">
	<input type="hidden" name="app" value="{{$_app}}">
	<input type="hidden" name="bloco" value="{{$_bloco}}">
	<input type="hidden" name="local" value="{{$_local}}">

	<input type="text" name="nome" placeholder="Digite o nome do endereço" value="{{P::r($r, 'nome')}}">

	<div class="bloco_cep">
		{{Form::cep('cep', P::r($r, 'cep->br'), array('placeholder' => 'Digite um CEP'))}}
		<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank">Não sabe o CEP?</a>
	</div>

	<input type="text" name="logradouro" placeholder="Digite o Logradouro" value="{{P::r($r, 'logradouro')}}">
	<input type="text" name="numero" placeholder="Digite o número" value="{{P::r($r, 'numero')}}">
	<input type="text" name="complemento" placeholder="Digite o complemento" value="{{P::r($r, 'complemento')}}">
	<input type="text" name="referencia" placeholder="Digite uma referência" value="{{P::r($r, 'referencia')}}">
	<input type="text" name="bairro" placeholder="Digite o bairro" value="{{P::r($r, 'bairro')}}">
	<input type="text" name="cidade" placeholder="Digite uma cidade" value="{{P::r($r, 'cidade')}}">
	{{Form::select('estado', Lista::estado(array('' => 'Escolha uma opção')), P::r($r, 'estado'))}}
	{{Form::booleano('principal', P::r($r, 'principal'))}}
</div>
<div class="bloco_mapa">
	<div class="mapa" id="bloco_endereco_mapa"></div>
	<div class="esquerda">
		<input type="text" name="latitude" placeholder="Latitude" value="{{P::r($r, 'mapa->latitude')}}">
		<input type="text" name="longitude" placeholder="Longitude" value="{{P::r($r, 'mapa->longitude')}}">
	</div>

	<div class="direita">
		<i class="atualizar" data-font="&#xe812;" data-ajuda="Atualizar pelo CEP"></i>
		<i class="abrir" data-font="&#xf105;" data-ajuda="Abrir mapa"><a id="bloco_endereco_como_chegar" href="https://www.google.com.br/maps/dir//{{P::r($r, 'mapa->latitude')}}, {{P::r($r, 'mapa->longitude')}}" target="_blank"></a></i>
	</div>
</div>

<footer class="geral_botao">
	<?php if($_acao == 'editar'): ?>
	<div class="botao" id="but_endereco_deletar">DELETAR</div>
	<?php endif; ?>
	<button class="botao" id="but_endereco_salvar">SALVAR</button>
</footer>
