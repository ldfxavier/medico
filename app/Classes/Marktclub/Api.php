<?php

namespace App\Marktclub;

use App\Marktclub\Curl;

final class Api extends Curl
{

    private $dado = [], $header = [], $id = '';

    private $erro_status = false, $erro_titulo = '', $erro_texto = '';

    private function resetar()
    {

        $this->id = '';
        $this->dado = [];
        $this->header = [];

        $this->erro_status = false;
        $this->erro_titulo = '';
        $this->erro_texto = '';

        return $this;

    }

    public function pagina(Int $pagina)
    {

        $this->dado['pagina'] = $pagina;

        return $this;

    }

    public function quantidade(Int $quantidade)
    {

        $this->dado['quantidade'] = $quantidade;

        return $this;

    }

    public function ordem(String $ordem)
    {

        $this->dado['ordem'] = $ordem;

        return $this;

    }

    public function id($id)
    {

        $this->id = $id;

        return $this;

    }

    public function parametro(array $dado = [])
    {

        $this->dado = $dado;

        return $this;

    }

    public function header(array $dado = [])
    {

        $this->header = $dado;

        return $this;

    }
    public function arquivo(array $dado = [])
    {

        $lista = [];
        foreach ($dado as $ind => $val):
            if (file_exists($val)):
                $lista[$ind] = curl_file_create($val, mime_content_type($val));
            endif;
        endforeach;
        if (!empty($this->dado)):
            $this->dado = array_merge($this->dado, $lista);
        else:
            $this->dado = $lista;
        endif;

        return $this;

    }

    public function get(String $url)
    {

        $this->enviar_get($url, $this->dado, $this->header);

        return $this;

    }

    public function post(String $url)
    {

        $this->validar_dado();

        if ($this->erro_status):
            return $this;
        endif;

        $this->enviar_post($url, $this->dado, $this->header);

        return $this;

    }

    public function put(String $url)
    {

        // $this->validar_id()->validar_dado();

        if ($this->erro_status):
            return $this;
        endif;

        $this->enviar_put($url, $this->dado, $this->id, $this->header);

        return $this;

    }

    public function delete(String $url)
    {

        // $this->validar_id();

        if ($this->erro_status):
            return $this;
        endif;

        $this->enviar_delete($url, $this->id, $this->header);

        return $this;

    }

    public function gerar_token($dado)
    {

        if (!$this->validar_geracao_token($dado)):

            $this->setar_erro('Campo incorreto!', 'Ocorreu um erro ao fazer seu login.');
            return $this;

        endif;

        $this->post_token([
            'code' => $dado['code'],
            'state' => $dado['state'],
        ]);

        return $this;

    }

    public function deletar_token()
    {

        $this->put_token();

        return $this;

    }

    public function pegar_token($login)
    {

        $token = $_SESSION['TOKEN'] ?? false;
        $data = (new \App\Helpers\Data)->valor(date('Y-m-d H:i:s'))->remover('5', 'minutes')->formato('Y-m-d H:i:s');

        if (!$token):

            $token = $this->parametro([
                'login' => $login,
                'grant_type' => 'client_credentials',
                'client_id' => CLIENT_ID,
                'client_secret' => SECRET_ID,
                'scope' => 'voucher:validar publicidade:salvar empresa:listar relatorio:listar equipe:contato',
            ])->post('/auth/parceiro')->array() ?? '';

            if (isset($token['erro']) && $token['erro'] == true):
                return $token;
                exit();
            endif;

            $_SESSION['TOKEN'] = [
                'token' => $token,
                'login' => $login,
                'data' => date('Y-m-d H:i:s'),
            ];

            return $token;

        endif;

        return $_SESSION['TOKEN'];

    }

    function array() {

        if ($this->erro_status):
            return $this->erro();
        endif;

        $this->resetar();

        return $this->retorno_array_object(true);

    }

    public function object()
    {

        if ($this->erro_status):
            return $this->erro();
        endif;

        $this->resetar();

        return $this->retorno_array_object(false);

    }
    public function retorno()
    {

        return $this->retorno_direto();

    }
    public function r()
    {
        return $this->retorno_normal();
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS PRIVADOS
    |--------------------------------------------------------------------------
    |
    | Métodos privados da classe
    |
     */
    private function setar_erro($titulo, $texto)
    {

        $this->erro_status = true;
        $this->erro_titulo = $titulo;
        $this->erro_texto = $texto;

    }

    private function erro()
    {

        return mensagem_erro($this->erro_titulo, $this->erro_texto, 400);

    }

    private function validar_id()
    {

        if (false === $this->erro_status && (empty($this->id) || !is_numeric($this->id))):

            $this->setar_erro('Campo incorreto!', 'Você deve passar um ID.');

        endif;

        return $this;

    }

    private function validar_dado()
    {

        if (false === $this->erro_status && (empty($this->dado) || !is_array($this->dado))):

            $this->setar_erro('Campo incorreto!', 'Você deve passar pelo menos um dado.');

        endif;

        return $this;

    }

}
