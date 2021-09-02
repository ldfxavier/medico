<?php
    namespace App\Helpers;

    use \PHPMailer\PHPMailer\PHPMailer;

    require_once(__ROOT.'/files/phpmailer/Exception.php');
    require_once(__ROOT.'/files/phpmailer/OAuth.php');
    require_once(__ROOT.'/files/phpmailer/POP3.php');
    require_once(__ROOT.'/files/phpmailer/SMTP.php');
    require_once(__ROOT.'/files/phpmailer/PHPMailer.php');

    final class Email {

		private $erro_status, $erro_titulo, $erro_texto;
		private $dado = null;
        private $host_smtp, $porta_smtp, $login_smtp, $senha_smtp;
        private $liberar_debug;
        private $envio, $resposta;

		private $girar_email = [
			[
				'host' => 'mail.marktclub.com.br',
				'porta' => 587,
				'login' => 'nao-responda@marktclub.com.br',
				'senha' => 'Email@2016',
				'envio' => ['NÃO RESPONDA', 'nao-responda@marktclub.com.br'],
				'resposta' => ['NÃO RESPONDA', 'atendimento@marktclub.com.br']
			],
			[
				'host' => 'mail.marktclub.com.br',
				'porta' => 587,
				'login' => 'nao-responda2@marktclub.com.br',
				'senha' => 'Email@2016',
				'envio' => ['NÃO RESPONDA', 'nao-responda@marktclub.com.br'],
				'resposta' => ['NÃO RESPONDA', 'atendimento@marktclub.com.br']
			],
			[
				'host' => 'mail.marktclub.com.br',
				'porta' => 587,
				'login' => 'nao-responda3@marktclub.com.br',
				'senha' => 'Email@2016',
				'envio' => ['NÃO RESPONDA', 'nao-responda@marktclub.com.br'],
				'resposta' => ['NÃO RESPONDA', 'atendimento@marktclub.com.br']
			],
		];

        public function __construct($array = []){

            if($array):
                $this->dado = $array;
			endif;

			$this->setar_host([
				'host' => MAIL_HOST,
				'porta' => MAIL_PORTA,
				'login' => MAIL_USUARIO,
				'senha' => MAIL_SENHA,
				'envio' => MAIL_ENVIO,
				'resposta' => MAIL_RESPOSTA
			]);

			$this->liberar_debug = MAIL_DEBUG ? 2 : 0;

		}

		private function setar_erro(String $titulo, String $texto){

			$this->erro_status = true;
			$this->erro_titulo = $titulo;
			$this->erro_texto = $texto;

		}

		private function validar_host($dado){

			$host = $dado['host'] ?? false;
			$porta = $dado['porta'] ?? false;
			$login = $dado['login'] ?? false;
			$senha = $dado['senha'] ?? false;

			$envio = $dado['envio'] ?? $this->envio;
			$resposta = $dado['resposta'] ?? $this->resposta;

			if(empty($host)):
				$this->setar_erro('Campo obrigatório!', 'Você deve configurar o host do SMTP.');
			elseif(empty($porta)):
				$this->setar_erro('Campo obrigatório!', 'Você deve configurar a porta do SMTP.');
			elseif(empty($login)):
				$this->setar_erro('Campo obrigatório!', 'Você deve configurar o login do SMTP.');
			elseif(empty($senha)):
				$this->setar_erro('Campo obrigatório!', 'Você deve configurar o senha do SMTP.');
			elseif(!empty($envio) && (!is_array($envio) || count($envio) != 2)):
				$this->setar_erro('Campo obrigatório!', 'Nome e e-mail de envido não está no formato correto.');
			elseif(!empty($resposta) && (!is_array($resposta) || count($resposta) != 2)):
				$this->setar_erro('Campo obrigatório!', 'Nome e e-mail de resposta não está no formato correto.');
			endif;

		}

		private function setar_host($dado){

			$this->validar_host($dado);

			if($this->erro_status):
				return false;
			endif;

			$this->host_smtp = $dado['host'];
			$this->porta_smtp = $dado['porta'];
			$this->login_smtp = $dado['login'];
			$this->senha_smtp = $dado['senha'];

			$this->envio = $dado['envio'] ?? $this->envio;
			$this->resposta = $dado['resposta'] ?? $this->resposta;

		}

        private function pegar_dado($array = null){

            if($array == null && $this->dado == null):
                $this->setar_erro('Erro ao enviar e-mail', 'Não foi enviado os dado para o envio.');
            endif;

            return is_array($array) && !empty($array) ? $array : $this->dado;

		}

        private function validar_dado($array){

            if(!isset($array['titulo']) || empty($array['titulo'])):
                $this->setar_erro('Erro ao enviar e-mail', 'É obrigatório enviar um título para o e-mail.');
            elseif(!isset($array['nome']) || empty($array['nome'])):
                $this->setar_erro('Erro ao enviar e-mail', 'É obrigatório enviar o nome do usuário.');
            elseif(!isset($array['email']) || empty($array['email'])):
                $this->setar_erro('Erro ao enviar e-mail', 'É obrigatório enviar o e-mail do usuário.');
            elseif(!isset($array['mensagem']) || empty($array['mensagem'])):
                $this->setar_erro('Erro ao enviar e-mail', 'É obrigatório enviar uma mensagem para o e-mail.');
			endif;

			return $array;

		}

		/*
		|--------------------------------------------------------------------------
		| ENVIA UM E-MAIL
		|--------------------------------------------------------------------------
		|
		| Enviar option com Array
		| titulo = Título do e-mail que será enviado para o usuário
		| nome = Nome do usuário que recebera o e-mail
		| email = E-mail do usuário que recebera o e-mail
		| mensagem = String ou link da mensagem a ser enviada
		|
		|
		*/
		public function aleatorio(){

			$email = $this->girar_email[rand(0, (count($this->girar_email)-1) )];

			$this->setar_host([
				'host' => $email['host'],
				'porta' => $email['porta'],
				'login' => $email['login'],
				'senha' => $email['senha'],
				'envio' => $email['envio'],
				'resposta' => $email['resposta']
			]);

			return $this;

		}
        public function enviar(Array $option){

			$dado = $this->validar_dado($this->pegar_dado($option));

            if($this->erro_status):
                return $this->erro();
			endif;

            $titulo = $dado['titulo'];
            $nome = $dado['nome'];
            $email = $dado['email'];
            $mensagem = filter_var($dado['mensagem'], FILTER_VALIDATE_URL) ? file_get_contents($dado['mensagem']) : $dado['mensagem'];

			$envio_nome = $dado['envio_nome'] ?? $this->envio[0] ?? '';
            $envio_email = $dado['envio_email'] ?? $this->envio[1] ?? '';

			$resposta_nome = $dado['resposta_nome'] ?? $this->resposta[0] ?? '';
            $resposta_email = $dado['resposta_email'] ?? $this->resposta[1] ?? '';

			$copia_enviada = $dado['co'] ?? [];
			$copia_oculta = [];
            if(is_string($copia_enviada) && !empty($copia_enviada)):
				$copia_oculta = [$copia_enviada];
			elseif(is_array($copia_enviada) && !empty($copia_enviada)):
				foreach($copia_enviada as $valor):
					$copia_oculta[] = $valor;
				endforeach;
            endif;

			$arquivo_enviado = $dado['arquivo'] ?? [];
			$arquivo = [];
            if(is_string($arquivo_enviado) && !empty($arquivo_enviado)):
				$arquivo = [$arquivo_enviado];
			elseif(is_array($arquivo_enviado) && !empty($arquivo_enviado)):
				foreach($arquivo_enviado as $valor):
					$arquivo[] = $valor;
				endforeach;
            endif;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = $this->liberar_debug;
			if($this->host_smtp == 'smtp.gmail.com'):
				$mail->SMTPSecure = 'tls';
			endif;
            $mail->SMTPOptions = [
                'ssl' => [
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
                ]
            ];
            $mail->Host = $this->host_smtp;
            $mail->Username = $this->login_smtp;
            $mail->Password = $this->senha_smtp;
            $mail->Port = $this->porta_smtp;
            $mail->setFrom($envio_email, $envio_nome);
            $mail->addReplyTo($resposta_email, $resposta_nome);
            $mail->addAddress($email, $nome);

            if($copia_oculta):
                foreach($copia_oculta as $lista):
                    if(is_array($lista)):
                        $mail->addBCC($lista[0], isset($lista[1]) ? $lista[1] : '');
                    else:
                        $mail->addBCC($lista);
                    endif;
                endforeach;
            endif;
            if($arquivo):
                foreach($arquivo as $lista):
                    $mail->addAttachment($lista, $lista);
                endforeach;
            endif;

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $titulo;
            $mail->Body = $mensagem;
            $mail->AltBody = 'Ative o HTML da sua conta.';

            $enviar = $mail->send();

            if($enviar):
                return ['erro' => false];
            else:
                return ['erro' => true, 'titulo' => 'Erro ao enviar E-mail!', 'texto' => 'Erro: '.$mail->ErrorInfo];
            endif;
		}

		private function girar_email(){

			$lista = $this->girar_email;

			if($lista):
				foreach($lista as $ind => $val):
					$hora_de = '';
					$hora_ate = '';
					if(strstr($ind, '-')):
						$explode = explode('-', $ind);
						$hora_de = (Int)$explode[0];
						$hora_ate = (Int)$explode[1] ?? $hora_de;
					elseif(is_numeric($ind)):
						$hora_de = (Int)$ind;
						$hora_ate = $hora_de;
					endif;

					$hora_de = date('h');
					$hora_ate = date('h');
					if(is_numeric($hora_de) && is_numeric($hora_ate) && $hora_de >= $hora && $hora_ate <= $hora):
						$this->setar_host($val);
						break;
					endif;
				endforeach;
			endif;

		}

    }
