<?php

namespace App\Models\Site;

use App\Helpers\Auth;
use App\Helpers\Converter;
use App\Helpers\Email;
use App\Helpers\Validar;
use App\Helpers\Upload;
use App\Marktclub\Api;
use System\Model;

final class UsuarioCliente extends Model
{

    public function __construct()
    {

        parent::__construct(TABELA_USUARIO_CLIENTE);

        $this->ERROR = [];

    }

    public function montar($dados)
    {
        $array = [];
        if ($dados):
            $converter = new Converter;
            foreach ($dados as $r):
                $nome = explode(' ', $r->nome);
                $endereco = '';
                $estado = !empty($r->estado) ? $converter->valor($r->estado)->caixa('A')->r() : '';
                $cep = !empty($r->cep) ? $converter->valor($r->cep)->cep()->r() : '';
                if (!empty($r->cep)):
                    $numero = !empty($r->numero) ? ', ' . $r->numero : '';
                    $complemento = !empty($r->complemento) ? ', ' . $r->complemento : '';
                    $endereco = $r->logradouro . $numero . $complemento . ', ' . $r->bairro . ' - ' . $r->cidade . '/' . $r->estado;
                endif;

                $array[] = (Object) [
                    'id' => $r->cod,
                    'nome_fantasia' => $r->nome_fantasia,
                    'logo' =>  (object) [
                        'valor' => $r->logo,
                        'link' => $logo,
                    ],
                    'email' => $r->email,
                    'nome' => (object) [
                        'valor' => $r->nome,
                        'primeiro' => $nome[0],
                        'ultimo' => end($nome) != $nome[0] ? end($nome) : '',
                    ],
                    'cpf' => $Converter->valor($r->cpf)->documento()->r(),
                    'endereco' => (object) [
                        'cep' => $Converter->valor($r->cep)->cep()->r(),
                        'logradouro' => $r->logradouro,
                        'numero' => $r->numero,
                        'complemento' => $r->complemento,
                        'referencia' => $r->referencia,
                        'bairro' => $r->bairro,
                        'cidade' => $r->cidade,
                        'estado' => $r->estado,
                    ]
                ];
            endforeach;
        endif;
        return $array;
    }

    public function salvar_cadastro($dado)
    { 

        $login = $dado['login'] ?? false;
        $senha = $dado['senha'] ?? false;
        $confirmar_senha = $dado['confirmar_senha'] ?? false;
        $nome = $dado['nome'] ?? false;
        $cpf = $dado['cpf'] ?? false;
        $email = $dado['email'] ?? false;
        $confirmar_email = $dado['confirmar_email'] ?? false;
        $telefone = $dado['telefone'] ?? false;
        $celular = $dado['celular'] ?? false;
        $cep = $dado['cep'] ?? false;
        $logradouro = $dado['logradouro'] ?? false;
        $numero = $dado['numero'] ?? false;
        $complemento = $dado['complemento'] ?? false;
        $referencia = $dado['referencia'] ?? false;
        $bairro  = $dado['bairro'] ?? false;
        $cidade = $dado['cidade'] ?? false;
        $estado = $dado['estado'] ?? false;

        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $telefone = preg_replace("/[^0-9]/", "", $telefone);
        $celular = preg_replace("/[^0-9]/", "", $celular);

        $contato = empty($telefone) && empty($celular) ? false : true;

        $validar = (new Validar)
            ->valor($login, 'Login')->obrigatorio()->vazio()
            ->valor($senha, 'Senha')->obrigatorio()->vazio()
            ->valor($senha, '', 'O campo senha e confirmar senha estão diferentes.')->igual($confirmar_senha)
            ->valor($nome, 'Nome ')->vazio()
            ->valor($cpf, 'CPF')->obrigatorio()->vazio()->documento()
            ->valor($telefone, 'Telefone')->telefone()
            ->valor($celular, 'Celular')->telefone()
            ->valor($cep, 'CEP')->obrigatorio()->vazio()->numero()->tamanho('=', 8)
            ->valor($logradouro, 'Logradouro')->obrigatorio()->vazio()
            ->valor($numero, 'Número')->obrigatorio()->vazio()
            ->valor($complemento, 'Complemento')->obrigatorio()->vazio()
            ->valor($bairro, 'Bairro')->obrigatorio()->vazio()
            ->valor($cidade, 'Cidade')->obrigatorio()->vazio()
            ->valor($estado, 'Estado')->obrigatorio()->vazio()
            ->valor($cpf, 'CPF')->obrigatorio()->vazio()
            ->valor($email, 'E-mail')->obrigatorio()->vazio()
            ->valor($confirmar_email, '', 'O campo email e confirmar email estão diferentes.')->igual($confirmar_email);

        if (!$validar->b()):
            return $validar->erro();
        endif;

        $array = [
            'cod' => uuid(),
            'nome' => $nome,
            'documento' => (Int) so_numero($documento),
            'telefone' => $telefone,
            'celular' => $celular,
            'cep' => so_numero($cep),
            'logradouro' => $logradouro,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'numero' => $numero,
            'complemento' => $complemento,
            'estado' => $estado,
            'referencia' => $referencia,
            'email' => $email,
            'login' => $login,
            'data_criacao' => date('Y-m-d H:i:s'),
            'data_atualizacao' => NULL,
            'status' => 1
        ];

        if (!empty($senha)):
            $array['senha'] = password_hash($senha, PASSWORD_DEFAULT, ['cost' => 11]);
            $array['data_senha'] = date('Y-m-d H:i:s');
        endif;

        $cadastrar = $this->dado($array)->insert();

        if (!isset($cadastrar['erro']) || false !== $cadastrar['erro']):
            return mensagem_erro('Erro!', 'Ocorreu um erro ao realizar seu cadastro, por favor, verifique os dados informados e tente novamente.', 400);
        endif;

        if (is_array($cadastrar) && isset($cadastrar['erro']) && false === $cadastrar['erro']) {
            return [
                'erro' => false,
                'link' => LINK_PADRAO . '/',
            ];
        }

    }


}
