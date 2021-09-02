<?php
	final class config {

		/**
		 * PADRÕES DO SISTEMA
		 */
		private $_sistema;
		private $_hash;

		/**
		 * CONFIGURAÇÕES PADRÕES
		 */
		private $_config_erro;
		private $_config_fuso;
		private $_config_https;
		private $_config_www;
		private $_config_emailsistema;

		/**
		 * LINKS DO SITE
		 */
		private $_link_url;
		private $_link_link;
		private $_link_arquivo;
		private $_link_painel;

		/**
		 * DADOS DO PDO
		 */
		private $_pdo_host;
		private $_pdo_banco;
		private $_pdo_usuario;
		private $_pdo_senha;

		/**
		 * DADOS PARA O HEADER
		 */
		private $_header_titulo;
		private $_header_descricao;
		private $_header_imagem;
		private $_header_robots;
		private $_header_keywords;
		private $_header_viewport;
		private $_header_charset;

		/**
		 * APIS DA GOOGLE E DO FACEBOOK
		 */
		private $_google_analytics;
		private $_google_client_key;
		private $_google_client_id;
		private $_facebook_key;

		/**
		 * DEMAIS DADOS QUE VEM POR LAÇO
		 */
		private $_imagem;
		private $_opcionais;
		private $_social;

		function __construct(){
			$this->setSistema();
		}

		/**
		 * VERIFICA O HASH DO GIT PARA CRIAR O CACHE
		**/
		private function setCache(){
			// Pega o hash do GIT para transformar no cache
			$cache = @exec('git rev-parse --verify HEAD 2> /dev/null') ?? '';
			$versao = file_exists('.versao') ?? '';

			if($cache != $versao || empty($cache) || empty($versao)):
				$cache = empty($cache) ?? '1';
				$arquivo = fopen('.versao', 'w+');
				fwrite($arquivo, $cache);
				fclose($arquivo);
			endif;
			//Define o CACHE
			define('CACHE', '?cache='.$cache);
		}

		/**
		 * COPIA OS HOOKS PARA O DIRETÓRIO DO GIT
		**/
		// private function hooks(){
		// 	if(!file_exists('.git/hooks/pre-commit')):
		//         @exec('cp .config/hooks/* .git/hooks/');
		//         if(!file_exists('.git/hooks/pre-commit')):
		//             echo 'Ocorreu um erro ao copiar os Hooks do git. Acesse .config/hooks e copie para .git/hooks e de permissão para o diretório.';
		//             exit();
		//         else:
		//             exec("chmod -R 775 .git/hooks");
		//         endif;
		//     endif;
        //
		// }

		private function setSistema(){
			include('qa.php');
			include('producao.php');

			$host = $_SERVER['HTTP_HOST'];
			if(strstr($host, ':')):
				$host = explode(':', $host)[0];
			endif;
			
			$protocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? 'https://' : 'http://';
			if(in_array($host, $qa_link['link'])):
				$this->_sistema = 'qa';
				$this->_header_robots = $qa_header['robots'];

				$this->_opcionais = $qa_opcionais;

				$this->_config_erro = $qa_config['erro'];
				$this->_config_https = $qa_config['https'];
				$this->_config_www = $qa_config['www'];
				$this->_config_emailsistema = $qa_config['emailsistema'];

				$this->_link_painel = $qa_link['painel'];
				$this->_link_arquivo = $qa_link['arquivo'];
				$this->_link_diretorio = $qa_link['diretorio'];
				$this->_link_template = $qa_link['template'];

				$this->_pdo_host = $qa_pdo['host'];
				$this->_pdo_banco = $qa_pdo['banco'];
				$this->_pdo_usuario = $qa_pdo['usuario'];
				$this->_pdo_senha = $qa_pdo['senha'];

				$this->_google_analytics = $qa_google['analytics'];
				$this->_google_client_key = $qa_google['client_key'];
				$this->_google_client_id = $qa_google['client_id'];
				$this->_facebook_key = $qa_facebook['key'];
			
				if($qa_config['https'] === true):
					$protocolo = 'https://';
				elseif($qa_config['https'] === false):
					$protocolo = 'http://';
				endif;

				//$this->hooks();
			elseif((is_array($link['link']) && in_array($host, $link['link'])) || ($link['link'] == '*' || $link['link'] == $host)):
				$this->_sistema = 'producao';
				$this->_header_robots = $header['robots'];

				$this->_opcionais = $opcionais;

				$this->_config_erro = $config['erro'];
				$this->_config_https = $config['https'];
				$this->_config_www = $config['www'];
				$this->_config_emailsistema = $config['emailsistema'];

				$this->_link_painel = $link['painel'];
				$this->_link_arquivo = $link['arquivo'];
				$this->_link_diretorio = $link['diretorio'];
				$this->_link_template = $link['template'];

				$this->_pdo_host = $pdo['host'];
				$this->_pdo_banco = $pdo['banco'];
				$this->_pdo_usuario = $pdo['usuario'];
				$this->_pdo_senha = $pdo['senha'];

				$this->_google_analytics = $google['analytics'];
				$this->_google_client_key = $google['client_key'];
				$this->_google_client_id = $google['client_id'];
				$this->_facebook_key = $facebook['key'];
			
				if($config['https'] === true):
					$protocolo = 'https://';
				elseif($config['https'] === false):
					$protocolo = 'http://';
				endif;
			
			else:
				include('system/.erro/0001.php');
				exit(0);
			endif;
            $raiz = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
            if($qa_config['https'] === true):	
                $protocolo = 'https://';	
            elseif($qa_config['https'] === false):	
                $protocolo = 'http://';	
            endif;

            if($config['https'] === true):
                $protocolo = 'https://';
            elseif($config['https'] === false):
                $protocolo = 'http://';
            endif;
			$this->_link_link = $protocolo.$_SERVER['HTTP_HOST'].$raiz;
			$this->_link_painel = str_replace('{{LINK}}', $this->_link_link, $this->_link_painel);
			$this->_link_arquivo = str_replace('{{LINK}}', $this->_link_link, $this->_link_arquivo);
			$this->_link_url = $this->_link_link.((isset($_GET['url'])) ? '/'.$_GET['url'] : '');

			$this->_header_titulo = $header['titulo'];
			$this->_header_descricao = $header['descricao'];
			$this->_header_imagem = str_replace('{{LINK}}', $this->_link_link, $header['imagem']);
			$this->_header_keywords = $header['keywords'];
			$this->_header_viewport = $header['viewport'];
			$this->_header_charset = $header['charset'];
			$this->_config_fuso = $config['fuso'];

			$this->_imagem = $imagem;
			$this->_social = $social;

			if(!isset($_SESSION['HASH'])) $_SESSION['HASH'] = md5(uniqid(time()));
			$this->_hash = $_SESSION['HASH'];

			$this->setCache();
			$this->setDefines();
		}

		private function setDefines(){
			define('TITULO', $this->_header_titulo);
			define('DESCRICAO', $this->_header_descricao);
			if(!empty($this->_header_imagem)) define('IMAGEMSOCIAL', $this->_header_imagem);
			define('ROBOTS', $this->_header_robots);
			define('KEYWORDS', $this->_header_keywords);
			define('VIEWPORT', $this->_header_viewport);
			define('CHARSET', $this->_header_charset);
			define('EMAILSISTEMA', $this->_config_emailsistema);

			define('HASH', $this->_hash);

			define('LINK', $this->_link_link);
			define('URL', $this->_link_url);
			define('PAINEL', $this->_link_painel);
			define('ARQUIVO', $this->_link_arquivo);
			define('DIRETORIO', $this->_link_diretorio);
			define('TEMPLATE', $this->_link_template);

			define('PDOHOST', $this->_pdo_host);
			define('PDOBANCO', $this->_pdo_banco);
			define('PDOUSUARIO', $this->_pdo_usuario);
			define('PDOSENHA', $this->_pdo_senha);

			define('GOOGLEANALYTICS', $this->_google_analytics);
			define('GOOGLECLIENTKEY', $this->_google_client_key);
			define('GOOGLECLIENTID', $this->_google_client_id);
			define('FACEBOOKKEY', $this->_facebook_key);

			define('SISTEMA', $this->_sistema);

			if($this->_imagem) foreach($this->_imagem as $ind => $valores) define(mb_strtoupper($ind, 'UTF-8'), str_replace("{{LINK}}", $this->_link_link, $valores));
			if($this->_social) foreach($this->_social as $ind => $valores) define(mb_strtoupper($ind, 'UTF-8'), str_replace("{{LINK}}", $this->_link_link, $valores));
			if($this->_opcionais) foreach($this->_opcionais as $ind => $valores) define(mb_strtoupper($ind, 'UTF-8'), str_replace("{{LINK}}", $this->_link_link, $valores));
		}

		public function getSistema(){
			return $this->_sistema;
		}

		public function getHeader(){
			return (object)array(
				'titulo' => $this->_header_titulo,
				'descricao' => $this->_header_descricao,
				'imagem' => $this->_header_imagem,
				'robots' => $this->_header_robots,
				'keywords' => $this->_header_keywords,
				'viewport' => $this->_header_viewport,
				'charset' => $this->_header_charset
			);
		}

		public function getConfig(){
			return (object)array(
				'erro' => $this->_config_erro,
				'fuso' => $this->_config_fuso,
				'https' => $this->_config_https,
				'www' => $this->_config_www,
				'email' => $this->_config_emailsistema
			);
		}

		public function getLink(){
			return (object)array(
				'link' => $this->_link_link,
				'url' => $this->_link_url,
				'painel' => $this->_link_painel,
				'arquivo' => $this->_link_arquivo
			);
		}

	}
