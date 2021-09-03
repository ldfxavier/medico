<?php
	$r = isset($_dado) ? $_dado : '';

	if(isset($r->cod)) $cod = $r->cod;
	else $cod = md5(uniqid(time()));
?>

<input type="hidden" id="form_app_geral" value="{{$_app}}">
<input type="hidden" id="form_volta_geral" value="{{PAINEL}}/app/{{$_app}}">

<?php if(isset($r->id)): ?>
<input type="hidden" name="id" value="{{$r->id}}">
<?php endif; ?>
<input type="hidden" name="cod" value="{{$cod}}">

<fieldset>
	<label>Ordem:</label>
	<input type="number" name="ordem" placeholder="Ordem" value="{{P::r($r, 'ordem')}}">

	<label>Tabela:</label>
	<input type="text" name="tabela" value="{{P::r($r, 'tabela')}}" placeholder="Nome da tabela">

	<label>Campo:</label>
	<input type="text" name="campo" value="{{P::r($r, 'campo')}}" placeholder="Nome do campo">

	<label>Nome:</label>
	<input type="text" name="nome" placeholder="Digite um nome" value="{{P::r($r, 'nome')}}">

	<label>Valor:</label>
	<input type="text" name="valor" placeholder="Digite um valor" value="{{P::r($r, 'valor')}}">

	<label>Cor:</label>
	{{Form::cor('cor', P::r($r, 'cor'))}}
</fieldset>
<?php if(isset($r->id)): ?>
<button class="deletar" id="but_deletar_form"><i data-font="&#xe808;"></i><span>DELETAR</span></button>
<?php endif; ?>
<button id="but_add_geral" data-historico="0"><i data-font="&#xf0ee;"></i><span>SALVAR</span></button>
