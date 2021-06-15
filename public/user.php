<?php
include('php/config.php');
include('../helpers/helpers.php');
include('verify.php');

include(TEMPLATE . 'header.php');

$dados = [];
$mensagem = "";

$resposta_lista = CURL_API('GET', $cabecalho_json, json_encode($dados), $modulos['usuario']);

if (isset($resposta_lista['status']) && $resposta_lista['status'] == 1) {

    $lista = $resposta_lista['dados'];
    //
} else {
    $mensagem = $resposta_lista['mensagem'];
}

if ($mensagem != '') {
    echo alerta($mensagem, 'erro');
}

// echo "<pre>";
// print_r($lista);
// echo "</pre>";
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Lista de Usuários</li>
    </ol>
</nav>

<table id="table-user" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Seq.</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Foto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($lista as $key => $val) :
            $avatar_url = ($val['avatar_url'] != '') ? '<img class="rounded-circle" src="' . $val['avatar_url'] . '" alt="" width="50" height="50">' : '';
        ?>
            <tr>
                <td><?= $val['id'] ?></td>
                <td><?= $val['nome'] ?></td>
                <td><?= $val['email'] ?></td>
                <td><?= $avatar_url ?></td>
                <td>
                    <a href="userEdit.php?id=<?= $val['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Seq.</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Foto</th>
            <th></th>
        </tr>
    </tfoot>
</table>

<?php include(TEMPLATE . 'footer.php'); ?>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table-user').DataTable();
    });
</script>