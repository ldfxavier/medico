<?php $equipe = $_SESSION['EQUIPE'] ?>
<link rel="stylesheet" href="{{LINK}}/app/views/painel/{{$_app}}/scripts/layout.css"/>
<script type="text/javascript" src="{{LINK}}/app/views/painel/{{$_app}}/scripts/all.js"></script>

<div id="bloco_dashboard">
    <header class="header_principal header_principal_animacao header_principal_absolute">
        <h1>DASHBOARD</h1>
    </header>
	<div class="header_principal_false"></div>

    <div class="dados">

        <!-- <form class="" action="<?php //PAINEL.'/post_upload_csv' ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="arquivo" value="">
            <button type="submit" name="button">ENVIAR</button>
        </form> -->

        <!-- BLOCO DE PERFIL -->
        <!-- <div class="bloco_perfil bloco_geral bloco_1">
            <figure class="imagem_trocar" style="background-image: url({{$equipe->imagem}}80)" data-width="80"></figure>
            <div class="equipe">
                <div class="nome">{{$equipe->nome->primeiro}} {{$equipe->nome->ultimo}}</div>
                <div class="area">{{$equipe->area->texto}}</div>
            </div>
            <div class="conteudo">
                <ul class="tipo">
                    <li>Usuário</li>
        			<?php if($equipe->gerente == 1): ?>
                    <li>Gerênte</li>
        			<?php endif;?>
        			<?php if($equipe->admin == 1): ?>
                    <li>Administrador</li>
        			<?php endif; ?>
                </ul>
            </div>
        </div> -->

        <!-- LISTA DE NÚMEROS -->
        <!-- <article class="bloco_quadrado bloco_geral bloco_1">
            <header class="header_dashboard">
                <h1>USUÁRIOS</h1>
            </header>
            <div class="lista">
                <div class="quadro">
                    <div class="bg"></div>
                    <div class="valor">17000</div>
                    <div class="texto">TOTAL</div>
                </div>
                <div class="quadro">
                    <div class="bg"></div>
                    <div class="valor">1200</div>
                    <div class="texto">ATIVOS</div>
                </div>
                <div class="quadro">
                    <div class="bg"></div>
                    <div class="valor">300</div>
                    <div class="texto">INATIVOS</div>
                </div>
                <div class="quadro">
                    <div class="bg"></div>
                    <div class="valor">100</div>
                    <div class="texto">NOVOS</div>
                </div>
            </div>
        </article> -->

        <!-- LISTA COM DATA -->
        <!-- <article class="bloco_lista bloco_geral bloco_calendario bloco_1">
            <header class="header_dashboard">
                <h1>AGENDA</h1>
                <a class="add" href="" data-ajuda="Adicionar novo"><i data-font="&#xe809;"></i></a>
            </header>
            <ul class="conteudo">
                <li class="zero">SEM DADOS</li>
                <?php for($i=0;$i<10;$i++): ?>
                <li class="geral">
                    <span class="data">
                        HOJE<br>
                        10:00
                    </span>
                    <span class="texto">Reunião de pauta</span>
                    <i data-font="&#xe802;" data-ajuda="Visualizar dado"></i>
                </li>
                <?php endfor; ?>
            </ul>
            <div class="footer"></div>
        </article> -->

        <!-- LIGAÇÕES DO SISTEMA -->
        <!-- <article class="bloco_quadrado bloco_geral bloco_1">
            <header class="header_dashboard">
                <h1>LIGAÇÕES</h1>
            </header>
            <div class="lista">
                <div class="quadro">
                    <a href=""></a>
                    <div class="bg"></div>
                    <div class="valor">60</div>
                    <div class="texto">PARA HOJE</div>
                </div>
                <div class="quadro">
                    <a href=""></a>
                    <div class="bg"></div>
                    <div class="valor">120</div>
                    <div class="texto">AMANHÃ</div>
                </div>
                <div class="quadro">
                    <a href=""></a>
                    <div class="bg"></div>
                    <div class="valor">300</div>
                    <div class="texto">ONTEM</div>
                </div>
                <div class="quadro">
                    <a href=""></a>
                    <div class="bg"></div>
                    <div class="valor">100</div>
                    <div class="texto">ATRASADAS</div>
                </div>
            </div>
        </article> -->

        <!-- <article class="bloco_lista_grande bloco_geral bloco_meta bloco_cheio">
            <header class="header_dashboard">
                <h1>META</h1>
            </header>
            <ul>
                <li class="topo">
                    <div class="td">Nome</div>
                    <div class="td">Tipo</div>
                    <div class="td">Status</div>
                    <div class="td">Progresso</div>
                </li>
                <li class="lista">
                    <div class="td">Lorem ipsum dolor sit amet.</div>
                    <div class="td"><span class="tipo">Diaria</span></div>
                    <div class="td"><span class="status bg_vermelho">A bater</span></div>
                    <div class="td"><span class="progresso"><span>50%</span></span></div>
                </li>
                <li class="zero">SEM MÉTRICAS NO MOMENTO</li>
            </ul>
        </article> -->

    </div>
</div>
