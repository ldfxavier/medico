<?php
    class painelController extends Controller {

        public function init(){
            $_SESSION['MENU'] = isset($_SESSION['MENU']) && !empty($_SESSION['MENU']) ? $_SESSION['MENU'] : 'aberto';

            $action = $this->getSep(1);
            $array = ['dashboard', 'ligar', 'sessao', 'index', 'incorporar', 'analytics', 'app', 'pre_visualizacao', 'visualizar', 'add', 'editar', 'relatorio', 'download', 'busca', 'historico_lista', 'contato', 'endereco', 'agenda', 'post_atualizar_unico', 'post_salvar', 'post_deletar', 'post_historico', 'post_contato', 'post_contato_deletar', 'download_gerar', 'post_login', 'post_login_social', 'post_busca_principal', 'post_busca', 'post_busca_remover', 'post_autorizacao', 'post_desbloquear', 'post_alterar_senha', 'post_mudar_senha', 'post_upload_arquivo', 'post_upload_arquivo_simples', 'post_social', 'post_upload_imagem', 'post_endereco', 'post_endereco_deletar', 'api_cep', 'api_mapa'];

            if(in_array($action, $array)):
                if(isset($_POST['ajax']) && !Auth::validar('PAINEL', false)) $this->negado('login');
                else Auth::validar('PAINEL');
            endif;
        }

        private function permissao($controller, $acao = null, $retorno = false){
            if(!Permissao::Validar($controller, $acao)):
                if($retorno):
                    echo json_encode(array('erro' => true, 'titulo' => 'Erro!', 'texto' => 'Você não tem permissão para acessar essa área ou está deslogado.'));
                    exit();
                else:
                    $this->negado();
                endif;
            endif;
        }

        public function ligar(){
            $dados['cod'] = $this->getSep(2);
            $this->view('!painel.agenda.include.ligar', $dados);
        }

        public function sessao(){
            if(!isset($_POST['nome']) || !isset($_POST['valor'])) return false;
            $_SESSION[$_POST['nome']] = $_POST['valor'];
        }

        public function converter_link(){
            $acao = $this->getSep(2);
            $app = $this->getSep(3);
            $valor = $this->getSep(4);

            $Painel = new PainelModel;
            if($acao == 'id-cod') $valor = $Painel->p_campo($app, 'cod', "`id` = '{$valor}'");
            elseif($acao == 'cod-id') $valor = $Painel->p_campo($app, 'id', "`cod` = '{$valor}'");

            header("LOCATION: ".PAINEL.'/visualizar/'.$app.'/'.$valor);
        }

        public function index(){
            header('LOCATION: '.PAINEL.'/dashboard');
        }
        public function negado($pagina = ''){
            $this->getPar('par');
            $pagina = !empty($pagina) ? '_'.$pagina : '';
            $this->view('!painel.negado'.$pagina);
            exit();
        }
        public function incorporar(){
            $app = $this->getSep(2);
            $pagina = $this->getSep(3);

            $dados['par'] = $this->getPar('par');
            $dados['app'] = $app;
            $dados['pagina'] = $pagina;
            $dados['post'] = isset($_POST) ? $_POST : array();

            $template = ($this->getPar('template')) ? '' : '!';
            $this->view($template.'painel.'.$app.'.include.'.$pagina, $dados);
        }

        public function login(){
            Auth::login('PAINEL');
            $this->view('!painel.login');
        }
        public function sair(){
            Auth::deletar('PAINEL');
            if(isset($_SESSION['BLOQUEADO'])) unset($_SESSION['BLOQUEADO']);
            if(isset($_SESSION['PAINEL_REDIRECIONAR'])) unset($_SESSION['PAINEL_REDIRECIONAR']);
            if(isset($_SESSION['EQUIPE'])) unset($_SESSION['EQUIPE']);
            header('LOCATION: '.PAINEL.'/login');
        }

        public function analytics(){
            $app = str_replace('-', '_', $this->getSep(2));
            $this->permissao('analytics', $app);

            $dados['cod'] = $this->getSep(3);
            $dados['app'] = $app;
            $dados['post'] = isset($_POST) ? $_POST : '';
            $this->view('painel.analytics.'.$app.'.index', $dados);
        }
        public function dashboard(){
            $app = !empty($this->getSep(2)) ? $this->getSep(2) : 'perfil';
            if(!in_array($app, array('perfil', 'modelos'))) $this->erro();

            $dados['app'] = 'dashboard';
            $dados['pagina'] = $app;
            $this->view('painel.dashboard.index', $dados);
        }
        public function app(){
            Auth::validar('PAINEL');
            $app = $this->getSep(2);

            $this->permissao($app, 'visualizar');

            $pagina = isset($_SESSION['PAGINA_'.$app]) ? $_SESSION['PAGINA_'.$app] : 1;
            if($this->getPar('pagina') && is_numeric($this->getPar('pagina'))):
                $pagina = $this->getPar('pagina');
                $_SESSION['PAGINA_'.$app] = $this->getPar('pagina');
            endif;

            $where = isset($_SESSION['WHERE_'.$app]) ? $_SESSION['WHERE_'.$app] : '';
            $order = isset($_SESSION['ORDER_'.$app]) ? $_SESSION['ORDER_'.$app] : '';

            if(!empty($this->getPar('ordem'))):
                $order = $this->getPar('ordem');
                $_SESSION['ORDER_'.$app] = $this->getPar('ordem');
            endif;

            $dados['app'] = $app;
            $dados['where'] = $where;
            $dados['order'] = $order;
            $dados['pagina'] = $pagina;
            $dados['post'] = isset($_POST) ? $_POST : [];

            $this->view('painel.'.$app.'.index', $dados);
        }

        public function pre_visualizacao(){
            $app = $this->getSep(2);
            $this->permissao($app, 'visualizar');

            $dados['app'] = $app;
            $Painel = new PainelModel;
            $dados['dado'] = $Painel->p_previsualizacao($app, $_POST['dados']);
            $dados['pre_visualizacao'] = true;

            if($dados['dado']) $this->view('!painel.'.$app.'.visualizar', $dados);
        }
        public function visualizar(){
            $app = $this->getSep(2);
            $cod =  $this->getSep(3);

            $this->permissao($app, 'detalhe');
            $Painel = new PainelModel;
            $dado = $Painel->p_cod($app, $cod);
            if(!$dado) $this->erro();

            $dados['app'] = $app;
            $dados['dado'] = $dado;
            $dados['par'] = $this->getPar('par');

            $this->view('painel.'.$app.'.visualizar', $dados);
        }
        public function add(){
            $app = $this->getSep(2);

            $this->permissao($app, 'add');

            $Painel = new PainelModel;
            $dados['coluna'] = $Painel->p_coluna($app);

            $dados['app'] = $app;
            $dados['tipo'] = 'add';
            $dados['par'] = $this->getPar('par');

            $template = isset($_POST['ajax']) ? '!' : '';
            $this->view($template.'painel.'.$app.'.add', $dados);
        }
        public function editar(){
            $app = $this->getSep(2);
            $cod = $this->getSep(3);

            $this->permissao($app, 'editar');

            $Painel = new PainelModel;
            $dado = $Painel->p_cod($app, $cod);
            if(!$dado) $this->erro();

            $Painel = new PainelModel;
            $dados['coluna'] = $Painel->p_coluna($app);

            $dados['app'] = $app;
            $dados['dado'] = $dado;
            $dados['tipo'] = 'editar';
            $dados['par'] = $this->getPar('par');

            $template = isset($_POST['ajax']) ? '!' : '';
            $this->view($template.'painel.'.$app.'.editar', $dados);
        }
        public function relatorio(){
            $app = $this->getSep(2);

            $this->permissao($app, 'relatorio');

            $dados['app'] = $app;
            $this->view('painel.'.$app.'.relatorio', $dados);
        }
        public function download(){
            $app = $this->getSep(2);

            $this->permissao($app, 'download');

            $Painel = new PainelModel;
            $dados['coluna'] = $Painel->p_coluna($app);
            $dados['app'] = $app;

            $this->view('!painel.'.$app.'.download', $dados);
        }
        public function download_gerar(){
            if(!isset($_POST['app']) || !isset($_POST['coluna'])) exit();
            $this->permissao($_POST['app'], 'download', true);
            $Painel = new PainelModel;
            echo $Painel->p_download($_POST['app'], $_POST['coluna']);
        }
        public function download_historico(){
            $app = $this->getSep(2);

            $this->permissao($app, 'download');

            $Painel = new PainelModel;
            $dados['app'] = $app;

            $this->view('!painel.'.$app.'.download_historico', $dados);
        }
		public function download_historico_gerar(){
			if(!isset($_POST['app'])) exit();
			$this->permissao($_POST['app'], 'download', true);
			$Painel = new PainelModel;
			echo $Painel->p_download_historico($_POST['app'], $_POST['titulo'], $_POST['equipe'], $_POST['cadastro_de'], $_POST['cadastro_ate']);
		}
        public function busca(){
            $app = $this->getSep(2);

            $this->permissao($app, 'visualizar');

            $dados['app'] = $app;
            $this->view('!painel.'.$app.'.busca', $dados);
        }

        public function historico_lista(){
            $dados['app'] = $_POST['app'];
            $dados['cod'] = $_POST['cod'];
            $dados['pagina'] = $_POST['pagina'];

            $this->view('!painel.padrao.historico.lista', $dados);
        }

        public function contato(){
            $acao = $this->getSep(2);
            if($acao == 'editar'):
                $Contato = new ContatoModel;
                $dados['dado'] = $Contato->id($_POST['id']);
                if(!$dados['dado']) exit();
            endif;
            $dados['cod'] = isset($_POST['cod']) ? $_POST['cod'] : '';
            $dados['app'] = isset($_POST['app']) ? $_POST['app'] : '';
            $dados['bloco'] = isset($_POST['bloco']) ? $_POST['bloco'] : '';
            $dados['local'] = isset($_POST['local']) ? $_POST['local'] : '';
            $dados['acao'] = $acao;
            $this->view('!painel.padrao.contato.add', $dados);
        }
        public function endereco(){
            $acao = $this->getSep(2);
            if($acao == 'editar'):
                $Endereco = new EnderecoModel;
                $dados['dado'] = $Endereco->id($_POST['id']);

                if(!$dados['dado']) exit();
            endif;
            $dados['cod'] = isset($_POST['cod']) ? $_POST['cod'] : '';
            $dados['app'] = isset($_POST['app']) ? $_POST['app'] : '';
            $dados['bloco'] = isset($_POST['bloco']) ? $_POST['bloco'] : '';
            $dados['local'] = isset($_POST['local']) ? $_POST['local'] : '';
            $dados['acao'] = $acao;
            $this->view('!painel.padrao.endereco.add', $dados);
        }
        public function agenda(){
            $dados['cod'] = isset($_POST['cod']) ? $_POST['cod'] : '';
            $dados['app'] = isset($_POST['app']) ? $_POST['app'] : '';
            $dados['bloco'] = isset($_POST['bloco']) ? $_POST['bloco'] : '';
            $dados['local'] = isset($_POST['local']) ? $_POST['local'] : '';
            $this->view('!painel.padrao.agenda.add', $dados);
        }

        public function post_atualizar_unico(){
            $app = $_POST['app'];
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $valor = $_POST['valor'];

            $Painel = new PainelModel;
            echo $Painel->p_atualizar($app, $id, $nome, $valor);
        }
        public function post_salvar(){
            $app = $_POST['app'];
            $dados = $_POST['dados'];

            $acao = 'add';
            if(isset($dados['id']) && !empty($dados['id'])):
                if($app != 'foto'):
                    $this->permissao($app, 'editar', true);
                endif;
                $acao = 'update';
            else:
                $this->permissao($app, 'add', true);
            endif;

            $Painel = new PainelModel;

            if(file_exists('app/views/painel/'.$app.'/include/_post_salvar.php')):
                include('app/views/painel/'.$app.'/include/_post_salvar.php');
            endif;

            $salvar = $Painel->p_salvar($app, $dados);
            if(isset($salvar['erro']) && $salvar['erro'] == false && file_exists('app/views/painel/'.$app.'/include/_post_pos_salvar.php')):
                include('app/views/painel/'.$app.'/include/_post_pos_salvar.php');
            endif;
            echo json_encode($salvar);
        }
        public function post_deletar(){
            $dados = $_POST['dados'];
            $app = $_POST['app'];

            if($app != "arquivo"):
                $this->permissao($app, 'deletar', true);
            endif;

            $Painel = new PainelModel;

			$dados = (isset($_POST['dados'])) ? $_POST['dados'] : [];

            if(file_exists('app/views/painel/'.$app.'/include/_post_deletar.php')):
                include('app/views/painel/'.$app.'/include/_post_deletar.php');
            endif;

            $deletar = $Painel->p_deletar($app, $dados);

            if(empty($deletar) && file_exists('app/views/painel/'.$app.'/include/_post_pos_deletar.php')):
                include('app/views/painel/'.$app.'/include/_post_pos_deletar.php');
            endif;
            echo json_encode($deletar);
        }

        public function post_historico(){
            $dados['tabela'] = $_POST['app'];
            $dados['cod'] = $_POST['cod'];
            $dados['tipo'] = $_POST['tipo'];
            $dados['texto'] = $_POST['texto'];
            $booleano = (isset($_POST['booleano']) && !empty($_POST['booleano'])) ? $_POST['booleano'] : '';

			$app = explode(',', $dados['tabela']);

			foreach($app as $r):
	            if(file_exists('app/views/painel/'.$r.'/include/_post_historico.php')):
	                include('app/views/painel/'.$r.'/include/_post_historico.php');
	            endif;
			endforeach;

            $Historico = new HistoricoModel;
            $salvar = $Historico->salvar($dados);
            $salvar = json_decode($salvar);

            if(!empty($salvar) && $salvar->erro != 1):
    			foreach($app as $r):
    	            if(file_exists('app/views/painel/'.$r.'/include/_post_pos_historico.php')):
    	                include('app/views/painel/'.$r.'/include/_post_pos_historico.php');
    	            endif;
    			endforeach;
            endif;

            echo json_encode($salvar);
        }

        public function post_contato(){
            $_POST['tabela'] = Permissao::tabela($_POST['app']);
            unset($_POST['app']);

            $Contato = new ContatoModel;
            if(isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id']):
                echo $Contato->editar($_POST);
            else:
                echo $Contato->salvar($_POST);
            endif;
        }
        public function post_contato_deletar(){
            $Contato = new ContatoModel;
            echo $Contato->deletar($_POST['id']);
        }

        public function post_login(){
            if(!isset($_POST['ajax'])) exit();
            $model = new EquipeModel;
            $Painel = new PainelModel;
            $Painel->p_log($this->getSep(1));
            echo $model->login($_POST['login'], $_POST['password']);
        }
        public function post_login_social(){
            if(!isset($_POST['ajax'])) exit();
            $model = new EquipeModel;
            echo $model->login_social($_POST['tipo'], $_POST['id']);
        }

        public function post_busca_principal(){
            $dados['busca'] = $_POST['busca'];
            $this->view('!painel.padrao.busca.lista', $dados);
        }
        public function post_busca(){
            $app = $this->getSep(2);

            $this->permissao($app, 'visualizar');
            $where = '';
            if(file_exists('app/views/painel/'.$app.'/include/_post_busca.php') && $_POST):
                include('app/views/painel/'.$app.'/include/_post_busca.php');
            elseif(isset($_POST)):
                $post = $_POST;
                $where = [];
                foreach($post as $ind => $val):
                    if(!empty($ind) && !empty($val)):
                        if($ind == 'busca_especial'):
                            $_SESSION['WHERE_'.$app] = [$ind => $val];
                            $_SESSION['PAGINA_'.$app] = 1;
                            header('LOCATION: '.PAINEL.'/app/'.$app);
                            exit();
                        endif;


                        if(strstr($ind, 'JSONLIKE|')) $sep = 'JSONLIKE';
                        elseif(strstr($ind, 'LIKE|')) $sep = 'LIKE';
                        else $sep = '=';
                        $ind = str_replace(array('JSONLIKE|', 'LIKE|'), '', $ind);

                        $campo_explode = explode(',', $ind);
                        $campo = array();
                        foreach($campo_explode as $r):
                            if(strstr($val, '||')):
                                $valores = explode('||', $val);
                                if($sep == 'LIKE'):
                                    $campo[] = "`".$r."` LIKE '%".implode("%' OR `".$r."` LIKE '%", $valores)."'";
                                elseif($sep == 'JSONLIKE'):
                                    $campo[] = "`".$r."` LIKE '%\"".implode("\"%' OR `".$r."` LIKE '%\"", $valores)."\"%'";
                                else:
                                    $campo[] = "`".$r."` = '".implode("' OR `".$r."` = '", $valores)."'";
                                endif;
                            else:
                                if($sep == 'LIKE'):
                                    $campo[] = "`".$r."` LIKE '%".$val."%'";
                                elseif($sep == 'JSONLIKE'):
                                    $campo[] = "`".$r."` LIKE '%\"".$val."\"%'";
                                else:
                                    $campo[] = "`".$r."` = '".$val."'";
                                endif;
                            endif;
                        endforeach;
                        $where[] = '('.implode(' OR ', $campo).')';
                    endif;
                endforeach;
                $where = implode(' AND ', $where);
            endif;

            $_SESSION['WHERE_'.$app] = $where;
            $_SESSION['PAGINA_'.$app] = 1;
            $Painel = new PainelModel;

            $Painel->p_log($this->getSep(1), $_POST, '', $app);
            header('LOCATION: '.PAINEL.'/app/'.$app);
        }

        public function post_busca_remover(){
            $app = $this->getSep(2);
            if(isset($_SESSION['WHERE_'.$app])) unset($_SESSION['WHERE_'.$app]);
            $_SESSION['PAGINA_'.$app] = 1;
            header('LOCATION: '.PAINEL.'/app/'.$app);
        }

        public function post_autorizacao(){
            $login = $_POST['login'];
            $password = $_POST['password'];
            $tipo = $_POST['tipo'];

            $Equipe = new EquipeModel;
            echo $Equipe->autorizacao($login, $password, $tipo);
        }

        public function post_desbloquear(){
            $Equipe = new EquipeModel;
            echo $Equipe->alterar_desbloquear($_POST['password']);
        }
        public function post_alterar_senha(){
            $Equipe = new EquipeModel;
            echo $Equipe->alterar_senha($_POST['atual'], $_POST['password'], $_POST['password_2']);
        }
        public function post_mudar_senha(){
            $Equipe = new EquipeModel;
            echo $Equipe->mudar_senha();
        }

        public function post_social(){
            $tipo = $_POST['tipo'];
            $id = $_POST['id'];
            $imagem = $_POST['imagem'];

            $Equipe = new EquipeModel;
            echo $Equipe->social($tipo, $id, $imagem);
        }

        public function post_upload_csv(){
			if(!$_FILES):
				echo json_encode(array(
					'erro' => true,
					'titulo' => 'Erro!',
					'texto' => 'Nenhum arquivo enviado.'
				));
			else:
                $file = $_FILES['arquivo'];
				$arquivo = $file['tmp_name'];
				$e_ext = explode('/', $file['type']);
				$ext = str_replace('jpeg', 'jpg', Converter::caixa(isset($e_ext[1]) ? $e_ext[1] : '', 'a'));
				if($ext == "comma-separated-values"):
					$ext = "csv";
				endif;
				$nome = date('Y-m-d\_H:i:s')."_".time().".".$ext;

				if($ext != 'csv'):
					echo json_encode(array(
						'erro' => true,
						'titulo' => 'Arquivo incorreto!',
						'texto' => 'Envie um arquivo no formato correto (csv).'
					));
				else:
					$target = DIRETORIO.'/csv/'.$nome;

					move_uploaded_file($arquivo, $target);

					if(!file_exists($target)):
						echo json_encode(array(
							'erro' => true,
							'titulo' => 'Erro de permissão!',
							'texto' => 'O arquivo não foi enviado, verifique a permissão da pasta.'
						));
					else:
						$delimitador = ',';
						$cerca = '"';
						$ParceiroConcorrente = new ParceiroConcorrenteModel();

						$f = fopen(ARQUIVO.'/csv/'.$nome, 'r');
						if($f):
							$cabecalho = fgetcsv($f, 0, $delimitador, $cerca);
							$i = 0;
                            echo "<pre>";
							while(!feof($f)):
								$linha = fgetcsv($f, 0, $delimitador, $cerca);
								if (!$linha):
									continue;
								endif;

								$registro = array_combine($cabecalho, $linha);
                                $registro['cod'] = md5(uniqid(time()));
								$registro['status'] = 1;
								$registro['data_criacao'] = date('Y-m-d H:i:s');

								if($registro):
									$ParceiroConcorrente->salvar($registro);
								endif;
							endwhile;
							fclose($f);
						endif;
						echo json_encode(array(
							'erro' => false,
							'titulo' => 'Cadastros enviados',
							'texto' => 'cadastros enviados.'
						));
					endif;
				endif;
			endif;
		}

        public function post_upload_arquivo(){
            $arquivo = $_FILES['arquivo'];
            $diretorio = $_POST['diretorio'];
            $local = $_POST['local'];
    		$ext = explode('/', $_POST['ext']);
            $cod = $_POST['cod'];

            $Upload = new Upload;
            $retorno = json_decode($Upload->enviar($arquivo, $diretorio, 'arquivo', $ext), true);
			$nome_arquivo = explode(strrchr($arquivo['name'], '.'), $arquivo['name']);
            if(isset($retorno['erro']) && $retorno['erro'] == false):
                $Arquivo = new ArquivoModel;
                $arquivo = $Arquivo->salvar($cod, $retorno['arquivo'], $nome_arquivo[0], $local, true);
                if(!isset($arquivo['erro']) || $arquivo['erro'] == true):
                    echo json_encode($arquivo);
                else:
                    $retorno['id'] = $arquivo['id'];
                    echo json_encode($retorno);
                endif;
            else:
                echo json_encode($retorno);
            endif;
        }
        public function post_upload_arquivo_simples(){
            $arquivo = $_FILES['arquivo'];
            $diretorio = $_POST['diretorio'];
    		$ext = explode('/', $_POST['ext']);

            $Upload = new Upload;
            echo $Upload->enviar($arquivo, $diretorio, 'arquivo', $ext);
        }

        public function post_upload_imagem(){
            $imagem = $_FILES['imagem'];
    		$diretorio = $_POST['diretorio'];
    		$ext = explode('/', $_POST['ext']);
    		$width = $_POST['width'];
    		$height = $_POST['height'];
    		$tipo = $_POST['tipo'];

            $Upload = new Upload;
            echo $Upload->enviar($imagem, $diretorio, $tipo, $ext, $width, $height);
        }
        public function post_upload_imagem_lista(){
            $imagem = $_FILES['imagem'];
    		$diretorio = $_POST['diretorio'];
    		$ext = explode('/', $_POST['ext']);
    		$width = $_POST['width'];
    		$height = $_POST['height'];
    		$tipo = $_POST['tipo'];
            $tabela = Permissao::tabela($_POST['app']);
            $cod = $_POST['cod'];

            $Upload = new Upload;
            $imagem = json_decode($Upload->enviar($imagem, $diretorio, $tipo, $ext, $width, $height), true);
            if(isset($imagem['erro']) && $imagem['erro'] == false):
                $Foto = new FotoModel;
                $dados = [
                    "cod" => md5(uniqid(time())),
                    "vinculo" => $cod,
                    "imagem" => $imagem['arquivo'],
                    "data_criacao" => date("Y-m-d H:i:s"),
                    "status" => 1
                ];

                $foto = $Foto->salvar($dados);

                if(isset($foto['erro']) && $foto['erro'] == false):
                    $foto['link'] = $imagem['link'];
                endif;
                echo json_encode($foto);
            else:
                echo json_encode($imagem);
            endif;
        }
        public function post_upload_imagem_lista_deletar(){
            $Foto = new FotoModel;
            echo $Foto->deletar($_POST['id']);
        }

        public function post_endereco(){
            $_POST['tabela'] = Permissao::tabela($_POST['app']);
            unset($_POST['app']);

            $Endereco = new EnderecoModel;
            if(isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id']):
                echo $Endereco->editar($_POST);
            else:
                echo $Endereco->salvar($_POST);
            endif;
        }
        public function post_endereco_deletar(){
            $Endereco = new EnderecoModel;
            echo $Endereco->deletar($_POST['id']);
        }

        public function api_login(){
            $hash = $this->getSep(2);
            $Equipe = new EquipeModel;
            $Equipe->api($hash);
        }

        public function api_cep(){
            $cep = isset($_POST['cep']) ? $_POST['cep'] : '';
            echo json_encode(Localizacao::cep($cep));
        }
        public function api_mapa(){
            $local = $_POST['local'];
            echo json_encode(Localizacao::geolocalizacao(preg_replace("/[^0-9]/", "", $local).', Brazil'));
        }
    }
