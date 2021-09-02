<button class="but_ajax" data-link="{{LINK}}/exemplos/pagina-conteudo/Pagina+01">PAGINA 01</button>

<style media="screen">
    button {
        width: 100%;
        max-width: 200px;
        height: 50px;
        margin: 20px auto;
        background-color: rgb(0,80,200);
        color: #FFF;
        display: table;
        border-radius: 3px;
    }

    .bloco_conteudo {
        width: calc(100% - 40px);
        max-width: 500px;
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        display: none;
    }
    .bloco_conteudo .conteudo {
        width: 100%;
        float: left;
        background-color: #FFF;
        padding: 10px 10px 0 10px;
    }
</style>

<script type="text/javascript">
$(function(){
    $.pagina({
        botao:'.but_ajax',
        attr:"data-link",
        width: 500
    });
});
</script>
