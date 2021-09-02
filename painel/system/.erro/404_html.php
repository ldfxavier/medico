<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo FAVICON ?>" type="image/png">

    <link rel="stylesheet" href="<?php echo LINK ?>/system/.arquivos/css/resetar.css"/>

    <meta charset="UTF-8">
    <title>PAGINA NÃO ENCONTRADA</title>
    <style>
        #bloco_erro_geral {
            width: 100%;
            min-height: 100vh;
            background-color: #F6F6F6;
            text-align: center;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-items: center;
            word-wrap: break-word;
        }
        #bloco_erro_geral h1 {
            font-size: 30px;
            font-weight: bold;
            margin-top: 20px;
        }
        #bloco_erro_geral img {
            margin-top: 40px;
        }
        #bloco_erro_geral p {
            color: #666;
            margin-bottom: 30px;
        }
        #bloco_erro_geral a {
            height: 40px;
            line-height: 40px;
            background-color: green;
            color: #FFF;
            text-decoration: none;
            padding: 0 30px;
            border-radius: 20px;
        }
        #bloco_erro_geral ul {
            list-style: none;
            margin-top: 60px;
        }
        #bloco_erro_geral ul li {
            margin-bottom: 4px;
            color: #999;
        }
        #bloco_erro_geral ul li span {
            width: 100%;
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }
        #bloco_erro_geral .icon {
            width: 200px;
            height: 200px;
            margin-top: 50px;
            border-radius: 200px;
        }
    </style>
</head>
<body style="margin:0; padding:0;">
<div id="bloco_erro_geral">
    <img src="<?= LOGO ?>" height="50" />
    <h1>Ops!</h1>
    <p>A página acessada não existe ou está inativa no momento.</p>
    <a href="<?= LINK ?>">IR PARA HOME</a>
    <ul>
        <li><span>POSSÍVEIS MOTIVOS</span></li>
        <li>O endereço digitado está incorreto.</li>
        <li>A página está fora do ar no momento.</li>
        <li>O conteúdo foi movido para outra endereço.</li>
        <li>A página foi retirado do ar.</li>
    </ul>
</div>
</body>
</html>
