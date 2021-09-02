<h1>CSS</h1>
<div class="margin_20"></div>
<p>Regras para estruturação do CSS.</p>

<ul>
	<li>Deve seguir a mesma ordem da estrutura do HTML;</li>
	<li>Deve começar com os imports, tags, classes, blocos e por último, as animações;</li>
	<li>Deve criar o site como responsive first;</li>
	<li>O responsivo deve ficar no final de cada bloco principal;</li>
	<li>Cada página deve ser feita em um arquivo separado;</li>
	<li>Deve declarar as tag principais antes das classes (form.formulario_contato);</li>
	<li>Pode dar até 1 tab no css principal e 2 no responsivo;</li>
	<li>Sempre voltar para o início da indentação em cada bloco;</li>
	<li>Usar stylus como pre procesador;</li>
	<li>Não usar os caracteres "{", "}" e ";";</li>
	<li>Usar em para declarar tamanho da fonte;</li>
</ul>

<h3>Exemplo:</h3>
<pre>
#bloco__produto--mais-novo
	width: 100%
	header
		font-size: 2.4em
#bloco__produto--mais-novo .bloco_banner
	width: 100%
	height: 400px
	figure
		width: 100%
		height: 100%
		position: absolute
#bloco__poduto--mais-novo .bloco_produto
	width: 100%
	article
		col(2)

@media screen and (max-width:1060px)
	#bloco__produto--mais-novo
		padding: 0 20px
	#bloco__poduto--mais-novo .bloco_produto
		article
			col(1)
</pre>

<div class="margin_40"></div>
<h2>ESTRUTURA</h2>
<p>A estrutura do CSS deve ficar dentro do diretório <b>css/dev</b>, dentro dele irá ter 3 diretórios:</p>
<ul>
	<li><strong>geral:</strong> Onde fica os scripts padrões;</li>
	<li><strong>painel:</strong> O CSS para o painel;</li>
	<li><strong>site:</strong> O CSS para o site;</li>
</ul>

<p>No diretório site e painel, terá 1 diretório e 1 arquivo:</p>
<ul>
	<li><strong>pagina:</strong> Diretório onde deve ficar os arquivos de cada página;</li>
	<li><strong>padrao.styl:</strong> Arquivo padrão que deve ficar o css padrão do site;</li>
</ul>
<p>O padrão para o diretório painel é o mesmo do diretório site.</p>

<p>Para colocar um arquivo no diretório pagina, basta colocar o mesmo nome do controller e action separado por "_", para usar o mesmo arquivo em 2 páginas, separa o nome por "-".</p>

<h3>Exemplo:</h3>
<div class="exemplo">
	produto_index.styl<br>
	pagamento_index-pagamento_status.styl
</div>
