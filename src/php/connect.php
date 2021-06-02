<?php

header('Content-Type: text/html; charset=utf-8');

# SERVIDOR ONDE ESTÁ LOCALIZADO O BANCO DE DADOS 
$servidor = $config["host_bd"];

# NOME DO BANCO DE DADOS
$db = $config["BD"];

# USUÁRIO PARA TER ACESSO AO BANCO
$usuario = $config["user_bd"];

# SENHA DE ACESSO AO BANCO
$senha = $config["pass_bd"];

$conexao = mysqli_connect($servidor, $usuario, $senha, $db);

if (!$conexao) {
    echo "Error: Unable to connect to MySQL.<br />";
    echo "Debugging errno: " . mysqli_connect_errno() . "<br />";
    echo "Debugging error: " . mysqli_connect_error() . "<br />";
    exit;
}
else {
    //echo "Success: A proper connection to MySQL $host was made! The my_db database is great. <br />";
    //echo "Host information: " . mysqli_get_host_info($conexao) . "<br />";
    
    mysqli_query($conexao,"SET NAMES 'utf8'");
	mysqli_query($conexao,'SET character_set_connection=utf8');
	mysqli_query($conexao,'SET character_set_client=utf8');
	mysqli_query($conexao,'SET character_set_results=utf8');
}
