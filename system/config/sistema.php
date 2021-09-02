<?php

/*
|--------------------------------------------------------------------------
| CONFIGURAÇÕES INICIAIS DO SISTEMA
|--------------------------------------------------------------------------
|
| Faz as configurações iniciais como verificar se o sistema esta em
| produção, homologação ou local, cria as defines de LINK e gerencia e
| seta qual arquivo env será usado
|
 */

define('__ROOT', str_replace(['/system/config', '\system\config'], '', dirname(__FILE__)));

$__host = $_SERVER['HTTP_HOST'];

$__metodo = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ?? $_SERVER['REQUEST_METHOD'] ?? '';
define('__METODO', mb_strtoupper($__metodo, 'UTF-8'));

function montar_env($dado)
{
    $array = [];
    if ($dado):
        foreach ($dado as $ind => $val):
            if (!empty(trim($val))):
                $temp = explode('=', $val);
                $valor = trim($temp[1] ?? '');
                if (in_array($temp[0], ['APP_URL', 'MAIL_EMAIL', 'MAIL_ENVIO', 'MAIL_RESPOSTA'])):
                    $valor = string_array($valor);
                endif;

                $array[$temp[0]] = $valor;
            endif;
        endforeach;
    endif;
    return $array;
}

$__lista_arquivo_raiz = array_diff(scandir(__ROOT), ['.', '..']);

$__env_producao = montar_env(file(__ROOT . '/.env'));
$__env_homologacao = montar_env(file(__ROOT . '/.env.homologacao'));

$__env_localhost_arquivo = array_filter($__lista_arquivo_raiz, function ($valor) {
    if (preg_match('/^.env./', $valor) && $valor != '.env.homologacao'):
        return $valor;
    endif;
});

$__env_localhost = [];
if (is_array($__env_localhost_arquivo) && !empty($__env_localhost_arquivo) && file_exists(__ROOT . '/' . reset($__env_localhost_arquivo))):
    $__env_localhost = montar_env(file(__ROOT . '/' . reset($__env_localhost_arquivo)));
endif;

$__url_producao = $__env_producao['APP_URL'] ?? false;
$__url_homologacao = $__env_homologacao['APP_URL'] ?? false;
$__url_localhost = $__env_localhost['APP_URL'] ?? false;
if (!$__url_producao && !$__url_homologacao && !$__url_localhost):
    trigger_error('VOCÊ PRECISA CONFIGURAR O APP_URL');
    exit();
endif;

function __validar_env($env, $host, $tipo_geral)
{

    if (defined('SISTEMA')):
        return false;
    endif;

    $host = explode(':', $host)[0] ?? '';

    $url = $env['APP_URL'] ?? false;
    $tipo = $env['APP_TIPO'] ?? '';
    if (empty($tipo)):
        $tipo = $tipo_geral;
    endif;

    if (
        (is_array($url) && in_array($host, $url)) ||
        (is_string($url) && $url == $host) ||
        $url == '*'
    ):
        define('SISTEMA', $tipo);
        define('__ENV_USO', $env);
    endif;

}

__validar_env($__env_localhost, $__host, 'localhost');
__validar_env($__env_homologacao, $__host, 'homologacao');
__validar_env($__env_producao, $__host, 'producao');

if (!defined('SISTEMA')):
    trigger_error('VOCÊ PRECISA PASSAR A URL DO PROJETO');
    exit();
endif;

$__teste = false;
$__localhost = false;
$__homologacao = false;
$__producao = false;

define('__ENV_PRODUCAO', $__env_producao);
if (SISTEMA == 'producao'):
    $__producao = true;
elseif (SISTEMA == 'homologacao'):
    $__teste = true;
    $__homologacao = true;
elseif (SISTEMA == 'localhost'):
    $__teste = true;
    $__localhost = true;
endif;

define('TESTE', $__teste);
define('LOCALHOST', $__localhost);
define('HOMOLOGACAO', $__homologacao);
define('PRODUCAO', $__producao);

$__http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? 'https' : 'http';
$__http = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https' : $__http;
$__port = $_SERVER['SERVER_PORT'] ?? 0;

if ($__http == 'http' && $__port === 443):
    $__http = 'https';
endif;

$__https = env('APP_HTTPS', false);
$__raiz = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

$__expresao_url = '/^' . str_replace(['\\', '/'], ['\\\\', '\\/'], $__raiz) . '/';
$__url = preg_replace($__expresao_url, '', $_SERVER["REQUEST_URI"]);

$__www = env('APP_WWW', '');

$__location = false;
$__link_url = $__http . '://' . $__host . $__raiz . $__url;

$expressao_www = '/^' . $__http . ':\/\/www./';
if (true === $__www && !preg_match($expressao_www, $__link_url)):
    $__link_url = str_replace('://', '://www.', $__link_url);
    $__location = true;
elseif (false === $__www && preg_match($expressao_www, $__link_url)):
    $__link_url = str_replace('://www.', '://', $__link_url);
    $__location = true;
endif;

$__session_http = !isset($_SESSION['__HTTP']) || $_SESSION['__HTTP'] !== $__https;
$_SESSION['__HTTP'] = $__https;
if ($__http == 'http' && true === $__https && $__session_http):
    $__link_url = str_replace('http://', 'https://', $__link_url);
    $__location = true;
elseif ($__http == 'https' && false === $__https && $__session_http):
    $__link_url = str_replace('https://', 'http://', $__link_url);
    $__location = true;
endif;

if (true === $__location):
    header('LOCATION: ' . $__link_url);
    exit();
endif;

define('__HTTP', $__https ? 'https://' : 'http://');
define('__HOST', $__host);
define('__RAIZ', $__raiz);
define('URL', $__url);
$_SESSION['__LINK'] = __HTTP . __HOST . __RAIZ;
