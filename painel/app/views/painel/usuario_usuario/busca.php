<?php
Painel::busca_header($_app);
$Status = new StatusModel;
?>
<fieldset>
    <?=Form::select('status', array('' => 'Todos', 1 => 'Ativo', 2 => 'Inativo'));?>
    <?=Form::select('delegacia', $Status->select('enquete', 'delegacia', array('' => 'Todos')));?>
    <input type="text" name="LIKE|nome,documento" placeholder="Digite sua busca" value="">
</fieldset>
<?php Painel::busca_footer();?>
