<?php
// INCLUSÕES
include('./config/config.php');
include('../helpers/helpers.php');

// VARIÁVEIS, LISTAS E AUXILIARES
$retorno = array();
$mensagem = "";
$status = 0;

// AÇÕES PARA O FRONTEND
if (isset($_POST) && sizeof($_POST)) {

    extract($_POST);

    // 1 - REGISTRO DE USUÁRIO
    if ($acao == 1) {
    }
    // 2 - LOGIN DE USUÁRIO
    elseif ($acao == 2) {
    }
    // LOGOUT
    elseif ($acao == 3) {
    }
    //
    elseif ($acao == 4) {

        $retorno['status'] = $status;
        $retorno['message'] = $mensagem;
    }
    //
    elseif ($acao == 5) {

        $retorno['status'] = $status;
        $retorno['message'] = $mensagem;
    }
    //
    else {
        $retorno['message'] = 'Não é uma ação válida';
    }
} else {
    $retorno['message'] = 'Não há dados para processamento';
}

echo json_encode($retorno);
