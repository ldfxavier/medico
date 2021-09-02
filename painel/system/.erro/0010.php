<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ERRO 0010</title>
    <style>
        body {
            min-height: 100vh;
            background-color: #F6F6F6;
            text-align: center;
            font-family: Arial, sans-serif;
            word-wrap: break-word;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: #F26;
        }
        img {
            margin-right: 20px;
        }
        p {
            margin-top: 20px;
            padding: 0;
            color: #CCC;
        }
    </style>
</head>
<body>
    <?php $diretorio = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) ?>
    <img src="<?php echo $diretorio ?>/system/.arquivos/images/erro.png" alt="[ERRO]" height="50">
    <p>Não foi possível acessar está página, por favor, entrar em contato com o administrador.</p>
    <!--
    <p>Erro 0010 - Site sem ação de PDO.</p>
    -->
</body>
</html>
