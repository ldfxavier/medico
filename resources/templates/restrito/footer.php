

        </div>

    </main>

    <footer>
        <div class="banner_footer" style="background-image: url(<?= LINK_PADRAO ?>/images/imagem.jpg);">
            <div class="conteudo">
                <div class="centro">
                    <div class="topo">
                        <img src="<?= LINK_PADRAO ?>/images/logo_branca.png" height="45" alt="">
                        <a href="#" class="contratar">Contratar</a>
                    </div> 

                    <div class="informacao animar">
                        <ul>
                            <li class="bold">Endereço:</li>
                            <li>Sig Quadra 4 Lote 125</li>
                            <li>Bloco A Sala 10</li>
                            <li>Brasília/DF</li>
                            <li>CEP: 70610-440</li>
                            <li class="email bold">E-mail</li>
                            <li>atendimento@parlamentum.com.br</li>
                        </ul>
                    </div>

                </div>
                <div class="copyright">
                    <div class="centro">
                        <p>2021 - Todos os direitos reservados</p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</div>

<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Sarala:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<script src="<?=LINK_PADRAO;?>/js/login.js?cache=<?=CACHE;?>" type="text/javascript"></script>

<?=$js_pagina;?>

<style media="screen">
#site .color_cor,
.color_cor {
    color: #003366 !important;
}
#site .bg_cor,
.bg_cor{
    background-color: #003366 !important;
}
#site .border_cor,
.border_cor {
    border-color: #003366;
}
#site .color_cor_hover:hover
.color_cor_hover:hover {
    color: #003366;
}
#site .bg_cor_hover:hover,
.bg_cor_hover:hover {
    background-color: #003366;
}
#site .border_cor_hover:hover,
.border_cor_hover:hover {
    border-color: #003366;
}
#site .hover_pai:hover .bg_filho,
.hover_pai:hover .bg_filho {
    background-color: #003366;
}
#site .hover_pai:hover .color_filho,
.hover_pai:hover .color_filho {
    color: #003366;
}
#site .hover_pai:hover .border_filho,
.hover_pai:hover .border_filho {
    border-color: #003366;
}
</style>

<form action="/" method="post">
<input type="hidden" name="LINK_PADRAO" id="LINK" value="<?=LINK_PADRAO;?>">
<input type="hidden" name="PAINEL" id="PAINEL" value="<?=LINK_PAINEL;?>">
<input type="hidden" name="ARQUIVO" id="ARQUIVO" value="<?=LINK_ARQUIVO;?>">
<input type="hidden" name="COR" id="COR" value="<?=$_SESSION['CLUBE']->cor;?>">
<input type="hidden" name="LINK_LOCATION" id="LINK_LOCATION" value="<?= $_SESSION['LINK_LOCATION'] ?? LINK ?>">
</form>

</body>
</html>
