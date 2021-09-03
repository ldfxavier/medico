<?php Painel::busca_header($_app) ?>
<fieldset>
	<label>Data:</label>
	<input type="hidden" name="tipo" value="1">
    <div class="coluna">
        {{Form::data('data_inicio', null, null, true)}}
        <p class="ate">até</p>
        {{Form::data('data_final', null, null, true)}}
    </div>

    <?php
        $Status = new StatusModel;
        echo Form::select('status', Lista::status('Selecione um status:'));
    ?>
	<input type="text" name="titulo" placeholder="Digite um título" value="">
</fieldset>
<?php Painel::busca_footer() ?>
