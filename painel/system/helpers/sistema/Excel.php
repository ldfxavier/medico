<?php
	final class Excel {
		/**
		 * SALVA O VALOR EM UM ARQUIVO CSV
		**/
		public static function gerar($nome, $lista){
			$i = 0;
			$tabela = '<table border="1">';
			foreach($lista as $linha):
				if($i == 0) $tabela .= '<tr bgcolor="#000000" style="color: #FFFFFF">';
				else $tabela .= '<tr>';
				foreach($linha as $val):
					$tabela .= '<td>'.utf8_decode($val).'</td>';
				endforeach;
				$tabela .= '</tr>';
				$i++;
			endforeach;
			$tabela .= '<table>';

			header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
			header ("Cache-Control: no-cache, must-revalidate");
			header ("Pragma: no-cache");
			header ("Content-type: application/x-msexcel");
			header ("Content-Disposition: attachment; filename=\"{$nome}\"" );
			header ("Content-Description: PHP Generated Data" );

			echo $tabela;
			exit();
		}
	}
