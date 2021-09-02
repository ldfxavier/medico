<?php

namespace App\Controllers\Site;

use App\Helpers\Auth;
use App\Helpers\Validar;
use App\Marktclub\Api;
use App\Models\Site\UsuarioCliente;
use System\Controller;

class Index extends Controller
{

    public function index()
    {
        return View("site.index");
    }
    
    public function cadastro()
    {
        return view('site.cadastro');
    }

    public function sair()
    {

        (new Auth)->deletar('SITE');

        $sessao = ['RELATORIO', 'USUARIO',];

        foreach ($sessao as $valor):
            if (isset($_SESSION[$valor])):
                unset($_SESSION[$valor]);
            endif;
        endforeach;

        return Location(LINK . \Route::link('index.index'));

    }

    public function post_salvar_cadastro()
    {
        $dado = $this->POST();
	
        return (new UsuarioCliente)->salvar_cadastro($dado);

    }


}
