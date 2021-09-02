<form action="/" method="post">
    <button id="but_normal">ALERTA NORMAL</button>
    <button id="but_confirmar">ALERTA CONFIRME</button>
    <button id="but_refresh">ALERTA REFRESH</button>
    <button id="but_alerta">ALERTA TOPO</button>
    <button id="but_alerta_2">ALERTA TOPO</button>
</form>

<script type="text/javascript">
$(function(){
    $('body').on('click', '#teste', function(){
        $('body').css('background-color', '#F00');
    });

    $('#but_normal').click(function(){
        $.alerta({
            titulo:'Olá Mundo!',
            texto:'Lorem ipsum dolor sit amet.'
        });
        return false;
    });
    $('#but_confirmar').click(function(){
        $.alerta({
            titulo:'Olá Mundo!',
            texto:'Lorem ipsum dolor sit amet.',
            confirmar:'teste'
        });
        return false;
    });
    $('#but_refresh').click(function(){
        $.alerta({
            titulo:'Olá Mundo!',
            texto:'Lorem ipsum dolor sit amet.',
            href:"{{URL}}"
        });
        return false;
    });
    $('#but_alerta').click(function(){
        $.alerta({
            texto:'Lorem ipsum dolor sit amet. Lorem ipsum do sit amet. Lorem ipsum dolor sit amet.',
            notificacao:'erro'
        });
        return false;
    });

    $('#but_alerta_2').click(function(){
        $.alerta({
            texto:'Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.',
            notificacao:'ok'
        });
        return false;
    });
});
</script>

<style media="screen">
form {
    width: calc(100% - 40px);
    max-width: 200px;
    margin: 0 auto;
    font-family: Arial;
}
form button {
    width: 100%;
    height: 60px;
    font-size: 1.6em;
    border: 1px solid green;
    border-top: none;
}
form button:first-child {
    border-top: 1px solid green;
    margin-top: 40px;
}
form button:hover {
    background-color: green;
    color: #FFF;
}
</style>
