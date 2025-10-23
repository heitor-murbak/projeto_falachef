<?php  
    $domain = "localhost";   // Localização do servidor
    $user = "root";          // Usuário do banco de dados
    $password = "";          // Senha do banco de dados
    $database = "receitas_db"; // Nome do banco de dados

    // Criando a conexão com o banco de dados
    $mysqli = new mysqli($domain, $user, $password, $database);

    // Verifica se houve erro na conexão
    if ($mysqli->connect_errno) {
        exit("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
    }

    // Definir o charset para evitar problemas com acentos
    $mysqli->set_charset("utf8");
?>