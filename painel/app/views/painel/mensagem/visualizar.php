<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;
	$pre_visualizacao = isset($_pre_visualizacao) ? true : false;
	$app_voltar = $_app;
	$app_editar = '';
	if(in_array($_par, ['convenio_clube'])):
		$app_voltar = $_par;
		$app_editar = '/par/'.$_par;
	endif;

	$r = $_dado;
	$cod = $r->cod;
?>

<script src="<?= LINK; ?>/app/views/painel/<?= $_app; ?>/scripts/all.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?= LINK; ?>/app/views/painel/<?= $_app; ?>/scripts/layout.css"/>
<form>
	<input type="hidden" id="input_cod_indicacao" value="<?= $r->cod; ?>">
	<input type="hidden" id="input_status_indicacao" value="<?= $r->status->valor; ?>">
</form>
<div id="bloco_visualizar_<?= $_app; ?>" class="app_visualizar_mensagem">
    <header class="header_principal volta header_principal_animacao header_principal_absolute">
		<a class="voltar" href="<?= PAINEL; ?>/app/<?= $_app; ?>"></a>
        <h1>VISUALIZAR</h1>
    </header>
	<div class="header_principal_false"></div>

	<div class="bloco_mensagem" data-criacao="<?= $r->data->data_criacao; ?>">
		<!-- <figure></figure> -->
		<div class="conteudo_mensagem">
			<div class="data">
				<span>Criado em: <?= $r->data->criacao ?> </span>
			</div>

			<?php if(!empty($r->nome)): ?>
			<p class="linha"><span>NOME:</span> <span class="texto"><?= $r->nome; ?></span></p>
			<?php endif; ?>

			<?php if(!empty($r->telefone)): ?>
			<p class="linha"><span>TELEFONE:</span> <span class="texto"><?= $r->telefone->texto; ?></span></p>
			<?php endif; ?>

			<?php if(!empty($r->texto)): ?>
			<p class="linha"><span>MENSAGEM:</span> <span class="texto"><?= $r->texto; ?></span></p>
			<?php endif; ?>
			<div class="select but_change_atualizar" data-cod="<?= $r->cod; ?>" data-id="<?= $r->id; ?>" data-app="<?= $_app; ?>">
				<?php
				$Status = new StatusModel;
				echo Form::select('status', $Status->select('mensagem', 'status'), $r->status->valor);
				?>
			</div>
		</div>
			<?php
				$Painel = new PainelModel;
				$notificacao = '';
				$historico_add_cod = $cod;
				$historico_add_app = $_app;

				if(!isset($historico_add_cod) || !isset($historico_add_app)):
					$historico_add_cod = $r->cod;
					$historico_add_app = $_app;
				endif;

				Painel::visualizar_footer($historico_add_app, $historico_add_cod, true, null, $notificacao);
			?>
	</div>
</div>
