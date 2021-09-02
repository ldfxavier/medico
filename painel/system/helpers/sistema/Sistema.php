<?php
	class Sistema {

		/**
		 * PEGA OS DADOS DO USERAGENT E CONVERTE PARA DADOS
		 */
		public static function agente(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			if($info):
				$dados = (object)array(
					'plataforma' => $info->platform,
					'browser' => (object)array(
						'nome' => $info->browser,
						'versao' => $info->version
					),
					'device' => (object)array(
						'tipo' => $info->device_type,
						'mobile' => $info->ismobiledevice,
						'tablet' => $info->istablet
					)
				);
				return $dados;
			endif;
		}
		public static function get_browser(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return mb_strtolower($info->browser, 'UTF-8');
		}
		public static function get_versao(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return $info->version;
		}
		public static function get_browser_versao(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return mb_strtolower($info->browser, 'UTF-8').' '.$info->version;
		}
		public static function get_os(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return mb_strtolower($info->platform, 'UTF-8');
		}
		public static function get_device(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return mb_strtolower($info->device_type, 'UTF-8');
		}
		public static function get_ip(){
			return $_SERVER['SERVER_ADDR'];
		}

		public static function is_mobile(){
			// $info = get_browser($_SERVER['HTTP_USER_AGENT']);
			// return ($info->ismobiledevice == true || $info->istablet == true) ? true : false;
			return false;
		}
		public static function is_phone(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return ($info->ismobiledevice == true) ? true : false;
		}
		public static function is_tablet(){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			return ($info->istablet == true) ? true : false;
		}
		public static function is_browser($browser){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			if(ucfirst($info->browser) == ucfirst($browser)) return true;
		}
		public static function is_os($os){
			$info = get_browser($_SERVER['HTTP_USER_AGENT']);
			if(ucfirst($info->platform) == ucfirst($os)) return true;
		}
	}
