<?php
// INCLUSÕES
// include('./config/config.php');
include('../helpers/helpers.php');

// COSNTANTES
define('PASTA_PROJETO', 'desafio-pushstart');

// VARIÁVEIS, LISTAS E AUXILIARES
$retorno = array();
$mensagem = "";
$status = 0;

$servidor_api = "http://localhost/" . PASTA_PROJETO . "/src";

$cabecalho_post = array(
    "content-type: multipart/form-data;"
);

$cabecalho_json = array(
    "content-Type: application/json;"
);

$pontos_finais = array(
    "logar" => $servidor_api . "/usuario",
    "listar_usuario" => $servidor_api . "/",
    "incluir_usuario" => $servidor_api . "/",
    "alterar_usuario" => $servidor_api . "/"
);

// AÇÕES PARA O FRONTEND
if (sizeof($_POST)) {

    extract($_POST);

    // 1 - REGISTRO DE USUÁRIO
    if ($action == 1) {
    }
    // 2 - LOGIN DE USUÁRIO
    elseif ($action == 2) {

        $dados = [];
        $dados['email'] = $email;
        $dados['senha'] = $password;

        $resposta_login = CURL_API('POST', $cabecalho_post, $dados, $pontos_finais['logar']);

        print_r($resposta_login);

        if (isset($resposta_login['status']) && $resposta_login['status'] == 200) {

            $status = 1;

            session_start();
            $retorno['redirect'] = 'painel.php';
            //
        } else {
            $mensagem = $resposta_login['mensagem'];
        }

        $retorno['status'] = $status;
        $retorno['message'] = $mensagem;
    }
    //
    elseif ($action == 3) {
    }
    //
    elseif ($action == 4) {
    }
    //
    elseif ($action == 5) {
    }
    //
    else {
        $retorno['message'] = 'Não é uma ação válida';
    }
} else {
    $retorno['message'] = 'Não há dados para processamento';
}


echo json_encode($retorno);
