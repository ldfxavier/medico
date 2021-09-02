<?php

$GET = [];
$POST = [];
$PUT = [];

include __DIR__ . '/../Xss/Xss.php';

function __limpar_requisicao($dado)
{

    $array = [];

    if ($dado):

        $xss = new \Xss\Xss;

        $jsOnEvent = ['onabort', 'onafterprint', 'onanimationend', 'onanimationiteration', 'onanimationstart', 'onbeforeprint', 'onbeforeunload', 'onblur', 'oncanplay', 'oncanplaythrough', 'onchange', 'onclick', 'oncontextmenu', 'oncopy', 'oncut', 'ondblclick', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'ondurationchange', 'onended', 'onerror', 'onfocus', 'onfocusin', 'onfocusout', 'onfullscreenchange', 'onfullscreenerror', 'onhashchange', 'oninput', 'oninvalid', 'onkeydown', 'onkeypress', 'onkeyup', 'onload', 'onloadeddata', 'onloadedmetadata', 'onloadstart', 'onmessage', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseover', 'onmouseout', 'onmouseup', 'onmousewheel', 'onoffline', 'ononline', 'onopen', 'onpagehide', 'onpageshow', 'onpaste', 'onpause', 'onplay', 'onplaying', 'onpopstate', 'onprogress', 'onratechange', 'onresize', 'onreset', 'onscroll', 'onsearch', 'onseeked', 'onseeking', 'onselect', 'onshow', 'onstalled', 'onstorage', 'onsubmit', 'onsuspend', 'ontimeupdate', 'ontoggle', 'ontouchcancel', 'ontouchend', 'ontouchmove', 'ontouchstart', 'ontransitionend', 'onunload', 'onvolumechange', 'onwaiting', 'onwheel'];

        foreach ($dado as $ind => $val):
            if (is_array($val)):
                $array[$ind] = __limpar_requisicao($val);
            elseif (is_string($val)):
                $string = htmlspecialchars(str_replace($jsOnEvent, '', strip_tags($val)), ENT_QUOTES, 'UTF-8');
                $array[$ind] = $xss->filter_it($string);
            else:
                $array[$ind] = $val;
            endif;
        endforeach;
        ksort($array);
    endif;

    return $array;

}

if (__METODO == 'GET' && !empty($_GET)):
    $GET = __limpar_requisicao($_GET);
elseif (__METODO == 'POST'):
    $__conteudo_post = file_get_contents("php://input");
    $__dado = json_decode($__conteudo_post, true);
    if (!empty($__dado) && is_array($__dado)):
        $POST = __limpar_requisicao($__dado);
    elseif (!empty($_POST)):
        $POST = __limpar_requisicao($_POST);
    endif;
elseif (__METODO == 'PUT'):
    $__conteudo_put = file_get_contents("php://input");

    $__dado = [];
    if (is_array(json_decode($__conteudo_put, true))):
        $__dado = json_decode($__conteudo_put, true);
    elseif (!empty($__conteudo_put) && strstr(urldecode($__conteudo_put), '=')):
        $__array_put = json_decode('{"' . str_replace(['"', "'", '=', "&"], ['\"', "\'", '":"', '","'], $__conteudo_put) . '"}', 2);
        $__final_put = [];
        if (is_array($__array_put) && $__array_put):
            foreach ($__array_put as $ind => $val):
                $__final_put[$ind] = urldecode($val);
            endforeach;
        endif;
        $__dado = $__final_put;
    endif;

    if (!empty($__dado)):
        ksort($__dado);
        $PUT = $__dado;
    endif;
endif;

define('__GET', $GET);
define('__POST', $POST);
define('__PUT', $PUT);

$_POST = [];
$_GET = [];
$GET = [];
$POST = [];
$PUT = [];
