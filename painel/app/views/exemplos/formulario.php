
<form action="/" method="post">
    <fieldset>
        {{Form::legend('Nome do Formulário')}}

        {{Form::label('Input:')}}
        {{Form::input('nome')}}

        {{Form::label('CPF:')}}
        {{Form::cpf('cpf')}}

        {{Form::label('CNPJ:')}}
        {{Form::cnpj('cnpj')}}

        {{Form::label('Documento:')}}
        {{Form::documento('documento')}}

        {{Form::label('E-mail:')}}
        {{Form::email('email')}}

        {{Form::label('Número:')}}
        {{Form::numero('numero')}}

        {{Form::label('Data:')}}
        {{Form::data('data')}}

        {{Form::label('Data e hora:')}}
        {{Form::datahora('datahora')}}

        {{Form::label('Calendário:')}}
        {{Form::data('calendariodata', null, array('data-calendario' => 'data'))}}

        {{Form::label('Calendario e Hora:')}}
        {{Form::datahora('calendariohora', null, array('data-calendario' => 'datahora'))}}

        {{Form::label('Calendário de:')}}
        {{Form::data('calendariodata', null, array('id' => 'calendario_inicio'))}}
        {{Form::label('Calendário até:')}}
        {{Form::data('calendariodata', null, array('id' => 'calendario_final'))}}
        {{Form::label('Calendário período:')}}
        {{Form::data('calendariodata', null, array('id' => 'calendario_periodo'))}}

        {{Form::label('CEP:')}}
        {{Form::cep('cep')}}

        {{Form::label('Telefone:')}}
        {{Form::telefone('telefone')}}

        {{Form::label('Celular:')}}
        {{Form::celular('celular')}}

        {{Form::label('Dinheiro:')}}
        {{Form::dinheiro('dinheiro')}}

        {{Form::label('Selecione sua área:')}}
        {{Form::select('uf', array(0 => '01', 1 => '02'))}}

        {{Form::label('Digite seu site:')}}
        {{Form::url('url')}}

        {{Form::label('Textarea:')}}
        {{Form::textarea('datahora')}}

        {{Form::label('Escolha uma opção:')}}
        {{Form::radio('escolha', array(1 => 'Opção 01', 2 => 'Opção 02'), 2)}}

        {{Form::label('Marque as opções:')}}
        {{Form::checkbox('tv', 'TV', 'TV')}}
        {{Form::checkbox('radio', 'TV', 'Rádio')}}
        {{Form::checkbox('internet', 'TV', 'Internet')}}

        {{Form::booleano('booleano', 'Status:', 1)}}
        {{Form::booleano('booleano_2', 'Administrador:', 2)}}

        {{Form::label('Digite seu password:')}}
        {{Form::password('password')}}

        {{Form::label('Digite seu password 2:')}}
        {{Form::password_completo(array('password_completo', 'password_completo_2'))}}

        <div class="editor">
            <textarea name="editor" class="textarea_editor"></textarea>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
$.calendario({
    id:'#calendario_inicio',
    minimo:'<?php echo date('d/m/Y') ?>'
});
$.calendario({
    id:'#calendario_final',
    minimo:'#calendario_inicio'
});
$.calendario({
    id:'#calendario_periodo',
    minimo:'#calendario_inicio',
    maximo:'#calendario_final'
});
</script>

<style media="screen">
.editor {
    width: 100%;
    float: left;
    margin-top: 20px;
}
form {
    width: calc(100% - 40px);
    max-width: 600px;
    margin: 30px auto;
    display: table;
}
form label {
    width: 100%;
    float: left;
    margin: 10px 0 3px 0;
    font-size: 1.4em;
}
form fieldset {
    border: 1px solid #CCC;
    border-radius: 3px;
    padding: 0 10px 10px 10px;
}
form legend {
    font-size: 1.6em;
    font-weight: bold;
    padding: 0 5px;
}
form select {
    width: 100%;
    height: 40px;
    border: 1px solid #CCC;
    background: url(../images/select.png) no-repeat center right;
    padding-left: 10px;
    font-size: 1.4em;
}
form input[type=date],
form input[type=datetime],
form input[type=time],
form input[type=tel],
form input[type=text],
form input[type=email],
form input[type=number],
form input[type=password] {
    width: 100%;
    height: 40px;
    float: left;
    border: 1px solid #CCC;
    padding: 0 10px;
    font-size: 1.4em;
}

form textarea {
    width: 100%;
    height: 120px;
    float: left;
    padding: 10px;
    font-size: 1.4em;
    border: 1px solid #CCC;
}

form .input_booleano_geral {
    float: left;
    margin-top: 20px;
    cursor: pointer;
    clear: both;
}
form .input_booleano_geral .booleano_titulo {
    height: 30px;
    line-height: 30px;
    float: left;
    font-size: 1.4em;
}
form .input_booleano_geral .booleano_botao {
    width: 60px;
    height: 16px;
    float: left;
    margin: 8px 0 0 20px;
    border-radius: 10px;
}
form .input_booleano_geral.ativo .booleano_botao {
    background-color: rgba(0,80,200,.5);
}
form .input_booleano_geral.inativo .booleano_botao {
    background-color: #CCC;
}
form .input_booleano_geral .booleano_botao .booleano_bola {
    width: 30px;
    height: 30px;
    border-radius: 100%;
    box-shadow: 0 0 4px #CCC;
    margin-top: -7.5px;
}
form .input_booleano_geral.ativo .booleano_botao .booleano_bola {
    float: right;
    background-color: rgb(0,80,200);
}
form .input_booleano_geral.inativo .booleano_botao .booleano_bola {
    float: left;
    background-color: #FFF;
}

form .input_url_geral {
    width: 100%;
    float: left;
}
form .input_url_geral select {
    width: 100px;
    float: left;
    background-color: rgb(0,80,200);
    color: #FFF;
}
form .input_url_geral input {
    width: calc(100% - 100px);
    height: 40px;
    float: left;
    border: 1px solid #CCC;
    border-left: none;
    font-size: 1.4em;
    padding: 0 10px;
}

form .input_documento_geral {
    width: 100%;
    float: left;
}
form .input_documento_geral select {
    width: 100px;
    float: left;
    background-color: rgb(0,80,200);
    color: #FFF;
}
form .input_documento_geral input {
    width: calc(100% - 100px);
    height: 40px;
    float: left;
    border: 1px solid #CCC;
    border-left: none;
}

form label[type=radio] {
    width: auto;
    margin: 0;
    line-height: 20px;
    margin-right: 30px;
    cursor: pointer;
}
form input[type=radio] {
    width: 13px;
    height: 13px;
    float: left;
    margin-right: 7px;
    background-color: #EEE;
    border: 1px solid #CCC;
    border-radius: 100%;
    cursor: pointer;
}
form input[type=radio]:checked {
    background-color: rgb(0,80,200);
}

form label[type=checkbox] {
    width: auto;
    margin: 0;
    line-height: 20px;
    margin-right: 30px;
    cursor: pointer;
}
form input[type=checkbox] {
    width: 13px;
    height: 13px;
    float: left;
    margin-right: 7px;
    background-color: #EEE;
    border: 1px solid #CCC;
    border-radius: 2px;
    cursor: pointer;
}
form input[type=checkbox]:checked {
    background-color: rgb(0,80,200);
}

form .input_password_geral {
    width: 100%;
    float: left;
}
form .input_password_geral .bloco_password {
    width: calc(50% - 10px);
    position: relative;
    float: left;
}
form .input_password_geral .bloco_password:nth-child(even){
    float: right;
}
form .input_password_geral .bloco_password .bloco_verificar {
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    position: absolute;
    font-size: 1.2em;
    color: #FFF;
    top: 0;
    right: 0;
}
form .input_password_geral .bloco_password .bloco_verificar.correto {
    background-color: rgb(0,200,80);
}
form .input_password_geral .bloco_password .bloco_verificar.incorreto {
    background-color: rgb(200,10,0);
}
form .input_password_geral .bloco_password .but_password_visualizar {
    width: 40px;
    height: 40px;
    line-height: 40px;
    position: absolute;
    top: 0;
    right: 0;
    font-size: 1.4em;
    color: #FFF;
    text-align: center;
    background-color: rgb(0,80,200);
    z-index: 2;
    cursor: pointer;
}
</style>
