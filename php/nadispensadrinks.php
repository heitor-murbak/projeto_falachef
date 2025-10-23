<?php
require __DIR__ . '/config.php';

$categorias_drinks_list = [
    'Bebidas Alcoólicas', 
    'Bebidas', 
    'Frutas Frescas', 
    'Frutas Congeladas', 
    'Ervas', 
    'Açúcar e Chocolates',
    'Laticínios',
    'Temperos e Essências',
    'Outros'
];

$stmt_ingredientes_drinks = $pdo->prepare(
    "SELECT i.id, i.nome, i.categoria
     FROM ingredientes i
     WHERE i.categoria IN (" . str_repeat('?,', count($categorias_drinks_list)-1) . "?)
     ORDER BY i.categoria, i.nome"
);
$stmt_ingredientes_drinks->execute($categorias_drinks_list);

if ($stmt_ingredientes_drinks) {
    $ingredientes_drinks = $stmt_ingredientes_drinks->fetchAll();
    
    $categorias_drinks = [];
    foreach ($ingredientes_drinks as $ing) {
        if (!in_array($ing['categoria'], $categorias_drinks)) {
            $categorias_drinks[] = $ing['categoria'];
        }
    }
    sort($categorias_drinks);

    $porCategoria = [];
    foreach ($ingredientes_drinks as $ing) {
        $porCategoria[$ing['categoria']][] = $ing;
    }
} else {
    $categorias_drinks = $categorias_drinks_list;
    $porCategoria = [];
}

$receitas = [];
$ingredientes_selecionados = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredientes'])) {
    $ingredientes_selecionados = $_POST['ingredientes'];
    
    if (!empty($ingredientes_selecionados)) {
        $placeholders = str_repeat('?,', count($ingredientes_selecionados) - 1) . '?';
        
        $sql_total = "
            SELECT r.id, COUNT(DISTINCT ri.ingrediente_id) as total_ingredientes
            FROM receitas r
            INNER JOIN receita_ingrediente ri ON r.id = ri.receita_id
            WHERE r.categoria = 'Drinks'
            GROUP BY r.id
        ";
        $stmt_total = $pdo->query($sql_total);
        $totais = [];
        while ($row = $stmt_total->fetch()) {
            $totais[$row['id']] = $row['total_ingredientes'];
        }
        
        $sql = "
            SELECT r.id, r.nome, r.descricao, r.tempo_preparo, r.dificuldade, r.instrucoes,
                   COUNT(ri.ingrediente_id) as ingredientes_match
            FROM receitas r
            INNER JOIN receita_ingrediente ri ON r.id = ri.receita_id
            WHERE ri.ingrediente_id IN ($placeholders)
            AND r.categoria = 'Drinks'
            GROUP BY r.id
            HAVING ingredientes_match > 0
            ORDER BY ingredientes_match DESC, r.nome
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ingredientes_selecionados);
        $receitas = $stmt->fetchAll();
        
        foreach ($receitas as &$receita) {
            $receita['total_ingredientes'] = $totais[$receita['id']] ?? 0;
            $receita['percentual'] = $receita['total_ingredientes'] > 0 
                ? round(($receita['ingredientes_match'] / $receita['total_ingredientes']) * 100) 
                : 0;
            
            $sql_ingredientes = "
                SELECT i.nome, ri.quantidade, 
                       CASE WHEN i.id IN (" . str_repeat('?,', count($ingredientes_selecionados)-1) . "?) 
                            THEN 1 ELSE 0 END as tem
                FROM receita_ingrediente ri 
                JOIN ingredientes i ON ri.ingrediente_id = i.id 
                WHERE ri.receita_id = ?
                ORDER BY tem DESC, i.nome
            ";
            $params = array_merge($ingredientes_selecionados, [$receita['id']]);
            $stmt_ing = $pdo->prepare($sql_ingredientes);
            $stmt_ing->execute($params);
            $receita['ingredientes'] = $stmt_ing->fetchAll();
        }
        unset($receita);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drinks — Na Despensa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/nadispensadrinks.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="back-btn">
                <a href="nadispensa.php"><img src="../images/seta.png" alt="Voltar"></a>
            </div>
            <div class="logo">
                <img src="../images/falachef.png" alt="Fala Chef">
            </div>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="#">Receitas ▼</a>
                    <ul class="dropdown">
                        <li><a href="../../receitas/doce/index.html">Doces</a></li>
                        <li><a href="../../receitas/salgado/index.html">Salgados</a></li>
                    </ul>
                </li>
                <li><a href="../arte/artecultura.html">Arte e Cultura</a></li>
                <li><a href="../noticias.html">Notícias</a></li>
                <li><a href="../drinks completo (1)/drinks/index.html">Drinks</a></li>
                <li><a href="nadispensa.php" class="active">Na Despensa</a></li>
            </ul>
        </nav>
    </header>

    <div class="banner-drinks">
        <h1>DRINKS & BEBIDAS</h1>
    </div>

    <div class="main-container">
        <form method="post" action="">
            <div class="filters-box">
                <div class="filter-header">
                    <?php if (!empty($ingredientes_selecionados)): ?>
                    <p class="selected-count">✓ <?= count($ingredientes_selecionados) ?> ingrediente(s) selecionado(s)</p>
                    <?php endif; ?>
                </div>

                <?php foreach ($categorias_drinks as $categoria): ?>
                    <?php if (isset($porCategoria[$categoria])): ?>
                    <div class="category-section">
                        <div class="category-header">
                            <span><?= htmlspecialchars($categoria) ?> (<?= count($porCategoria[$categoria]) ?>)</span>
                            <span class="toggle-icon">+</span>
                        </div>
                        <div class="ingredients-grid">
                            <?php foreach ($porCategoria[$categoria] as $ing): ?>
                            <div class="ingredient-item">
                                <input type="checkbox" 
                                        name="ingredientes[]" 
                                        value="<?= (int)$ing['id'] ?>" 
                                        id="ing_<?= $ing['id'] ?>"
                                        <?= in_array($ing['id'], $ingredientes_selecionados) ? 'checked' : '' ?>>
                                <label for="ing_<?= $ing['id'] ?>"><?= htmlspecialchars($ing['nome']) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <button type="submit" class="search-button">Mostrar receitas</button>
            </div>

            <div class="results-section">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <?php if (!empty($receitas)): ?>
                        <div class="info-message">
                            <p>Encontramos <?= count($receitas) ?> receita(s) de drinks compatível(eis)!</p>
                        </div>
                        <div class="recipe-results">
                            <?php foreach ($receitas as $receita): ?>
                            <div class="recipe-card">
                                <div class="recipe-header">
                                    <h3><?= htmlspecialchars($receita['nome']) ?></h3>
                                    <span class="compatibility-badge" title="Compatibilidade">
                                        <?= $receita['percentual'] ?>% compatível
                                    </span>
                                </div>
                                <p class="recipe-description"><?= htmlspecialchars($receita['descricao']) ?></p>
                                
                                <div class="recipe-meta">
                                    <span>⏱ Tempo: <?= $receita['tempo_preparo'] ?> min</span>
                                    <span>📊 Dificuldade: <?= $receita['dificuldade'] ?></span>
                                    <span>✓ <?= $receita['ingredientes_match'] ?>/<?= $receita['total_ingredientes'] ?> ingredientes</span>
                                </div>
                                
                                <div class="ingredients-section">
                                    <h4>🥄 Ingredientes:</h4>
                                    <?php foreach ($receita['ingredientes'] as $ingrediente): ?>
                                    <div class="ingredient-line <?= $ingrediente['tem'] ? 'has-ingredient' : 'missing-ingredient' ?>">
                                        <span class="ingredient-icon"><?= $ingrediente['tem'] ? '✓' : '✗' ?></span>
                                        <span class="ingredient-name"><?= htmlspecialchars($ingrediente['nome']) ?></span>
                                        <span class="ingredient-quantity"><?= htmlspecialchars($ingrediente['quantidade']) ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <?php if (!empty($receita['instrucoes'])): ?>
                                <div class="instructions-section">
                                    <h4>👨‍🍳 Modo de Preparo:</h4>
                                    <div class="instructions">
                                        <?= nl2br(htmlspecialchars($receita['instrucoes'])) ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="placeholder-content no-results">
                            <h3>😕 Nenhuma bebida encontrada</h3>
                            <p>Não encontramos receitas de drinks ou bebidas com os ingredientes selecionados.<br>Tente selecionar outros ingredientes!</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="placeholder-content">
                        <h3>🍹 Selecione os ingredientes</h3>
                        <p>Escolha os ingredientes que você tem disponível e clique em "Mostrar receitas" para encontrar deliciosos drinks e bebidas!</p>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="footer">
        <p>© 2025 - Fala Chef! – Todos os direitos reservados</p>
    </div>

    <script>
        document.querySelectorAll('.category-header').forEach(header => {
            header.addEventListener('click', () => {
                const section = header.parentElement;
                section.classList.toggle('active');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.category-section').forEach(section => {
                const hasChecked = section.querySelector('input[type="checkbox"]:checked');
                if (hasChecked) {
                    section.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>