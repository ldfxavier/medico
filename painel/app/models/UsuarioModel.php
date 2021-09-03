<?php
    final class UsuarioModel extends Model {
        public $_tabela = 'usuario_cliente';

        public function montar($dados){
            $array = array();
			$quantidade = count($dados);
            if($dados):
                $Status = new StatusModel;
                foreach($dados as $r):
                    $nome = explode(' ', $r->nome);
                    $endereco = '';
                    $uf = !empty($r->uf) ? Converter::caixa($r->uf, 'A') : '';
                    $cep = !empty($r->cep) ? Converter::cep($r->cep) : '';
                    if(!empty($r->cep)):
                        $numero = !empty($r->numero) ? ', '.$r->numero : '';
                        $complemento = !empty($r->complemento) ? ', '.$r->complemento : '';
                        $endereco = $r->logradouro.$numero.$complemento.', '.$r->bairro.' - '.$r->cidade.'/'.$r->estado;
                    endif;

                    $array[] = (Object)[
                        'id' => $r->id,
                        'cod' => $r->cod,
                        'nome' => (object)[
                            'valor' => $r->nome,
                            'primeiro' => Converter::caixa($nome[0], 'A'),
                            'ultimo' => end($nome) != $nome[0] ? Converter::caixa(end($nome), 'A') : ''
                        ],
                        'cpf' => (object)[
                            'valor' => $r->documento,
                            'br' => Converter::documento($r->documento)
                        ],
                        'email' => $r->email,
                        'telefone' => (object)[
                            'celular' => (object)[
                                'valor' => $r->celular,
                                'br' => Converter::telefone($r->celular)
                            ],
                            'fixo' => (object)[
                                'valor' => $r->telefone,
                                'br' => Converter::telefone($r->telefone)
                            ]
                        ],
                        'endereco' => (object)[
                            'endereco' => $endereco,
                            'cep' => (object)[
                                'valor' => $r->cep,
                                'br' => $cep
                            ],
                            'logradouro' => $r->logradouro,
                            'numero' => $r->numero,
                            'complemento' => $r->complemento,
                            'bairro' => $r->bairro,
                            'cidade' => $r->cidade,
                            'referencia' => $r->referencia,
                            'estado' => $r->estado
                        ],
                        'data' => (object)array(
                            'criacao' => Converter::data($r->data_criacao, 'd/m/Y H:i'),
                        ),
                        'status' => $Status->valor("usuario", 'status', $r->status)
                    ];
                endforeach;
                return $array;
            endif;
        }

        public function cod($cod){
            $dado = $this->montar($this->read("`cod` = '{$cod}'"));
            if($dado) return $dado[0];
        }

        public function id($id){
            $dado = $this->montar($this->read("`id` = '{$id}'"));
            if($dado) return $dado[0];
        }
        
        public function resetar_senha(){
            $usuario = $this->read("salt IS NULL");
            if(!empty($usuario)):
                foreach($usuario as $r):
                $senha = substr($r->documento, 0, 4);
                $dados['salt'] = password_hash($senha, PASSWORD_DEFAULT, ['cost' => 11]);
                $dados['status'] = 1;
                $this->update($dados, "`id` = '".$r->id."'");
                endforeach;
            endif;
            
            return $usuario;
        }

        public function salvar($dados){	
            unset($dados['ajax']);

            $documento = $dados['documento'];
            $usuario = $this->query("
            SELECT a.documento, b.documento FROM usuario_cliente as a 
            INNER JOIN mensagem_filiese as b on a.documento = b.documento 
            WHERE a.documento = '{$documento}'");
            
            if(!empty($usuario)):
                echo json_encode(array(
                    'erro' => true,
                    'titulo' => 'CPF duplicado!',
                    'texto' => 'Já existe um usuário com o mesmo CPF na lista de usuários.'
                ));	
                exit();
            endif;
            $dados['data_criacao'] = date('Y-m-d H:i:s');
            $dados['data_admissao'] = Converter::data($dados['data_admissao'], 'Y-m-d');
            
            return $this->insert($dados, true);
        }
        
        public function limpaCPF_CNPJ($valor){
            $valor = trim($valor);
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", "", $valor);
            $valor = str_replace("-", "", $valor);
            $valor = str_replace("/", "", $valor);
            return $valor;
        }

        public function migrar_usuario(){            
            $dados_user = $this->query("SELECT * FROM `tabela_usuario`");

            foreach($dados_user as $r):
                $limpa_cpf = $this->limpaCPF_CNPJ($r->cpf);
                $dados = [
                    "cod" => md5(uniqid(time())),
                    "nome" => $r->nome,
                    "documento" => $limpa_cpf,
                    "email" => $r->email ? $r->email : '',
                    "salt" => password_hash(substr($limpa_cpf, 0, 4), PASSWORD_DEFAULT, ['cost' => 11]),
                    "data_criacao" => date('Y-m-d H:i:s'),
                    "primeiro_acesso" => 1,
                    "status" => 2
                ];
            
                $salvar = $this->insert($dados);
            
                pp($salvar);
            endforeach;

/*             ppe($salvar); */
        }
    }
