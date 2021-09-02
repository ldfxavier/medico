<?php

namespace App\Marktclub;

abstract class Curl extends Config
{

    private $token = false, $status_html, $retorno;

    public function __construct()
    {

        $this->token = '';

        $token = $_SESSION['TOKEN'] ?? '';
        if (is_object($token) && isset($token->access_token)):
            $this->token = $token->access_token;
        endif;

    }

    public function retorno_array_object($tipo_retorno)
    {

        return json_decode($this->retorno, $tipo_retorno);

    }
    public function retorno_direto()
    {
        return $this->retorno;
    }

    private function enviar_requisicao_curl(String $metodo, String $url, array $dado = [], array $header = [])
    {

        $url = $this->link() . $url;

        if ($dado):

            $arrayDado = [];
            if ($metodo == 'GET' || (in_array($metodo, ['POST', 'PUT']) && isset($header['Content-Type']) && $header['Content-Type'] == 'application/x-www-form-urlencoded')):

                foreach ($dado as $ind => $val):
                    $arrayDado[] = $ind . '=' . urlencode($val);
                endforeach;

                $dado = implode('&', $arrayDado);

                if ($metodo == 'GET'):
                    $url .= '?' . $dado;
                    $dado = '';
                endif;

            endif;

        endif;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($header):

            $array_header = [];

            foreach ($header as $ind => $val):
                $array_header[] = $ind . ':' . $val;
            endforeach;

            curl_setopt($ch, CURLOPT_HTTPHEADER, $array_header);

        endif;

        if (!empty($dado) && !in_array($metodo, ['GET', 'DELETE'])):
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dado);
        endif;

        $retorno = curl_exec($ch);

        $status_html = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $erro = curl_error($ch);

        curl_close($ch);

        if ($erro):
            return ['erro' => true, 'erro' => $erro];
        endif;

        $this->retorno = $retorno;
        $this->status_html = $status_html;

    }

    public function enviar_get(String $url, array $dado = [], array $header = [])
    {

        if (!$header):
            $header = [
                'Content-Type' => 'application/json',
                'Token' => $this->token,
            ];
        endif;

        $this->enviar_requisicao_curl('GET', $url, $dado, $header);

    }

    public function enviar_post(String $url, array $dado = [], array $header = [])
    {

        if (!$header):
            $header = [
                'Token' => $this->token,
            ];
        endif;

        $dado = $this->enviar_requisicao_curl('POST', $url, $dado, $header);

    }
    public function enviar_put(String $url, array $dado = [], $id, array $header = [])
    {

        if (!$header):
            $header = [
                'Token' => $this->token,
                'content-type' => 'application/x-www-form-urlencoded',
            ];
        endif;

        $this->enviar_requisicao_curl('PUT', $url, $dado, $header);

        if ($this->status_html == 204):
            $this->retorno = '{"erro":false}';
        endif;

    }

    public function enviar_delete(String $url, $id, array $header = [])
    {

        if (!$header):
            $header = [
                'Token' => $this->token,
                'Content-Type' => 'application/json',
            ];
        endif;

        $this->enviar_requisicao_curl('DELETE', $url . '/' . $id, [], $header);

        $status = $dado['status_html'] ?? 0;

        if ($this->status_html == 204):
            $this->retorno = '{"erro":false}';
        endif;

    }

}
