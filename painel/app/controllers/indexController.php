<?php
	class indexController extends Controller {
		public function index(){
			header('LOCATION: '.PAINEL);
		}
	}
