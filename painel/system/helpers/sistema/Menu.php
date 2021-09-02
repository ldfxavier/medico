<?php
	class Menu {

		public static function principal($titulo, $hover, $cor = '', $lista){
			$equipe = $_SESSION['EQUIPE'];

			$menu_hover = '';
			$alerta = 0;
			$array = array();
			foreach($lista as $sub):
				if((
					in_array(Permissao::nome($sub[1]).'_visualizar', $_SESSION['EQUIPE']->permissao->lista) &&
					(
						!isset($sub[3]) ||
						(isset($sub[3]) && $_SESSION['EQUIPE']->admin == 1)
					)
				) ||
					$equipe->desenvolvedor == 1
				):
					$array[] = $sub;
					if($sub[1] == $hover):
						$menu_hover = ' hover';
					endif;
					$alerta += $sub[2];
				endif;
			endforeach;

			if($alerta > 0):
				$alerta = ($alerta > 9) ? '+9' : $alerta;
				$alerta = '<span class="alerta">'.$alerta.'</span>';
			else:
				$alerta = '';
			endif;

			if(count($array) > 1):
				echo '<li class="li_principal" style="border-left: 3px solid '.$cor.'">';
					echo '<div class="menu_titulo">'.$titulo.$alerta.'<i>+</i></div>';
					echo '<ul class="menu_sub '.$menu_hover.'">';
						 	foreach($array as $sub):
								$sub_hover = ($sub[1] == $hover) ? 'class="hover"' : '';
								if($sub[2] > 0):
									$sub_alerta = ($sub[2] > 9) ? '+9' : $sub[2];
									$sub_alerta = '<span class="alerta">'.$sub_alerta.'</span>';
								else:
									$sub_alerta = '';
								endif;
								$link = PAINEL.'/app/'.$sub[1];
								echo '<li><a '.$sub_hover.' href="'.$link.'"><i data-font="&#xf105;"></i>'.$sub[0].$sub_alerta.'</a></li>';
							endforeach;
					echo '</ul>';
				echo '</li>';
			elseif(count($array) == 1):
				$sub = $array[0];
				$sub_hover = ($sub[1] == $hover) ? 'hover' : '';
				if($sub[2] > 0):
					$sub_alerta = ($sub[2] > 9) ? '+9' : $sub[2];
					$sub_alerta = '<span class="alerta">'.$sub_alerta.'</span>';
				else:
					$sub_alerta = '';
				endif;
				$link = PAINEL.'/app/'.$sub[1];
				echo '<li class="li_principal" style="border-left: 3px solid '.$cor.'">';
				echo '<a class="simples '.$sub_hover.'" href="'.$link.'">'.Converter::caixa($sub[0], 'A').$sub_alerta.'</a>';
				echo '</li>';
			endif;
		}

		public static function td($lista, $app, $order){
			$html = '';
			if($lista):
				foreach($lista as $campo => $valor):
					$tipo = 'ASC';
					$icone = '&#xe810;';
					if($campo.' ASC' == $order):
						$tipo = 'DESC';
						$icone = '&#xf106;';
					endif;

					$class = '';
					$titulo = $valor;
					if(is_array($valor)):
						$titulo = $valor[0];
						$class = isset($valor[1]) ? $valor[1] : '';
					endif;
					if(strstr($campo, 'limpo_')):
						$html .= '<div class="td '.$class.'"><p>'.$titulo.'</p><span data-font="'.$icone.'"></span></div>';
					else:
						$html .= '<div class="td '.$class.'"><a href="'.PAINEL.'/app/'.$app.'/par/ordem/'.$campo.'+'.$tipo.'"><p>'.$titulo.'</p><span data-font="'.$icone.'"></span></a></div>';
					endif;
				endforeach;
			endif;
			return $html;
		}

	}
