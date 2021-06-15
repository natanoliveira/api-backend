<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h2 class="display-5">Seja Bem vindo <i><?= $usuario_nome_perfil ?></i></h2>
    <?php if ($usuario_ultimo_acesso != '') { ?>
        <p class="lead">Seu último acesso foi em <?= DataBancoApp($usuario_ultimo_acesso) ?></p>
    <?php } else { ?>
        <p class="lead">Seu primeiro acesso à nossa plataforma</p>
    <?php } ?>
</div>