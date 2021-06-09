<?php
// INCLUSÕES
// include('./config/config.php');
include('../helpers/helpers.php');

// COSNTANTES
define('PASTA_PROJETO', 'desafio-pushstart/api-backend');
// CREDENCIAIS GERADAS COM SEGUINTES PAYLOADS
define("CLIENT_ID", "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiY2xpZW50X2lkIiwiSXNzdWVyIjoiZGVzYWZpbyIsIlVzZXJuYW1lIjoicHVzaHN0YXJ0In0.vHVG0C5MCvd8Buwd0sxwQP_65X_3JrBiQOpYjFnNx9o");
define("CLIENT_SECRET", "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiY2xpZW50X3NlY3JldCIsIklzc3VlciI6ImRlc2FmaW8iLCJVc2VybmFtZSI6InB1c2hzdGFydCJ9.FO4DHfDgfYWQuq_K4QKJqXX0Xe89ZgObPe_TnlUnuEo");

// VARIÁVEIS, LISTAS E AUXILIARES
$retorno = array();
$mensagem = "";
$status = 0;

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

$pontos_finais = array(
    "logar" => $servidor_api . "/usuario.php",
    "listar_usuario" => $servidor_api . "/",
    "incluir_usuario" => $servidor_api . "/",
    "alterar_usuario" => $servidor_api . "/"
);

// AÇÕES PARA O FRONTEND
if (sizeof($_POST)) {

    extract($_POST);

    // 1 - REGISTRO DE USUÁRIO
    if ($acao == 1) {
    }
    // 2 - LOGIN DE USUÁRIO
    elseif ($acao == 2) {

        $dados = [];
        $dados['email'] = $email;
        $dados['senha'] = $password;
        $dados['acao'] = 'autenticar';

        $resposta_login = CURL_API('POST', $cabecalho_json, json_encode($dados), $pontos_finais['logar']);

        // print_r($resposta_login);
        // exit;

        if (isset($resposta_login['status']) && $resposta_login['status'] == 1) {

            $status = 1;

            // echo "<pre>";
            // print_r($resposta_login);
            // echo "</pre>";

            session_start();

            foreach ($resposta_login['dados'] as $key => $val) :
                $_SESSION['logado'][$key] = $val;
            endforeach;

            $retorno['itens'] = $resposta_login['dados'];
            $retorno['redirect'] = 'dashboard.php';
            //
        } else {
            $mensagem = $resposta_login['mensagem'];
        }

        $retorno['status'] = $status;
        $retorno['message'] = $mensagem;
    }
    //
    elseif ($acao == 3) {
    }
    //
    elseif ($acao == 4) {
    }
    //
    elseif ($acao == 5) {
    }
    //
    else {
        $retorno['message'] = 'Não é uma ação válida';
    }
} else {
    $retorno['message'] = 'Não há dados para processamento';
}


echo json_encode($retorno);
