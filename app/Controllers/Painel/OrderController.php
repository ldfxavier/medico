<?php
	
	namespace App\Controllers\Painel;

	use System\Controller;
	
	class Order extends Controller {


		public function app($app, $campo, $tipo){

			$app_link = $app;
			$app = str_replace('-', '_', $app);

			$order = [];
			
			$config = [];
			if(file_exists(__ROOT.'/resources/views/painel/'.$app.'/config.php')):
				$config = include(__ROOT.'/resources/views/painel/'.$app.'/config.php');
			endif;

			$order[] = $config['app']['lista'][$campo]['campo'] ?? $campo;

			if(in_array($tipo, ['ASC', 'DESC'])):
				$order[] = $tipo;
			endif;

			$_SESSION['ORDER_'.$app] = $order;

			return location(LINK_PAINEL.'/app/'.$app_link);

		}

	}