<?php
// Ativa exibição de erros em desenvolvimento (remova em produção)
ini_set('display_errors', 1);           // exibe erros
ini_set('display_startup_errors', 1);   // exibe erros de startup
error_reporting(E_ALL);                 // nível máximo de erro

// Configurações do banco
$db_host = 'localhost';                 // host do MySQL (XAMPP/WAMP normalmente é localhost)
$db_name = 'receitas_db';               // nome do banco criado no script SQL
$db_user = 'root';                      // usuário do MySQL (padrão no XAMPP)
$db_pass = '';                          // senha (vazia no XAMPP, ajuste se necessário)

try {
    // DSN de conexão (driver mysql + host + dbname + charset)
    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4"; // define DSN

    // Cria uma instância de PDO com opções de segurança/performance
    $pdo = new PDO(
        $dsn,                             // DSN
        $db_user,                         // usuário
        $db_pass,                         // senha
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // lança exceções em erros SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // fetch em array associativo
            PDO::ATTR_EMULATE_PREPARES => false,         // usa prepared statements nativos
        ]
    );
} catch (PDOException $e) {
    // Encerra a execução com mensagem amigável se falhar a conexão
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage()); // mensagem de erro
}
