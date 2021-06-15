<?php
// INCLUSOES
include('php/config.php');
include('php/connect.php');
include('php/functions.php');

header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// RETORNO-RESPOSTA DAS REQUISIÇÕES
$json = array();

// RECEPÇÃO DE MÉTODO E OUTROS DADOS DE REQUISIÇÕES
$METODO = $_SERVER['REQUEST_METHOD'];
$CABECALHO = apache_request_headers();

// VARRENDO OS ITENS DE HEADERS
$arg = array();
foreach ($CABECALHO as $item => $valor) :
    $arg[$item] = $valor;
endforeach;

// $json['headers'] = $arg;

// DECODIFICANDO E QUEBRANDO A AUTORIZAÇÃO
$credenciais = base64_decode($arg['authorization']);
list($cliente_id, $cliente_secreto) = explode(":", $credenciais);

// DADOS PERTINENTES À TABELA DE BANCO DE DADOS
$tabela_base = "usuario";
$tabela_sessao = "sessao";

// VAARIÁVEIS, LISTAS E AUXILIARES
$status = 0;
$lista_erros = array();
$itens = array();
$mensagem = "";
$msg_erro = array();

// CONFIGURAÇÃO PARA UPLOAD DE IMAGEM
$diretorio_upload = 'upload/';
$extensao_arquivo = array('jpeg', 'jpg', 'png', 'gif');
$tamanho_arquivo = '4000000';  # 4MB

// SESSÃO
$tempo_agora = time();

// SOMENTE ENTRA SE AS CREDENCIAIS PERMITIDAS FOREM AS DISPONIBILIZADAS PARA O CLIENTE/USUÁRIO
if (
    $cliente_id == CLIENT_ID &&
    $cliente_secreto == CLIENT_SECRET
) {

    // RECEBENDO JSON POST
    $CORPO_JSON = (array) json_decode(file_get_contents('php://input'), TRUE);

    // GET - LISTAGEM DE DADOS
    if ($METODO == "GET") {

        $id = isset($_GET['id']) ? antiInjection($_GET['id']) : "";

        if ($id != '') {
            $cond = "id='$id'";
        } else {
            $cond = "1=1";
        }

        $sql = "SELECT id, nome, email, avatar AS avatar_url, nome_perfil, token FROM $tabela_base WHERE $cond ORDER BY id";

        $rs_sql = mysqli_query($conexao, $sql);

        if (mysqli_num_rows($rs_sql) != 0) {

            $status = 1;

            while ($row_sql = mysqli_fetch_assoc($rs_sql)) :

                $itens[] = $row_sql;

            endwhile;
            // 
        } else {

            $mensagem = ($id == '') ? "Dados não existentes para listagem" : "Conta não existente";
        }

        // RESPOSTAS
        $json['status'] = $status;

        if ($mensagem != '') {
            $json['mensagem'] = $mensagem;
        }

        if (count($itens) > 0) {
            $json['dados'] = $itens;
        }
    }
    // POST - INCLUSÃO/ALTERAÇÃO DE AVATAR
    elseif (($METODO == "POST") && (isset($_POST) && sizeof($_POST))) {

        // EXTRAINDO O POST
        extract($_POST);

        // ALTERAR IMAGEM DO USUÁRIO
        if ($acao == 'avatar') {

            if (
                isset($_FILES['imagem']) &&
                sizeof($_FILES['imagem'])
            ) {

                // ATRIBUINDO DADOS
                $imagem_nome = $_FILES['imagem']['name'];
                $imagem_nome_temporario = $_FILES['imagem']['tmp_name'];
                $imagem_tamanho = $_FILES['imagem']['size'];

                // PEGA EXTENSÃO DO ARQUIVO
                list($imagem_nome_sem_extensao, $extensao) = explode(".", $imagem_nome);
                $imagem_hash = sha1($imagem_nome_sem_extensao) . "." . $extensao;

                $pasta_usuario = $diretorio_upload . "usuario/";

                // VALIDANDO A EXTENSÃO DO ARQUIVO
                if (in_array($extensao, $extensao_arquivo)) {

                    // VALIDANDO O TAMANHO DO ARQUIVO
                    if ($imagem_tamanho < $tamanho_arquivo) {

                        // MOVE PARA O DIRETÓRIO DE IMAGENS
                        if (move_uploaded_file($imagem_nome_temporario, $pasta_usuario . $imagem_hash)) {

                            // PREPARANDO PARA GRAVAR A URL DA IMAGEM NA COLUNA 'AVATAR' DA TABELA
                            $url_avatar = CAMINHO_UPLOAD . "usuario/" . $imagem_hash;

                            // ATUALIZANDO AVATAR DO USUÁRIO
                            $sql = "UPDATE $tabela_base SET "
                                . "avatar = '$url_avatar'"
                                . "WHERE id='$id';";

                            $rs_sql = mysqli_query($conexao, $sql);

                            // VERIFICAR SE A QUERY EXECUTOU NORMALMENTE
                            if ($rs_sql) {

                                // SELECIONANDO O REGISTRO RECÉM ALTERADO
                                $status = 1;
                                $itens['avatar_url'] = $url_avatar;
                                $mensagem = "Imagem de enviada com sucesso.";
                                // 
                            } else {
                                $mensagem = "O registro não foi modificado";
                            }
                        } else {
                            $mensagem = "Não foi possível enviar o arquivo desejado";
                        }
                        // 
                    } else {
                        $mensagem = "Arquivo com tamanho acima do permitido. Permitido: 4MB.";
                    }
                    //
                } else {
                    $mensagem = "Arquivo com extensão não permitida. Permitidos: .jpeg, .jpg, .png, .gif";
                }
                //
            } else {
                $mensagem = "Arquivo de imagem inválido ou não enviado";
            }
            //
        }
        // SEM NENHUMA AÇÃO PARA A VERBOSE POST
        else {
            $mensagem = "Requisição malfeita. Ação inválida";
        }

        // RESPOSTAS
        $json['status'] = $status;

        if ($mensagem != '') {
            $json['mensagem'] = $mensagem;
        }

        if (count($itens) > 0) {
            $json['dados'] = $itens;
        }

        if (count($msg_erro) > 0) {
            $json['erro'] = $msg_erro;
        }
    }
    // POST - AUTENTICAÇÃO INCLUSÃO DE REGISTRO
    elseif (($METODO == "POST") && (isset($CORPO_JSON) && sizeof($CORPO_JSON))) {

        // EXTRAINDO O CORPOR
        extract($CORPO_JSON);

        // CASO NÃO TENHA A AÇÃO LOGAR SERÁ PARA INSERIR UM USUÁRIO
        if ($acao == 'nova_conta') {

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

            // VERIFICANDO SE JÁ EXISTE UMA CONTA PARA O E-MAIL ENVIADO
            $rs_existe = mysqli_query($conexao, "SELECT id FROM $tabela_base WHERE email = '$email';");
            $num_linhas = mysqli_num_rows($rs_existe);

            if ($num_linhas >= 1) {
                $lista_erros[] = "E-mail já usado para outra conta";
            }

            // CASO NÃO TENHA CAÍDO EM NENHUMA CRÍTICA VAMOS INSERI-LO
            if (!sizeof($lista_erros)) {

                // GERANDO TOKEN UNIFICADO
                $token = getGUID($email . "/." . $senha . "-" . time());

                // GERANDO HASH DE SENHA
                $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

                // FRAGMENTANDO O NOME (NOME + SOBRENOME) PARA AMOSTRAGEM REDUZIDA NO PERFIL
                $fragmento = explode(" ", $nome);
                $nome_perfil = $fragmento[0] . " " . end($fragmento);

                // GERANDO AVATAR PADRÃO
                $url_avatar = CAMINHO_UPLOAD . "usuario/default.jpg";

                // SQL DEVIDAMENTE PRONTO PARA BANCO DE DADOS
                $sql = "INSERT INTO $tabela_base SET "
                    . "nome = UPPER('$nome'), "
                    . "nome_perfil = UPPER('$nome_perfil'), "
                    . "token = '$token', "
                    . "email = '$email', "
                    . "avatar = '$url_avatar', "
                    . "senha = '$hash_senha'";

                $rs_sql = mysqli_query($conexao, $sql);

                // VERIFICAR SE A QUERY EXECUTOU NORMALMENTE
                if ($rs_sql) {

                    // O ID DA ÚLTIMA CONTA INSERIDA
                    $usuario_inserido = mysqli_insert_id($conexao);

                    $rs_sql = mysqli_query($conexao, "SELECT nome, nome_perfil, email, cadastro FROM $tabela_base WHERE id='$usuario_inserido';");
                    $linha = mysqli_fetch_assoc($rs_sql);
                    $itens[] = $linha;

                    $status = 1;
                    $mensagem = "Conta de usuário gerada com sucesso.";
                } else {
                    $mensagem = "O registro não foi modificado";
                }
            }
            // CAIU EM ALGUMA CRÍTICA DE VALIDAÇÃO ENTÃO VAMOS RETORNARO ERRO
            else {
                $msg_erro[] = $lista_erros;
            }
        }
        // VERIFICANDO AÇÃO DO POST
        elseif ($acao == 'autenticar') {

            // BUSCAR USUARIO POR EMAIL
            $sql = "SELECT id, nome, senha, nome_perfil, email, ultimo_acesso, token, avatar AS avatar_url FROM $tabela_base WHERE email = '$email';";

            $rs_existe = mysqli_query($conexao, $sql);
            $num_linha = mysqli_num_rows($rs_existe);

            // CONTA EXISTENTE PARA O E-MAIL ENVIADO. TESTE DE SENHA POSTERIORMENTE
            if ($num_linha == 1) {

                $linha = mysqli_fetch_assoc($rs_existe);

                // VERIFICANDO O HASH ENCONTRADO NA BASE COM O ENVIADO
                if (password_verify($senha, $linha['senha'])) {

                    // INICIA A SESSÃO E REDIRECIONA A PÁGINA
                    $status = 1;
                    $mensagem = "Login efetuado com sucesso";

                    // INICIANDO A SESSÃO
                    session_start();

                    // ATRIBUINDO OS DADOS DO USUÁRIO ENCONTRADO AO RETUORNO DE DADOS
                    foreach ($linha as $col => $val) :
                        if ($col != 'senha') {
                            $itens[$col] = $val;
                            $_SESSION['logado'][$col] = $val;
                        }
                    endforeach;

                    // PREPARANDO CAMPOS PARA A TABELA DE SESSÕES
                    $usuario_id = $linha['id'];
                    $session_id = session_id();
                    $tempo_inicial = time();
                    $data_acesso = date('Y-m-d H:i:s');

                    // ADICIONA A SESSÃO DA CONTA EM BASE DE DADOS
                    $sql = "INSERT INTO $tabela_sessao SET "
                        . "usuario_id = '$usuario_id', "
                        . "sessao_id = '$session_id', "
                        . "tempo_inicial = '$tempo_inicial', "
                        . "data_acesso = '$data_acesso';";

                    $rs_sql = mysqli_query($conexao, $sql);
                } else {
                    $mensagem = "Dados inválidos";
                }
                // 
            }
            // CONTA NÃO EXISTENTE
            elseif ($num_linha == 0) {
                $mensagem = "Não há conta registrada para este e-mail de acesso";
            }
            // 
        }
        // SEM NENHUMA AÇÃO PARA A VERBOSE POST
        else {
            $mensagem = "Requisição malfeita. Ação inválida";
        }

        // RESPOSTAS
        $json['status'] = $status;

        if ($mensagem != '') {
            $json['mensagem'] = $mensagem;
        }

        if (count($itens) > 0) {
            $json['dados'] = $itens;
        }

        if (count($msg_erro) > 0) {
            $json['erro'] = $msg_erro;
        }
    }
    // PUT - ALTERAÇÃO DE REGISTRO
    elseif (($METODO == "PUT") && (isset($CORPO_JSON) && sizeof($CORPO_JSON))) {

        print_r($CORPO_JSON);

        // EXTRAINDO O CORPOR
        extract($CORPO_JSON);

        $id = isset($_GET['id']) ? mysqli_real_escape_string($conexao, $_GET['id']) : "";

        if ($id != '') {

            // CAPTURANDO OS DADOS
            // $nome = $_PUT['nome'];
            // $email = $_PUT['email'];
            // $senha = $_PUT['senha'];

            $nome = mysqli_real_escape_string($conexao, $nome);
            $email = mysqli_real_escape_string($conexao, $email);

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

            // SOMENTE CRIA UMA SENHA SE FOR ENVIADA OUTRA SENHA PARA ALTERAÇÃO
            if ($senha != '') {
                // GERANDO HASH DE SENHA
                $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
                $coluna_senha = "senha = '$hash_senha', ";
            }

            if (!sizeof($lista_erros)) {

                $atualizacao = date('Y-m-d H:i:s');

                // SQL DEVIDAMENTE PRONTO PARA BANCO DE DADOS
                $sql = "UPDATE $tabela_base SET "
                    . "nome = '$nome', "
                    . "atualizacao = '$atualizacao', "
                    . $coluna_senha
                    . "email = '$email' WHERE id='$id';";

                $rs_sql = mysqli_query($conexao, $sql);

                // VERIFICAR SE A QUERY EXECUTOU NORMALMENTE
                if ($rs_sql) {

                    // SELECIONANDO O REGISTRO RECÉM ALTERADO
                    $rs_sql = mysqli_query($conexao, "SELECT * FROM $tabela_base WHERE id='$id';");
                    $linha = mysqli_fetch_assoc($rs_sql);
                    $itens[] = $linha;

                    // 
                } else {
                    $mensagem = "O registro não foi modificado";
                }
                // 
            } else {
                $msg_erro[] = $lista_erros;
            }
            // 
        } else {
            $mensagem = "Requisição malfeita";
        }

        // RESPOSTAS
        $json['status'] = $status;

        if ($mensagem != '') {
            $json['mensagem'] = $mensagem;
        }

        $json['dados'] = $itens;

        if (count($msg_erro) > 0) {
            $json['erro'] = $msg_erro;
        }
    }
    // DELETE - REMOÇÃO DE REGISTRO
    elseif (($METODO == "DELETE") && (isset($CORPO_JSON) && sizeof($CORPO_JSON))) {

        // EXTRAINDO O CORPOR
        extract($CORPO_JSON);

        // EVITANDO INJEÇÃO SQL
        $id = isset($id) ? mysqli_real_escape_string($conexao, $id) : "";

        // EXTRAINDO CORPO JSON
        if ($id != '') {

            $rs_existe = mysqli_query($conexao, "SELECT sessao_id FROM $tabela_sessao WHERE usuario_id='$id';");
            $num_linhas = mysqli_num_rows($rs_existe);

            if ($num_linhas >= 1) {

                $ultimo_acesso = date('Y-m-d H:i:s');

                $rs_ultimo_acesso = mysqli_query($conexao, "UPDATE $tabela_base SET ultimo_acesso = '$ultimo_acesso' WHERE id = '$id';");

                if ($rs_ultimo_acesso) {

                    $rs_sessao = mysqli_query($conexao, "DELETE FROM $tabela_sessao WHERE usuario_id = '$id';");

                    if (isset($_SESSION['logado'])) session_destroy();

                    $status = 1;
                    $mensagem = "Você fez logout do sistema.";
                    // 
                } else {
                    $mensagem = "Sessão não ativa";
                }
                // 
            } else {
                $mensagem = "Usuário não logado";
            }
            //
        } else {
            $mensagem = "Requisição malfeita";
        }

        // RESPOSTAS
        $json['status'] = $status;
        $json['mensagem'] = $mensagem;
    }
    // METÓDO NÃO ACEITO
    else {
        // RESPOSTAS
        $json['status'] = $status;
        $json['mensagem'] = "Método não permitido";
    }
    // 
} else {
    // RESPOSTAS
    $json['status'] = $status;
    $json['mensagem'] = "Falha de autenticação";
}

// FECHANDO A CONEXÃO COM A BASE DE DADOS
@mysqli_close($conexao);

// SETANDO CONTENT-TYPE PARA JSON
header('Content-type: application/json');
echo json_encode($json);

// 200: OK. Tudo funcionou conforme o esperado;
// 201: Um recurso foi criado com êxito em resposta a uma requisição POST. O cabeçalho location contém a URL que aponta para o recurso recém-criado;
// 204: A requisição foi tratada com sucesso e a resposta não contém nenhum conteúdo no corpo (por exemplo uma requisição DELETE);
// 304: O recurso não foi modificado. Você pode usar a versão em cache;
// 400: Requisição malfeita. Isto pode ser causado por várias ações por parte do usuário, tais como o fornecimento de um JSON inválido no corpo da requisição, fornecendo parâmetros inválidos, etc;
// 401: Falha de autenticação;
// 403: O usuário autenticado não tem permissão para acessar o recurso da API solicitado;
// 404: O recurso requisitado não existe;
// 405: Método não permitido. Favor verificar o cabeçalho Allow para conhecer os métodos HTTP permitidos;
// 415: Tipo de mídia não suportada. O número de versão ou o content type requisitado são inválidos;
// 422: Falha na validação dos dados (na resposta a uma requisição POST, por exemplo). Por favor, verifique o corpo da resposta para visualizar a mensagem detalhada do erro;
// 429: Excesso de requisições. A requisição foi rejeitada devido a limitação de taxa;
// 500: Erro interno do servidor. Isto pode ser causado por erros internos do programa.
