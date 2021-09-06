<?php

namespace App\Controllers\Site;

use App\Helpers\Auth;
use App\Helpers\Validar;
use App\Models\Site\{UsuarioCliente, PublicidadeBanner, Site, Especialidade, Mensagem};
use System\Controller;

class Index extends Controller
{

    public function index()
    {
        return View("site.index", [
			'banner' => (new PublicidadeBanner)->home(),
			'dado' => (new Site)->home(),
			'especialidade' => (new Especialidade)->home()
		]);
    }
    

	public function popup_especialidade($url){
			
		$url = (new Especialidade)->url($url);

		return View('!site.popup_especialidade', [
			'dado' => $url
		]);

	}
	public function popup_sobre(){
			
		$sobre = (new Site)->sobre();


		return View('!site.popup_sobre', [
			'dado' => $sobre
		]);

	}

	public function post_salvar(){

		return (new Mensagem)->salvar($this->POST());

	}


}
