<?php
    /**
     * SESSÕES COM OS DADOS DAS SESSÕES
    **/
    if(!isset($_SESSION['PAINEL_LOGIN'])) $_SESSION['PAINEL_LOGIN'] = PAINEL.'/login';
    if(!isset($_SESSION['PAINEL_LOGADO'])) $_SESSION['PAINEL_LOGADO'] = PAINEL;
    if(!isset($_SESSION['PAINEL_HASH'])) $_SESSION['PAINEL_HASH'] = '';

    final class Auth {
		public static function validar($sessao, $location = true){
			if(!isset($_SESSION[$sessao]) || $_SESSION[$sessao] != $_SESSION[$sessao.'_HASH']):
				if($location):
                    $_SESSION[$sessao.'_REDIRECIONAR'] = URL;
                    header('LOCATION: '.$_SESSION[$sessao.'_LOGIN']);
                    exit();
                else:
                    return false;
                endif;
			endif;
			return true;
        }
		public static function login($sessao, $location = true){
			if(isset($_SESSION[$sessao]) && $_SESSION[$sessao] == $_SESSION[$sessao.'_HASH']):
				if($location):
                    header('LOCATION: '.$_SESSION[$sessao.'_LOGADO']);
                    exit();
				else:
                    return false;
                endif;
			endif;
            return true;
        }
		public static function criar($sessao, $hash){
			$_SESSION[$sessao] = true;
            $_SESSION[$sessao.'_HASH'] = $hash;
        }
		public static function deletar($sessao){
			if(isset($_SESSION[$sessao])):
                unset($_SESSION[$sessao]);
                unset($_SESSION[$sessao.'_HASH']);
            endif;
		}
    }
