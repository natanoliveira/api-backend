<footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
        <div class="col-12 col-md text-center">
            <img class="mb-2" src="assets/img/logo-white.png" alt="" width="110">
            <small class="d-block mb-3 text-muted">&copy; 2021</small>
        </div>
        <?php /* ?>
        <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Cool stuff</a></li>
                <li><a class="text-muted" href="#">Random feature</a></li>
                <li><a class="text-muted" href="#">Team feature</a></li>
                <li><a class="text-muted" href="#">Stuff for developers</a></li>
                <li><a class="text-muted" href="#">Another one</a></li>
                <li><a class="text-muted" href="#">Last time</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Resource</a></li>
                <li><a class="text-muted" href="#">Resource name</a></li>
                <li><a class="text-muted" href="#">Another resource</a></li>
                <li><a class="text-muted" href="#">Final resource</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Team</a></li>
                <li><a class="text-muted" href="#">Locations</a></li>
                <li><a class="text-muted" href="#">Privacy</a></li>
                <li><a class="text-muted" href="#">Terms</a></li>
            </ul>
        </div>
        <?php */ ?>
    </div>
</footer>
</div>

<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="logout.php" method="post">
                <input type="hidden" name="uid" value="<?= base64_encode($usuario_id) ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    Deseja realmente sair do sistema?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="suubmit" class="btn btn-primary" id="btn-logout">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script>
    window.jQuery || document.write('<script src="assets/js/jquery-slim.min.js"><\/script>')
</script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/holder.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
    });
    // $(document).ready(function() {

    //     $("#btn-logout").click(function() {

    //         $('#btn-logout').attr('disabled', true);

    //         $.ajax({
    //             url: "process.php",
    //             type: "POST",
    //             data: {
    //                 id: <?= $usuario_id ?>,
    //                 acao: 3,
    //             },
    //             beforeSend: function() {
    //                 $('#btn-logout').empty().html('Saindo...');
    //             },
    //             success: function(result) {

    //                 var res = JSON.parse(result);
    //                 var mensagem = "";

    //                 if (res.status == 1) {
    //                     //  MENSAGEM QUE FOI ENVIADO
    //                     window.location.href = "'" + res.redirect + "'";

    //                 } else {
    //                     // MENSAGEM DE VALIDAÇÃO
    //                     if (res.message != '') {
    //                         mensagem = res.message;
    //                     } else {
    //                         mensagem = "Aconteceu um problema! - Mensagem não enviada!";
    //                     }
    //                 }

    //                 $('#btn-logout').empty().html('Sim');
    //                 $('#btn-logout').removeAttr('disabled');
    //             },
    //             error: function(jqXHR, textStatus, ex) {
    //                 alert(textStatus + "," + ex + "," + jqXHR.responseText);
    //                 $('#btn-logout').removeAttr('disabled');
    //             },
    //             done: function(result) {
    //                 $('#btn-logout').removeAttr('disabled');
    //             },
    //         });
    //     });
    // });
</script>
</body>

</html>