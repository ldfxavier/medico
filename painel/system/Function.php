<?php
	/*
    |--------------------------------------------------------------------------
    | CRIA UM CÓDIGO ALEATÓRIO
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('codigo')):

		function codigo( Int $tamanho = 8, Bool $minuscula = true, Bool $maiuscula = true, Bool $numero = true, Bool $simbolo = false ): String {

			$retorno = '';

			$caractere = $minuscula ? 'abcdefghijklmnopqrstuvwxyz' : '';
			$caractere .= $maiuscula ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '';
			$caractere .= $numero ? '1234567890' : '';
			$caractere .= $simbolo ? '!@#$%*-' : '';

			$caractere_tamanho = strlen($caractere);

			for($n=1;$n<=$tamanho;$n++):
				$rand = mt_rand(1, $caractere_tamanho);
				$retorno .= $caractere[$rand-1];
			endfor;

			return $retorno;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA UM UUID
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('uuid')):

		function uuid(): String {

			return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
				mt_rand( 0, 0xffff ),
				mt_rand( 0, 0x0fff ) | 0x4000,
				mt_rand( 0, 0x3fff ) | 0x8000,
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA UM HASH MD5
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('hash_md5')):

		function hash_md5(): String {
			return md5(uniqid(time()));

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA UM PASSWORD
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('password')):

		function password(String $password, Int $cost = 11): String {

			return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA UM NÚMERO INTEIRO
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('inteiro')):

		function inteiro(Int $min = 1000, Int $max = 9999): Int {

			return rand($min, $max);

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA UM LINK PARA QR CODE
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('qrcode')):

		function qrcode(String $url, Int $width = 200, Int $height = 200): String {

			return 'http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$width.'x'.$height;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA VAR_DUMP
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('dump')):

		function dump($objecto){

			var_dump($objecto);
			exit();

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA PRINT_PRE
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('pp')):

		function pp($conteudo){

			if(is_string($conteudo)):
				echo $conteudo.'<br>';
			else:
				echo '<pre>';
				print_r($conteudo);
			endif;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA PRINT_PRE_EXIT
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('ppe')):

		function ppe($conteudo){

			if(is_string($conteudo)):
				echo $conteudo.'<br>';
			else:
				echo '<pre>';
				print_r($conteudo);
			endif;

			exit();

		}

	endif;


	/*
    |--------------------------------------------------------------------------
    | CRIA url_title
    |--------------------------------------------------------------------------
    |
	| funcao que torna string em url amigavel removendo caracteres especiais
    |
	*/
	if(!function_exists('url_title')):

		function url_title ($string) {
			$string = strtolower(utf8_decode($string)); $i=1;

			$string = strtr($string, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');

			$string = preg_replace("/([^a-z0-9])/",'-',utf8_encode($string));

			while($i>0) $string = str_replace('--','-',$string,$i);

			if (substr($string, -1) == '-') $string = substr($string, 0, -1);

			return $string;
		}
	
	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA PRINT_EXIT
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('pe')):

		function pe($conteudo){

			if(is_string($conteudo)):
				echo $conteudo.'<br>';
			else:
				echo '<pre>';
				print_r($conteudo);
			endif;

			exit();

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | MENSAGEM DE ERRO
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('mensagem_erro')):

		function mensagem_erro(String $titulo = '', String $texto = '', Int $status = 0, Int $codigo = 0): Array {

			$array['erro'] = true;
			if($status > 0):
				http_response_code($status);
				$array['status_html'] = $status;
			endif;
			if(!empty($codigo)):
				$array['codigo'] = $codigo;
			endif;
			if(!empty($titulo)):
				$array['titulo'] = $titulo;
			endif;
			if(!empty($texto)):
				$array['texto'] = $texto;
			endif;

			return $array;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | MENSAGEM OK
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('so_numero')):

		function so_numero($string) {

			return preg_replace("/[^0-9]/", "", $string);

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | MENSAGEM OK
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('mensagem_ok')):

		function mensagem_ok($option = []): Array {

			$array['erro'] = false;

			if(isset($option['status'])):
				$array['status_html'] = $option['status'];
			endif;

			return $array;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | MENSAGEM COM CÓDIGO
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('Mensagem_codigo')):

		function mensagem_codigo(Int $codigo, $parametro_2 = '', $parametro_3 = ''): Array {

			if(is_numeric($parametro_2)):
				$status_html = $parametro_2;
				$campo = $parametro_3;
			elseif(is_string($parametro_2) && is_numeric($parametro_3)):
				$campo = $parametro_2;
				$status_html = $parametro_3;
			elseif(is_string($parametro_2)):
				$campo = $parametro_2;
				$status_html = 200;
			else:
				$campo = '';
				$status_html = 200;
			endif;
			
			$linha = file(__ROOT.'/files/erro/lista.txt');

			$titulo = '';
			$texto = '';

			foreach($linha as $l):
				$explode = explode(':', $l);
				if($explode[0] == $codigo):
					$titulo = $explode[1];
					$texto = trim(preg_replace('/\s\s+/', ' ', $explode[2]));
					break;
				endif;
			endforeach;

			return [
				'erro' => true,
				'titulo' => $titulo,
				'texto' => !empty($campo) && !empty($texto) ? str_replace('{CAMPO}', $campo, $texto) : str_replace('{CAMPO} ', '', $texto),
				'codigo' => $codigo,
				'status_html' => $status_html
			];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CHAMA A VIEW
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('View')):

		function view(String $arquivo, Array $var = [], String $template = null): Array {
			
			if(!strstr($arquivo, '.')):
				$arquivo = __ROUTE_DIRETORIO.'.'.$arquivo;
			endif;

			$view = str_replace(['.', '!'], ['/', ''], $arquivo);
			$target = __VIEWS.'/'.$view.".php";

			$template_config = '';
			$template_header = '';
			$template_footer = '';

			if(substr($arquivo, 0, 1) != '!' || !empty($template)):

				$explode = explode('/', $view);

				if(empty($template) && count($explode) > 1):
					$template = $explode[0];
				elseif(empty($template) && count($explode) <= 1):
					$template = 'padrao';
				endif;

				if(file_exists(__TEMPLETES.'/'.$template.'/config.php')):
					$template_config = __TEMPLETES.'/'.$template.'/config.php';
				endif;

				$template_header = __TEMPLETES.'/'.$template.'/header.php';
				$template_footer = __TEMPLETES.'/'.$template.'/footer.php';
				if(!file_exists($template_header) || !file_exists($template_footer)):

					if(file_exists(__TEMPLETES.'/padrao/config.php')):
						$template_config = __TEMPLETES.'/padrao/config.php';
					endif;

					$template_header = __TEMPLETES.'/padrao/header.php';
					$template_footer = __TEMPLETES.'/padrao/footer.php';

				endif;

			endif;

			if((!empty($template_header) && !file_exists($template_header)) || (!empty($template_footer) && !file_exists($template_footer)) || !file_exists($target)):
				return Error404();
			else:
				return [
					'erro' => false,
					'var' => $var,
					'template' => [
						'config' => $template_config,
						'header' => $template_header,
						'view' => $target,
						'footer' => $template_footer
					]
				];
			endif;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CHAMA A PAGINA 404
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('error404')):

		function error404(){
			return ['erro' => false, 'acao' => 'status_html', 'codigo' => 404];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CHAMA AS PÁGINAS DE STATUS
    |--------------------------------------------------------------------------
    |
	| Descricao
    |
	*/

	if(!function_exists('status_html')):

		function status_html(Int $status){
			return ['erro' => false, 'acao' => 'status_html', 'codigo' => $status];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | VALIDAR O RECAPTCHA DO GOOGLE V3
    |--------------------------------------------------------------------------
    |
	| Valida o recaptcha do google usando a versao 3 e retorna
	| o rate da requisição e retornar true ou false
    |
	*/

	if(!function_exists('recaptcha')):

		function recaptcha($hash){

			$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptcha_secret = RECAPTCHA_SECRET;
			$recaptcha_response = $hash;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$recaptcha = json_decode(curl_exec($ch));

			if(false === $recaptcha->success || (true === $recaptcha->success && $recaptcha->score <= .5)):
				return false;
			endif;

			return true;

		}

	endif;

	if (!function_exists('getallheaders')):
		function getallheaders() {
			$headers = [];
			foreach ($_SERVER as $name => $value):
				if (substr($name, 0, 5) == 'HTTP_'):
					$headers[str_replace(' ', '-', ucwords(mb_strtolower(str_replace('_', ' ', substr($name, 5)), 'UTF-8')))] = $value;
				endif;
			endforeach;
			return $headers;
		}
	endif;