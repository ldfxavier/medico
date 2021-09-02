<?php
    namespace app\Helpers;
    final class Grafico {

        public function porcentagem($array, $total, $campo = 'valor'){
            foreach($array as $ind => $val):
                $array[$ind]['porcentagem'] = $val[$campo] == 0 ? 0 : round((($val[$campo] * 100) / $total), 2);
            endforeach;
            return $array;
        }

        public static function lista($titulo = null, $dados, $download = null){
            $titulo = $download != null ? $titulo : '';
            $downalod = $download != null ? '<i data-font="&#xf0ed;" data-ajuda="Download da lista"><a href="'.$download.'" target="_blank"></a></i>' : '';

            $html = '<div class="grafico_lista">';
            $html .= '<h3><span>'.$titulo.'</span>'.$downalod.'</h3>';
            $html .= '<ul>';
            if($dados):
                foreach($dados as $ind => $val):
                    $a_inicial = isset($val['link']) ? '<a href="'.$val['link'].'" target="_blank" data-ajuda="Acessar">' : '';
                    $a_final = isset($val['link']) ? '</a>' : '';
                    if(is_array($val)):
                        $nome = isset($val['nome']) ? $val['nome'] : $ind;
                        $html .= '<li><span class="nome">'.$a_inicial.$nome.$a_final.'</span><span class="porcentagem" data-ajuda="'.$val['porcentagem'].'%"><span class="barra" style="width:'.$val['porcentagem'].'%"></span></span><span class="valor">'.$val['valor'].'</span></li>';
                    else:
                        $html .= '<li><span class="nome">'.$a_inicial.$ind.$a_final.'</span><span class="valor">'.$val.'</span></li>';
                    endif;
                endforeach;
            endif;
            $html .= '</ul></div>';

            return $html;
        }

        public static function circulo($titulo = null, $campo, $dados, $altura = 70){
            $id = 'grafico_'.md5(uniqid(time()));

            $campo_js = "['".implode("', '", $campo)."']";

            $valor = implode(',', $dados['valor']);
            $bg = "'".implode("','", $dados['bg'])."'";
            $lista_html = '';
            if(isset($dados['lista'])):
                $lista_html .= '<div class="grafico_lista">';
                if(!empty($titulo)) $lista_html .= '<h3>'.$titulo.'</h3>';
                $lista_html .= '<ul>';
                foreach($dados['lista'] as $ind => $val):
                    if(is_array($val)):
                        $lista_html .= '<li><span class="nome">'.$ind.'</span><span class="porcentagem" data-ajuda="'.$val['porcentagem'].'%"><span class="barra" style="width:'.$val['porcentagem'].'%"></span></span><span class="valor">'.$val['valor'].'</span></li>';
                    else:
                        $lista_html .= '<li><span class="nome">'.$ind.'</span><span class="valor">'.$val.'</span></li>';
                    endif;
                endforeach;
                $lista_html .= '</ul></div>';
            endif;
            $html = '
			<div class="bloco_grafico">
				<div class="grafico_circulo">
					<div class="grafico">
						<canvas id="'.$id.'" height="'.$altura.'"></canvas>
					</div>
					'.$lista_html.'
				</div>
			</div>
			<script>
			var ctx = document.getElementById("'.$id.'").getContext("2d");
			var myChart = new Chart(ctx, {
				type: "doughnut",
				data: {
					labels: '.$campo_js.',
					datasets: [{
						data: ['.$valor.'],
						backgroundColor: ['.$bg.']
					}]
				},
				options: {
					responsive: true,
					legend: {
						position: "top",
					},
					title: {
						display: false,
						text: "Título aqui"
					},
					animation: false
				}
			});
			</script>
            ';

            return $html;
        }

        public static function linha($titulo, $campo, $dados, $altura = 70, $minimo = null, $maximo = null, $tabela = false){
            $id = 'grafico_'.md5(uniqid(time()));
            $minimo = $minimo != null ? "suggestedMin: {$minimo}," : '';
            $maximo = $maximo != null ? "suggestedMax: {$maximo}," : '';

            $campo_js = "['".implode("', '", $campo)."']";

            $dados_lista = [];
            foreach($dados as $r):
                $r = (object)$r;
                $valor = implode(',', $r->valor);

                $dados_lista[] = "
				{
					label: '{$r->titulo}',
					borderColor: '{$r->borda}',
					backgroundColor: '{$r->bg}',
					data: [{$valor}],
					fill: true,
				}
                ";
            endforeach;
            $dados_lista = implode(',', $dados_lista);

            $tabela_html = '';
            if($tabela && is_array($tabela)):
                $lista = '';
                foreach($tabela as $campos):
                    $lista .= '<tr>';
                    foreach($campos as $texto):
                        $lista .= '<td>'.$texto.'</td>';
                    endforeach;
                    $lista .= '</tr>';
                endforeach;
                $tabela_html .= '
                    <div class="grafico_tabela">
                        <table border="0">
                            '.$lista.'
                        </table>
                    </div>
                ';
            endif;

            $titulo = !empty($titulo) ? '<h3 class="titulo_grafico">'.$titulo.'</h3>' : '';
            $html = '
			<div class="bloco_grafico">
				'.$tabela_html.'
				<div class="grafico_linha">
					'.$titulo.'
					<div class="grafico">
						<canvas id="'.$id.'" height="'.$altura.'"></canvas>
					</div>
				</div>
			</div>
			<script>
			var ctx = document.getElementById("'.$id.'").getContext("2d");
			var myChart = new Chart(ctx, {
				type: "line",
				data: {
					labels: '.$campo_js.',
					datasets: ['.$dados_lista.']
				},
				options: {
					animation:false,
					responsive: true,
					title:{
						display:false,
						text:"Título aqui"
					},
					tooltips: {
						mode: "index",
						intersect: false,
					},
					hover: {
						mode: "nearest",
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: false,
								labelString: "Nome aqui"
							}
						}],
						yAxes: [{
							display: true,
							ticks: {
								'.$minimo.'
								'.$maximo.'
							},
							scaleLabel: {
								display: false,
								labelString: "Valor aqui"
							}
						}]
					}
				}
			});
			</script>
            ';

            return $html;
        }

        public static function barra($titulo, $campo, $dados, $altura = 70, $minimo = null, $maximo = null, $tabela = false){
            $id = 'grafico_'.md5(uniqid(time()));
            $minimo = $minimo != null ? "suggestedMin: {$minimo}," : '';
            $maximo = $maximo != null ? "suggestedMax: {$maximo}," : '';

            $campo_js = "['".implode("', '", $campo)."']";

            $dados_lista = [];
            foreach($dados as $r):
                $r = (object)$r;
                $valor = implode(',', $r->valor);
                $bg = [];
                $borda = [];
                foreach($r->valor as $r_lista):
                    $bg[] = $r->bg;
                    $borda[] = $r->borda;
                endforeach;
                $bg = "'".implode("', '", $bg)."'";
                $borda = "'".implode("', '", $borda)."'";

                $dados_lista[] = "
{
    label: '{$r->titulo}',
    data: [{$valor}],
    backgroundColor: [
        {$bg}
    ],
    borderColor: [
        {$borda}
    ],
    borderWidth: 1
}
                ";
            endforeach;
            $dados_lista = implode(',', $dados_lista);

            $tabela_html = '';
            if($tabela && is_array($tabela)):
                $lista = '';
                foreach($tabela as $campos):
                    $lista .= '<tr>';
                    foreach($campos as $texto):
                        $lista .= '<td>'.$texto.'</td>';
                    endforeach;
                    $lista .= '</tr>';
                endforeach;
                $tabela_html .= '
                    <div class="grafico_tabela">
                        <table border="0">
                            '.$lista.'
                        </table>
                    </div>
                ';
            endif;

            $titulo = !empty($titulo) ? '<h3 class="titulo_grafico">'.$titulo.'</h3>' : '';
            $html = '
<div class="bloco_grafico">
    <div class="grafico_barra">
        '.$titulo.'
        <div class="grafico">
            <canvas id="'.$id.'" height="'.$altura.'"></canvas>
        </div>
    </div>
    '.$tabela_html.'
</div>
<script>
var ctx = document.getElementById("'.$id.'").getContext("2d");
var myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: '.$campo_js.',
        datasets: ['.$dados_lista.']
    },
    options: {
        animation:false,
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    '.$minimo.'
                    '.$maximo.'
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
            ';

            return $html;
        }

    }
