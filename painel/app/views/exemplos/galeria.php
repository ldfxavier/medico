<h1 class="texto_center fz30 mt20">GALERIA DE FOTOS</h1>
<div id="galeria">
    <div class="center">
        <figure style="background-image:url(http://placehold.it/600x600)"><img src="http://placehold.it/600x600" width="100%"></figure>
        <figure style="background-image:url(http://placehold.it/600x300)"><img src="http://placehold.it/600x300" width="100%"></figure>
        <figure style="background-image:url(http://placehold.it/600x300)"><img src="http://placehold.it/600x300" width="100%"></figure>
        <figure style="background-image:url(http://placehold.it/600x300)"><img src="http://placehold.it/600x300" width="100%"></figure>
        <figure style="background-image:url(http://placehold.it/600x300)"><img src="http://placehold.it/600x300" width="100%"></figure>
        <figure style="background-image:url(http://placehold.it/400x100)"><img src="http://placehold.it/400x100" width="100%"></figure>
    </div>
</div>

<script type="text/javascript">
$(function(){
    $.galeria({
        id:'#galeria',
        botao:'figure'
    });
});
</script>

<style media="screen">
#galeria {
    width: 100%;
    float: left;
    margin-bottom: 20px;
}
h1 {
    margin-bottom: 40px;
}
#galeria figure {
    width: calc((50%) - 2px);
    height: 300px;
    position: relative;
    float: left;
    background-position: center center;
    background-size: cover;
    margin:1px;
    cursor: pointer;
    z-index: 2;
    overflow: hidden;
}
#galeria figure.animacao {
    cursor: default;
    z-index: 3;
}
#galeria figure img {
    position: relative;
    opacity: 0;
}

</style>
