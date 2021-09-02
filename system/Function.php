<?php

	/*
    |--------------------------------------------------------------------------
    | CRIA UM CÓDIGO ALEATÓRIO
    |--------------------------------------------------------------------------
    |
	| Gera um código aleatório
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
	| Gera um UUID  versão 4
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
	| Cria um hash único com MD5
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
	| Gera um password usando o password_hash
    |
	*/

	if(!function_exists('password')):

		function password(String $password, String $algoritimo = 'PASSWORD_DEFAULT', Array $option = ['cost' => 11]): String {
			
			if($algoritimo == 'PASSWORD_DEFAULT'):
				return password_hash($password, PASSWORD_DEFAULT, $option);
			elseif($algoritimo == 'PASSWORD_BCRYPT'):
				return password_hash($password, PASSWORD_BCRYPT, $option);
			elseif($algoritimo == 'PASSWORD_ARGON2I'):
				return password_hash($password, PASSWORD_ARGON2I, $option);
			endif;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA UM NÚMERO INTEIRO
    |--------------------------------------------------------------------------
    |
	| Gera um número inteiro com o intervalo de min e max
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
	| Gera um QR Code com o dado enviado e retorna uma imagem com o tamanho
	| definido pela largura e altura
    |
	*/

	if(!function_exists('qrcode')):

		function qrcode(String $dado, Int $width = 200, Int $height = 200): String {

			return 'http://chart.apis.google.com/chart?cht=qr&chl='.$dado.'&chs='.$width.'x'.$height;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA VAR_DUMP
    |--------------------------------------------------------------------------
    |
	| Retonar um var_dump do dado enviado e retorna um exit
    |
	*/

	if(!function_exists('dump')):

		function dump($conteudo){

			var_dump($conteudo);
			exit();

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA PRINT_PRE
    |--------------------------------------------------------------------------
    |
	| Imprime um conteúdo e colocar um pre para array e objecto ou
	| um br para o restante
    |
	*/

	if(!function_exists('pp')):

		function pp($conteudo){

			if(is_object($conteudo) || is_array($conteudo)):
				echo '<pre>';
				print_r($conteudo);
			else:
				echo $conteudo.'<br>';
			endif;

		}

	endif;


	/*
    |--------------------------------------------------------------------------
    | REMOVE ACENTO
    |--------------------------------------------------------------------------
    |
	| Imprime um conteúdo sem acentos
	| 
    |
	*/

	if(!function_exists('remove_acento')):

		function remove_acento($string){
			return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($string)));
		}
	
	endif;

	/*
    |--------------------------------------------------------------------------
    | CRIA PRINT_PRE_EXIT
    |--------------------------------------------------------------------------
    |
	| Imprime um conteúdo e colocar um pre para array e objecto ou
	| um br para o restante. No final, coloca um exit
    |
	*/

	if(!function_exists('ppe')):

		function ppe($conteudo){

			if(is_object($conteudo) || is_array($conteudo)):
				echo '<pre>';
				print_r($conteudo);
			else:
				echo $conteudo.'<br>';
			endif;

			exit();

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | MENSAGEM DE ERRO
    |--------------------------------------------------------------------------
    |
	| Retonar uma mensagem de erro com titulo, texto, status html e codigo
    |
	*/

	if(!function_exists('mensagem_erro')):

		function mensagem_erro(String $titulo = '', String $texto = '', Int $status = 0, Int $codigo = 0): Array {

			$array['erro'] = true;
			if($status > 0):
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
	| Remove todos os caracteres que não são números
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
	| Retonar mensagem de OK
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
	| Retona uma mensagem de erro com código do erro e status erro
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
	| Retorna uma view do sistema
    |
	*/

	if(!function_exists('View')):

		function view(String $arquivo, Array $var = [], String $template = null): Array {

			if(!strstr($arquivo, '.') && strstr($arquivo, '!')):
				$arquivo = '!'.__ROUTE_DIRETORIO.'.'.str_replace('!', '', $arquivo);
			elseif(!strstr($arquivo, '.')):
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
	| Chama a página de error404
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
	| Chama um página de erro html
    |
	*/

	if(!function_exists('status_html')):

		function status_html(Int $status){
			return ['erro' => false, 'acao' => 'status_html', 'codigo' => $status];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | ENV
    |--------------------------------------------------------------------------
    |
	| Pega os valores dos arquivos de configuração
    |
	*/

	if(!function_exists('env')):

		function env($nome, $padrao = NULL){

			$valor = __ENV_USO[$nome] ?? __ENV_PRODUCAO[$nome] ?? $padrao;

			if($valor == 'true'):
				return true;
			elseif($valor == 'false'):
				return false;
			endif;

			return $valor;

		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | LOCATION
    |--------------------------------------------------------------------------
    |
	| Faz um location para o link informado
    |
	*/

	if(!function_exists('Location')):

		function location($link){
			return ['erro' => false, 'acao' => 'location', 'link' => $link];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    |
	| Faz um redirect para o link informado
    |
	*/

	if(!function_exists('Redirect')):

		function redirect($link){
			return ['erro' => false, 'acao' => 'redirect', 'link' => $link];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | DOWNLAOD
    |--------------------------------------------------------------------------
    |
	| Força o download de um arquivo
    |
	*/

	if(!function_exists('Download')):

		function download($link, $nome = 'download', $extensao = ['jpg', 'png', 'pdf', 'doc', 'docx']){
			return ['erro' => false, 'acao' => 'download', 'link' => $link, 'nome' => $nome, 'extensao' => $extensao];
		}

	endif;

	/*
    |--------------------------------------------------------------------------
    | CONVERTER STRING PARA ARRAY
    |--------------------------------------------------------------------------
    |
	| Converter string para array usando , para separar o array e : para
	| separar o indice e o valor
    |
	*/

	if(!function_exists('string_array')):

		function string_array($string, $retorno = true){

			
			if(strstr($string, ':')):
				return json_decode(str_replace([',""', ':""'], '', preg_replace(['/\t+/', '/\n+/', '/\r+/'], '', '{"'.str_replace(['\\', ':', ','], ['\\\\','":"', '","'], $string).'"}')), $retorno);
			elseif(strstr($string, ',')):
				return json_decode(str_replace(',""', '', preg_replace(['/\t+/', '/\n+/', '/\r+/'], '', '["'.str_replace(['\\', ','], ['\\\\', '","'], $string).'"]')), $retorno);
			endif;
			return $string;

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


	/*
    |--------------------------------------------------------------------------
    | PEGA O HEADER
    |--------------------------------------------------------------------------
    |
	| Pega o header da requisição caso não exista a função nativa do PHP
    |
	*/
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

	/*
    |--------------------------------------------------------------------------
    | PEGA A PRIMEIRA CHAVE DO ARRAY
    |--------------------------------------------------------------------------
    |
	| Pega a primeira chave de um array caso o PHP estaja em uma versão
	| inferior a 7.3
    |
	*/
	if (!function_exists('array_key_first')) {

		function array_key_first(array $arr) {
			foreach($arr as $key => $unused) {
				return $key;
			}
			return NULL;
		}

	}


	/*
	|--------------------------------------------------------------------------
    | Transforme todos os URLs em links clicáveis.
    |--------------------------------------------------------------------------
	| @param string $string
	| @param array $protocolos http / https
	| @param array $atributos
	| @return string
	*/

	if(!function_exists('monta_link')):

		function monta_link($string, $protocolos = array('http', 'https'), array $atributos = array('target' => '_blank')){
			// Link atributos
			$attr = '';
			foreach ($atributos as $key => $val) {
				$attr = ' ' . $key . '="' . htmlentities($val) . '"';
			}
			
			$links = array();
			
			// Extrair links e tags existentes
			$string = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { 
				return '<' . array_push($links, $match[1]) . '>'; }, $string);
			
			// Extrair links de texto para cada protocolo
			foreach ((array)$protocolos as $protocolo) {
				switch ($protocolo) {
					case 'http':
					case 'https': 
						$string = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocolo, &$links, $attr) { 
							if ($match[1]) $protocolo = $match[1]; $link = $match[2] ?: $match[3]; 
								return '<' . array_push($links, "<a $attr href=\"$protocolo://$link\">clique aqui</a>") . '>'; }, 
						$string); 
					break;
					default: 
						$string = preg_replace_callback('~' . preg_quote($protocolo, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocolo, &$links, $attr) { 
							return '<' . array_push($links, "<a $attr href=\"$protocolo://{$match[1]}\">{$match[1]}</a>") . '>'; }, 
						$string); 
					break;
				}
			}
			
			// Retorna todos os links inclusos na string
			return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $string);
		}


	endif;