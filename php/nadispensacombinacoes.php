<?php
require __DIR__ . '/config.php';

$categorias_combinacoes_list = [
    'Carnes', 
    'Frutos do Mar', 
    'Vegetais', 
    'Massas', 
    'Grãos', 
    'Molhos', 
    'Óleos', 
    'Ervas', 
    'Laticínios', 
    'Temperos e Essências',
    'Frutas Frescas',
    'Açúcar e Chocolates',
    'Bebidas Alcoólicas',
    'Bebidas',
    'Doces e Massas',
    'Frutas Congeladas'
];

$stmt_ingredientes_combinacoes = $pdo->prepare(
    "SELECT i.id, i.nome, i.categoria
     FROM ingredientes i
     WHERE i.categoria IN (" . str_repeat('?,', count($categorias_combinacoes_list)-1) . "?)
     ORDER BY i.categoria, i.nome"
);
$stmt_ingredientes_combinacoes->execute($categorias_combinacoes_list);

if ($stmt_ingredientes_combinacoes) {
    $ingredientes_combinacoes = $stmt_ingredientes_combinacoes->fetchAll();
    
    $categorias_combinacoes = [];
    foreach ($ingredientes_combinacoes as $ing) {
        if (!in_array($ing['categoria'], $categorias_combinacoes)) {
            $categorias_combinacoes[] = $ing['categoria'];
        }
    }
    sort($categorias_combinacoes);

    $porCategoria = [];
    foreach ($ingredientes_combinacoes as $ing) {
        $porCategoria[$ing['categoria']][] = $ing;
    }
} else {
    $categorias_combinacoes = $categorias_combinacoes_list;
    $porCategoria = [];
}

$receitas = [];
$ingredientes_selecionados = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredientes'])) {
    $ingredientes_selecionados = $_POST['ingredientes'];
    
    if (!empty($ingredientes_selecionados)) {
        $placeholders = str_repeat('?,', count($ingredientes_selecionados) - 1) . '?';
        
        $sql = "
            SELECT r.id, r.nome, r.descricao, r.tempo_preparo, r.dificuldade, r.instrucoes,
                   COUNT(ri.ingrediente_id) as ingredientes_match
            FROM receitas r
            INNER JOIN receita_ingrediente ri ON r.id = ri.receita_id
            WHERE ri.ingrediente_id IN ($placeholders)
            AND r.categoria = 'Combinações'
            GROUP BY r.id
            HAVING ingredientes_match > 0
            ORDER BY ingredientes_match DESC, r.nome
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ingredientes_selecionados);
        $receitas = $stmt->fetchAll();
        
        foreach ($receitas as &$receita) {
            $sql_total = "SELECT COUNT(*) as total FROM receita_ingrediente WHERE receita_id = ?";
            $stmt_total = $pdo->prepare($sql_total);
            $stmt_total->execute([$receita['id']]);
            $total_ing = $stmt_total->fetchColumn();
            $receita['total_ingredientes'] = $total_ing;
            $receita['percentual'] = $total_ing > 0 ? round(($receita['ingredientes_match'] / $total_ing) * 100) : 0;
            
            $sql_ingredientes = "
                SELECT i.id, i.nome, ri.quantidade 
                FROM receita_ingrediente ri 
                JOIN ingredientes i ON ri.ingrediente_id = i.id 
                WHERE ri.receita_id = ?
                ORDER BY i.nome
            ";
            $stmt_ing = $pdo->prepare($sql_ingredientes);
            $stmt_ing->execute([$receita['id']]);
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
    <title>Combinações — Na Despensa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/nadispensacombinacoes.css">
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
                        <li><a href="../receitas/doce/index.html">Doces</a></li>
                        <li><a href="../receitas/salgado/index.html">Salgados</a></li>
                    </ul>
                </li>
                <li><a href="../arte/artecultura.html">Arte e Cultura</a></li>
                <li><a href="../noticias.html">Notícias</a></li>
                <li><a href="../drinks completo (1)/drinks/index.html">Drinks</a></li>
                <li><a href="nadispensa.php" class="active">Na Despensa</a></li>
            </ul>
        </nav>
    </header>

    <div class="banner-combinacoes">
        <h1>COMBINAÇÕES</h1>
    </div>

    <div class="main-container">
        <form method="post" action="">
            <div class="filters-box">
                <div class="filter-header">
                    <?php if (!empty($ingredientes_selecionados)): ?>
                    <p class="selected-count">✓ <?= count($ingredientes_selecionados) ?> ingrediente(s) selecionado(s)</p>
                    <?php endif; ?>
                </div>

                <?php foreach ($categorias_combinacoes as $categoria): ?>
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
                            <p>Encontramos <?= count($receitas) ?> combinação(ões) compatível(eis)!</p>
                        </div>
                        <div class="recipe-results">
                            <?php foreach ($receitas as $receita): ?>
                            <div class="recipe-card">
                                <div class="recipe-header">
                                    <h3><?= htmlspecialchars($receita['nome']) ?></h3>
                                    <span class="compatibility-badge">
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
                                    <div class="ingredients-list">
                                        <?php foreach ($receita['ingredientes'] as $ingrediente): 
                                            $tem_ingrediente = in_array($ingrediente['id'], $ingredientes_selecionados);
                                            $classe = $tem_ingrediente ? 'has-ingredient' : 'missing-ingredient';
                                            $icone = $tem_ingrediente ? '✓' : '✗';
                                        ?>
                                        <div class="ingredient-line <?= $classe ?>">
                                            <span class="ingredient-icon"><?= $icone ?></span>
                                            <span class="ingredient-name"><?= htmlspecialchars($ingrediente['nome']) ?></span>
                                            <span class="ingredient-quantity"><?= htmlspecialchars($ingrediente['quantidade']) ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
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
                            <h3>😕 Nenhuma combinação encontrada</h3>
                            <p>Não encontramos combinações com os ingredientes selecionados.<br>Tente selecionar outros ingredientes!</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="placeholder-content">
                        <h3>🍽️ Selecione os ingredientes</h3>
                        <p>Escolha os ingredientes que você tem disponível e clique em "Mostrar receitas" para encontrar ótimas combinações!</p>
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