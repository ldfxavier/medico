<?php
/**
 * FRAMEWORD DESENVOLVIDO E MANTIDO PELO MARKT TEC TECNOLOGIA DA INFORMACAO LTDA
 *
 * @author André Rodrigues <andrerodrigues@andrerodrigues.com>
 * @version 1.0.0
 **/

/*
|--------------------------------------------------------------------------
| APP START
|--------------------------------------------------------------------------
|
| Roda o APP para utilização do fw
|
 */

header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("Content-Security-Policy: default-src 'self' 'unsafe-inline' *.google.com *.googleapis.com *.gstatic.com https://js.driftt.com *.marktclub.com.br *.googleusercontent.com https://ui.zanox.com http://*.hotjar.com:* https://*.hotjar.com:* http://*.hotjar.io https://*.hotjar.io wss://*.hotjar.com *.google-analytics.com *.googletagmanager.com data: https://viacep.com.br https://connect.facebook.net https://www.facebook.com https://graph.facebook.com https://*.facebook.com https://*.facebook.net img-src: https://www.google-analytics.com connect-src: https://www.google-analytics.com script-src: https://www.google-analytics.com https://ssl.google-analytics.com https://via.placeholder.com http://via.placeholder.com https://www.youtube.com");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("X-XSS-Protection: 1");

$app = require_once __DIR__ . '/../system/App.php';
