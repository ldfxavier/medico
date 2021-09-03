<?php
$r = isset($_dado) ? $_dado : '';
$equipe = $_SESSION['EQUIPE'];

if (isset($r->cod)) {
    $cod = $r->cod;
} else {
    $cod = md5(uniqid(time()));
}

?>

<script type="text/javascript" src="{{LINK}}/app/views/painel/{{$_app}}/scripts/all.js"></script>

<input type="hidden" id="form_app_geral" value="{{$_app}}">
<input type="hidden" id="form_volta_geral" value="{{PAINEL}}/app/{{$_app}}/{{$cod}}">
<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">
<?php if (isset($r->id)): ?>
<input type="hidden" name="id" value="{{$r->id}}">
<?php endif;?>
<input type="hidden" name="cod" value="{{$cod}}">

<div class="linha_grande">

	<fieldset>
		<legend>DADOS</legend>
		<label>Título:</label>
		<input type="text" name="title" value="{{P::r($r, 'titulo')}}" placeholder="Digite um título">

		<!-- <label>Link:</label>
		<input type="text" name="" value="{{P::r($r, 'arquivo->link')}}" placeholder="Digite um título"> -->
	</fieldset>

	<fieldset class="lista">
		<legend>ARQUIVO</legend>
		{{Form::arquivo('ARQUIVO', 'file', P::r($r, 'arquivo->valor'), 'drive', 'pdf/jpg/jpeg/png/doc/docx')}}
	</fieldset>
</div>
