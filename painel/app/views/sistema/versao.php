<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Versão</title>
</head>
<body>
<figure><img src="{{LOGO}}" alt="{{TITULO}}" height="60"></figure>
<section>
    <article>
        <header>
            <h1>Versão 1.0.0 <span>(00/00/0000)</span></h1>
        </header>
        <ul>
            <li>Versão inicial</li>
        </ul>
    </article>
</section>

<link rel="stylesheet" href="{{LINK}}/system/.arquivos/css/resetar.css"/>

<style>
body {
    margin: 0;
    padding: 0;
    background-color: #F6F6F6;
    font-family: Arial;
    font-size: 62.5%;
}
figure {
    width: 100%;
    float: left;
    margin: 20px 0 10px 0;
    text-align: center;
}
section {
    width: calc(100% - 40px);
    max-width: 500px;
    margin: 20px auto;
    background-color: #FFF;
    border-top: 4px solid <?php echo COR ?>;
    display: table;
}
section article {
    width: 100%;
    float: left;
    padding: 20px;
    border-bottom: 1px solid #DDD;
}
section article h1 {
    font-weight: bold;
    font-size: 1.6em;
}
section article h1 span {
    color: #999;
    font-size: 0.8em;
    font-weight: normal;
}
section article ul li {
    width: calc(100% - 40px);
    float: left;
    margin-top: 5px;
    font-size: 1.1em;
    list-style: circle;
    margin-left: 15px;
}
</style>

</body>
</html>
