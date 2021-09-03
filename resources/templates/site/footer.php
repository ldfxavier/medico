

        </div>

</main>

<footer>
	<div class="quadrado"></div>
	<div class="centro">
		<article class="redes">
			<ul>
				<li>
					<img src="<?= LINK_PADRAO ?>/images/email_footer.png" alt="email">
					<p>
						<span class="bold">E-mail</span>
						<span>cirurgiasoto@gmail.com</span>
					</p>
				</li>
				<li>
					<img src="<?= LINK_PADRAO ?>/images/whatsapp_footer.png" alt="whatsapp">
					<p>
						<span class="bold">Whatsapp</span>
						<span>+55 61 99840 4040</span>
					</p>
				</li>
			</ul>
			<ul class="rede_linha">
				<li><a href=""><img src="<?= LINK_PADRAO?>/images/facebook_footer.png" alt=""></a></li>
				<li><a href=""><img src="<?= LINK_PADRAO?>/images/instagram_footer.png" alt=""></a></li>
				<li><a href=""><img src="<?= LINK_PADRAO?>/images/twitter_footer.png" alt=""></a></li>
				<li><a href=""><img src="<?= LINK_PADRAO?>/images/youtube_footer.png" alt=""></a></li>
			</ul>
		</article>
		<article class="texto">
			<div class="conteudo">
				<h3>Institucional</h3>
				<p>Dr. André Neri</p>
				<p>Blog</p>
				<p>Agendamentos</p>
			</div>
		</article>
		<article class="texto">
			<div class="conteudo">
				<h3>Especialidades</h3>
				<p>Nariz</p>
				<p>Orelha</p>
				<p>Garganta</p>
				<p>Cirurgia laser</p>
			</div>
		</article>
		<article class="texto">
			<div class="conteudo">
				<h3>Contatos</h3>
				<p>+55 61 99840 4040</p>
				<p>cirurgiasoto@gmail.com</p>
			</div>
		</article>
	</div>

</footer>
</div>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200;0,400;0,500;0,600;0,700;0,800;1,200&display=swap" rel="stylesheet">

<script src="<?=LINK_PADRAO;?>/js/site.js?cache=<?=CACHE;?>" type="text/javascript"></script>

<?=$js_pagina;?>

<style media="screen">
#site .color_cor,
.color_cor {
color: #17567F !important;
}
#site .bg_cor,
.bg_cor{
background-color: #17567F !important;
}
#site .border_cor,
.border_cor {
border-color: #17567F;
}
#site .color_cor_hover:hover
.color_cor_hover:hover {
color: #17567F;
}
#site .bg_cor_hover:hover,
.bg_cor_hover:hover {
background-color: #17567F;
}
#site .border_cor_hover:hover,
.border_cor_hover:hover {
border-color: #17567F;
}
#site .hover_pai:hover .bg_filho,
.hover_pai:hover .bg_filho {
background-color: #17567F;
}
#site .hover_pai:hover .color_filho,
.hover_pai:hover .color_filho {
color: #17567F;
}
#site .hover_pai:hover .border_filho,
.hover_pai:hover .border_filho {
border-color: #17567F;
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
