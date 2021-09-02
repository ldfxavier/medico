<?php
	
	namespace App\Helpers;

	final class Auth {

		public function criar(String $local = null, $hash = null): Bool {
			
			$local = $local != null ? $local : mb_strtoupper(__ROUTE_DIRETORIO, 'UTF-8');

			$_SESSION['AUTH_'.$local.'_HASH'] = $hash != null ? $hash : hash_md5();
			$_SESSION['AUTH_'.$local] = $_SESSION['AUTH_'.$local.'_HASH'];
			
			return true;

		}

		public function deletar(String $local = null): Bool {

			$local = $local != null ? $local : mb_strtoupper(__ROUTE_DIRETORIO, 'UTF-8');

			if(isset($_SESSION['AUTH_'.$local.'_HASH'])):
				unset($_SESSION['AUTH_'.$local.'_HASH']);
			endif;
			if(isset($_SESSION['AUTH_'.$local])):
				unset($_SESSION['AUTH_'.$local]);
			endif;

			return true;

		}

	}