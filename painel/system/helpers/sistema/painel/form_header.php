<?php
    $equipe = $_SESSION['EQUIPE'];

	if(isset($painel_input['cod'])):
		$cod = $painel_input['cod'];
		unset($painel_input['cod']);
    elseif(isset($r->cod)):
		$cod = $r->cod;
	else:
		$cod = md5(uniqid(time()));
	endif;

    if($painel_volta == null) $painel_volta = in_array(Permissao::nome($painel_app).'_visualizar', $equipe->permissao->lista) ? PAINEL.'/visualizar/'.$painel_app.'/'.$cod : PAINEL.'/app/'.$painel_app;
?>
<input type="hidden" id="form_app_geral" value="<?= $painel_app; ?>">
<input type="hidden" id="form_volta_geral" value="<?= $painel_volta; ?>">

<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">

<?php if(isset($r->id)): ?>
<input type="hidden" name="id" value="<?= $r->id ?>">
<?php endif; ?>
<input type="hidden" name="cod" value="<?= $cod ?>">

<?php
    if($painel_input):
        foreach($painel_input as $ind => $val):
?>
<input type="hidden" name="<?= $ind ?>" value="<?= $val ?>">
<?php
        endforeach;
    endif;
?>
