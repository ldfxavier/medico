    <?php
        if($painel_historico):
            $cod = $painel_cod;
            $_app = $painel_app;
            if($painel_historico_id != null) $bloco_historico = $painel_historico_id;
    ?>
    <div class="center">
        <?php include('app/views/painel/padrao/historico/index.php') ?>
    </div>
    <?php
        endif;
    ?>
</div>
