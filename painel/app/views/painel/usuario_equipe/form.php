<?php
	$r = isset($_dado) ? $_dado : '';
	$equipe = $_SESSION['EQUIPE'];

	if(isset($r->cod)) $cod = $r->cod;
	else $cod = md5(uniqid(time()));
?>

<script type="text/javascript" src="{{LINK}}/app/views/painel/{{$_app}}/scripts/all.js"></script>

<input type="hidden" id="form_app_geral" value="{{$_app}}">
<input type="hidden" id="form_volta_geral" value="{{PAINEL}}/visualizar/{{$_app}}/{{$cod}}">

<input type="hidden" name="desenvolvedor" value="2">

<input type="text" class="input_zero" value="">
<input type="password" class="input_zero" value="">
<?php if(isset($r->id)): ?>
<input type="hidden" name="id" value="{{$r->id}}">
<?php endif; ?>
<input type="hidden" name="cod" value="{{$cod}}">
<input type="hidden" name="empresa" value="1">

<div class="linha">
	<fieldset>
		<div class="legenda">DADOS PESSOAIS</div>
		<label>Nome:</label>
		<input type="text" name="nome" value="{{P::r($r, 'nome->valor')}}" placeholder="Digite um nome">

		<label>CPF:</label>
		{{Form::cpf('documento', P::r($r, 'documento->br'))}}

		<label>Data de nascimento:</label>
		<?php
			$valor = isset($r->aniversario->br) ? $r->aniversario->br : '';
			echo Form::data('aniversario', P::r($r, 'aniversario->br'), null, true);
		?>

	</fieldset>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">ACESSO</div>
		<label>Login:</label>
		<?php $valor = isset($r->login) ? $r->login : '' ?>
		<input type="email" name="login" value="{{P::r($r, 'login')}}" placeholder="Digite um e-mail">

		<label>Senha:</label>
		{{Form::password_completo(array('salt'), array('placeholder' => 'Digite uma senha'))}}
	</fieldset>
	<fieldset>
		<div class="legenda">CONTATO</div>
		{{Form::contato($_app, $cod, P::r($r, 'contato'))}}
	</fieldset>
</div>

<div class="linha">
	<fieldset>
		<div class="legenda">STATUS</div>
		{{Form::booleano('gerente', 'Gerente?', P::r($r, 'gerente', false), array('data-admin' => true))}}
		{{Form::booleano('admin', 'Administrador?', P::r($r, 'admin', false), array('data-admin' => true, 'data-admintipo' => 2))}}
		{{Form::booleano('mudar_senha', 'Mudar senha?', P::r($r, 'mudar_senha', false), array('data-admin' => true))}}
		{{Form::booleano('status', 'Status:', P::r($r, 'status->valor', false))}}
	</fieldset>
	<fieldset>
		<div class="legenda">ENDEREÇO</div>
		{{Form::endereco($_app, $cod, P::r($r, 'endereco'))}}
	</fieldset>
</div>

<div class="linha_grande">	
	<fieldset class="bloco_checkbox_todos" id="bloco_equipe_permissao">	
		<div class="legenda">PERMISSÕES</div>	

		<div class="checkbox">	
			<?php	
				$marca_todos = (isset($r->permissao->lista) && count(Permissao::lista(true)) == count($r->permissao->lista)) ? true : false;	
			?>	
			{{Form::checkbox('', '', 'Marcar/Desmarca todos', $marca_todos, array('data-name' => 'todos'))}}	
		</div>	

		<?php	
			foreach(Permissao::lista() as $permissao_r):	
				if(isset($permissao_r->lista)):	
		?>	
		<div class="bloco_linha">	
			<div class="texto bold"><?php echo $permissao_r->titulo ?></div>	
			<div class="checkbox">	
				<?php	
					foreach($permissao_r->lista as $per_valor => $per_titulo):	
						$permissao_valor = (isset($r->permissao->lista) && in_array($per_valor, $r->permissao->lista)) ? true : false;	
						echo Form::checkbox('permissao', $per_valor, $per_titulo, $permissao_valor, array('data-valor' => $per_valor));	
					endforeach;	
				?>	
			</div>	
		</div>	
		<?php	
				endif;	
			endforeach;	
		?>	
	</fieldset>	
</div>