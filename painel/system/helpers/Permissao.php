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
        'usuario_equipe' => array(
            'titulo' => 'Equipe',
            'tabela' => 'equipe',
            'model' => 'EquipeModel',
            'permissao' => 'per_usuario_equipe',
            'lista' => array(
                'per_usuario_equipe_visualizar' => 'Visualziar lista',
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
                'per_usuario_usuario_visualizar' => 'Visualziar lista',
                'per_usuario_usuario_detalhe' => 'Detalhe do usuário',
                'per_usuario_usuario_add' => 'Adicionar usuário',
                'per_usuario_usuario_editar' => 'Editar usuário',
                'per_usuario_usuario_deletar' => 'Deletar usuário',
                'per_usuario_usuario_download' => 'Download lista usuário',
            ),
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