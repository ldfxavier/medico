<section class="bloco_banner--padrao " id="banner_principal">

	<figure style="background-image: url(<?= LINK_PADRAO;?>/images/banner.png)">
	<!-- 	<header>
			<h1>titulo</h1>
			<p>texto</p>
		</header>
		<a href="#" ></a> -->
	</figure>
	<figure style="background-image: url(<?= LINK_PADRAO;?>/images/banner.png)">
	<!-- 	<header>
			<h1>titulo</h1>
			<p>texto</p>
		</header>
		<a href="#" ></a> --></figure>

	<i class="controlador prev" id="banner_principal_prev"></i>
	<i class="controlador next" id="banner_principal_next"></i>

	<ul class="controle" id="controle">
		<li data-id="0" class="hover"></li>
		<li data-id="1"></li>
	</ul>

</section>


<section id="sobre">
	<div class="quadrado"></div>
	<div class="conteudo">
		<article class="esquerdo">
			<h1>DR. ANDRÉ NERI</h1>
			<p>
				Residência em Cardiologia no Instituto Dante Pazzanese de Cardiologia
				Especialização em Arritmia Clínica e Marcapasso no Instituto do Coração (InCor) da Faculdade de Medicina da Universidade de São Paulo (FMUSP)
				Título de Especialista em Cardiologia pela Sociedade Brasileira de Cardiologia
				Membro da Sociedade Brasileira de Cardiologia
			</p>
			<a href="#">Saiba mais</a>
		</article>
		<article class="direito">
			<figure>
				<img src="<?= LINK_PADRAO ?>/images/foto_1.png" alt="">
			</figure>
		</article>
	</div>
</section>

<section id="especialidade">
	<div class="bg"></div>
	<div class="titulo_padrao">
		<h1>Especialidades</h1>
		<div class="linha"></div>
	</div>
	<div class="conteudo">
		<?php
		$i = 1;
		while ($i <= 5) {
		?>
			<article>
				<figure>
					<img src="<?= LINK_PADRAO ?>/images/nariz.png" alt="">
				</figure>
				<h1>Nariz</h1>
				<p>Buy  your medicines with our mobile application with a simple delivery system</p>
				<a href="#"></a>
			</article>	
		<?php
			$i++;
		}
		?>
		<article class="ultimo">
			<div class="quadrado"></div>
		</article>
	</div>
</section>

<section id="agenda">
	<div class="centro">
		<article class="esquerdo">
			<div class="titulo_padrao_esquerdo">
				<h1>Agende sua consulta</h1>
				<div class="linha"></div>
			</div>
			<ul>
				<li>CONSULTA PRESENCIAL</li>
				<li>- Consulta Particular</li>
				<li>- Consulta Particular + Eletrocardiograma</li>
				<li>₪ CONSULTA ONLINE POR VIDEOCHAMADA (TELEMEDICINA)</li>
				<li>- Consulta Particular </li>
			</ul>
			<p class="margin">Para mais informações sobre Consulta Online, clique aqui.</p>
			<p>OBS: Mesmo que não façamos parte da rede credenciada de Planos de Saúde, você pode se consultar. São fornecidos Recibos para solicitar Reembolso do valor pago para os Planos de Saúde/Convênios. Se você tiver dúvidas, entre em contato com seu convênio ou conosco.</p>
		</article>
		<article class="direito">
			<form action="" method="post">
				<h1>Preencha os campos abaixo:</h1>
				<label for="nome">Nome</label>
				<input type="text" placeholder="Nome" name="nome" id="nome">

				<label for="email">E-mail</label>
				<input type="text"  placeholder="E-mail"  name="email" id="email">

				<label for="telefone">Telefone para contato</label>
				<input type="text" data-mascara="telefone"   placeholder="telefone"  name="telefone" id="telefone">
				
				<label for="telefone">Mensagem</label>
				<textarea placeholder="Sua mensagem" name="" id="" cols="30" rows="10"></textarea>
				<button>Enviar</button>
			</form>
		</article>
	</div>
</section>

<section id="localizacao">
	<div class="titulo_padrao">
		<h1>Localização</h1>
		<div class="linha"></div>
	</div>
	<div class="centro">
		<article class="esquerdo">
			<div class="quadrado"></div>
			<ul>
				<li>Rua Cincinato Braga, 340 - 6º Andar</li>
				<li>Bela Vista</li>
				<li>São Paulo - SP</li>
			</ul>
			
		</article>
		<article class="direito">
			<div class="mapa">
				<figure>
					<a href="https://www.google.com/maps/place/R.+Cincinato+Braga,+340+-+6%C2%BA+andar+-+Bela+Vista,+S%C3%A3o+Paulo+-+SP,+01333-010/data=!4m2!3m1!1s0x94ce59bc23f93033:0x85cba9b6ee454db5?sa=X&ved=2ahUKEwjE_Z_eyeHyAhU7q5UCHVy7D_QQ8gF6BAgMEAE" target="_blank"></a>
					<img src="<?= LINK_PADRAO ?>/images/mapa.png" alt="">
				</figure>
			</div>
		</article>
		<div class="quadrado_footer"></div>
	</div>
</section>