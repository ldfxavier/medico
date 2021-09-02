<div id="banner">
    <figure class="bg_azul">IMAGEM 01</figure>
    <figure class="bg_vermelho">IMAGEM 02</figure>
    <figure class="bg_verde">IMAGEM 03</figure>
    <figure class="bg_rosa">IMAGEM 04</figure>
    <figure class="bg_laranja">IMAGEM 05</figure>

    <div class="prev" id="prev"></div>
    <div class="next" id="next"></div>

    <ul class="controle" id="controle">
        <li data-id="0" class="hover"></li>
        <li data-id="1"></li>
        <li data-id="2"></li>
        <li data-id="3"></li>
        <li data-id="4"></li>
    </ul>

    <div class="barra"><span id="barra"></span></div>
</div>

<script type="text/javascript">
$(function(){
    $.banner({
        id: '#banner',
        imagem: 'figure',
        controle: '#controle',
        prev: '#prev',
        next: '#next',
        barra: '#barra',
        rotacao: true,
        mobile: false,
        transicao: 0.5,
        tempo: 8,
    });
});
</script>

<style>
#banner {
    width: 100%;
    height: 400px;
    position: relative;
    float: left;
}
#banner figure {
    width: 100%;
    height: 100%;
    position: absolute;
    text-align: center;
    vertical-align: center;
    color: #FFF;
    padding-top: 50px;
    top: 0;
    left: 0;
    display: none;
}
#banner figure:first-child {
    display: block;
}
#banner .prev,
#banner .next {
    width: 50px;
    height: 100px;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
    background-color: #FFF;
    z-index: 10;
    cursor: pointer;
    opacity: 0;
}
#banner .prev {
    left: 10px;
}
#banner:hover .prev {
    opacity: 1;
}
#banner .next {
    right: 10px;
}
#banner:hover .next {
    opacity: 1;
}
#banner .controle {
    position: relative;
    margin: 0 auto;
    margin-top: 350px;
    display: table;
    z-index: 10;
}
#banner .controle li {
    width: 25px;
    height: 25px;
    float: left;
    margin: 0 5px;
    border: 4px solid #000;
    background-color: #000;
    cursor: pointer;
    border-radius: 100%;
}
#banner .controle li:hover {
    background-color: red;
}
#banner .controle li.hover {
    background-color: red;
}
#banner .barra {
    width: calc(100% - 10px);
    height: 10px;
    position: absolute;
    background-color: rgba(220,220,220, .3);
    left: 5px;
    bottom: 5px;
    border-radius: 5px;
    overflow: hidden;
    z-index: 10;
}
#banner .barra span {
    width: 0%;
    height: 10px;
    float: left;
    background-color: green;
    border-radius: 10px;
}

img {
    float: left;
    margin: 20px;
}
p {
    line-height: 1.5em;
    font-size: 14px;
    margin-top: 20px;
}
</style>
