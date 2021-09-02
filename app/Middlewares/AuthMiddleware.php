<?php

namespace App\Middlewares;

class Auth
{

    public function validar(String $local = null, String $link = null)
    {

        $local = $local != null ? $local : mb_strtoupper(__ROUTE_DIRETORIO, 'UTF-8');
        $link = $link != null ? str_replace(['{{LINK}}', '{{LINK_SITE}}', '{{LINK_API}}', '{{LINK_PAINEL}}'], [LINK, LINK_SITE, LINK_API, LINK_PAINEL], $link) : LINK_PADRAO . '/login';

        if (!isset($_SESSION['AUTH_' . $local]) || !isset($_SESSION['AUTH_' . $local . '_HASH']) || $_SESSION['AUTH_' . $local] != $_SESSION['AUTH_' . $local . '_HASH']):
            $_SESSION['LINK_LOCATION'] = LINK_PADRAO . URL;
            return Location($link);
        endif;

        return true;

    }
    
    public function logado(String $local = null, String $link = null)
    {

        $local = $local != null ? $local : mb_strtoupper(__ROUTE_DIRETORIO, 'UTF-8');

        $link = $link != null ? str_replace(['{{LINK}}', '{{LINK_SITE}}', '{{LINK_API}}', '{{LINK_PAINEL}}'], [LINK, LINK_SITE, LINK_API, LINK_PAINEL], $link) : LINK_PADRAO;

        if (isset($_SESSION['AUTH_' . $local]) && isset($_SESSION['AUTH_' . $local . '_HASH']) && $_SESSION['AUTH_' . $local] == $_SESSION['AUTH_' . $local . '_HASH']):
            return Location($link);
        endif;

        return true;

    }

}
