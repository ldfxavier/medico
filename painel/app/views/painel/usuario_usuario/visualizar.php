<?php
	$equipe = $_SESSION['EQUIPE'];
	$permissao = $equipe->permissao->lista;
	$desenvolvedor = $equipe->desenvolvedor == 1 ? true : false;
	$pre_visualizacao = isset($_pre_visualizacao) ? true : false;
	$r = $_dado;
	$cod = $r->cod;
?>
<div class="app_geral_visualizar">
	<?php if(!$pre_visualizacao): ?>
    <header class="header_principal volta header_principal_animacao header_principal_absolute">
		<a class="voltar" href="{{PAINEL}}/app/{{$_app}}"></a>
        <h1>VISUALIZAR</h1>
		<?php if($desenvolvedor || in_array(Permissao::nome($_app).'_editar', $permissao)): ?>
		<a class="editar" href="{{PAINEL}}/editar/{{$_app}}/{{$r->cod}}" data-ajuda="Editar dados"></a>
		<?php endif; ?>
    </header>
	<div class="header_principal_false"></div>
	<?php endif; ?>

	<div class="center">

		<div class="dados_direita">
			<article class="bloco">
				<header><h1>DADOS PESSOAIS</h1></header>
				<p><span class="bold">Nome:</span> <?php echo P::filtro($r->nome->valor, 'Sem nome') ?></p>
				<p><span class="bold">CPF:</span> <?php echo P::filtro($r->cpf->br, 'Sem documento') ?></p>

				<p><span class="bold">E-mail:</span> <?php echo $r->email ?></p>
                <?php if(isset($r->telefone->fixo) && !empty($r->telefone->fixo->br) ): ?>
                <p><span class="bold">Telefone:</span> <?php echo P::filtro($r->telefone->fixo->br, 'Sem telefone') ?></p>
                <?php endif; ?>

                <?php if(isset($r->telefone->celular) && !empty($r->telefone->celular->br) ): ?>
				<p><span class="bold">Telefone celular:</span> <?php echo P::filtro($r->telefone->celular->br, 'Sem Telefone celular') ?></p>
                <?php endif; ?>
			</article>



            <?php if(isset($r->endereco) && !empty($r->endereco)): ?>
			<article class="bloco">
				<header><h1>ENDEREÇO</h1></header>
                <?php if(isset($r->endereco->cep->br) && !empty($r->endereco->cep->br)): ?>
				<p><span class="bold">CEP:</span> <?php echo $r->endereco->cep->br ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->logradouro) && !empty($r->endereco->logradouro)): ?>
				<p><span class="bold">Logradouro:</span> <?php echo $r->endereco->logradouro ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->numero) && !empty($r->endereco->numero)): ?>
				<p><span class="bold">Número:</span> <?php echo $r->endereco->numero ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->complemento) && !empty($r->endereco->complemento)): ?>
				<p><span class="bold">Complemento:</span> <?php echo $r->endereco->complemento ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->bairro) && !empty($r->endereco->bairro)): ?>
				<p><span class="bold">Bairro:</span> <?php echo $r->endereco->bairro ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->cidade) && !empty($r->endereco->cidade)): ?>
				<p><span class="bold">Cidade:</span> <?php echo $r->endereco->cidade ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->estado) && !empty($r->endereco->estado)): ?>
				<p><span class="bold">Estado:</span> <?php echo $r->endereco->estado ?></p>
                <?php endif; ?>
                <?php if(isset($r->endereco->referencia) && !empty($r->endereco->referencia)): ?>
				<p><span class="bold">Referência:</span> <?php echo $r->endereco->referencia ?></p>
                <?php endif; ?>
			</article>
            <?php endif; ?>



			<article class="bloco">
				<header><h1>STATUS</h1></header>
				<p class="status_texto"><span class="bold">Status:</span> <span><?php echo $r->status->texto ?></span></p>
			</article>
		</div>
	</div>

</div>