<?php
class Permissao
{
    private static $_lista = array(
        'interno_foto' => array(
            'tabela' => 'foto',
            'model' => 'FotoModel',
        ),
        'foto' => array(
            'tabela' => 'foto',
            'model' => 'FotoModel',
        ),
        'drive' => array(
            'titulo' => 'Drive',
            'tabela' => 'drive',
            'model' => 'DriveModel',
            'permissao' => 'per_drive',
            'lista' => array(
                'per_drive' => 'Visualizar lista',
                'per_drive_visualizar' => 'Visualizar arquivo',
                'per_drive_add' => 'Adicionar arquivo',
                'per_drive_editar' => 'Editar arquivo',
                'per_drive_deletar' => 'Deletar arquivo',
            ),
        ),

        'publicidade_banner' => array(
            'titulo' => 'Banner',
            'tabela' => 'banner',
            'model' => 'BannerModel',
            'permissao' => 'per_publicidade_banner',
            'lista' => array(
                'per_publicidade_banner_visualizar' => 'Visualizar lista',
                'per_publicidade_banner_detalhe' => 'Detalhe do banner',
                'per_publicidade_banner_add' => 'Adicionar banner',
                'per_publicidade_banner_editar' => 'Editar banner',
                'per_publicidade_banner_deletar' => 'Deletar banner',
            ),
        ),
        'administrativo_status' => array(
            'titulo' => 'Status',
            'tabela' => 'status_novo',
            'model' => 'StatusModel',
            'permissao' => 'per_administrativo_status',
            'lista' => array(
                'per_administrativo_status_visualizar' => 'Visualizar lista',
                'per_administrativo_status_add' => 'Adicionar área',
                'per_administrativo_status_editar' => 'Editar área',
                'per_administrativo_status_deletar' => 'Deletar área',
            ),
        ),
		'administrativo_site' => array(
			'titulo' => 'Site',
			'tabela' => 'site',
			'model' => 'SiteModel',
			'permissao' => 'per_administrativo_site',
			'lista' => array(
				'per_administrativo_site_visualizar' => 'Visualizar lista',
				'per_administrativo_site_editar' => 'Editar dados'
			)
		),
        'usuario_equipe' => array(
            'titulo' => 'Equipe',
            'tabela' => 'equipe',
            'model' => 'EquipeModel',
            'permissao' => 'per_usuario_equipe',
            'lista' => array(
                'per_usuario_equipe_visualizar' => 'Visualizar lista',
                'per_usuario_equipe_detalhe' => 'Detalhe da equipe',
                'per_usuario_equipe_add' => 'Adicionar equipe',
                'per_usuario_equipe_editar' => 'Editar equipe',
                'per_usuario_equipe_deletar' => 'Deletar equipe',
            ),
        ),
        'usuario_usuario' => array(
            'titulo' => 'Usuário',
            'tabela' => 'usuario',
            'model' => 'UsuarioModel',
            'permissao' => 'per_usuario_usuario',
            'lista' => array(
                'per_usuario_usuario_visualizar' => 'Visualizar lista',
                'per_usuario_usuario_detalhe' => 'Detalhe do usuário',
                'per_usuario_usuario_add' => 'Adicionar usuário',
                'per_usuario_usuario_editar' => 'Editar usuário',
                'per_usuario_usuario_deletar' => 'Deletar usuário',
                'per_usuario_usuario_download' => 'Download lista usuário',
            ),
        ),
        'especialidades' => array(
            'titulo' => 'Especialidades',
            'tabela' => 'especialidades',
            'model' => 'EspecialidadesModel',
            'permissao' => 'per_especialidades',
            'lista' => array(
                'per_especialidades_visualizar' => 'Visualizar lista',
                'per_especialidades_detalhe' => 'Detalhe',
                'per_especialidades_add' => 'Adicionar',
                'per_especialidades_editar' => 'Editar',
                'per_especialidades_deletar' => 'Deletar',
                'per_especialidades_download' => 'Download lista usuário',
            ),
        ),
        'telemedicina' => array(
            'titulo' => 'Telemedicina',
            'tabela' => 'telemedicina',
            'model' => 'TelemedicinaModel',
            'permissao' => 'per_telemedicina',
            'lista' => array(
                'per_telemedicina_visualizar' => 'Visualizar lista',
                'per_telemedicina_detalhe' => 'Detalhe',
                'per_telemedicina_add' => 'Adicionar',
                'per_telemedicina_editar' => 'Editar',
            ),
        ),
        'formulario' => array(
            'titulo' => 'Formulário',
            'tabela' => 'formulario',
            'model' => 'FormularioModel',
            'permissao' => 'per_formulario',
            'lista' => array(
                'per_formulario_add' => 'Adicionar',
                'per_formulario_visualizar' => 'Visualizar lista',
                'per_formulario_detalhe' => 'Detalhe',
                'per_formulario_editar' => 'Editar',
            ),
        ),
		'mensagem' => array(
			'titulo' => 'Mensagem',
			'tabela' => 'mensagem',
			'model' => 'MensagemModel',
			'permissao' => 'per_mensagem',
			'lista' => array(
				'per_mensagem_visualizar' => 'Visualizar lista',
				'per_mensagem_detalhe' => 'Detalhe da mensagem',
				'per_mensagem_editar' => 'Editar mensagem',
				'per_mensagem_deletar' => 'Deletar mensagem'
			)
		),
        'arquivo' => array(
            'tabela' => 'arquivo',
            'model' => 'ArquivoModel',
        ),
        'historico' => array(
            'tabela' => 'historico_novo',
            'model' => 'HistoricoModel',
        ),
    );

    public static function lista($linha = false, $associacao = false)
    {
        $array = array();
        foreach (self::$_lista as $r):
            if (isset($r['lista'])):
                if ($associacao && strstr($r['titulo'], 'Associação - ')):
                    $array[] = (object) array(
                        'titulo' => $r['titulo'],
                        'lista' => (object) $r['lista'],
                    );
                elseif (!$associacao):
                    $array[] = (object) array(
                        'titulo' => $r['titulo'],
                        'lista' => (object) $r['lista'],
                    );
                endif;
            endif;
        endforeach;

        if ($linha):
            $array = array();
            foreach (self::$_lista as $lista_r) {
                if (isset($lista_r['lista'])) {
                    foreach ($lista_r['lista'] as $ind => $val) {
                        $array[$ind] = $val;
                    }
                }
            }

        endif;
        return $array;
    }

    public static function titulo($titulo)
    {
        return isset(self::$_lista[$titulo]['titulo']) ? self::$_lista[$titulo]['titulo'] : '';
    }

    public static function model($app)
    {
        return isset(self::$_lista[$app]['model']) ? self::$_lista[$app]['model'] : '';
    }

    public static function tabela($app)
    {
        return isset(self::$_lista[$app]['tabela']) ? self::$_lista[$app]['tabela'] : '';
    }

    public static function nome($app)
    {
        return isset(self::$_lista[$app]['permissao']) ? self::$_lista[$app]['permissao'] : '';
    }
    public static function validar($app, $acao = null)
    {
        if (!isset($_SESSION['EQUIPE'])) {
            return false;
        }

        $equipe = $_SESSION['EQUIPE'];

        if (!isset(self::$_lista[$app]['permissao']) && $equipe->desenvolvedor == 2) {
            return false;
        }

        $acao = ($acao != null) ? '_' . $acao : '';
        $permissao = isset(self::$_lista[$app]['permissao']) ? self::$_lista[$app]['permissao'] . $acao : 'sem_permissao';
        return (in_array($permissao, $equipe->permissao->lista) || $equipe->desenvolvedor == 1) ? true : false;
    }
}