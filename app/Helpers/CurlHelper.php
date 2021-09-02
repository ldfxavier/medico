<?php
namespace App\Helpers;

final class Curl
{

    private $header = [], $retorno, $opt = [], $url, $dado = [], $debug = false;

    public function __construct(String $url = '', String $retorno = 'array')
    {
        $this->url = $url;
        $this->retorno = $retorno;
    }

    private function limpar_dado_da_requisicao()
    {
        $this->header = [];
        $this->opt = [];
        $this->dado = [];
    }
    private function executar_curl(String $metodo, String $uri = '')
    {

        $url = !empty($uri) ? $this->url . $uri : $this->url;
        if (empty($url)):
            return ['erro' => true, 'titulo' => 'Campo obrigatório!', 'texto' => 'Você precisa enviar uma URL para a requisição.'];
        endif;

        $dado = [];
        if ($this->dado && in_array($metodo, ['GET', 'PUT'])):
            foreach ($this->dado as $ind => $val):
                $dado[] = $ind . '=' . urlencode($val);
            endforeach;
            $dado = implode('&', $dado);
            if ($metodo == 'GET'):
                $url .= '?' . $dado;
            endif;
        endif;

        if ($this->debug):
            ob_start();
            $out = fopen('php://output', 'w');
        endif;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
        if ($this->debug):
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_STDERR, $out);
        endif;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->header):
            $header = [];
            foreach ($this->header as $ind => $val):
                $header[] = $ind . ':' . $val;
            endforeach;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        endif;
        if (!empty($this->dado) && !in_array($metodo, ['GET', 'DELETE'])):
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->dado);
        endif;
        if ($this->opt):
            foreach ($this->opt as $ind => $val):
                curl_setopt($ch, $ind, $val);
            endforeach;
        endif;

        $retorno = curl_exec($ch);
        $erro = curl_error($ch);
        curl_close($ch);

        if ($this->debug):
            fclose($out);
            $debug = ob_get_clean();
            print_r($debug);
        endif;

        $this->limpar_dado_da_requisicao();

        if ($erro):
            return ['erro' => true, 'erro' => $erro];
        elseif ($this->retorno == 'array'):
            return is_array(json_decode($retorno, true)) ? json_decode($retorno, true) : $retorno;
        elseif ($this->retorno == 'object'):
            return is_array(json_decode($retorno, true)) ? json_decode($retorno, false) : $retorno;
        endif;
        return $retorno;
    }

    public function get(String $url = '')
    {
        return $this->executar_curl('GET', $url);
    }
    public function post(String $url = '')
    {
        return $this->executar_curl('POST', $url);
    }
    public function put(String $url = '')
    {
        return $this->executar_curl('PUT', $url);
    }
    public function delete(String $url = '')
    {
        return $this->executar_curl('DELETE', $url);
    }

    public function opt(array $array)
    {
        $this->opt = $array;
        return $this;
    }
    public function dado(array $array)
    {
        if (!empty($this->dado)):
            $this->dado = array_merge($this->dado, $array);
        else:
            $this->dado = $array;
        endif;
        return $this;
    }
    public function arquivo(array $array)
    {
        $lista = [];
        foreach ($array as $ind => $val):
            $lista[$ind] = curl_file_create($val, mime_content_type($val));
        endforeach;
        if (!empty($this->dado)):
            $this->dado = array_merge($this->dado, $lista);
        else:
            $this->dado = $lista;
        endif;
        return $this;
    }
    public function header(array $array)
    {
        $this->header = $array;
        return $this;
    }

}
