<?php
include('php/config.php');
include('../helpers/helpers.php');
include('verify.php');

// session_start();

if (!empty($_POST['uid'])) {

    $uid = base64_decode($_POST['uid']);

    $dados = [];
    $dados['id'] = $uid;

    $resp_api = CURL_API('DELETE', $cabecalho_json, json_encode($dados), $modulos['usuario']);

    if (isset($resp_api['status']) && $resp_api['status'] == 1) {

        session_destroy();
        unset($_SESSION['logado']);
        header('Location: login.php');
        //
    } else {
        echo "<script>alert('" . $resp_api['mensagem'] . "');</script>";
    }
}
exit();
