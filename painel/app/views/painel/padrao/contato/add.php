<?php
	$r = isset($_dado) ? $_dado : '';

	if($_acao == 'editar'):
		$tipo = $r->tipo->valor;
		$cod = $r->cod;
	else:
		$tipo = 1;
		$cod = $_cod;
	endif;
?>
<header class="geral">
	<h1>CONTATO</h1>
	<i class="fechar"></i>
</header>

<div class="dados">
	<?php if(isset($r->id)): ?>
	<input type="hidden" name="id" value="{{$r->id}}">
	<?php endif; ?>
	<input type="hidden" name="cod" value="{{$cod}}">
	<input type="hidden" name="app" value="{{$_app}}">
	<input type="hidden" name="bloco" value="{{$_bloco}}">
	<input type="hidden" name="local" value="{{$_local}}">

	<input type="text" name="contato" value="{{P::r($r, 'contato')}}" placeholder="Nome do contato">

	{{Form::cpf('documento', P::r($r, 'documento->br'))}}

	<?php
		echo Form::select('tipo', array(
			1 => 'Telefone',
			2 => 'E-mail'
		), P::r($r, 'tipo->valor'), array(
			'id' => 'input_contato_tipo'
		));
	?>

	<?php
		$nome = P::r($r, 'nome->valor');
		$valor = ($tipo == 1) ? P::r($r, 'nome->valor') : '';
		echo Form::select('nome_telefone', array(
			1 => 'Celular',
			2 => 'Comercial',
			3 => 'Residencial',
			10 => 'Whatsapp',
			4 => 'Fax',
			5 => '0800',
			6 => 'Outro'
		), $valor, array(
			'id' => 'input_contato_nome_telefone',
			'class' => ($tipo == 1 && $nome != 6) ? '' : 'hide'
		));
	?>

	<?php
		$valor = ($tipo == 2) ? P::r($r, 'nome->valor') : '';
		echo Form::select('nome_email', array(
			7 => 'Profissional',
			8 => 'Pessoal',
			9 => 'Funcional',
			6 => 'Outro'
		), $valor, array(
			'id' => 'input_contato_nome_email',
			'class' => ($tipo == 2 && $nome != 6) ? '' : 'hide'
		));
	?>

	<div class="outro <?php echo ($nome != 6) ? 'hide' : '' ?>">
		<span></span>
		<input type="text" name="outro" value="{{P::r($r, 'nome->outro')}}" placeholder="Nome">
	</div>

	<?php $valor = ($tipo == 1) ? P::r($r, 'valor->texto') : '' ?>
	<input class="<?php echo $tipo == 1 ? '' : 'hide' ?>" data-mascara="celular" type="tel" name="valor_telefone" placeholder="Digite o telefone" value="<?php echo $valor ?>" id="input_contato_valor_telefone">

	<?php $valor = ($tipo == 2) ? P::r($r, 'valor->texto') : '' ?>
	<input class="<?php echo $tipo == 2 ? '' : 'hide' ?>" type="email" name="valor_email" placeholder="Digite o e-mail" value="<?php echo $valor ?>" id="input_contato_valor_email">

	<?php
		echo Form::select('operadora', array(
			'' => 'SEM',
			1 => 'OI',
			2 => 'TIM',
			3 => 'CLARO',
			4 => 'VIVO',
			5 => 'NEXTEL',
			6 => 'NET',
			7 => 'EMBRATEL',
		), P::r($r, 'operadora->valor'), array(
			'id' => 'input_contato_operadora',
			'class' => $tipo == 1 ? '' : 'hide'
		));
	?>

	{{Form::booleano('destaque', 'Colocar como destaque?', P::r($r, 'destaque'))}}
</div>

<footer class="geral_botao">
	<?php if($_acao == 'editar'): ?>
	<div class="botao" id="but_contato_deletar">DELETAR</div>
	<?php endif; ?>
	<button class="botao" id="but_contato_salvar">SALVAR</button>
</footer>
