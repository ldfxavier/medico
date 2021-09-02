<?php
    $link = LINK;
    $instagram = !empty(INSTAGRAM) ? '<a href="'.INSTAGRAM.'"><img height="25" src="'.LINK.'/images/email_instagram.png" alt="Instagram" /></a>' : '';
    $facebook = !empty(FACEBOOK) ?  '<a href="'.FACEBOOK.'"><img height="25" src="'.LINK.'/images/email_facebook.png" alt="Facebook" /></a>' : '';
    $google = !empty(GOOGLE) ? '<a href="'.GOOGLE.'"><img height="25" src="'.LINK.'/images/email_google.png" alt="Google" /></a>' : '';
    $twitter =  !empty(TWITTER) ? '<a href="'.TWITTER.'"><img height="25" src="'.LINK.'/images/email_twitter.png" alt="Twitter" /></a>' : '';

	$Painel = new PainelModel;
	$Construtor = new ConstrutorModel;
	$parceiro = $Painel->p_read("convenio_parceiro", "`cod` = '".$_parceiro."'");
	if($_empresa != 0):
		$empresa = $Painel->p_read("administrativo_construtor", "`empresa` = '{$_empresa}'");
	endif;
	$logo = $Construtor->logo_padrao($parceiro[0]->empresa->lista);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>EMAIL</title>
</head>
<body style="margin:0; padding: 0; background: #f4f4f4" bgcolor="#F4F4F4">

<table style="font-size: 14px; font-family: Arial, sans-serif" border="0" width="100%" bgcolor="#f4f4f4">
<tr>
<td>
    <table align="center" border="0" width="600" cellspacing="0" colspacing="0" >
        <tr><td height="20"></td></tr>
    </table>

	<table style="border-collapse: collapse; background: #eeeeee; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td><img style="display: block;" src="{{LINK}}/images/email/aviso_parceiro/topo.jpg" alt="Novos clientes para a sua empresa!" id="ext-gen2166" width="600" height="352" align="none" /></td>
			</tr>
		</tbody>
	</table>
	<?php
	if(isset($empresa) && !empty($empresa)):
	?>
    <table style="border-collapse: collapse; background: #eeeeee; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
                <td style="text-align:center; background-color:#fff;" width="240" height="100"></td>
				<td style="text-align:center; background-color:#fff;"><img style="display: block; text-aligin:center;" src="<?= $empresa[0]->imagem->logo_padrao->link; ?>" alt="Novos clientes para a sua empresa!" id="ext-gen2166" align="none" /></td>
                <td style="text-align:center; background-color:#fff;"width="240" height="100"></td>
			</tr>
		</tbody>
	</table>
	<?php
	endif;
	?>
    <table style="border-collapse: collapse; background: #eeeeee; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td><img style="display: block;" src="{{LINK}}/images/email/aviso_parceiro/chamada.jpg" alt="Novos clientes para a sua empresa!" id="ext-gen2166" width="600" height="93" align="none" /></td>
            </tr>
        </tbody>
    </table>
    <table style="border-collapse: collapse; background: #FFF; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<?php
                if($logo):
                    $i = 0;
                    foreach($logo as $r):
                        echo ($i == 0) ? '<tr><td width="20"></td>' : '';
			?>
				<td style="text-align:center; background-color:#fff;"><img style="display: block;" src="<?= $r->imagem; ?>" alt="<?= $r->titulo ?>" id="ext-gen2166" width="100%" align="none" /></td>
			<?php
                    echo ($i == 0 || $i == 1) ? '<td width="20"></td>' : '';

    				echo ($i == 2) ? '<td width="20"></td></tr><tr><td width="20"></td><td height="20"></td><td width="20"></td><td height="20"></td><td width="20"></td><td height="20"></td><td width="20"></td></tr>' : '';
    				($i == 2) ? $i = 0 : $i++;
                    endforeach;
                endif;
			?>
            <tr><td width="20"></td><td height="40"></td><td width="20"></td><td height="40"></td><td width="20"></td><td height="40"></td><td width="20"></td></tr>
		</tbody>
	</table>
    <table style="border-collapse: collapse; background: #eeeeee; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td><img style="display: block;" src="{{LINK}}/images/email/aviso_parceiro/base.jpg" alt="Cuide bem de sua parceria!" id="ext-gen2166" width="600" height="77" align="none" /></td>
			</tr>
		</tbody>
	</table>

    <table style="border-collapse: collapse; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr><td height="20"></td></tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr><td align="center" style="color: #000; font-size: 18px; font-weight: bold">DÚVIDAS?</td></tr>
            <tr><td align="center" height="5"></td></tr>
            <tr><td align="center"><a href="tel:0800 932 0000 ramal 4199 (Apenas telefone fixo)" style="color: #666; font-size: 14px; font-weight: bold">0800 932 0000 ramal 4199 (Apenas telefone fixo)</a></td></tr>
            <tr><td align="center"><a href="email:{{EMAIL}}" style="color: #666; font-size: 14px; font-weight: bold">convenio@marktclub.com.br</a></td></tr>
            <tr><td align="center" height="10"></td></tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr><td height="10"></td></tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr><td align="center" style="color: #999; font-size: 12px">&copy; Todos os direitos reservados - {{TITULO}}.</td></tr>
            <tr><td align="center" style="color: #999; font-size: 12px"><span style="font-weight: bold">Está é uma mensagem automática, por favor, não responda.</span></td></tr>
            <tr><td height="20"></td></tr>
        </tbody>
    </table>
</td>
</tr>
</table>

</body>
</html>
