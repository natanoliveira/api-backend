<?php
ini_set('display_errors', 0);
date_default_timezone_set('America/Fortaleza');
header('Access-Control-Allow-Origin: *');

$config["em_teste"] = ($_SERVER['HTTP_HOST'] == 'localhost') ? true : false;

$IP_BROWSER = (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER["REMOTE_ADDR"];

$PROTOCOLO_HTTP = 'https://';

if ($config["em_teste"]) {

    # HOST DA APLICACAO
    $config["SITE"] = $PROTOCOLO_HTTP . "localhost/desafio-pushstart/";

    # DIRETORIO PARA RECUPERAR UPLOAD DE ARQUIVOS
    $config["Caminho_Upload"] = $config["SITE"] . "upload/";

    # BANCO DE DADOS
    $config["BD"] = "pushstart";

    # DEV TESTE
    $config["host_bd"] = "localhost";
    $config["user_bd"] = "root";
    $config["pass_bd"] = "";

    # PASTA PROJETO
    $config["pasta_projeto"] = "desafio-pushstart/";
    // 
} else {

    # HOST DA APLICACAO
    $config["SITE"] = $PROTOCOLO_HTTP . "www.pushstart.natanoliveira.com.br/";

    # DIRETORIO PARA RECUPERAR UPLOAD DE ARQUIVOS
    $config["Caminho_Upload"] = $PROTOCOLO_HTTP . "app.carlarejane.com.br/upload/";

    # BANCO DE DADOS
    $config["BD"] = "";

    # PRODUÇÃO
    $config["host_bd"] = "";
    $config["user_bd"] = "";
    $config["pass_bd"] = "";

    # PASTA PROJETO
    $config["pasta_projeto"] = "";
}

# ***********************************************************
# ****************** CONSTANTES DO SISTEMA ******************
# ***********************************************************

/**
 * DIRETORIO DOS ARQUIVOS
 */
define("URL_SITE", $PROTOCOLO_HTTP . "localhost/desafio-pushstart");
define("TITLE_APP", "Desafio :: PushStart");
define("PATH_SITE", $config["SITE"]);
define("PATH_FILES", $config["SITE"] . "assets/");
define("PATH_TEMPLATE", "includes/");
define("UPLOAD_FILES", $_SERVER['DOCUMENT_ROOT'] . "img/avatar/");
define("UPLOAD_FILES_APP", $_SERVER['DOCUMENT_ROOT'] . "/" . $config["pasta_projeto"] . "upload/");

define("CAMINHO_UPLOAD", $config["Caminho_Upload"]);
define("URL_ATIVA", "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

// CREDENCIAIS GERADAS COM SEGUINTES PAYLOADS
// {
//     "Issuer": "desafio",
//     "Username": "pushstart",
//     "Role": "client_id"
// }
define("CLIENT_ID", "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiY2xpZW50X2lkIiwiSXNzdWVyIjoiZGVzYWZpbyIsIlVzZXJuYW1lIjoicHVzaHN0YXJ0In0.vHVG0C5MCvd8Buwd0sxwQP_65X_3JrBiQOpYjFnNx9o");
// {
//     "Issuer": "desafio",
//     "Username": "pushstart",
//     "Role": "client_secret"
// }
define("CLIENT_SECRET", "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiY2xpZW50X3NlY3JldCIsIklzc3VlciI6ImRlc2FmaW8iLCJVc2VybmFtZSI6InB1c2hzdGFydCJ9.FO4DHfDgfYWQuq_K4QKJqXX0Xe89ZgObPe_TnlUnuEo");
