<h1>MYSQL</h1>
<div class="margin_20"></div>
<p>Regras para criação de bancos, tabelas e registros no banco de dados.</p>

<p>Por padrão, adotar as normas a seguir em todo o banco de dados (Bancos, tabelas e colunas):</p>
<ul>
	<li>Não usar hífen, acentos e caracteres especiais;</li>
	<li>Não é permitido abreviar os nomes;</li>
	<li>Não usar palavras reservadas como: INSERT, DELETE, SELECT e etc;</li>
	<li>A nomenclatura deve ser toda em caixa baixa; (livro no lugar de Livro)</li>
	<li>Não usar mais que 30 (trinta) caracteres;</li>
	<li>Não usar verbos;</li>
	<li>Deve usar o conceito de snake case; (nome_nome no lugar de nomeNome)</li>
	<li>Não usar preposições; (de, a, em, etc)</li>
	<li>Não utilizar palavras no plural; (livro no lugar de livros)</li>
	<li>Não usar números;</li>
	<li>Não usar nomes próprios; (André, João, etc)</li>
	<li>O nome não pode ter várias interpretações;</li>
	<li>Crie nomes sucintos e objetivos;</li>
</ul>

<div class="margin_40"></div>
<h2>BANCO</h2>

<p>O nome do banco deve ter as seguintes normas:</p>
<ul>
	<li>Deve ter referência ao négocio ao qual ele será usado.</li>
	<li>Usar a codificação utf8mb4_unicode_ci.</li>
</ul>

<h3>Exemplo:</h3>
<div class="exemplo">
	marktclub_financeiro
</div>

<div class="margin_40"></div>
<h2>TABELA</h2>
<p>O nome das tabela de ter as seguintes normas:</p>

<ul>
	<li>Deve se referir a sua área e ao seu uso.</li>
	<li>
		Deve ter os seguintes campos obrigatórios:
		<ul>
			<li>id *Int(11)* auto increment</li>
			<li>uuid *char(36)* uniqid</li>
			<li>data_criacao *datetime*</li>
			<li>data_atualizacao *datetime*</li>
			<li>status *int(1,2,3)*</li>
		</ul>
	</li>
	<li>Usar a codificação utf8mb4_unicode_ci.</li>
</ul>

<h3>Exemplo:</h3>
<div class="exemplo">
	convenio_captacao<br>
	convenio_clube<br>
	ou<br>
	mensagem_indicacao<br>
	mensagem_declaracao
</div>

<div class="margin_40"></div>
<h2>NOMES DOS CAMPOS</h2>
<p>Os nomes dos campos devem ter as seguintes normas:</p>

<ul>
	<li>Deve ser todo em caixa baixa.</li>
	<li>Não pode ser abreviado.</li>
	<li>Deve ser no singular.</li>
	<li>Deve usar o conceito de snake case.</li>
	<li>Teve ter pelo menos 1 "_" exceto os campos <b>id</b>, <b>uuid</b> e <b>status</b>.</li>
	<li>estrangeira 1:1 deve começar com <b>id_</b> e conter o nome da tabela relacionada.</li>
	<li>Toda chave estrangeira n:n deve se chamar <b>id_vinculo</b> ou um nome mais indicado em casos específicos.</li>
	<li>O tamanho máximo para o nome deve ser de 30 caracteres.</li>
	<li>Evite abreviar a não ser que o nome exceda os 30 caracteres.</li>
	<li>Para abreviar usa 3 ou 4 caracteres dependendo da melhor prática.</li>
	<li>Sempre começe abreviando do final para o começo e sempre os nomes de mais fácil leitura quando abreviado (valor_venda_produto_internacional_sem_iof para valor_venda_prod_inter_sem_iof).</li>
</ul>

<h3>Exemplo:</h3>
<div class="exemplo">
	nome_completo<br>
	telefone_celular<br>
	telefone_fixo
</div>

<div class="margin_40"></div>
<h2>TIPOS</h2>
<p>Todos os tipos devem ter a seguinte configuração:</p>

<ul>
	<li><strong>id:</strong> Int(11), auto increment, uniqid;</li>
	<li><strong>uuid:</strong> char(36), uniqid;</li>
	<li><strong>números inteiros:</strong> int({...});</li>
	<li><strong>números float:</strong> float;</li>
	<li><strong>dinheiro:</strong> decimal(10,2);</li>
	<li><strong>data:</strong> date;</li>
	<li><strong>data e hora:</strong> datetime;</li>
	<li><strong>hora:</strong> time;</li>
	<li><strong>json:</strong> json;</li>
</ul>

<div class="margin_40"></div>
<h2>NOMES PADRÕES</h2>
<p>Para não ter nomes diferentes em tabelas diferentes para o mesmo dado, seguir os padrões a seguir:</p>
<ul>
	<li><strong>Código:</strong> uuid, Type chat(36);</li>
	<li><strong>Chave extrangéira:</strong> id_{nometabela}, Type char(36);</li>
	<li><strong>Vinculo com mais de 1 tabela:</strong> id_vinculo, Type char(36);</li>
	<li><strong>Data de nascimento ou Aniversário:</strong> data_nascimento, Type date;</li>
	<li><strong>Data de criação:</strong> data_criacao ou data, Type datetime;</li>
	<li><strong>Data de atualização:</strong> data_atualizacao, Type datetime;</li>
	<li><strong>CPF:</strong> cpf, Type bigint(11) UNSIGNED ZEROFILL;</li>
	<li><strong>CNPJ:</strong> cnpj, Type bigint(14) UNSIGNED ZEROFILL;</li>
	<li><strong>E-mails:</strong> email{_pessoal}, Type varchar(70);</li>
	<li><strong>Telefone:</strong> telefone{_celular}, Type Bigint(11);</li>
	<li><strong>Razão Social:</strong> razao_social, Type varchar(100);</li>
	<li><strong>Nome fantasia:</strong> nome_fantasia, Type varchar(50);</li>
	<li><strong>Status:</strong> status, Type int({2,3});</li>
</ul>

<div class="margin_40"></div>
<h2>PADRÃO DE COMENTÁRIO</h2>
<p>Utilizar o comentário para fazer validação direto do model ou determinar quem vai ser liberado para fazer download nos relatórios.</p>
<p>Para validar, basta passar o valor validar dentro de chavez e qual validação.</p>

<h3>Exemplo:</h3>
<div class="exemplo">
	<span>{validar,<b>email,cpf,cnpj,cep,celular,telefone</b>}</span>
</div>
<div class="margin_10"></div>
<p>Os campos marcados como type <b>int, bitint, float, decimal, date, detetime, time, json</b> são validados automaticamente.</p>

<p>Para marcar que uma coluna pode ser feito download nos relatórios, colocar o valor download dentro de chavez.</p>

<h3>Exemplo:</h3>
<div class="exemplo">
	<span>{<b>download</b>}</span>
</div>
<div class="margin_10"></div>

<p>Para colocar um nome na coluna, coloque o valor dentro de cochetes.</p>
<h3>Exemplo:</h3>
<div class="exemplo">
	<span>[<b>Título do campo</b>]</span>
</div>
<div class="margin_10"></div>