<div class="app_geral_add">
    <header class="header_principal volta">
		<a class="voltar" href="{{PAINEL}}/app/{{$_app}}/{{$_dado->cod}}"></a>
        <h1>EDITAR</h1>
		<button id="but_add_geral" data-historico="2"><i data-font="&#xf0ee;"></i><span>ATUALIZAR</span></button>
    </header>

	<form class="form_geral" id="form_geral" action="{{PAINEL}}/post-salvar" method="post">
		<?php include('form.php') ?>
	</form>
</div>
