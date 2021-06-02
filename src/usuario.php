<?php
// INCLUSOES
include('php/config.php');
include('php/connect.php');
include('php/functions.php');

// RETORNO-RESPOSTA DAS REQUISIÇÕES
$json = array();

// RECEPÇÃO DE MÉTODO E OUTROS DADOS DE REQUISIÇÕES
$metodo = $_SERVER['REQUEST_METHOD'];
$cabecalho = apache_request_headers();

// VARRENDO OS ITENS DE HEADERS
$arg = array();
foreach ($cabecalho as $item => $valor) :
    $arg[$item] = $valor;
endforeach;

// DECODIFICANDO E QUEBRANDO A AUTORIZAÇÃO
$credenciais = base64_decode($arg['authorization']);
list($cliente_id, $cliente_secreto) = explode(":", $credenciais);

// DADOS PERTINENTES À TABELA DE BANCO DE DADOS
$tabela_base = "usuario";

// CONFIGURAÇÃO PARA GERAÇÃO DE HASH DE SENHA
// $config_hash_senha = array("cost" => 10, "salt" => uniqid());
// $config_hash_senha = hash("256","push")."/.".hash("256","start");

// VAARIÁVEIS, LISTAS E AUXILIARES
$status = 0;
$lista_erros = array();
$mensagem = "";

// SOMENTE ENTRA SE AS CREDENCIAIS PERMITIDAS FOREM AS DISPONIBILIZADAS PARA O CLIENTE/USUÁRIO
if (
    $cliente_id == CLIENT_ID &&
    $cliente_secreto == CLIENT_SECRET
) {

    // GET - LISTAGEM DE DADOS
    if ($metodo == "GET") {

        $id = isset($_GET['id']) ? antiInjection($_GET['id']) : "";

        if ($id != '') {
            $cond = "id='$id'";
        } else {
            $cond = "1=1";
        }

        $sql = "SELECT nome, email, avatar as foto FROM $tabela_base WHERE $cond ORDER BY id";
        $rs_sql = mysqli_query($conexao, $sql);

        $itens = [];

        if (mysqli_num_rows($rs_sql) != 0) {

            $status = 1;

            while ($row_sql = mysqli_fetch_assoc($rs_sql)) :
                $itens[] = $row_sql;
            endwhile;
            // 
        } else {

            $mensagem = "Erro";
            $json['mensagem'] = $mensagem;
        }

        $json['status'] = $status;
        $json['dados'] = $itens;
    }
    // POST - AUTENTICAÇÃO E INCLUSÃO DE REGISTRO
    elseif ($metodo == "POST") {

        // VERIFICANDO SE HOUVE POST ENVIADO E PREENCHIDO
        if (isset($_POST) && sizeof($_POST)) {

            // EXTRAINDO O POST
            extract($_POST);

            // VERIFICANDO A'Ã'O DO POST
            if ($action == 'auth') {

                // BUSCAR USUARIO POR EMAIL
                $rs_existe = mysqli_query($conexao, "SELECT * FROM usuario WHERE email='$email'");

                if (mysqli_num_rows($rs_existe) <= 1) {

                    $linha = mysqli_fetch_assoc($rs_existe);

                    // VERIFICANDO O HASH ENCONTRADO NA BASE COM O ENVIADO
                    if (password_verify($password, $linha['senha'])) {

                        // INICIA A SESSÃO E REDIRECIONA A PÁGINA
                        $status = 1;
                        $mensagem = "Login efetuado com sucesso";

                        // INICIANDO A SESSÃO
                        session_start();
                        // ATRIBUINDO OS DADOS DO USUÁRIO ENCONTRADO AO RETUORNO DE DADOS
                        foreach ($linha as $col => $val) :
                            $itens[$col] = $val;
                            $_SESSION['logado'][$col] = $val;
                        endforeach;
                        // print_r($_SESSION);

                    } else {
                        $mensagem = "Dados inválidos";
                    }
                    // 
                } else {
                    $mensagem = "Email utilizado par aoutro usuário";
                }
                // 
            }
            // CASO NÃO TENHA A AÇÃO LOGAR SERÁ PARA INSERIR UM USUÁRIO
            else {

                // INICIANDO VALIDAÇÃO DE DADOS
                if ($nome == '') {
                    $lista_erros[] = "Nome é obrigatório";
                }

                if ($email == '') {
                    $lista_erros[] = "E-mail é obrigatório";
                } else {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $lista_erros[] = "E-mail inserido inválido";
                    }
                }

                // CASO NÃO TENHA CAÍDO EM NENHUMA CRÍTICA VAMOS INSERI-LO
                if (!sizeof($lista_erros)) {

                    // GERANDO TOKEN UNIFICADO
                    $token = getGUID($email . "/." . $password . "-" . time());

                    // GERANDO HASH DE SENHA
                    $hash_senha = password_hash($password, PASSWORD_DEFAULT);

                    // SQL DEVIDAMENTE PRONTO PARA BANCO DE DADOS
                    $sql = "INSERT INTO SET "
                        . "nome = '$nome', "
                        . "token = '$token', "
                        . "email = '$email', "
                        . "senha = '$hash_senha'";

                    $rs_sql = mysqli_query($conexao, $sql);

                    // VERIFICAR SE A QUERY EXECUTOU NORMALMENTE
                    if ($rs_sql) {
                        $status = 1;
                        $mensagem = "Conta de usuário gerada com sucesso.";
                    } else {
                        $mensagem = "Não foi possível gerar conta.";
                    }
                }
                // CAIU EM ALGUMA CRÍTICA DE VALIDAÇÃO ENTÃO VAMOS RETORNARO ERRO
                else {
                    $msg_erro[] = $lista_erros;
                }
            }
        } else {
            $mensagem = "Post não enviado";
        }

        $json['status'] = $status;
        $json['mensagem'] = $mensagem;
        $json['dados'] = $itens;
        if (count($msg_erro) > 0) {
            $json['erro'] = $msg_erro;
        }
    }
    // PUT - ALTERAÇÃO DE REGISTRO
    elseif ($metodo == "PUT") {
    }
    // DELETE - REMOÇÃO DE REGISTRO
    elseif ($metodo == "DELETE") {
    }
    // METÓDO NÃO ACEITO
    else {
        $json['status'] = $status;
        $json['mensagem'] = "Requisição com método não aceito!";
    }
    // 
} else {
    $json['status'] = $status;
    $json['mensagem'] = "Falha de autenticação";
}

@mysqli_close($conexao);

// SETANDO CONTENT-TYPE PARA JSON
header('Content-type: application/json');
echo json_encode($json);
