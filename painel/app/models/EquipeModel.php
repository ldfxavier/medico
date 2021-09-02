<?php
	class EquipeModel extends Model {

		public $_tabela = "usuario_equipe";

		public function montar($dados){
            $array = array();
            if($dados):
				$Status = new StatusModel;
				$quantidade = count($dados);
                foreach($dados as $r):
                    $nome = explode(' ', $r->nome);

					$equipe = [];
					$contato_lista = array();
					$endereco_lista = array();
					if($quantidade == 1):
						$Contato = new ContatoModel;
						$contato_lista = $Contato->lista($r->cod, 'equipe');
						$Endereco = new EnderecoModel;
						$endereco_lista = $Endereco->lista($r->cod, 'equipe');

						if($r->desenvolvedor == 1 || $r->admin == 1) $equipe = $this->admin(true);
						elseif(json_decode($r->gerente, true)) $equipe = $this->admin(false, json_decode($r->gerente, true));
					endif;

                    $array[] = (object)array(
                        'id' => $r->id,
						'empresa' => $r->empresa,
						'cod' => $r->cod,
						'facebook' => $r->facebook,
						'google' => $r->google,
						'tipo' => (object)[
							'texto' => '',
							'valor' => $r->tipo
						],
						'area' => (object)array(
							'texto' => $Status->nome('equipe', 'area', $r->area),
							'valor' => $r->area
						),
                        'nome' => (object)array(
                            'valor' => $r->nome,
                            'primeiro' => isset($nome[0]) ? $nome[0] : '',
                            'ultimo' => (!empty(end($nome))) ? end($nome) : ''
                        ),
						'contato' => $contato_lista,
						'endereco' => $endereco_lista,
                        'imagem' => empty($r->imagem) ? LINK.'/images/painel/usuario_grande.png?sz=' : $r->imagem,
						'login' => $r->login,
                        'documento' => (object)array(
                            'br' => Converter::documento($r->documento),
                            'valor' => $r->documento
                        ),
                        'aniversario' => (object)array(
                            'br' => Converter::data($r->aniversario, 'd/m/Y'),
                            'valor' => $r->aniversario
                        ),
                        'sexo' => (object)array(
                            'texto' => $Status->nome('equipe', 'sexo', $r->sexo),
                            'valor' => $r->sexo
                        ),
						'senha' => empty($r->salt) ? 2 : 1,
						'permissao' => (object)array(
							'valor' => $r->permissao,
							'lista' => Converter::json($r->permissao)
						),
						'data' => (object)array(
							'criacao' => Converter::data($r->data_criacao, 'd/m/Y H:m'),
							'atualizacao' => Converter::data($r->data_atualizacao, 'd/m/Y H:m'),
							'acesso' => Converter::data($r->data_acesso, 'd/m/Y H:m')
						),
						'ramal' => (object)[
							'id' => $r->ramal_id,
							'numero' => $r->ramal_numero
						],
						'mudar_senha' => ($r->mudar_senha == 1) ? 1 : 2,
						'admin' => ($r->admin == 1) ? 1 : 2,
						'gerente' => ($r->gerente == 1) ? 1 : 2,
						'equipe' => (object)[
							'lista' => Converter::json($r->equipe),
							'select' => $equipe,
							'valor' => $r->equipe
						],
						'desenvolvedor' => $r->desenvolvedor,
						'ramal' => (object)[
                            'id' => $r->ramal_id,
                            'numero' => $r->ramal_numero
                        ],
                        'status' => (object)array(
                            'texto' => $Status->nome('equipe', 'status', $r->status),
                            'valor' => $r->status,
                        )
                    );
                endforeach;

                return $array;

            endif;
        }

		public function admin($admin = false, $gerente = array()){
			$busca = false;
			if($admin):
				$busca = $this->read("", "`nome` ASC");
			elseif(is_array($gerente) && $gerente):
				$where = "`id` = '".implode("' OR `id` = '", $gerente)."'";
				$busca = $this->read($where, "`nome` ASC");
			endif;

			$array = [];
			if($busca) foreach($busca as $r) $array[$r->id] = $r->nome;
			return $array;
		}

		public function nome($id){
			$dado = $this->read("`id` = '{$id}'");
			if($dado) return $dado[0]->nome;
		}

		private function logar($equipe){
			$equipe = $this->montar($equipe);
			$_SESSION['EQUIPE'] = $equipe[0];
            $Painel = new PainelModel;
            $Painel->p_log('post-login');

			$this->update(array('data_acesso' => date('Y-m-d H:i:s')), "`id` = '{$equipe[0]->id}'");
			Auth::criar('PAINEL', md5(uniqid(time())));
			return Mensagem::ok();
		}
		public function login($login, $password){
			Validar::vazio($login, 'Login');
			Validar::vazio($password, 'Senha');

			$login_documento = preg_replace("/[^0-9]/", "", $login);
		
			$equipe = $this->read("`login` = '{$login}' OR `documento` = '{$login_documento}'");
			if(!$equipe) return Mensagem::erro('Usuário não encontrado!', 'Verifique o login digitado e tente novamente.');

			if($equipe[0]->status == 2) return Mensagem::erro('Usuário bloqueado!', 'Entre em contato com o suporte técnico para ativar sua conta.');
			elseif(!password_verify($password, $equipe[0]->salt)) return Mensagem::erro('Senha incorreta!', 'Verifique a senha digitada e tente novamente.');

			return $this->logar($equipe);
		}
		public function login_social($tipo, $id){
			Validar::vazio($tipo, 'Tipo de rede');
			Validar::vazio($id, 'Id da rede');

			$equipe = $this->read("`{$tipo}` = '{$id}'");

			if(!$equipe) return Mensagem::erro('Usuário não encontrado!', 'Não existe usuário vinculado a essa conta de rede social.');

			if($equipe[0]->status == 2) return Mensagem::erro('Usuário bloqueado!', 'Entre em contato com o suporte técnico para ativar sua conta.');

			return $this->logar($equipe);
		}

		public function lista($empresa, $tipo = 1){
			$desenvolvedor = (isset($_SESSION['EQUIPE']->desenvolvedor) && $_SESSION['EQUIPE']->desenvolvedor == 2) ? "`desenvolvedor` = '2' AND " : "";
			return $this->montar($this->read($desenvolvedor."`empresa` = '{$empresa}' AND `tipo` = '{$tipo}'"));
		}
		public function associacao(){
			return $this->montar($this->read("`tipo` = '2'"));
		}

		public function select($titulo = array(), $id = null){
			$id = ($id != null) ? "`id` != '{$id}' AND " : '';
			$array = array();
			if($titulo) foreach($titulo as $ind => $val) $array[$ind] = $val;

			$dados = $this->read($id."`desenvolvedor` = '2'");
			if($dados) foreach($dados as $r) $array[$r->id] = $r->nome;

			return $array;
		}

		public function permissao($equipe){
			$dado = $this->read("`id` = '{$equipe}'");
			if($dado):
				return array(
					'erro' => false,
					'permissao' => Converter::json($dado[0]->permissao)
				);
			endif;
			return array('erro' => true);
		}

		public function social($tipo, $id, $imagem){
			$equipe = $_SESSION['EQUIPE'];

			$dados = array(
				$tipo => $id,
				'imagem' => $imagem
			);
			$_SESSION['EQUIPE']->imagem = $imagem;
			$_SESSION['EQUIPE']->$tipo = $id;
			return $this->update($dados, "`id` = '{$equipe->id}'");
		}

		public function autorizacao($login, $password, $tipo = 3){
			if($tipo == 3) $login = $_SESSION['EQUIPE']->login;
			if(empty($login)) return Mensagem::erro('Erro!', 'Digite o login do administrador.');
			elseif(empty($password)) return Mensagem::erro('Erro!', 'Digite a senha.');

			$verificar = $this->read("`login` = '{$login}'");

			if(!$verificar) return Mensagem::erro('Erro!', 'Usuário não encontrado.');
			elseif(!password_verify($password, $verificar[0]->salt)) return Mensagem::erro('Erro!', 'Senha incorreta.');
			elseif($tipo == 1 && ($verificar[0]->admin != 1)) return Mensagem::erro('Erro!', 'Usuário sem permissão.');
			elseif($tipo == 2 && ($verificar[0]->admin != 1 && $verificar[0]->gerente != 1)) return Mensagem::erro('Erro!', 'Usuário sem permissão.');
			else return Mensagem::ok();
		}

		public function alterar_senha($atual, $password, $password_2){
			$equipe = $_SESSION['EQUIPE'];

			Validar::vazio($atual, 'Senha atual');
			Validar::vazio($password, 'Nova senha');
			Validar::diferente($password, $password_2, 'Nova senha', 'Repetir senha');

			$validar = $this->read("`id` = '{$equipe->id}'");
			if(!password_verify($atual, $validar[0]->salt)) return Mensagem::erro('Senha incorreta!', 'Verifique sua senha atual para continuar.');

			$dados = array(
				'salt' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]),
				'data_atualizacao' => date('Y-m-d H:i:s')
			);

			return $this->update($dados, "`id` = '{$equipe->id}'");
		}
		public function alterar_desbloquear($password){
			$equipe = $_SESSION['EQUIPE'];
			Validar::vazio($password, 'Senha');
			$validar = $this->read("`id` = '{$equipe->id}'");
			if(!password_verify($password, $validar[0]->salt)):
				return Mensagem::erro('Senha incorreta!', 'Verifique a senha digitada e tente novamente.');
			else:
				if(isset($_SESSION['BLOQUEADO'])) unset($_SESSION['BLOQUEADO']);
				return Mensagem::ok();
			endif;
		}
		public function mudar_senha(){
			$equipe = $_SESSION['EQUIPE'];
			$this->update(array('mudar_senha' => 2), "`id` = '{$equipe->id}'");
			$_SESSION['EQUIPE']->mudar_senha = false;
		}

		public function api($hash){
			$Painel = new PainelModel;
			$documento = $Painel->p_campo('usuario_usuario', 'documento', "`hash` = '{$hash}'");
			if(!$documento):
				header('LOCATION: '.PAINEL.'/login');
				exit();
			endif;
			$equipe = $this->read("`documento` = '{$documento}' AND `tipo` = '2'");
			if(!$equipe):
				header('LOCATION: '.PAINEL.'/login');
				exit();
			endif;

			$Painel->p_update('usuario_usuario', ['hash' => ''], "`documento` = '{$documento}'");

			$this->logar($equipe);
			header('LOCATION: '.PAINEL);
		}
		public function convenio($dados = null){
			if(!empty($dados)):
				foreach($dados as $ind => $val) $select[$ind] = $val;
			endif;

			$equipe = $this->read("`tipo` = '1' AND empresa = '1' AND status = '1' AND area = '2'");
			if(isset($equipe) && !empty($equipe)):
				foreach($equipe as $r):
					$select[$r->id] = $r->nome;
				endforeach;
			endif;
			return $select;
        }
        
        public function migrar_equipe(){            
            $dados = $this->query("SELECT * FROM `equipe`");

            foreach($dados as $r):
                $salvar = "";
    
                $de = ['Ã¡','Ã¢','Ã£','Ã©','Ãª','Ã­','Ã³','Ã´', 'Ãµ','Ãº','Ã¼','Ã§','Ã','Ã','Ã','Ã','Ã','Ã','Ã','Ã','Ã', 'Ã','Ã','Ã','Ã', 'â?', 'â??', 'ª', '°', ' Ã', 'Ã','Ã\u008d','ÃƒO','Ã‡ÃƒO','ÃƒO','NÃ£o','Ã‡Ãƒ','ACÌ§AÌƒO','í‡íƒO','CÌ§OS','IÌ','Â ','í‡A','ÂÂ°'];
                $para = ['á','â','ã','é','ê','í','ó','ô', 'õ','ú','ü','ç','Á','À','Â','Ã','É','Ê','Í','Ó','Ô', 'Õ','Ú','Ü','Ç','"','"', 'Âª', 'Â°', ' à', 'í','ão','ÇÃO','ÃO','NÃO','ÇÃ','ÇÃO','AÇÃO','ÇÃO','ÇOS','Í','','ÇA','º'];

                $dados_salvar = [
                    "cod" => md5(uniqid(time())),
                    "facebook" =>  $r->facebook,
                    "google" =>  $r->google,
                    "area" => $r->area,
                    "nome" => $r->nome,
                    "documento" => $r->documento,
                    "sexo" => $r->sexo,
                    "aniversario" => $r->aniversario,
                    "imagem" => $r->imagem,
                    "login" => $r->login,
                    "salt" => $r->salt,
                    "data_criacao" => $r->data_criacao,
                    "data_atualizacao" => $r->data_atualizacao,
                    "data_acesso" => $r->data_acesso,
                    "permissao" => json_decode($r->permissao),
                    "gerente" => $r->gerente,
                    "admin" => $r->admin,
                    "mudar_senha" => $r->mudar_senha,
                    "desenvolvedor" => $r->desenvolvedor,
                    "status" => $r->status == 1 ? 1 : 2
                ];
                $salvar = $this->insert($dados_salvar);
           
            endforeach;

            /* ppe($salvar);  */           
        }

        

	}
