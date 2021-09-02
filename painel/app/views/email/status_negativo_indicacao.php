<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>EMAIL</title>
</head>
<body style="margin:0; padding: 0; background: #f4f4f4" bgcolor="#F4F4F4">
<style media="screen">
    {
        font-weight:
    }
</style>
<table align="center" style="font-family: Arial, sans-serif" border="0" width="560px" bgcolor="#f4f4f4">
    <tr><td height="20"></td></tr>
    <tr>
        <td style="line-height: 32px; font-weight: bold; font-size: 28px; text-align: center; padding: 0 15px;">STATUS DA SUA INDICAÇÃO</tr>
    </td>

    <tr><td height="10" style="border-bottom: 2px dotted <?= $_cor; ?>;"></td></tr>
    <tr><td height="10"></td></tr>

    <tr><td><img src="<?= LINK ?>/images/email/status_indicacao/bg_negativo.jpg" width="560px"></td></tr>

    <tr><td height="5"></td></tr>

    <tr><td style="line-height: 30px; background: #333; color: #FFF; font-size: 16px; padding: 15px; text-align: center;">
        APESAR DOS CONTATOS O PARCEIRO INDICADO NÃO TEVE INTERESSE EM FORMALIZAR CONOSCO, ACESSE AGORA O SEU CLUBE E INDIQUE UM NOVO PARCERIO.
    </td></tr>

    <tr>
        <td height="20" style="background-color: #FFF; border-top: 4px solid  <?= $_cor; ?>; text-align:center;"><table>
            <tr>
                <td></td>
            </tr>
        </table>
        Indicar novamente:<?= $_indicacao; ?>
        <table>
            <tr>
                <td></td>
            </tr>
        </table>
    </td>
    </tr>

</table>
<table style="border-collapse: collapse; width: 600px; max-width: 600px; margin: 0 auto;" width="600" cellspacing="0" cellpadding="0" border="0" width="600">
    <tr>
        <td width="20"></td>
        <td width="20"></td>
        <td align="center" height="80"><img src="<?= $_logo; ?>" alt="MARKT CLUB" height="60" /></td>
        <td width="20"></td>
        <td width="20"></td>
    </tr>
    <tr>
        <td width="20" height="20"></td>
        <td width="20" height="20"></td>
        <td height="20"></td>
        <td width="20" height="20"></td>
        <td width="20" height="20"></td>
    </tr>

    <tr>
        <td width="20" height="20"></td>
        <td width="20" height="20"></td>
        <td height="20" align="center">
            <span style="font-size: 12px; color: #999">
                Este e-mail foi enviado de forma automática, por favor, não responda.<br>
                &copy; Todos os direitos reservados.
            </span>
        </td>
        <td width="20" height="20"></td>
        <td width="20" height="20"></td>
    </tr>
    <tr>
        <td width="20" height="20"></td>
        <td width="20" height="20"></td>
        <td height="20"></td>
        <td width="20" height="20"></td>
        <td width="20" height="20"></td>
    </tr>
<table>

</body>
</html>
