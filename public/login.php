<?php
include('php/config.php');
include('../helpers/helpers.php');

$mensagem = "";

if (isset($_POST) && sizeof($_POST)) {

    extract($_POST);

    if (!empty($email) && !empty($password)) {

        $dados = [];
        $dados['email'] = $email;
        $dados['senha'] = $password;
        $dados['acao'] = 'autenticar';

        $resposta_login = CURL_API('POST', $cabecalho_json, json_encode($dados), $modulos['usuario']);

        if (isset($resposta_login['status']) && $resposta_login['status'] == 1) {

            session_start();

            foreach ($resposta_login['dados'] as $key => $val) :
                $_SESSION['logado'][$key] = $val;
            endforeach;

            header('Location: dashboard.php');
            //
        } else {
            $mensagem = $resposta_login['mensagem'];
        }
    } else {
        $mensagem = "Dados inválidos";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://pushstart.com.br/favicon-32x32.png?v=d8a94433f082ec4909821d4d40678b50">

    <title>Login :: Push Start</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="text-center">
    <?php if ($mensagem != '') { ?>
        <div class="alert alert-danger"><?= $mensagem ?></div>
    <?php } ?>
    <form class="form-signin" id="form-signin" autocomplete="off" method="post" action="">
        <img class="mb-4" src="assets/img/logo-white.png" alt="">
        <h1 class="h3 mb-3 font-weight-normal">Desafio</h1>
        <label for="inputEmail" class="sr-only">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="E-mail de acesso" required autofocus>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="***" required>
        <br />
        <button class="btn btn-lg btn-primary btn-block" id="bt-entrar" type="submit">Entrar</button>
        <input type="hidden" name="acao" value="2">
        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
    </form>

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script> -->
    <!-- bootstrap -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- Sweetalert -->
    <script src="assets/js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">

    <script>
        // $(document).ready(function() {

        //     $('#bt-entrar').click(function(e) {
        //         e.preventDefault();

        //         $('#bt-entrar').attr('disabled', true);

        //         // disableElement({
        //         //     id: "bt-entrar"
        //         // })

        //         var form_data = $('#form-signin').serialize();

        //         $.ajax({
        //             url: "process.php",
        //             type: "POST",
        //             data: form_data,
        //             xhrFields: {
        //                 withCredentials: false
        //             },
        //             beforeSend: function() {
        //                 $('#bt-entrar').empty().html('Autenticando...');
        //             },
        //             success: function(result) {

        //                 // console.log(result);

        //                 var res = JSON.parse(result);
        //                 var mensagem = "";

        //                 if (res.status == 1) {
        //                     //  MENSAGEM QUE FOI ENVIADO
        //                     // mensagem = "Mensagem enviada. Entraremos em contato o mais breve possível.";
        //                     window.location.href = "'" + res.redirect + "'";

        //                 } else {
        //                     // MENSAGEM DE VALIDAÇÃO
        //                     if (res.message != '') {
        //                         mensagem = res.message;
        //                     } else {
        //                         mensagem = "Aconteceu um problema! - Mensagem não enviada!";
        //                     }
        //                 }

        //                 $('#bt-entrar').empty().html('Entrar');

        //                 var tipo = (res.status == 1) ? "success" : "error";
        //                 var titulo = (res.status == 1) ? "Parabens!" : "Opa!";
        //                 var icone = (res.status == 1) ? "success" : "error";
        //                 // var botao = (res.status == 1) ? "#3085d6" : "#ab669a";

        //                 // Sweet alert
        //                 Swal.fire({
        //                     icon: icone,
        //                     title: titulo,
        //                     // text: mensagem,
        //                     html: mensagem,
        //                     // type: tipo,
        //                     // confirmButtonColor: botao,
        //                     // confirmButtonText: 'Fechar'
        //                 })

        //                 $('#bt-entrar').removeAttr('disabled');

        //                 // activeElement({
        //                 //     id: "bt-entrar"
        //                 // })
        //             },
        //             error: function(jqXHR, textStatus, ex) {
        //                 alert(textStatus + "," + ex + "," + jqXHR.responseText);
        //                 // activeElement({
        //                 //     id: "bt-entrar"
        //                 // })
        //                 $('#bt-entrar').removeAttr('disabled');
        //             },
        //             done: function(result) {
        //                 // activeElement({
        //                 //     id: "bt-entrar"
        //                 // })
        //                 $('#bt-entrar').removeAttr('disabled');
        //             },
        //         });
        //     });
        // });
    </script>
</body>

</html>