<?php
    class Voip {

        private static $_key = VOIP_KEY;

        public static function sms($numero, $mensagem, $resposta = false){
            $numero = preg_replace("/[^0-9]/", "", $numero);

            if(empty($numero)) return (object)['erro' => true, 'status' => 4, 'texto' => 'Número vazio'];
            elseif(!Validar::telefone($numero, '', true)) return (object)['erro' => true, 'status' => 4, 'texto' => 'Número inválido'];

            $url = 'https://api.totalvoice.com.br/sms';
            $dados = [
                'numero_destino' => $numero,
                'resposta_usuario' => $resposta,
                'mensagem' => $mensagem,
                'multi_sms' => false
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Access-Token: '.self::$_key));

            $retorno = json_decode(curl_exec($ch), false);
            if(isset($retorno->status) && $retorno->status == 200):
                return (object)[
                    'erro' => false,
                    'status' => 3,
                    'id' => $retorno->dados->id
                ];
            else:
                return (object)[
                    'erro' => true,
                    'status' => 4,
                    'texto' => isset($retorno->mensagem) ? $retorno->mensagem : 'Outro erro'
                ];
            endif;
        }

        public static function sms_buscar($id){
            $url = 'https://api.totalvoice.com.br/sms/'.$id;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Access-Token: '.self::$_key));

            $retorno = json_decode(curl_exec($ch), false);
            if(isset($retorno->status) && $retorno->status == 200):
                $resposta = end($retorno->dados->respostas);
                return (object)[
                    'erro' => false,
                    'retorno' => $resposta->resposta,
                    'quantidade' => count((array)$retorno->dados->respostas),
                    'data' => Converter::data($resposta->data_resposta, 'Y-m-d H:i:s')
                ];
            else:
                return (object)['erro' => true];
            endif;
        }

        public static function sms_relatorio($inicio, $fim){
            $url = 'https://api.totalvoice.com.br/sms/relatorio?data_inicio='.$inicio.'&data_fim='.$fim;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Access-Token: '.self::$_key));

            $retorno = json_decode(curl_exec($ch), false);
            if(isset($retorno->status) && $retorno->status == 200):
                return (object)[
                    'erro' => false,
                    'lista' => $retorno->dados->relatorio
                ];
            else:
                return (object)['erro' => true];
            endif;
        }

        public static function recarga(){
            $url = 'https://api.evoline.com.br/conta/urlrecarga??url_retorno='.PAINEL;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Access-Token: ".self::$_key));

            $retorno = json_decode(curl_exec($ch), false);
            if(isset($retorno->status) && $retorno->status == 200):
                return (object)[
                    'erro' => false,
                    'url' => $retorno->dados->url
                ];
            endif;
        }

        public static function saldo(){
            $url = 'https://api.evoline.com.br/saldo';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Access-Token: ".self::$_key));

            $retorno = json_decode(curl_exec($ch), false);
            if(isset($retorno->status) && $retorno->status == 200):
                return (object)[
                    'erro' => false,
                    'saldo' => (object)[
                        'br' => number_format($retorno->dados->saldo, 2, ',', '.'),
                        'valor' => $retorno->dados->saldo
                    ]
                ];
            else:
                return (object)[
                    'erro' => true,
                    'saldo' => (object)[
                        'br' => '0,00',
                        'valor' => '0.00'
                    ],
                    'texto' => 'Erro ao buscar saldo.'
                ];
            endif;
        }

        public static function ligacao($numero, $equipe){
            $numero = preg_replace("/[^0-9]/", "", $numero);
            $ramal_id = $equipe->ramal->id;
            $ramal = $equipe->ramal->numero;

            $url = 'https://api.evoline.com.br/webphone?tipo=hidden&id_ramal='.$ramal_id.'&ramal='.$ramal.'&ligar_para='.$numero.'&fechar_fim=true&gravar_audio=true&tags="123"';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Access-Token: ".self::$_key));
            $retorno = json_decode(curl_exec($ch), false);

            if(isset($retorno->status) && $retorno->status == 200):
                $url = $retorno->dados->url;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $retorno = curl_exec($ch);
                return json_encode(['erro' => false, 'retorno' => $retorno]);
            endif;

            return Mensagem::erro('Erro na ligação', 'Ocorreu um erro ao tentar fazer a ligação, por favor, tente novamente.');
        }

    }
