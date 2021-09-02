<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/usuario_usuario/scripts/layout.css{{CACHE}}"/>
<script src="<?= LINK ?>/app/views/painel/usuario_usuario/scripts/all.js{{CACHE}}" type="text/javascript"></script>
<?php
	$Painel = new PainelModel;
	$r = $Painel->p_cod('usuario_usuario', $_par);
?>
<form class="bloco_busca_ajax form_geral form_geral_codigo">
    <header>
        <h1>DEPENDENTE</h1>
        <i class="but_fechar_ajax"></i>
    </header>
	<div class="corpo">
		<fieldset>
			<input type="hidden" name="cod" value="<?= (isset($_par) && !empty($_par)) ? $_par : '' ?>" />
			<input type="hidden" name="acao" value="add" />
            <div class="bloco_dependente">
            <?php  	
                    if(isset($r->cod) && !empty($r->cod)):
                        $lista = $Painel->p_read('usuario_usuario', "`cod` = '{$r->cod}'");
                    endif;
                        if(isset($lista) && !empty($lista)):
                        foreach($r->filiacao->dependente as $d):
                ?>
                <div class="categoria dependente" style="margin: 20px 0px;">
                    <?php
                    if(isset( $d->nome) ):
                    ?>
                    <input type="hidden" id="nome_dependente" name="nome_dependente" data-campo="Nome dependente" value="<?= $d->nome ?>">
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->documento) ):
                    ?>
                    <input type="hidden" id="documento_dependente" name="documento_dependente" data-campo="Documento dependente" value="<?= $d->documento ?>">
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->rg) ):
                    ?>
                    <input type="hidden"  id="input_rg_dependente" value="<?= $d->rg ?>" name="rg_dependente" data-campo="Cônjuge" placeholder="Digite o rg do dependente" >
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->emissor) ):
                    ?>
                    <input type="hidden"  id="input_emissor_dependente"  value="<?= $d->emissor ?>" name="emissor_dependente" data-campo="Emissor" placeholder="Digite o emissor do dependente" >
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->nascimento) ):
                    ?>
                    <input type="hidden"  id="input_data_nascimento_dependente"  value="<?= $d->nascimento ?>"  name="data_nascimento_dependente" data-campo="data_nascimento" placeholder="Digite o data nascimento do dependente"  data-mascara="00/00/0000">
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->parentesco) ):
                    ?>
                    <input type="hidden"   id="input_parentesco_dependente"  value="<?= $d->parentesco ?>"  name="parentesco_dependente" data-campo="parentesco" placeholder="Digite o parentesco do dependente" >
        
                    <?php
                    endif;
                    ?>
                </div>
			
                <?php  	
                    endforeach;
                    endif;
                
                ?>
                <div class="categoria dependente primeiro">
                    <label for="input_nome_dependente">NOME COMPLETO:</label>
                    <input type="text" id="input_nome_dependente" name="nome_dependente" data-campo="Nome dependente" placeholder="Digite o nome do dependente" >

                    <label for="input_documento_dependente">CPF:</label>
                    <input type="text" id="input_documento_dependente" name="documento_dependente" data-campo="Cônjuge"data-mascara="000.000.000-00"  placeholder="Digite o documento do dependente">

                    <label for="input_rg_dependente">RG:</label>
                    <input type="text" id="input_rg_dependente" name="rg_dependente" data-campo="Cônjuge" placeholder="Digite o rg do dependente" >

                    <label for="input_emissor_dependente">EMISSOR:</label>
                    <input type="text" id="input_emissor_dependente" name="emissor_dependente" data-campo="Emissor" placeholder="Digite o emissor do dependente" >

                    <label for="input_data_nascimento_dependente">DATA DE NASCIMENTO:</label>
                    <input type="text" id="input_data_nascimento_dependente" name="data_nascimento_dependente" data-campo="data_nascimento" placeholder="Digite o data de nascimento do dependente"  data-mascara="00/00/0000">

                    <label for="input_parentesco_dependente">PARENTESCO:</label>
                    <input type="text" id="input_parentesco_dependente" name="parentesco_dependente" data-campo="parentesco" placeholder="Digite o parentesco do dependente" >
                </div>

                <div class="adicionar_dependente" style="cursor:pointer;">Adicionar dependente</div>
            </div>
        </fieldset>
    </div>
    <footer>
        <button class="botao btn_dependente">CADASTRAR</button>
    </footer>
</form>
</script>
