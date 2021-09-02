<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="robots" content="noindex, nofollow">
	<title>PARCEIROS - TEMPO EXPIRADO</title>
</head>
<body style="font-family: Arial; background-color: #F4F4F4">
	<div style="padding: 10px 20px">
		<img src="{{LOGO}}" alt="{{TITULO}}" height="60" />
		<div style="padding: 10px 20px; background: #FFFFFF">
			<p>Já fazem 90 dias que esses parceiros não foram concluidos:</p>
            <br>
			<?php
			if(isset($_parceiro['dias_90']) && !empty($_parceiro['dias_90'])):
				foreach($_parceiro['dias_90'] as $r):
				?>
				<a href="{{PAINEL}}/editar/convenio_parceiro/<?= $r->cod ?>" target="_blank"><?= (isset($r->nome)) ? $r->nome : $r->titulo; (isset($r->usuario) && !empty($r->usuario) ?? " - Indicação"); ?></a><br />
				<?php
				endforeach;
			else:
				echo "Nenhum parceiro expirado.";
			endif;
			?>
			<br>
			<br>
			<p>Já fazem 120 dias que esses parceiros não foram concluidos:</p>
            <br>
			<?php
			if(isset($_parceiro['dias_120']) && !empty($_parceiro['dias_120'])):
				foreach($_parceiro['dias_120'] as $r):
				?>
				<a href="{{PAINEL}}/editar/convenio_parceiro/<?= $r->cod ?>" target="_blank"><?= (isset($r->nome)) ? $r->nome : $r->titulo; (isset($r->usuario) && !empty($r->usuario) ?? " - Indicação"); ?></a><br />
				<?php
				endforeach;
			else:
				echo "Nenhum parceiro expirado.";
			endif;
				?>
		</div>
		<p>
			Para maiores informações, ligue para: (61) 3202-3003<br>
			Markt Club - www.marktclub.com.br
		</p>
	</div>
</body>
</html>
