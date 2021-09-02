<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>README</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
</head>
<body>

<main>
    <header>README</header>

    <h1>FRAMEWORK FWMKT v1.0.1</h1>
    <hr>

    <p>Framework MVC desenvolvido por André Rodrigues (andrerodrigues.com) e utilizado é mantido pela empresa MARKT TEC TECNOLOGIA DA INFORMAÇÃO LTDA ME.</p>

    <h2>Organização</h2>
    <hr>
    <p>Organização dos diretórios do FRAMEWORK.</p>
    <ul>
        <li><span>.config</span> <span>Pasta de configuração do site</span></li>
        <li>
            <ul>
                <li><span>app</span> <span>Aplicações do site</span></li>
                <li><span>app/controllers</span> <span>Controllers do site ("páginas")</span></li>
                <li><span>app/templates</span> <span>Templates padrões do site</span></li>
                <li><span>app/models</span> <span>Models do site ("Banco de dados")</span></li>
                <li><span>app/views</span> <span>Views do site em produção ("HTML")</span></li>
                <li><span>app/views/dev</span> <span>Views do site em QA ("HTML")</span></li>
            </ul>
        </li>
        <li><span>arquivos</span> <span>Diretório dos arquivos enviado via painel</span></li>
        <li>
            <ul>
                <li><span>css</span> <span>Arquivos CSS do site</span></li>
                <li><span>css/dev</span> <span>Arquivos de desenvolvimento</span></li>
            </ul>
        </li>
        <li>
            <ul>
                <li><span>images</span> <span>Imagens do site</span></li>
                <li><span>images/email</span> <span>Imagens dos arquivos de e-mail automático do sistema</span></li>
                <li><span>images/ext</span> <span>Icones com extensões</span></li>
                <li><span>images/painel</span> <span>Imagens do painel</span></li>
            </ul>
        </li>
        <li>
            <ul>
                <li><span>js</span> <span>Arquivos JS do site</span></li>
                <li><span>js/dev</span> <span>Arquivos de desenvolvimento</span></li>
            </ul>
        </li>
        <li>
            <ul>
                <li><span>system</span> <span>Arquivos do sistema</span></li>
                <li><span>system/helpers</span> <span>Classes de ajuda</span></li>
            </ul>
        </li>
    </ul>

    <h1>Arquivos de configuração</h1>
    <hr>
    <p>Para configurar o site, deverá ser configurado os arquivos de produção e QA, para isso, acesse os seguintes arquivos:</p>
    <ul>
        <li><span>.config/producao.php</span> <span>Arquivo principal de configuração do site</span></li>
        <li><span>.config/qa.php</span> <span>Alterações do arquivo de produção para quando está em QA</span></li>
    </ul>

    <p class="m">Alterações do head do site:</p>
    <code>
<pre>
$header = [
    'titulo' => 'SITE PADRÃO', <span>// Título do site</span>
    'descricao' => 'Descrição do site aqui', <span>// Description do site</span>
    'imagem' => '{{LINK}}/images/social.png', <span>// Imagem padrão para redes sociais</span>
    'robots' => 'index, follow', <span>// robots do site</span>
    'keywords' => 'tag1, tag2, tag3, tag4, tag5', <span>// keywords do site</span>
    'viewport' => true, <span>// Viewport do site</span>
    'charset' => 'utf-8' <span>// Charset do site</span>
];
</pre>
    </code>

    <p class="m">Alterações das configurações gerais do site:</p>
    <code>
<pre>
$config = [
	'erro' => false, <span>// true | false - Liberar ou cancela o display_erros do PHP respectivamente</span>
	'fuso' => 'America/Sao_Paulo', <span>// Fuso horário</span>
	'https' => 'auto', <span>// true | false | auto - redireciona para https, http ou auto respectivamente</span>
	'www' => 'auto', <span>// true | false | auto - redireciona para versão com www, sem ww ou auto respectivamente</span>
	'emailsistema' => '' <span>// E-mail padrão do sistema</span>
];
</pre>
    </code>

    <p class="m">Logo e favicon do site:</p>
    <code>
<pre>
$imagem = [
    'logo' => '{{LINK}}/images/logo.png', <span>// Logo do site</span>
    'favicon' => '{{LINK}}/images/favicon.png' <span>// Favicon do site</span>
];
</pre>
    </code>

    <p class="m">Links do sistema:</p>
    <code>
<pre>
$link = [
    'link' => ['dominio.com.br', 'www.dominio.com.br'], <span>// Array ou string com o link do site</span>
    'painel' => '{{LINK}}/painel', <span>// Link do painel</span>
    'arquivo' => '{{LINK}}/arquivos', <span>// Link dos arquivos</span>
    'diretorio' => 'arquivos' <span>// Diretório onde fica os arquivos</span>
];
</pre>
    </code>

    <p class="m">Conexão ao Banco de dados:</p>
    <code>
<pre>
$pdo = [
    'host' => null, <span>// Host do bando de dados</span>
    'banco' => null, <span>// Nome do banco de dados</span>
    'usuario' => null, <span>// Usuário do banco de dados</span>
    'senha' => null <span>// Senha do banco de dados</span>
];
</pre>
    </code>

    <p class="m">APIs do Google:</p>
    <code>
<pre>
$google = [
    'analytics' => true, <span>// ID do Google Analytics</span>
    'client_id' => null, <span>// ID do cliente</span>
    'client_key' => null <span>// Key do cliente</span>
];
</pre>
    </code>

    <p class="m">APIs do Facebook:</p>
    <code>
<pre>
$facebook = [
    'key' => null <span>// Chave da API</span>
];
</pre>
    </code>

    <p class="m">Links das redes sociais (adicionar ao array):</p>
    <code>
<pre>$social = [
    'rede_social' => 'https://link.com'
];</pre>
    </code>

    <p class="m">Adicionar outros valores opcionais:</p>
    <code>
<pre>
$opcionais = [
    'campo' => 'valor'
];
</pre>
    </code>

    <p>Os campos com <b>{{LINK}}</b> subistituem essa string pelo dominio do projeto.</p>

    <h2>Defines do sistema</h2>
    <hr>
    <p>O sistema cria alguns defines padrões que são informados nos arquivos de configuração acima que são:</p>
    <ul>
        <li><span>CACHE</span> <span>Hash para ser usado como cache criada com a hash do commit do GIT</span></li>
        <li><span>TITULO</span> <span>Título do site</span></li>
        <li><span>DESCRICAO</span> <span>Descição do site</span></li>
        <li><span>IMAGEMSOCIAL</span> <span>Imagem padrão para rede social</span></li>
        <li><span>ROBOTS</span> <span>ROBOTS para o header</span></li>
        <li><span>KEYWORDS</span> <span>Palavras chave para a metatag keywords</span></li>
        <li><span>VIEWPORT</span> <span>Se irá usar o viewport ou não</span></li>
        <li><span>CHARSET</span> <span>Charset do site</span></li>
        <li><span>EMAILSISTEMA</span> <span>Um e-mail padrão para ser usado pelo sistema</span></li>
        <li><span>HASH</span> <span>Hash criar a cada sessão do usuário</span></li>
        <li><span>LINK</span> <span>Dominio do site com o protocolo</span></li>
        <li><span>URL</span> <span>Link completo com protocolo e URL</span></li>
        <li><span>PAINEL</span> <span>Dominio do painel</span></li>
        <li><span>ARQUIVO</span> <span>Dominio das imagens</span></li>
        <li><span>DIRETORIO</span> <span>Diretório onde é salvo as imagens</span></li>
        <li><span>PDOHOST</span> <span>Host do banco de dados</span></li>
        <li><span>PDOBANCO</span> <span>Nome do banco de dados</span></li>
        <li><span>PDOUSUARIO</span> <span>Usuário do banco de dados</span></li>
        <li><span>PDOSENHA</span> <span>Senha do banco de dados</span></li>
        <li><span>GOOGLEANALYTICS</span> <span>ID do Google Analytics</span></li>
        <li><span>GOOGLECLIENTKEY</span> <span>Chave do usuário da Google</span></li>
        <li><span>GOOGLECLIENTID</span> <span>Id do usuário da Google</span></li>
        <li><span>FACEBOOKKEY</span> <span>Chave da API do Facebook</span></li>
        <li><span>SISTEMA</span> <span>Se o sistema está em produção ou QA*</span></li>
    </ul>
    <p>Todos os valores passados nos arrays de configuração <b>"$imagem"</b>, <b>"$social"</b> e <b>"$opcionais"</b> serão convertidos em defines usando o padrão de caixa alta.</p>
    <p>* O sistema sabe se está em produção ou QA verificando o domínio atual com os passados nos arquivos de configuração.</p>

    <h2>Automatização do Framework</h2>
    <hr>
    <p>As principais tarefas do Framework como o compilador do Stylus, minify entre outros são feitas de forma automática usando o Grunt, para isso, deve ser instalado o Grunt e o Node.js.</p>
    <p>Primeiro, deve-se instalar o Node.js, para máquinas <b>Windows</b> e <b>MAC</b>, <a href="https://nodejs.org/en/download/" target="_blank">clique aqui</a> e escolha uma opção de download.</p>

    <p class="m">Para usuário <b>Linux</b>, instale pelo terminal:</p>
    <code>
        sudo apt-get install nodejs-legacy npm<br>
    </code>

    <p class="m">Após a instalação do Node.js, instale o Grunt via npm pelo terminal:</p>
    <code>
        sudo npm install -g grunt-cli
    </code>

    <p class="m">Por fim, para baixar as dependencias necessárias, entre no diretório do projeto e execute no terminal o seguinte comando:</p>
    <code>
        sudo npm install
    </code>

    <p> Para mais informações sobre o Grunt, <a href="https://gruntjs.com/" target="_blank">clique aqui</a>.</p>

    <h3>Comando para automatização:</h3>
    <p>Para torna o desenvolvimento mais rápido, execute os seguintes comandos:</p>

    <ul>
        <li><span>grunt clean</span> <span>Limpa arquivos temporários criados pelo MAC</span></li>
        <li><span>grunt minify</span> <span>Minifica os arquivos JS, CSS, HTML e imagens</span></li>
        <li><span>grunt stylus</span> <span>Compila arquivos stylus</span></li>
        <li><span>grunt jshint</span> <span>Verifica se existe erros no JS</span></li>
        <li><span>grunt dev</span> <span>Deve ser executado sempre que estiver em QA</span></li>
        <li><span>grunt producao</span> <span>Deve ser executado sempre que for subir o sistema para produção</span></li>
    </ul>

    <h2>STYLUS</h2>
    <hr>
    <p>O Framework utiliza o pre processador Stylus. Para usa-lo você deve instalá-lo via npm com o seguinte comando:</p>

    <code>sudo npm install stylus -g</code>

    <p>A organização dos arquivos Stylus (.styl) fica da seguinte maneira:</p>

    <ul>
        <li><span>css/dev/site</span> <span>Arquivo styl do site</span></li>
        <li><span>css/dev/painel</span> <span>Arquivo styl do painel</span></li>
        <li><span>css/dev/geral</span> <span>Arquivos gerais do sistema que será importado nos demais</span></li>
    </ul>

    <p>Existe dois arquivos utilizados pelo Stylus para lidar com as variáveis e os mixins:</p>

    <ul>
        <li>
            <ul>
                <li><span>css/dev/geral/</span> <span>Diretórios dos arquivos</span></li>
                <li><span>variaveis.styl</span> <span>Arquivo onde ficam todas as variáveis</span></li>
                <li><span>mixins.styl</span> <span>Arquivo onde ficam todos os Mixins ("funções")</span></li>
            </ul>
        </li>
    </ul>

    <p>Por padrão, todas as variáveis serão começadas pelo caracter "$" para ter uma melhor leitura.</p>

    <code>
<pre>
$vermelho = #F00
$desktop = 1000px
</pre>
    </code>

    <p>Todos os arquivos salvos em <b>/geral</b>, <b>/site</b> e <b>/painel</b> serão copiado para a raiz da diretório <b>/css</b> criando os arquivos <b>site.css</b> e <b>painel.css</b> compilados e com todos os prefix desde que esteja usando o <b>grunt dev</b>.</p>

    <h3>Alinhamento</h3>
    <p>Para melho leitura, o alinhamento do código Stylus deve segir a seguinte estrutura (Mesmo padrão do Sass):</p>
    <code>
<pre>
body
    background-color: $vermelho

<span>/* CLASS / COMECO */</span>
.titulo
    font-size: 2.0em
<span>/* CLASS / FINAL */</span>

<span>/* HOME / COMECO */</span>
#home
    display: flex
    flex-direction: column

    .banner
        width: 100%
        height: 400px
    .banner figure
        max-width: 100%
        opacity: .8
        &:hover
            opacity: 1

    .destaque
        width: 100%
<span>/* HOME / FINAL */</span>

<span>/* CONTATO / COMECO */</span>
#contato
    display: flex
    flex-direction: column

    form
        background-color: $branco
<span>/* CONTATO / FINAL */</span>
</pre>
    </code>

    <p>O script Stylus acima será processado para o CSS abaixo:</p>
    <code>
<pre>
body {
  background-color: #f00;
}
<span>/* CLASS / COMECO */</span>
.titulo {
    font-size: 2.0em;
}
<span>/* CLASS / FINAL */</span>
<span>/* HOME / COMECO */</span>
#home {
  display: flex;
  flex-direction: column;
}
#home .banner {
  width: 100%;
  height: 400px;
}
#home .banner figure {
  max-width: 100%;
  opacity: 0.8;
}
#home .banner figure:hover {
  opacity: 1;
}
#home .destaque {
  width: 100%;
}
<span>/* HOME / FINAL */</span>
<span>/* CONTATO / COMECO */</span>
#contato {
  display: flex;
  flex-direction: column;
}
#contato form {
  background-color: #fff;
}
<span>/* CONTATO / FINAL */</span>

</pre>
    </code>

    <p class="m">Como visto acima, a estrutura começa pelas <b>tags</b>, depois <b>class</b> e por fim as páginas.</p>
    <p class="m">No começo de cada página deve ter o comentário <b><i>/* NOME / COMEÇO */</i></b> e no final o comentário <b><i>/* NOME / FINAL */</i></b>.</p>
    <p class="m">Deve usar a identação apenas uma vez para o bloco principal da página e uma vez para os seletores.</p>
    <p class="m">Deve remover todos os caracteres "<b>{</b>", "<b>}</b>", e "<b>;</b>" deixando apenas o caracter "<b>:</b>" que divide a propriedade e o valor para deixar a escrita limpa.</p>
    <p>Para mais informações, acessar os arquivos <b>/css/dev/geral/variaveis.styl</b> e <b>/css/dev/geral/mixins.styl</b> pra ver as variáveis e mixins respectivamente.</p>

    <h3>Importar arquivos</h3>
    <p>Para importar arquivos deve usar o @import segundo documentação:</p>

    <code>
<pre>
<span>/* arquivo por arquivo */</span>
@import "css/dev/geral/variaveis.styl"
@import "css/dev/geral/mixins.styl"

<span>/* Todos os arquivos de um diretório */</span>
@import "css/dev/geral/*"

<span>/* Todos os arquivos de um diretório com a extensão desejada */</span>
@import "css/dev/geral/*.styl"
</pre>
    </code>

    <h2>Arquivos JS</h2>
    <hr>
    <p>A estrutura dos arquivos JS é parecida com a do CSS/Stylus, todo o conteudo em QA fica na pasta dev e são copiados para a raiz com o <b>grunt dev</b>. A grande diferença é que todos os arquivos do diretório <b>/js/dev/geral</b> será incorporado ao documento principal.</p>

    <ul>
        <li><span>/js</span> <span>Raiz onde ficará os arquivos em produção</span></li>
        <li>
            <ul>
                <li><span>/js/dev</span> <span>Onde ficará os arquivos em QA</span></li>
                <li><span>/js/dev/site</span> <span>Arquivos do site</span></li>
                <li><span>/js/dev/painel</span> <span>Arquivos do painel</span></li>
                <li><span>/js/dev/geral</span> <span>Arquivos que serão incorporados ao site e ao painel</span></li>
            </ul>
        </li>
        <li><span>/js/fw</span> <span>Frameworks como o tinymce e etc</span></li>
    </ul>

    <h2>Helpers</h2>
    <hr>
    <p>Os helpers são classes PHP para ajudar no desenvolvimento como converter formatos, validar strings e etc. Temos dois tipos de helpers que são:</p>
    <ul>
        <li><span>/system/helpers</span> <span>Hepers que são modificados dependendo do projeto</span></li>
        <li><span>/system/helpers/sistema</span> <span>Hepers padrões que dificilmente serão alterados</span></li>
    </ul>

    <p>A maioria dos helpers são estáticos:</p>
    <code>
<pre>
&lt;?php
    echo Converter::data('2015-09-17', 'd/m/Y'); <span>// Retorno = 17/09/2015</span>
    echo Criar::codigo(5); <span>// Retorno = Def3R</span>
</pre>
    </code>

    <h2>Outras ajudas do sistema</h2>
    <hr>
    <p>No PHP, fora de laços você pode usar chaves para imprimir algo na tela:</p>
    <code>
<pre>
&lt;? $nome = 'João Rodrigues'; ?>

{{$nome}} <span>// Retorno = João Rodrigues</span>

&lt;?php echo $nome ?> <span>// Retorno = João Rodrigues</span>
&lt;?= $nome ?> <span>// Retorno = João Rodrigues</span>
</pre>
    </code>

    <p>Existem vários plugins JS no sistema, para ver todos, verifique a página de exemplos <a href="exemplos" target="_blank">clicando aqui</a>.</p>
</main>


<style>
* {
    margin: 0;
    padding: 0;
    list-style: none;
    border: none;
    box-sizing:border-box;
}
body {
    font-size: 62.5%;
    font-family: 'Lato', sans-serif;
}
main {
    width: calc(100% - 40px);
    max-width: 1000px;
    margin: 20px auto;
    border: 1px solid #DDD;
    padding: 40px;
    display: flex;
    flex-direction: column;
}
hr {
    border-bottom: 1px solid #DDD;
    margin: 10px 0 20px 0;
}
h1 {
    font-size: 2.4em;
}
h2 {
    font-size: 2.2em;
    margin-top: 20px;
}
h3 {
    font-size: 1.6em;
    font-weight: bold;
    margin-bottom: 5px;
}
header {
    width: calc(100% + 80px);
    padding: 10px 15px;
    font-size: 1.4em;
    margin: -40px 0 40px -40px;
    background-color: #f6f8fa;
    font-weight: bold;
}
p {
    line-height: 1.5em;
    margin-bottom: 20px;
    font-size: 1.6em;
}
p a {
    color: #1f1fdf;
}
.m {
    margin-bottom: 5px;
}
ul {
    width: 100%;
    margin-bottom: 40px;
    border-bottom: 1px solid #DDD;
    flex-direction: column;
    display: flex;
}
ul li {
    width: 100%;
    border: 1px solid #DDD;
    border-bottom: none;
    padding: 0 10px;
    display: flex;
}
ul li ul {
    width: 100%;
    margin-bottom: 0;
    border: none;
}
ul li ul li:first-child {
    padding-left: 10px;
    border-top: none;
}
ul li ul li {
    width: calc(100% + 20px);
    position: relative;
    border-right: none;
    border-left: none;
    margin-left: -10px;
    padding: 0 10px 0 40px;
}
ul li ul li:before {
    height: 40px;
    line-height: 40px;
    position: absolute;
    font-size: 2.0em;
    top: 0;
    left: 25px;
    content: "›";
}
ul li ul li:first-child:before {
    content: "";
}
ul li span {
    min-height: 40px;
    line-height: 40px;
    font-size: 1.6em;
}
ul li span:first-child {
    width: 200px;
    font-weight: bold;
    margin-right: 10px;
}
ul li ul li span:first-child {
    width: 170px;
}
ul li ul li:first-child span:first-child {
    width: 200px;
}


code {
    width: 100%;
    line-height: 1.5em;
    font-size: 1.8em;
    padding: 10px 20px;
    margin-bottom: 20px;
    background-color: #f6f8fa;
    overflow: auto;
}
code pre span {
    color: #999;
}

</style>

</body>
</html>
