<?php

namespace App\Controllers\Restrito;

use App\Helpers\Auth;
use App\Helpers\Validar;
use App\Marktclub\Api;
use App\Models\Site\UsuarioCliente;
use System\Controller;

class Login extends Controller
{

    public function index()
    {
        return View("!restrito.login_index");
    }
    


}
