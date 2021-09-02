<?php
    class apiController extends Controller {

        public function index(){

        }

        public function atualizar(){
            // $Migracao = new MigracaoModel;
            // $Usuario = new UsuarioModel;
            //
            //
            // $migracao = $Migracao->listar();
            //
            // foreach($migracao as $r):
            //     $usuario = $Usuario->buscar_nome($r->nome);
            //     if($usuario):
            //         $dados = array(
            //             'cpf' => $usuario->documento
            //         );
            //         $update = $Migracao->update($dados, "`nome` = '{$r->nome}'");
            //     endif;
            // endforeach;
            // exit();
        }

	    public function lista_combustivel(){
			$Combustivel = new CombustivelModel;
			$Combustivel->lista();
			exit();
	    }

		public function migrar_modelo_automovel(){
			$Modelo = new CarromodeloModel;
			$Carro = new CarroModel;

			$carro = $Carro->read();
			foreach($carro as $car):
				$_car = json_decode($car->modelo);
				foreach($_car as $r):
					$dados['cod'] = md5(uniqid(time()));
					$dados['vinculo'] = $car->cod;
					$dados['titulo'] = $r->titulo;
					$dados['detalhe'] = $r->texto;
					$dados['cor'] = $r->cor;
					$dados['valor'] = $r->valor;
					$dados['valor_off'] = $r->valor_off;
					$dados['data_criacao'] = date('Y-m-d H:i:s');
					$dados['status'] = 1;

					$modelo = $Modelo->insert($dados);
				endforeach;
			endforeach;

			echo "<pre>";
			print_r($modelo);
			exit();
		}

		public function migrar_historico(){
			// $tabela = "captacao";
            //
			// $Historico = new HistoricoModel;
			// $Parceiro = new ParceiroModel;
			// $Painel = new PainelModel;
            //
			// $Historico->_tabela = "historico";
			// $historico = $Historico->read("`tabela` = '{$tabela}'");
            //
			// $Historico->_tabela = "historico_novo";
			// $historico_novo = $Historico->read("`tabela` LIKE '%{$tabela}%'");
            //
			// foreach($historico as $r):
            //
			// 	$parceiro = $Parceiro->read("`id_captacao` = {$r->id_link}");
            //
			// 	if(!empty($parceiro)):
			// 		$dados['cod'] = json_encode([$parceiro[0]->cod]);
			// 		$dados['tipo'] = $r->tipo;
			// 		$dados['equipe'] = $r->equipe;
			// 		$dados['tabela'] = json_encode(['parceiro']);
			// 		$dados['texto'] = $r->texto;
			// 		$dados['data_criacao'] = $r->data_criacao;
            //
			// 		$insert = $Historico->insert($dados);
			// 	endif;
			// endforeach;
		}

		public function gerar_codigo(){
			$app = $this->getSep(2);
			$chave = $this->getSep(3);

			if(isset($chave) && $chave == "Dev@1324"):
				$Painel = new PainelModel;

				$lista = $Painel->p_read($app, "`cod` = '' OR `cod` IS NULL");

				foreach($lista as $r):
					$cod = md5(uniqid(time()));
						$retorno = $Painel->p_update($app, ['cod' => $cod], "`id` = {$r->id}");
				endforeach;

				if(isset($retorno)):
					echo "<pre>";
					print_r($retorno);
				else:
					echo "Nenhum cod atualizado!";
				endif;
			endif;
		}

		public function migrar_usuario(){
			exit();
			$Usuario = new UsuarioModel;
			$Usuario->migrar_usuario();
		}

		public function migrar_noticias(){
			exit();
			$Noticias = new NoticiasModel;
			$Noticias->migrar_noticias();
		}

		public function migrar_artigos(){
			exit();
			$Artigos = new PublicacaoArtigoModel;
			$Artigos->migrar_artigos();
		}

		public function migrar_jornal(){
			exit();
			$Artigos = new PublicacaoJornalModel;
			$Artigos->migrar_jornal();
		}
    }
