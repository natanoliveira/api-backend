<?php
session_start();

// echo "<pre>";
// print_r($_SESSION['logado']);
// echo "</pre>";

if (isset($_SESSION['logado']) && sizeof($_SESSION['logado'])) {

    $usuario_id = $_SESSION['logado']['id'];
    $usuario_token = $_SESSION['logado']['token'];
    $usuario_nome = $_SESSION['logado']['nome'];
    $usuario_nome_perfil = $_SESSION['logado']['nome_perfil'];
    $usuario_ultimo_acesso = $_SESSION['logado']['ultimo_acesso'];
    // 
} else {
    header('Location: logout.php');
}
