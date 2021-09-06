

			<div id="widget_wpp" class="fadeInDown">
				<a href="<?= $dado->whatsapp->link ?>" target="_blank">
					<i data-font="&#xe82d;"></i>
				</a>
			</div>
        </div>

</main>

<footer>
	<div class="quadrado"></div>
	<div class="centro">
		<article class="redes">
			<ul>

			<?php
				if (isset($dado->email) && !empty($dado->email)):
			?>
			<li>
				<img src="<?= LINK_PADRAO ?>/images/email_footer.png" alt="email">
				<p>
					<span class="bold">E-mail</span>
					<span><?= $dado->email?></span>
				</p>
			</li>
			<?php
				endif;
			?>
			<?php
				if (isset($dado->whatsapp->valor) && !empty($dado->whatsapp->valor)):
			?>
				<li>
					<img src="<?= LINK_PADRAO ?>/images/whatsapp_footer.png" alt="whatsapp">
					<p>
						<span class="bold">Whatsapp</span>
						<span><?= $dado->whatsapp->valor ?></span>
					</p>
					<a class="link" href="<?= $dado->whatsapp->link ?>"></a>
				</li>
			<?php
				endif;
			?>
			</ul>
			<ul class="rede_linha">

			<?php
				if (isset($dado->facebook) && !empty($dado->facebook)):
			?>
			<li><a href="<?= $dado->facebook ?>" target="_blank"><img src="<?= LINK_PADRAO?>/images/facebook_footer.png" alt=""></a></li>
			<?php
				endif;
			?>
			<?php
				if (isset($dado->instagram) && !empty($dado->instagram)):
			?>
			<li><a href="<?= $dado->instagram ?>"  target="_blank"><img src="<?= LINK_PADRAO?>/images/instagram_footer.png" alt=""></a></li>
			<?php
				endif;
			?>
			<?php
				if (isset($dado->twitter) && !empty($dado->twitter)):
			?>	
			<li><a href="<?= $dado->twitter ?>"><img src="<?= LINK_PADRAO?>/images/twitter_footer.png" alt=""></a></li>
			<?php
				endif;
			?>
			<?php
				if (isset($dado->youtube) && !empty($dado->youtube)):
			?>
			<li><a href="<?= $dado->youtube ?>"  target="_blank"><img src="<?= LINK_PADRAO?>/images/youtube_footer.png" alt=""></a></li>
			<?php
				endif;
			?>
			</ul>
		</article>
		<article class="texto">
			<div class="conteudo">
				<h3>Institucional</h3>
				<p><a href="#sobre">Dr. André Neri</a></p>
				<p><a href="#agenda">Agendamentos</a></p>
			</div>
		</article>
		<article class="texto">
			<div class="conteudo">
				<h3>Especialidades</h3>
				<?php
				if (isset($especialidade) && !empty($especialidade)):
					foreach ($especialidade as $t):
				?>
				<p><?= $t->titulo ?></p>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</article>
		<article class="texto">
			<div class="conteudo">
				<h3>Contatos</h3>
				<p><?= $dado->telefone ?></p>
				<p><?= $dado->email ?></p>
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
</form>

</body>
</html>
