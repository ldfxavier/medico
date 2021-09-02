<h1>JAVASCRIPT</h1>
<div class="margin_20"></div>
<p>Regras para utilização do javascript, na criação de funções, classes, métodos e afins.</p>

<ul>
	<li>Sempre deve ser dado preferência para criação de classes e funções;</li>
	<li>Sempre usar o <b>let</b> para criação de variáveis;</li>
	<li>Usar o padrão CamelCase;</li>
	<li>Criar um arquivo js para cada página;</li>
	<li>Usar "_" para declarar propriedades e métodos privados;</li>
	<li>Usar e para declarar um event em uma função;</li>
	<li>Usar o self quando for colocar o this em uma variável;</li>
	<li>Classes devem começar com a primeira letra Maiscula;</li>
	<li>Sempre que declarar uma classe deve criar a variável com a primeira letra Maiuscula;</li>
	<li>Usar os métodos mágicos get e set para declarar e pegar dados das propriedades;</li>
	<li>Cada classe deve ficar em um arquivo separado contendo apenas a classe;</li>
	<li>Arquivos de classes devem começar com a letra maiuscula de terminar com .class.js</li>
	<li>Cada método deve fazer apenas 1 coisa;</li>
	<li>Cada método deve tentar ter no máximo 20 linhas;</li>
</ul>

<h3>Exemplo:</h3>
<p>Classe OlaMundo</p>
<pre>
class OlaMundo {
	constructor(){
		this._mensagem;
	}

	criarMensagem(){
		this._mensagem = 'Olá Mundo!';
	}

	get mensagem(){
		return this._mensagem;
	}
}
</pre>
<p>Usando a classe</p>
<pre>
let Ola = new Ola();
Ola.criarMensagem();
console.log(Ola.mensagem);
</pre>

<div class="margin_40"></div>
<h2>ESTRUTURA</h2>
<p>A estrutura do JS deve ficar dentro do diretório <b>js/dev</b>, dentro dele irá ter 3 diretórios:</p>
<ul>
	<li><strong>geral:</strong> Onde fica os scripts padrões;</li>
	<li><strong>painel:</strong> O JS para o painel;</li>
	<li><strong>site:</strong> O JS para o site;</li>
</ul>

<p>No diretório site e painel, terá 1 diretório e 2 arquivos:</p>
<ul>
	<li><strong>pagina:</strong> Diretório onde deve ficar os arquivos de cada página;</li>
	<li><strong>padrao.js:</strong> Arquivo padrão que deve ficar o js padrão do site;</li>
	<li><strong>include.json:</strong> Arquivo com lista de includes para o arquivo padrao.js;</li>
</ul>
<p>O padrão para o diretório painel é o mesmo do diretório site.</p>
<p>O arquivo include.json vai concatenar os js de acordo com a ordem que eles forem declarados.</p>

<h3>Exemplo:</h3>
<pre>
[
	"js/dev/geral/jquery.js",
	"js/dev/geral/Pagina.class.js",
]
</pre>

<p>Para colocar um arquivo no diretório pagina, basta colocar o mesmo nome do controller e action separado por "_", para usar o mesmo arquivo em 2 páginas, separa o nome por "-".</p>

<h3>Exemplo:</h3>
<div class="exemplo">
	produto_index.js<br>
	pagamento_index-pagamento_status.js
</div>

<div class="margin_40"></div>
<h2>LOADING</h2>
<p>Para gerar o loading da página deve usar a class Loading.</p>

<h3>Exemplo:</h3>
<p>Abrir o loading:</p>
<pre>
Loading.show();
</pre>
<p>Fechar o loading:</p>
<pre>
Loading.hide();
</pre>
<div class="executar">
	<button id="botao_pagina">Executar</button>
<script>
$('#botao_pagina').click(function(){
	Loading.show();
	$('body').append('<div id="bloco_mensagem_js"><span>LOADING IRÁ FECHAR EM 5 SEGUNDOS</span></div>');
	setTimeout(() => {
		$('#bloco_mensagem_js').remove();
		Loading.hide();
	}, 5000);
});
</script>

<style>
#bloco_mensagem_js {
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;
	left: 0;
	z-index: 100;
	display: flex;
	justify-content: center;
    align-items: center;
}
#bloco_mensagem_js span {
	padding: 10px;
	border-radius: 5px;
	background-color: #FFF;
	box-shadow: 0 0 5px #000;
	font-size: 14px;
}
</style>

</div>