<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;

	// Título
	$_titulo = 'DRIVE';

	// Controller
	$controller = 'drive';

	// Botões
	$add = true;
	$deletar = true;
	$selecao = true;

	$Model = new DriveModel;
	$lista = $Model->lista();
?>

<link rel="stylesheet" href="{{LINK}}/app/views/painel/{{$_app}}/scripts/layout.css"/>
<script type="text/javascript" src="{{LINK}}/app/views/painel/{{$_app}}/scripts/all.js"></script>
<div id="bloco_{{$_app}}" class="app_geral_imagem">
    <header class="header_principal header_principal_animacao header_principal_absolute">
        <h1 class="linha">{{$_titulo}}</h1>
		<?php if($add && in_array(Permissao::nome($_app).'_add', $permissao)): ?>
		<a href="{{PAINEL}}/add/{{$_app}}" data-ajuda="Adicionar registro" class="add"><i data-font="&#xe809;"></i><span>ADD</span></a>
		<?php endif;?>
		<?php if($deletar && in_array(Permissao::nome($_app).'_deletar', $permissao)): ?>
		<div data-ajuda="Deletar registro" class="deletar but_deletar_lista bloco_selecionado hide"><i data-font="&#xe808;"></i><span>DELETAR</span></div>
		<?php endif;?>
    </header>
	<div class="header_principal_false"></div>

	<div id="gerar_link" class="link_doc">
		<div class="explicacao">
			<p class="texto">Copie este link para colocar na sua postagem</p>
			<input value="" type="text">
		</div>
	</div>

	<ul class="lista_dados" id="bloco_lista_geral" data-app="{{$_app}}">
		<?php
			if($lista):
				foreach($lista as $r):
		?>
		<li class="bloco li <?php echo ($selecao == true) ? 'but_visualizar_geral' : '' ?>" data-id="<?php echo $r->id ?>">
			<figure style="background-image: url(<?php echo $r->arquivo->extensao->link ?>)"></figure>
			<a href="{{PAINEL}}/editar/{{$_app}}/<?php echo $r->cod ?>"></a>
			<span><?php echo Converter::caixa($r->titulo, 'A') ?></span>
			<div class="but_gerar_link" data-link="<?php echo $r->arquivo->link ?>"><i data-font="&#xf0ed;"></i></div>
		</li>
		<?php
				endforeach;
			else:
		?>
		<div class="zero">
			<i data-font="&#xe801;"></i>
			<span>SEM DADOS NO MOMENTO</span>
		</div>
		<?php
			endif;
		?>
	</ul>

	<i id="voltar_topo" class="hide" data-font="&#xf106;"></i>
</div>
