<?php
	$Painel = new PainelModel;
	$r = $Painel->p_cod('usuario_usuario', $_par);
?>
<link rel="stylesheet" href="<?= LINK ?>/app/views/painel/usuario_usuario/scripts/layout.css{{CACHE}}"/>
<script src="<?= LINK ?>/app/views/painel/usuario_usuario/scripts/all.js{{CACHE}}" type="text/javascript"></script>
<form class="bloco_busca_ajax form_geral form_geral_codigo">
    <header>
        <h1>DEPENDENTE</h1>
        <i class="but_fechar_ajax"></i>
    </header>
	<div class="corpo">
		<fieldset>
			<input type="hidden" name="cod" value="<?= $r->cod ?>" />
			<input type="hidden" name="acao" value="editar" />
            <div class="bloco_dependente">
                <?php  	
                    $lista = $Painel->p_read('usuario_usuario', "`cod` = '{$r->cod}'");
                        if(isset($lista) && !empty($lista)):
                        foreach($r->filiacao->dependente as $d):
                ?>
                <div class="categoria dependente" style="margin: 20px 0px;">
                    <?php
                    if(isset( $d->nome) && !empty( $d->nome) ):
                    ?>
                    <label for="nome_dependente">Nome:</label>
                    <input type="text" id="nome_dependente" name="nome_dependente" data-campo="Nome dependente" value="<?= $d->nome ?>">
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->documento) && !empty( $d->documento) ):
                    ?>
                    <label for="documento_dependente">Documento:</label>
                    <input type="text" id="documento_dependente" name="documento_dependente" data-campo="Documento dependente" value="<?= $d->documento ?>">
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->rg) && !empty( $d->rg) ):
                    ?>
                    <label for="input_rg_dependente">RG:</label>
                    <input type="text"  id="input_rg_dependente" value="<?= $d->rg ?>" name="rg_dependente" data-campo="Cônjuge" placeholder="Digite o rg do dependente" >
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->emissor) && !empty( $d->emissor) ):
                    ?>
        
                    <label for="input_emissor_dependente">EMISSOR:</label>
                    <input type="text"  id="input_emissor_dependente"  value="<?= $d->emissor ?>" name="emissor_dependente" data-campo="Emissor" placeholder="Digite o emissor do dependente" >
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->nascimento) && !empty( $d->nascimento) ):
                    ?>
        
                    <label for="input_data_nascimento_dependente">DATA DE NASCIMENTO:</label>
                    <input type="text"  id="input_data_nascimento_dependente"  value="<?= $d->nascimento ?>"  name="data_nascimento_dependente" data-campo="data_nascimento" placeholder="Digite o data nascimento do dependente"  data-mascara="00/00/0000">
                    <?php
                    endif;
                    ?>
                    <?php
                    if(isset( $d->parentesco) && !empty( $d->parentesco) ):
                    ?>
        
                    <label for="input_parentesco_dependente">PARENTESCO:</label>
                    <input type="text"   id="input_parentesco_dependente"  value="<?= $d->parentesco ?>"  name="parentesco_dependente" data-campo="parentesco" placeholder="Digite o parentesco do dependente" >
        
                    <?php
                    endif;
                    ?>
                </div>
			
                <?php  	
                    endforeach;
                    endif;
                
                ?>
            </div>
		</fieldset>
	</div>
    <footer class="geral_botao">
        <button class="botao btn_dependente">ATUALIZAR</button>
    </footer>
</form>