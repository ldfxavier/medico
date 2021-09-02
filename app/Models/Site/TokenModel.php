<?php

namespace App\Models\Site;

use App\Marktclub\Api;

class Token
{

    public function gerar_token(String $code, String $state)
    {

        $token = (new Api)->gerar_token([
            'code' => $code,
            'state' => $state,
        ])->array();

        if (!isset($token['erro']) || true === $token['erro']):
            return false;
        endif;

        $token = json_decode(base64_decode($token['autorization']), true);

        $_SESSION['TOKEN'] = $token['token'];

        if (!$this->buscar_usuario($token['usuario'] ?? '') || !$this->buscar_clube($token['clube'] ?? '')):
            return false;
        endif;

        return true;

    }

    private function montar_usuario($usuario)
    {

        $sobrenome = $usuario->nome->primeiro != $usuario->nome->ultimo ? ' ' . $usuario->nome->ultimo : '';
        $_SESSION['USUARIO'] = (Object) [
            'id' => $usuario->id,
            'nome' => $usuario->nome->primeiro . $sobrenome,
            'imagem' => $usuario->imagem,
            'estado' => $usuario->endereco->estado,
            'documento' => $usuario->documento,
            'sexo' => $usuario->sexo,
            'indicacao' => $usuario->indicacao,
            'federacao' => $usuario->federacao,
        ];

    }
    private function buscar_usuario($uuid)
    {

        if (empty($uuid)):
            return false;
        endif;

        $usuario = (new Api)->get('/usuario/' . $uuid)->object();

        if (!is_object($usuario) || !isset($usuario->id)):
            return false;
        endif;

        $this->montar_usuario($usuario);

        return true;

    }

    private function montar_clube($clube)
    {
        $_SESSION['CLUBE'] = $clube;
    }
    private function buscar_clube($uuid)
    {

        if (empty($uuid)):
            return false;
        endif;

        $clube = (new Api)->get('/clube/' . $uuid)->object();
        if (!is_object($clube) || !isset($clube->id)):
            return false;
        endif;

        $this->montar_clube($clube);

        return true;

    }

}
