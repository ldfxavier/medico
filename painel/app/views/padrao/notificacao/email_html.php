<?php
    $url = 'https://novo.marktclub.com.br';
    $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
    $texto = isset($_GET['texto']) ? $_GET['texto'] : '';
    $link = isset($_GET['link']) ? $_GET['link'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>EMAIL</title>
    <style>
        table{
            border-collapse: collapse;
        }
        p{
            margin: 0;
        }
    </style>
</head>
<body style="margin:0; padding: 0; background: #f4f4f4" bgcolor="#F4F4F4">

<table style="font-size: 14px; font-family: Arial, sans-serif !important" border="0" width="100%" bgcolor="#f4f4f4">
<tr>
<td>
    <table align="center" border="0" width="500" cellspacing="0" colspacing="0" >
        <tr><td height="20"></td></tr>
        <tr><td height="60"><img src="<?= $url ?>/images/email/logo.png" alt="[SEJA PARCEIRO]" height="60" /></td></tr>
    </table>

    <table width="500" align="center" cellspacing="0" colspacing="0" style="border-left: 1px solid #CCC; border-right: 1px solid #CCC; border-top: 7px solid #ff6f00;" bgcolor="#FFFFFF" border="0">
        <tr bgcolor="#F0F0F0"><td width="20" height="20"></td><td><td width="20"></td></td></tr>
        <tr bgcolor="#F0F0F0"><td width="20"></td><td style="color:#666; font-family: Arial, sans-serif ">
            <span style="font-family: Arial, sans-serif; font-size: 16px; line-height: 24px;">
                <p style="margin-bottom: 10px; color: #ff6f00;"><b style="font-size: 20px"><?= $titulo ?></b></p>
                <p style="margin-bottom: 10px;"><?= $texto ?></p>
                <?php if(!empty($link)): ?>
                <p style="margin-bottom: 10px;">Acesse a notificação clicando no botão abaixo:</p>
                <?php endif; ?>
            </span>
        </td><td width="20"></td></tr>
        <tr bgcolor="#F0F0F0"><td width="20" height="10"></td><td><td width="20"></td></td></tr>
    </table>

    <?php if(!empty($link)): ?>
    <table width="500" align="center" cellspacing="0" colspacing="0" style="border-left: 1px solid #CCC; border-bottom: 1px solid #CCC; border-right: 1px solid #CCC;" bgcolor="#FFFFFF" border="0">

        <tr><td width="20" height="20"></td><td></td><td width="20"></td></tr>

        <tr>
            <td width="20"></td>
            <td width="460" valign="center" align="center" style="height: 40px; background-color:#ff6f00; text-align:center;border-radius: 4px; font-family: Arial, sans-serif !important"><p style=" font-family: Arial, sans-serif ;display:block !important; width: 100%;"><a style="width: 100%; height: 40px; line-height: 40px; float: left; color: #fff; text-decoration: none; font-family: Arial, sans-serif;" href="<?= $link ?>" target="_blank">ACESSAR PAINEL</a></p></td>
            <td width="20"></td>
        </tr>

        <tr><td width="20" height="20"></td><td></td><td width="20"></td></tr>

        <tr>
            <td width="20"></td>
            <td width="460">
                <p style="color: #666; font-size: 12px;">Caso não consiga clicar no botão, copie e cole o link abixo em seu navegador:</p>
                <p><a href="<?= $link ?>" style="color: #0000DD"><?= $link ?></a></p>
            </td>
            <td width="20"></td>
        </tr>

        <tr><td width="20" height="20"></td><td></td><td width="20"></td></tr>
    </table>
    <?php endif; ?>

    <table align="center" border="0" width="500" cellspacing="0" colspacing="0" >
        <tr><td height="10"></td></tr>
    </table>

    <table align="center" border="0" width="500" cellspacing="0" colspacing="0" >
        <tr><td height="20"></td></tr>
    </table>

    <table align="center" border="0" width="500" cellspacing="0" colspacing="0" >
        <tr><td align="center" style="color: #999;font-family: Arial, sans-serif ; font-size: 12px">&copy; Todos os direitos reservados.</td></tr>
        <tr><td align="center" style="color: #999;font-family: Arial, sans-serif ; font-size: 12px"><span style="font-weight: bold; color: red">Está é uma mensagem automática, por favor, não responda.</span></td></tr>
    </table>

    <table align="center" border="0" width="500" cellspacing="0" colspacing="0" >
        <tr><td height="20"></td></tr>
    </table>
</td>
</tr>
</table>

</body>
</html>
