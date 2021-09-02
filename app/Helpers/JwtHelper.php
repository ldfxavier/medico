<?php

namespace App\Helpers;

final class Jwt
{

    private $jwt;
    public function __construct($jwt)
    {
        $this->jwt = $jwt;
    }

    public function header(String $campo = '')
    {

        $jwt = $this->jwt;
        $explode = explode('.', $jwt);

        if (count($explode) != 3) {
            return [];
        }

        $dado = json_decode(\base64_decode($explode[0]), true);
        $dado = is_array($dado) ? $dado : [];
        if (!empty($campo)) {
            return $dado[$campo] ?? '';
        }
        return $dado;

    }

    public function body(String $campo = '')
    {

        $jwt = $this->jwt;
        $explode = explode('.', $jwt);

        if (count($explode) != 3) {
            return [];
        }

        $dado = json_decode(\base64_decode($explode[1]), true);
        $dado = is_array($dado) ? $dado : [];
        if (!empty($campo)) {
            return $dado[$campo] ?? '';
        }
        return $dado;

    }

}
