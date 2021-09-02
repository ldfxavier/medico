<?php

namespace System;

final class System
{

    private function middlewares($middleware)
    {

        $lista = explode(',', $middleware);

        if ($lista):
            foreach ($lista as $r):

                $explode = explode(':', $r);

                if (count($explode) != 2):
                    return mensagem_codigo(719, '', 400);
                endif;

                $ind = $explode[0];
                $val = $explode[1];

                $classe = "\App\Middlewares\\" . ucfirst(mb_strtolower(__ROUTE_DIRETORIO, 'UTF-8')) . '\\' . $ind;
                if (substr($ind, 0, 1) == '\\'):
                    $classe = "\App\Middlewares\\" . substr($ind, 1);
                endif;

                $action = $val;
                $parametro = [];

                if (strstr($action, '(')):
                    $parametro_explode = explode('(', $action);
                    $action = $parametro_explode[0];
                    $parametro = $parametro_explode[1] ?? '';
                    if (!empty($parametro)):
                        $parametro = explode('|', str_replace(')', '', $parametro));
                        if ($parametro):
                            $array = [];
                            foreach ($parametro as $valor):
                                $array[] = trim($valor);
                            endforeach;
                            $parametro = $array;
                        endif;
                    endif;
                endif;

                $app = new $classe;
                $retorno = call_user_func_array([$app, $action], $parametro);

                if ($retorno !== true):
                    return $retorno;
                endif;

            endforeach;
        endif;

        return true;
    }

    private function validar_requisicao($metodo, $lista)
    {
        if ($lista == '*'):
            return true;
        endif;

        if ($metodo == 'GET'):
            $requisicao = __GET;
        elseif ($metodo == 'POST'):
            $requisicao = __POST;
        elseif ($metodo == 'PUT'):
            $requisicao = __PUT;
        else:
            return false;
        endif;

        if (empty($lista) && !empty($requisicao)):
            return false;
        elseif (empty($requisicao) && empty($lista)):
            return true;
        endif;

        $indice_requisicao = array_keys($requisicao);
        $indice_lista = array_values($lista);

        $array_indice_lista_limpo = [];
        foreach ($indice_lista as $val):
            if (substr($val, 0, 1) != "!" && !in_array($val, $indice_requisicao)):
                return false;
            endif;
            if (substr($val, 0, 1) == "!"):
                $array_indice_lista_limpo[] = substr($val, 1);
            else:
                $array_indice_lista_limpo[] = $val;
            endif;
        endforeach;

        foreach ($indice_requisicao as $val):
            if (!in_array($val, $array_indice_lista_limpo)):
                return false;
            endif;
        endforeach;

        return true;

    }
    public function run()
    {

        $rota_bloqueada = string_array(env('ROTA_BLOQUEADA', ''));
        if (!empty($rota_bloqueada) && is_array($rota_bloqueada) && in_array(__ROUTE_DIRETORIO, $rota_bloqueada)):
            return mensagem_codigo(404, '', 404);
        endif;

        $rota = __ROUTE_USO;

        if (isset($rota['erro']) && false === $rota['erro']):
            return $rota;
        endif;

        if ($rota['metodo'] == 'GET' && true !== $this->validar_requisicao('GET', $rota['option']['get'] ?? [])):
            return mensagem_codigo(400, '', 400);
        elseif ($rota['metodo'] == 'POST' && true !== $this->validar_requisicao('POST', $rota['option']['post'] ?? [])):
            return mensagem_codigo(400, '', 400);
        elseif ($rota['metodo'] == 'PUT' && true !== $this->validar_requisicao('PUT', $rota['option']['put'] ?? [])):
            return mensagem_codigo(400, '', 400);
        endif;

        if (isset($rota['option']['middlewares'])):
            $middleware = $this->middlewares($rota['option']['middlewares']);
            if (true !== $middleware):
                return $middleware;
            endif;
        endif;

        $classe = 'App\Controllers\\' . ucfirst(mb_strtolower(__ROUTE_DIRETORIO, 'UTF-8')) . '\\' . $rota['controller'];
        if (!class_exists($classe)):
            return Error404();
        endif;

        $app = new $classe;

        $metodo_passado = $rota['metodo'];

        if ($metodo_passado == 'VIEW' && __METODO == 'GET'):
            $action = $rota['action'];
        elseif ($metodo_passado == 'GET' && __METODO == 'GET'):
            $action = 'get_' . $rota['action'];
        elseif ($metodo_passado == 'POST' && __METODO == 'POST'):
            $action = 'post_' . $rota['action'];
        elseif ($metodo_passado == 'PUT' && __METODO == 'PUT'):
            $action = 'put_' . $rota['action'];
        elseif ($metodo_passado == 'DELETE' && __METODO == 'DELETE'):
            $action = 'delete_' . $rota['action'];
        else:
            return Error404();
        endif;

        $url_explode = __URL_EXPLODE;
        $uri_explode = explode('/', $rota['uri']);

        if ($uri_explode[1] != '*' && $uri_explode[2] == '*'):
            unset($url_explode[0]);
        elseif ($uri_explode[1] != '*' && $uri_explode[2] != '*'):
            unset($url_explode[0]);
            if (isset($url_explode[1])):
                unset($url_explode[1]);
            endif;
        endif;
        $url_explode = array_values($url_explode);

        unset($uri_explode[0], $uri_explode[1], $uri_explode[2]);
        $uri_explode = array_values($uri_explode);

        $tamanho_explode = [];
        $tamanho_url = $uri_explode[0] ?? '';
        if (preg_match('/^\{[0-9]{1}\,[0-9]\}$/', $tamanho_url)):
            $tamanho_explode = explode(',', str_replace(['{', '}'], '', $tamanho_url));
        endif;

        if (count($tamanho_explode) == 2 && (count($url_explode) < $tamanho_explode[0] || count($url_explode) > $tamanho_explode[1])):
            return Error404();
        elseif (count($tamanho_explode) != 2 && count($uri_explode) != count($url_explode)):
            return Error404();
        elseif (!method_exists($app, $action)):
            return Error404();
        endif;

        $propriedade = [];
        if ($url_explode) {

            $xss = new \xss\xss;

            $jsOnEvent = ['onabort', 'onafterprint', 'onanimationend', 'onanimationiteration', 'onanimationstart', 'onbeforeprint', 'onbeforeunload', 'onblur', 'oncanplay', 'oncanplaythrough', 'onchange', 'onclick', 'oncontextmenu', 'oncopy', 'oncut', 'ondblclick', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'ondurationchange', 'onended', 'onerror', 'onfocus', 'onfocusin', 'onfocusout', 'onfullscreenchange', 'onfullscreenerror', 'onhashchange', 'oninput', 'oninvalid', 'onkeydown', 'onkeypress', 'onkeyup', 'onload', 'onloadeddata', 'onloadedmetadata', 'onloadstart', 'onmessage', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseover', 'onmouseout', 'onmouseup', 'onmousewheel', 'onoffline', 'ononline', 'onopen', 'onpagehide', 'onpageshow', 'onpaste', 'onpause', 'onplay', 'onplaying', 'onpopstate', 'onprogress', 'onratechange', 'onresize', 'onreset', 'onscroll', 'onsearch', 'onseeked', 'onseeking', 'onselect', 'onshow', 'onstalled', 'onstorage', 'onsubmit', 'onsuspend', 'ontimeupdate', 'ontoggle', 'ontouchcancel', 'ontouchend', 'ontouchmove', 'ontouchstart', 'ontransitionend', 'onunload', 'onvolumechange', 'onwaiting', 'onwheel'];

            foreach ($url_explode as $val) {
                $propriedade[] = htmlspecialchars(str_replace($jsOnEvent, '', strip_tags($val)), ENT_QUOTES, 'UTF-8');
            }

        }

        return call_user_func_array([$app, $action], $propriedade);

    }

}
