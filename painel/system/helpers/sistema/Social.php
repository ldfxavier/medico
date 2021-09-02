<?php
	class Social {
		/**
		 * @var $url 	string Url da página
		 * @return 		string Url para o Facebook
		 */
		public static function facebook($url){
			return 'http://www.facebook.com/sharer/sharer.php?u='.$url;
		}

		/**
		 * @var $url 	string Url da página
		 * @return 		string Url para o Google
		 */
		public static function google($url){
			return 'https://plus.google.com/share?url='.$url;
		}

		/**
		 * @var $title 		string Título da página
		 * @var $url 		string Url da página
		 * @var by 			string usuário do Twitter
		 * @var $related 	string usuário do Twitter
		 * @return 			string Url para o Twitter
		 */
		public static function twitter($title, $url, $by = null, $related = null){
			$by = ($by == null) ? '' : '&via='.$by;
			$related = ($related == null) ? '' : '&related='.$related;
			return 'http://twitter.com/intent/tweet?text='.$title.'&url='.$url.$by.$related;
		}

		/**
		 * @var $title 		string Título da página
		 * @var $url 		string Url da página
		 * @return	 		string Url para o Whatsapp
		 */
		public static function whatsapp($title, $url){
			$title = urlencode($title.' - '.$url);
			return 'whatsapp://send?text='.$title;
		}

	}
