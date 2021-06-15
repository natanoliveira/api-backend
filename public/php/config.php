<?php
// COSNTANTES
define('PASTA_PROJETO', 'desafio-pushstart/api-backend');

// CREDENCIAIS GERADAS COM SEGUINTES PAYLOADS
define("CLIENT_ID", "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiY2xpZW50X2lkIiwiSXNzdWVyIjoiZGVzYWZpbyIsIlVzZXJuYW1lIjoicHVzaHN0YXJ0In0.vHVG0C5MCvd8Buwd0sxwQP_65X_3JrBiQOpYjFnNx9o");
define("CLIENT_SECRET", "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiY2xpZW50X3NlY3JldCIsIklzc3VlciI6ImRlc2FmaW8iLCJVc2VybmFtZSI6InB1c2hzdGFydCJ9.FO4DHfDgfYWQuq_K4QKJqXX0Xe89ZgObPe_TnlUnuEo");

// PASTA DAS INCLUDES DO TEMPLATE
define('TEMPLATE', 'includes/');

$servidor_api = "http://localhost/" . PASTA_PROJETO . "/src";

$credencial = base64_encode(CLIENT_ID . ":" . CLIENT_SECRET);

$cabecalho_post = array(
    "content-type: multipart/form-data;",
    "authorization: $credencial"
);

$cabecalho_json = array(
    "content-Type: application/json;",
    "authorization: $credencial"
);

$modulos = array(
    "usuario" => $servidor_api . "/usuario.php"
);
