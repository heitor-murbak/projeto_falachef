<?php
// Importa a conexão PDO
require __DIR__ . '/config.php'; // inclui a conexão com o banco

// Obtém o array de ingredientes enviado via POST com filtro básico
$selecionados = filter_input(INPUT_POST, 'ingredientes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); // coleta checkboxes

// Se nada foi selecionado, informa e encerra
if (!$selecionados || count($selecionados) === 0) { // verifica vazio
    echo '<p>Selecione ao menos um ingrediente e tente novamente.</p>'; // mensagem ao usuário
    echo '<p><a href="index.php">Voltar</a></p>'; // link de volta
    exit; // finaliza o script
}

// Converte os valores para inteiros para segurança
$selecionados = array_map('intval', $selecionados); // força números

// Cria a lista de placeholders "?, ?, ?, ..." para o IN()
$placeholders = implode(',', array_fill(0, count($selecionados), '?')); // ex.: "?, ?, ?"

// Monta a SQL que encontra receitas contendo TODOS os ingredientes selecionados
$sql =
"SELECT r.id, r.nome, r.descricao                   -- seleciona dados da receita
 FROM receitas r                                     -- tabela principal
 JOIN receita_ingrediente ri ON ri.receita_id = r.id -- junta ingredientes da receita
 WHERE ri.ingrediente_id IN ($placeholders)          -- filtra apenas pelos ingredientes escolhidos
 GROUP BY r.id                                       -- agrupa por receita
 HAVING COUNT(DISTINCT ri.ingrediente_id) = ?";      // exige que a receita tenha TODOS os selecionados

// Prepara a query
$stmt = $pdo->prepare($sql); // prepara a consulta

// Monta os parâmetros: todos os ingredientes + o número total (para o HAVING)
$params = array_merge($selecionados, [count($selecionados)]); // última posição é o total

// Executa a query com os parâmetros
$stmt->execute($params); // executa de forma segura, evitando SQL injection

// Obtém as receitas encontradas
$receitas = $stmt->fetchAll(); // busca todas as linhas

// HTML básico do resultado
?>
<!doctype html>
<html lang="pt-br"> <!-- idioma -->
<head>
  <meta charset="utf-8"> <!-- charset -->
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- responsivo -->
  <title>Resultados da busca</title> <!-- título -->
  <style>
    body{font-family:system-ui,Arial,sans-serif;margin:24px;background:#fafafa}
    h1{margin-bottom:8px}
    .card{background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;margin:10px 0;box-shadow:0 1px 2px rgba(0,0,0,.04)}
    a.btn{display:inline-block;margin-top:12px;text-decoration:none;background:#0b9444;color:#fff;padding:10px 14px;border-radius:10px}
    .muted{color:#666}
  </style>
</head>
<body>
  <h1>Receitas encontradas</h1> <!-- cabeçalho -->

  <?php if (count($receitas) === 0): ?> <!-- nenhuma encontrada -->
    <p class="muted">Nenhuma receita encontrada com <strong>todos</strong> os ingredientes selecionados.</p> <!-- mensagem -->
  <?php else: ?> <!-- existem receitas -->
    <?php foreach ($receitas as $r): ?> <!-- lista cada receita -->
      <div class="card"> <!-- cartão -->
        <h2><?= htmlspecialchars($r['nome']) ?></h2> <!-- nome da receita -->
        <p><?= htmlspecialchars($r['descricao'] ?? 'Sem descrição.') ?></p> <!-- descrição -->
        <?php
          // Busca e exibe os ingredientes dessa receita (só para enriquecer a página)
          $stmtIng = $pdo->prepare(
            "SELECT i.nome
             FROM ingredientes i
             JOIN receita_ingrediente ri ON ri.ingrediente_id = i.id
             WHERE ri.receita_id = ?
             ORDER BY i.nome"
          ); // consulta dos ingredientes da receita
          $stmtIng->execute([$r['id']]); // executa passando o id da receita
          $ings = $stmtIng->fetchAll(PDO::FETCH_COLUMN); // pega só a coluna nome
        ?>
        <p class="muted"><strong>Ingredientes:</strong> <?= htmlspecialchars(implode(', ', $ings)) ?></p> <!-- lista -->
      </div>
    <?php endforeach; ?> <!-- fim loop receitas -->
  <?php endif; ?> <!-- fim condição resultados -->

  <p><a class="btn" href="index.php">Fazer nova busca</a></p> <!-- botão voltar -->
</body>
</html>
