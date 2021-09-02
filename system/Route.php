<?php

class Route
{
    private static $route = [];

    public static function diretorio($diretorio)
    {

        self::$route['diretorio'] = $diretorio;

    }

    private static function controller_converter($controller)
    {
        return str_replace(' ', '', ucwords(mb_strtolower(str_replace('-', ' ', $controller), 'UTF-8')));
    }

    public static function grupo($parametro_1 = '', $parametro_2 = null, $parametro_3 = null)
    {
        if (!is_callable($parametro_1) && !is_callable($parametro_2) && !is_callable($parametro_3)):
            trigger_error('Precisa enviar uma função callback para rota::controller.');
            return false;
        elseif (
            (is_callable($parametro_1) && (!is_null($parametro_2) || !is_null($parametro_3))) ||
            (is_callable($parametro_2) && !is_null($parametro_3))
        ):
            trigger_error('Você não pode passar nada depois da função callback na rota::controller.');
            return false;
        elseif (is_callable($parametro_2) && (!is_array($parametro_1) && !is_string($parametro_1))):
            trigger_error('Parâmetro 1 esperado uma string ou array na rota::controller.');
            return false;
        elseif (is_array($parametro_1) && !is_callable($parametro_2)):
            trigger_error('Após o option é esperado um callback.');
            return false;
        endif;

        $array_quantidade = 0;
        if (is_array($parametro_1)):
            $array_quantidade++;
        elseif (is_array($parametro_2)):
            $array_quantidade++;
        elseif (is_array($parametro_3)):
            $array_quantidade++;
        endif;
        if ($array_quantidade > 1):
            trigger_error('Você deve enviar apenas 1 option na rota::controller');
            return false;
        endif;

        $string_quantidade = 0;
        if (is_string($parametro_1)):
            $string_quantidade++;
        elseif (is_string($parametro_2)):
            $string_quantidade++;
        elseif (is_string($parametro_3)):
            $string_quantidade++;
        endif;
        if ($string_quantidade > 1):
            trigger_error('Você deve enviar apenas 1 nome para o controller na rota::controller');
            return false;
        endif;

        $controller = '';
        if (is_string($parametro_1)):
            $controller = $parametro_1;
        elseif (is_string($parametro_2)):
            $controller = $parametro_2;
        elseif (is_string($parametro_3)):
            $controller = $parametro_3;
        endif;

        $option = [];
        if (is_array($parametro_1)):
            $option = $parametro_1;
        elseif (is_array($parametro_2)):
            $option = $parametro_2;
        elseif (is_array($parametro_3)):
            $option = $parametro_3;
        endif;

        if (is_callable($parametro_1)):
            $callback = $parametro_1;
        elseif (is_callable($parametro_2)):
            $callback = $parametro_2;
        elseif (is_callable($parametro_3)):
            $callback = $parametro_3;
        endif;

        $route = self::$route;
        $route['controller'] = [
            'nome' => $controller,
            'option' => $option,
        ];
        self::$route = $route;
        call_user_func($callback);

    }

    private static function action($metodo, $parametro_1, $parametro_2, $parametro_3, $parametro_4)
    {

        $metodo_passado = $metodo;
        $metodo = $metodo == 'VIEW' ? 'GET' : $metodo;

        $parametro_uri = '';
        if (is_string($parametro_1) && strstr($parametro_1, '/')):
            $parametro_uri = $parametro_1;
        elseif (is_string($parametro_2) && strstr($parametro_2, '/')):
            $parametro_uri = $parametro_2;
        endif;

        $parametro_uri = preg_replace('/\/$/', '', $parametro_uri);
        if (empty($parametro_uri)):
            $parametro_uri = '/index/index';
        elseif (preg_match('/^\/{1}[a-zA-z0-9\-+]*$/', $parametro_uri)):
            $parametro_uri .= '/index';
        endif;

        $parametro_nome = '';
        if (is_string($parametro_1) && !strstr($parametro_1, '/')):
            $parametro_nome = $parametro_1;
        endif;

        $parametro_controller_action = '';
        if (is_string($parametro_1) && strstr($parametro_1, '/') && is_string($parametro_2) && strstr($parametro_2, '@')):
            $parametro_controller_action = $parametro_2;
        elseif (is_string($parametro_2) && strstr($parametro_2, '/') && is_string($parametro_3) && strstr($parametro_3, '@')):
            $parametro_controller_action = $parametro_3;
        endif;

        $parametro_option = [];
        if (is_string($parametro_1) && strstr($parametro_1, '/') && is_array($parametro_2)):
            $parametro_option = $parametro_2;
        elseif ((is_string($parametro_1) && strstr($parametro_1, '/')) || (is_string($parametro_2) && strstr($parametro_2, '/')) && is_array($parametro_3)):
            $parametro_option = $parametro_3;
        elseif (is_string($parametro_2) && strstr($parametro_2, '/') && is_array($parametro_4)):
            $parametro_option = $parametro_4;
        endif;

        if (!in_array($metodo, ['GET', 'POST', 'PUT', 'DELETE'])):
            trigger_error('Método HTTP do método route::' . $metodo . ' inválido.');
            return false;
        elseif (empty($parametro_uri)):
            trigger_error('Esperado uma rota no parametro $uri do método route::' . $metodo . '.');
            return false;
        elseif (is_array($parametro_2) && (!empty($parametro_3) || !empty($parametro_4))):
            trigger_error('Não pode ser passado nada após o option do método route::' . $metodo . '.');
            return false;
        endif;

        $route = self::$route;
        if (!empty($parametro_controller_action) && !preg_match('/^[A-Z]{1}[a-z]{1}[a-zA-Z_]*+@[a-z]{1}[a-zA-Z_]*$/', $parametro_controller_action)):
            trigger_error('O parametro Controller do método route::' . $metodo . ' deve seguir o padrão Controller@action.');
            return false;
        endif;

        $option = [];
        if (!empty($parametro_option) && !empty($route['controller']['option'])):

            $option_lista = [];
            foreach ($parametro_option as $ind => $val):
                $ind_real = $ind;
                if (substr($ind, 0, 1) == '!'):
                    $ind = substr($ind, 1);
                    if (isset($route['controller']['option'][$ind])):
                        unset($route['controller']['option'][$ind]);
                    endif;
                endif;

                if (!isset($route['controller']['option'][$ind])):

                    $option_lista[$ind] = $parametro_option[$ind_real];

                elseif (isset($route['controller']['option'][$ind]) && (is_array($route['controller']['option'][$ind]) && is_array($val))):
                    $option_lista[$ind] = array_merge($route['controller']['option'][$ind], $parametro_option[$ind]);
                elseif (isset($route['controller']['option'][$ind]) && (!is_array($route['controller']['option'][$ind]) && !is_array($val))):
                    $option_lista[$ind] = $route['controller']['option'][$ind] . ',' . $parametro_option[$ind];
                endif;
            endforeach;

            $option = array_merge($route['controller']['option'], $option_lista);

        elseif (!empty($parametro_option)):
            $option = $parametro_option;
        elseif (!empty($route['controller']['option'])):
            $option = $route['controller']['option'];
        endif;

        $explode_parametro_uri = explode('/', $parametro_uri);
        if (!empty($parametro_controller_action)):
            $explode_controller_action = explode('@', $parametro_controller_action);
            $controller = $explode_controller_action[0];
            $action = $explode_controller_action[1];
        else:
            $controller = self::controller_converter($explode_parametro_uri[1]);
            $action = str_replace(['-', '+'], '_', $explode_parametro_uri[2]);
        endif;

        if ($action == '*'):
            trigger_error('Quando passado um action coringa "*", é obrigatório passar o Controller do método route::' . $metodo . ' no padrão Controller@action.');
            return false;
        endif;

        if (isset($route['rota'][$metodo][$parametro_uri])):
            trigger_error('A rota ' . $parametro_uri . ' em route::' . $metodo . ' já foi declarada.');
            return false;
        endif;

        $route['rota'][$metodo]['/' . $explode_parametro_uri[1] . '/' . $explode_parametro_uri[2]] = [
            'uri' => $parametro_uri,
            'option' => $option,
            'metodo' => $metodo_passado,
            'controller' => $controller,
            'action' => $action,
        ];

        $controller_nome = $route['controller']['nome'];
        $controller_option = $route['controller']['option'];

        $link_controller = !empty($controller_nome) ? $controller_nome : $controller;
        $link_action = !empty($parametro_nome) ? $parametro_nome : $action;

        $route['link'][mb_strtolower($metodo_passado . '.' . $link_controller . '.' . $link_action, 'UTF-8')] = $parametro_uri;

        self::$route = $route;

    }

    public static function view($parametro_1, $parametro_2 = '', $parametro_3 = '', $parametro_4 = '')
    {
        self::action('VIEW', $parametro_1, $parametro_2, $parametro_3, $parametro_4);
    }
    public static function get($parametro_1, $parametro_2 = '', $parametro_3 = '', $parametro_4 = '')
    {
        self::action('GET', $parametro_1, $parametro_2, $parametro_3, $parametro_4);
    }
    public static function post($parametro_1, $parametro_2 = '', $parametro_3 = '', $parametro_4 = '')
    {
        self::action('POST', $parametro_1, $parametro_2, $parametro_3, $parametro_4);
    }
    public static function put($parametro_1, $parametro_2 = '', $parametro_3 = '', $parametro_4 = '')
    {
        self::action('PUT', $parametro_1, $parametro_2, $parametro_3, $parametro_4);
    }
    public static function delete($parametro_1, $parametro_2 = '', $parametro_3 = '', $parametro_4 = '')
    {
        self::action('DELETE', $parametro_1, $parametro_2, $parametro_3, $parametro_4);
    }

    public static function link($link)
    {

        $link = mb_strtolower($link, 'UTF-8');

        if (!in_array(explode('.', $link)[0], ['get', 'post', 'put', 'delete'])):
            $link = 'view.' . $link;
        endif;

        $link = explode('/', self::$route['link'][$link] ?? '');

        $controller = $link[1] ?? 'index';
        $action = $link[2] ?? 'index';

        if ($controller == 'index'):
            return '';
        elseif ($action == 'index'):
            return '/' . $controller;
        elseif ($action == '*'):
            return '/' . $controller . '/';
        endif;

        return '/' . $controller . '/' . $action;

    }

    public static function pegar_rota($metodo, $controller, $action)
    {
        $metodo = mb_strtoupper($metodo, 'UTF-8');

        if (!in_array($metodo, ['GET', 'POST', 'PUT', 'DELETE'])):
            return error404();
        endif;

        return self::$route['rota'][$metodo]['/' . $controller . '/' . $action] ?? self::$route['rota'][$metodo]['/' . $controller . '/*'] ?? self::$route['rota'][$metodo]['/*/*'] ?? error404();

    }

    public static function css(String $controller, String $action): String
    {

        $rota = self::$route['rota']['GET']['/' . $controller . '/' . $action] ?? self::$route['rota']['GET']['/' . $controller . '/*'] ?? self::$route['rota']['GET']['/*/*'] ?? false;

        $link = '';

        if (isset($rota['option']['css']) && !empty($rota['option']['css'])):
            $css_rota = explode(',', $rota['option']['css']);
            foreach ($css_rota as $css):
                if (file_exists(__ROOT . '/public/css/' . __ROUTE_DIRETORIO . '/' . $css . '.css')):
                    $link .= '<link rel="stylesheet" href="' . LINK_PADRAO . '/css/' . __ROUTE_DIRETORIO . '/' . $css . '.css?cache=' . CACHE . '"/>';
                endif;
            endforeach;
        endif;

        return $link;

    }
    public static function js(String $controller, String $action): String
    {

        $rota = self::$route['rota']['GET']['/' . $controller . '/' . $action] ?? self::$route['rota']['GET']['/' . $controller . '/*'] ?? self::$route['rota']['GET']['/*/*'] ?? false;

        $link = '';

        if (isset($rota['option']['js']) && !empty($rota['option']['js'])):
            $js_rota = explode(',', $rota['option']['js']);
            foreach ($js_rota as $js):
                if (file_exists(__ROOT . '/public/js/' . __ROUTE_DIRETORIO . '/' . $js . '.js')):
                    $link .= '<script type="text/javascript" src="' . LINK_PADRAO . '/js/' . __ROUTE_DIRETORIO . '/' . $js . '.js?cache=' . CACHE . '"/></script>';
                endif;
            endforeach;
        endif;

        return $link;

    }
}
