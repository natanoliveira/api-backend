<?php
# OBTENDO O NOME DO SCRIPT
$quebra_pag = explode("/", $_SERVER['PHP_SELF']);
$SCRIPT_PAGINA = end($quebra_pag);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://pushstart.com.br/favicon-32x32.png?v=d8a94433f082ec4909821d4d40678b50">

    <title>Dashboard :: Push Start</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

</head>

<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">PUSHSTART</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="dashboard.php">Dashboard</a>
            <a class="p-2 text-dark" href="user.php">Usuários</a>
            <?php /* ?>
            <a class="p-2 text-dark" href="#">Enterprise</a>
            <?php */ ?>
            <?php if ($usuario_primeiro_nome != '') { ?>
                <a class="p-2 text-dark disabled" href="javascript:void(0);">
                    <?= $usuario_primeiro_nome ?>
                </a>
            <?php } ?>
        </nav>
        <a class="btn btn-outline-primary" data-toggle="modal" data-target="#modalLogout" href="javascript:void(0);">Sair</a>

    </div>

    <?php if ($SCRIPT_PAGINA == "dashboard.php") { ?>
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h2 class="display-5">Seja Bem vindo <i><?= $usuario_nome_perfil ?></i></h2>
            <?php if ($usuario_ultimo_acesso != '') { ?>
                <p class="lead">Seu último acesso foi em <?= date("d/m/Y H:i", strtotime($usuario_ultimo_acesso)) ?></p>
            <?php } else { ?>
                <p class="lead">Seu primeiro acesso à nossa plataforma</p>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="container">