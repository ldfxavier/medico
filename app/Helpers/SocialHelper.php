<?php
	/**
	 * CLASS PARA TRABALHAR COM AS API DE COMPARTILHAMENTO DAS REDES SOCIAIS
	 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
	 * @version 1.0.0
	**/
	namespace Helpers;

	final class Social {

		public function facebook($url){
			return 'https://www.facebook.com/sharer/sharer.php?u='.$url;
		}

		public function twitter($title, $url, $by = null, $related = null){
			$by = ($by == null) ? '' : '&via='.$by;
			$related = ($related == null) ? '' : '&related='.$related;
			return 'https://twitter.com/intent/tweet?text='.$title.'&url='.$url.$by.$related;
		}

		public function whatsapp($title, $url){
			$title = urlencode($title.' - '.$url);
			return 'whatsapp://send?text='.$title;
		}

	}
