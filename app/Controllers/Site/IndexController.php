<?php

namespace App\Controllers\Site;

use App\Helpers\Auth;
use App\Helpers\Validar;
use App\Models\Site\{UsuarioCliente, PublicidadeBanner, Site, Especialidade, Mensagem, Formulario, Telemedicina};
use System\Controller;

class Index extends Controller
{

    public function index()
    {
        return View("site.index", [
			'banner' => (new PublicidadeBanner)->topo(),
			'banner_localiza' => (new PublicidadeBanner)->localizacao(),
			'legislacao' => (new Telemedicina)->local(1),
			'como_funciona' => (new Telemedicina)->local(2),
			'formulario' => (new Formulario)->url(),
			'dado' => (new Site)->home(),
			'galeria' => (new Site)->galeria(),
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

	public function popup_telemedicina($url){
			
		$url = (new Telemedicina)->url($url);

		return View('!site.popup_telemedicina', [
			'dado' => $url
		]);

	}

	public function post_salvar(){

		return (new Mensagem)->salvar($this->POST());

	}


}
