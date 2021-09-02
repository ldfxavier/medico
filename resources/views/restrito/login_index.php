<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FAÇA SEU LOGIN - PARLAMENTUM</title>
</head>
<body style="display: none;">

    <div class="corpo">
        <form id="form_login" action="<?= LINK_PADRAO ?>/login" method="post">
            <figure class="logo"><img src="<?= LINK_PADRAO ?>/images/logo.png" alt="[Logo do site]" height="50"></figure>
            <fieldset>
                <div class="bloco__label">      
                    <input name="login"  type="text" placeholder=" ">
                    <span class="linha"></span>
                    <label>Login</label>
                </div>
                <div class="bloco__label">      
                    <input name="senha"  type="password" placeholder=" ">
                    <span class="linha"></span>
                    <label>Senha</label>
                </div>
            </fieldset>
            <button>ENTRAR</button>

        </form>
        <a href="<?= LINK_PADRAO ?>" class="volta">VOLTAR</a>
    </div>

<form action="/" method="post" >
	<input type="hidden" name="LINK_LOCATION" id="LINK_LOCATION" value="<?= $_SESSION['LINK_LOCATION'] ?? LINK_PADRAO ?>">
</form>


<script src="<?= LINK_PADRAO ?>/js/restrito.js?cache=<?= CACHE ?>" type="text/javascript"></script>
<script src="<?= LINK_PADRAO ?>/js/restrito/login_index.js?cache=<?= CACHE ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?= LINK_PADRAO ?>/css/restrito/login_index.css?cache=<?= CACHE ?>"/>
<link rel="stylesheet" href="<?= LINK_PADRAO ?>/css/restrito.css?cache=<?= CACHE ?>"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">

<script>

    $('body').css('display', 'block');
    
</script>

</body>
</html>