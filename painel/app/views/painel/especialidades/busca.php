<?php Painel::busca_header($_app) ?>
<fieldset>
	{{Form::select('status', array('' => 'Todos', 1 => 'Ativo', 2 => 'Inativo', 3 => 'Bloqueado'))}}
	<input type="text" name="LIKE|titulo_grande,titulo_pequeno,texto_grande,texto_pequeno" placeholder="Digite sua busca" value="">
</fieldset>
<?php Painel::busca_footer() ?>
