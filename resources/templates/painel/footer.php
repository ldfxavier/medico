	</main>
</div>

<script src="<?= LINK_PADRAO ?>/js/painel.js?cache=<?= CACHE ?>" type="text/javascript"></script>
<?php if(isset($js) && !empty($js)): ?>
<script src="<?= LINK_PADRAO ?>/js/<?= $js ?>?cache=<?= CACHE ?>" type="text/javascript"></script>
<?php endif; ?>

<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
<link rel="stylesheet" href="<?= LINK_PADRAO ?>/css/painel.css?cache=<?= CACHE ?>"/>
<?php if(isset($css) && !empty($css)): ?>
<link rel="stylesheet" href="<?= LINK_PADRAO ?>/css/<?= $css ?>?cache=<?= CACHE ?>"/>
<?php endif; ?>

</body>
</html>
