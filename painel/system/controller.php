<?php
abstract class Controller extends System
{

    private function verificar_url()
    {
        $explode = $this->_explode;
        if (end($explode) == null) {
            array_pop($explode);
        }

        $quantidade = count($explode) - 1;
        $limite = $this->_limite;
        $forcar = $this->_limite_forcar;

        if ((is_numeric($limite) && $quantidade > 0 && $quantidade > $limite) || (is_numeric($limite) && $forcar && $quantidade > 1 && !isset($explode[$limite]))):
            $this->pagina_erro();
            exit();
        endif;
    }

    /**
     * PEGA OS INCLUDES E TRANSFORMA EM STRING
     * @var $arquivo     string     URL do view
     * @var $template     string     URL do template
     * @var $var        array     Array com as variáveis
     */
    private function converter($arquivo, $template = null, $var = null)
    {
        // Transoforma o array em variáveis
        if (is_array($var) && count($var) > 0) {
            extract($var, EXTR_PREFIX_ALL, "");
        }

        // Transforma a view em string
        ob_start();
        include $arquivo;
        $arquivo = ob_get_contents();
        ob_end_clean();

        // Se existe o template, transoforma ele em string
        if ($template != null):
            ob_start();
            include $template;
            $template = ob_get_contents();
            ob_end_clean();

            // Joga a view dentro do template
            $arquivo = str_replace('[[VIEW]]', $arquivo, $template);
        endif;

        // Subistitui os {{}} pelo echo do PHP
        $ini = array('{{"', '"}}', '{{', '}}', '&#123;&#123;"', '"&#125;&#125;');
        $fin = array('&#123;&#123;"', '"&#125;&#125;', "<?php echo ", " ?>", '{{"', '"}}');
        $arquivo = str_replace($ini, $fin, $arquivo);
        // Retorna o HTML
        return eval('?>' . $arquivo);
    }

    /**
     * MÉTODO PARA CHAMAR A VIEW
     * @var $nome         string     Nome do arquivo da view
     * @var $var         Array    Array com lista de variáveis
     * @var $template     string     Nome do template se precisar passar
     */
    protected function view($nome, $var = null, $template = null)
    {
        $this->verificar_url();

        $view = str_replace(array('.', '!'), array('/', ''), $nome);
        $arquivo = VIEWS . $view . ".php";

        if (!strstr($nome, '!') || !empty($template)):
            $explode = explode('/', $view);
            if (empty($template) && count($explode) > 1) {
                $template = $explode[0];
            } elseif (empty($template) && count($explode <= 1)) {
            $template = 'padrao';
        }

        $template = TEMPLETES . $template . '.php';
        if (!file_exists($template)) {
            $template = TEMPLETES . 'padrao.php';
        }

        endif;

        if ((!empty($template) && !file_exists($template)) || !file_exists($arquivo)):
            $this->erro();
        else:
            echo $this->converter($arquivo, $template, $var);
            exit();
        endif;
    }

    /**
     * MÉTODO INICIAL DE TODA CLASS
     */
    public function init()
    {}

    /**
     * MÉTODO DE ERRO QUANDO A PÁGINA NÃO EXISTIR
     */
    public function erro()
    {
        if (file_exists(CONTROLLERS . '/erroController.php')):
            $_SERVER['REDIRECT_STATUS'] = 404;
            include CONTROLLERS . '/erroController.php';
            $erro = new erroController();
            $erro->index();
            exit();
        else:
            $this->pagina_erro();
        endif;
    }
}
