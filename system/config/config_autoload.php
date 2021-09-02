<?php

/*
|--------------------------------------------------------------------------
| CONFIG AUTOLOAD
|--------------------------------------------------------------------------
|
| Carrega as classes usando o autolaod
|
 */
$__config_autoload = require_once __ROOT . '/config/autoload.php';

define('__AUTOLOAD_ALIAS', $__config_autoload['alias']);
define('__AUTOLOAD_COMPLEMENTO', $__config_autoload['complemento']);

spl_autoload_register(function ($classe) {

    $arquivo = str_replace(array_merge(['\\'], array_keys(__AUTOLOAD_ALIAS)), array_merge(['/'], array_values(__AUTOLOAD_ALIAS)), $classe);

    $classe_comparar = str_replace(['/', '\\'], '', $classe);

    $complemento = '';

    if (__AUTOLOAD_COMPLEMENTO):

        foreach (__AUTOLOAD_COMPLEMENTO as $ind => $val):
            $expressao = '/^' . str_replace(['\\', '/'], '', preg_quote($ind)) . '/';

            if (preg_match($expressao, $classe_comparar)):
                $complemento = $val;
                break;
            endif;

        endforeach;

    endif;

    $arquivo = __ROOT . '/' . $arquivo . $complemento . '.php';

    if (file_exists($arquivo)):
        require $arquivo;
    endif;

});
