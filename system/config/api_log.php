<?php

	if(__ROUTE_DIRETORIO == 'api'):

		class LogApi extends \System\Model {
			
			public function __construct(){
				parent::__construct('api_log');
			}

			public function salvar_log($retorno){

				$dado = $this->gerar_dado($retorno);
				if($dado):
					$this->dado($dado)->insert();
				endif;

			}

			private function gerar_dado($retorno){
				$rota = (__ROUTE_USO);

				if(isset($rota['erro'])):
					$metodo = '';
				else:
					$metodo = $rota['metodo'] ?? '';
				endif;

				if($metodo == 'VIEW'):
					return false;
				endif;

				if(isset($retorno['status_html'])):
					$status = $retorno['status_html'];
					unset($retorno['status_html']);
				else:
					$status = $_SERVER['REDIRECT_STATUS'] ?? '';
				endif;

				if(empty($metodo)):
					$metodo = $_SERVER['REQUEST_METHOD'] ?? '';
				endif;

				$ip = $_SERVER['REMOTE_ADDR'] ?? '';
				
				$dado = [];
				if(in_array($metodo, ['GET', 'VIEW'])):
					$dado = __GET;
				elseif($metodo == 'POST'):
					$dado = __POST;
				elseif($metodo == 'PUT'):
					$dado = __PUT;
				endif;

				if(isset($dado['senha']) && !empty($dado['senha'])):
					$dado['senha'] = password_hash($dado['senha'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['senha_atual']) && !empty($dado['senha_atual'])):
					$dado['senha_atual'] = password_hash($dado['senha_atual'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['senha_nova']) && !empty($dado['senha_nova'])):
					$dado['senha_nova'] = password_hash($dado['senha_nova'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['nova_senha']) && !empty($dado['nova_senha'])):
					$dado['nova_senha'] = password_hash($dado['nova_senha'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['senha_repetir']) && !empty($dado['senha_repetir'])):
					$dado['senha_repetir'] = password_hash($dado['senha_repetir'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['repetir_senha']) && !empty($dado['repetir_senha'])):
					$dado['repetir_senha'] = password_hash($dado['repetir_senha'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['password']) && !empty($dado['password'])):
					$dado['password'] = password_hash($dado['password'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['password1']) && !empty($dado['password1'])):
					$dado['password1'] = password_hash($dado['password1'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['password_1']) && !empty($dado['password_1'])):
					$dado['password_1'] = password_hash($dado['password_1'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['password2']) && !empty($dado['password2'])):
					$dado['password2'] = password_hash($dado['password2'], PASSWORD_DEFAULT, ['cost' => 11]);
				elseif(isset($dado['password_2']) && !empty($dado['password_2'])):
					$dado['password_2'] = password_hash($dado['password_2'], PASSWORD_DEFAULT, ['cost' => 11]);
				endif;

				$token = '';
				if(defined('API_TOKEN')):
					$token = API_TOKEN['token'];
				endif;
				
				return [
					'uuid' => uuid(),
					'token_utilizado' => $token,
					'retorno_api' => is_array($retorno) || is_object($retorno) ? json_encode($retorno) : $retorno,
					'metodo_utilizado' => $metodo,
					'dado_enviado' => !empty($dado) ? json_encode($dado) : '',
					'uri_acessada' => URL,
					'header_enviado' => getallheaders(),
					'ip_usuario' => $ip,
					'status_html' => $status,
					'data_criacao' => date('Y-m-d H:i:s'),
					'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
				];
			}
		}

		(new LogApi)->salvar_log($system);

	endif;