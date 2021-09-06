<?php

	namespace App\Models\Site;

	use System\Model;
	use App\Helpers\{Email, Validar};

	final class Mensagem extends Model {

		public function __construct(){

			parent::__construct(TABELA_MENSAGEM);

		}

		public function salvar($dado){

			$nome = $dado['nome'] ?? false;
			$texto = $dado['mensagem'] ?? false;
			$telefone = $dado['telefone'] ?? false;
			$email = $dado['email'] ?? false;

			$validar = (new Validar)
			->valor($nome, 'Nome')->obrigatorio()->vazio()
			->valor($email, 'E-mail')->obrigatorio()->vazio()->email()
			->valor($telefone, 'Telefone')->obrigatorio()->vazio()->telefone()
			->valor($texto, 'Mensagem')->obrigatorio()->vazio();

			if(!$validar->b()):
				return $validar->erro();
			endif;

			$uuid = uuid();
			$salvar = $this->dado([
				'cod' => $uuid,
				'nome' => $nome,
				'texto' => $texto,
				'telefone' => (Int)preg_replace("/[^0-9]/", "", $telefone),
				'email' => $email,
				'data_criacao' =>  date('Y-m-d H:i:s'),
				'status' => 1
			])->insert();

			if(!isset($salvar['erro']) || false !== $salvar['erro']):
				return mensagem_codigo(500, 500);
			endif;

			if(!empty(MAIL_USUARIO)):
				$Email = new Email;
                $dados = [
					'titulo' => 'CONTATO',
					'nome' => 'SITE',
                    'email' =>  MAIL_USUARIO,
					'mensagem' => "<p><b>Nova mensagem do contato do site.</b></p><br><p>Nome: {$nome}</p> <p>Telefone: {$telefone}</p> <p>E-mail: {$email}</p> <p>Mensagem: {$texto}</p>"
                ];

                $email = $Email->enviar($dados);
			endif;


			return [
				'erro' => false,
				'status_html' => 201
			];

		}

	}
