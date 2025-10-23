// Dados das receitas
const recipes = {
    'hot-roll': {
        title: 'Hot Roll',
        image: '../images/hot-roll.jpg',
        description: 'A versão brasileira do tempurá: sushi empanado e frito com recheio cremoso.',
        ingredients: [
            '200g de arroz para sushi',
            '3 colheres de sopa de vinagre de arroz',
            '1 colher de sopa de açúcar',
            '1/2 colher de chá de sal',
            '100g de salmão fresco',
            '100g de cream cheese',
            '1 pepino japonês',
            'Alga nori',
            'Farinha de rosca',
            '1 ovo batido',
            'Óleo para fritar'
        ],
        preparation: [
            'Cozinhe o arroz seguindo as instruções da embalagem.',
            'Misture o vinagre, açúcar e sal, e adicione ao arroz ainda quente.',
            'Corte o salmão em tiras finas e o pepino em palitos.',
            'Coloque uma folha de alga nori sobre a esteira de sushi.',
            'Espalhe o arroz sobre a alga, deixando uma borda livre.',
            'No centro, coloque o salmão, cream cheese e pepino.',
            'Enrole firmemente com a ajuda da esteira.',
            'Passe o rolinho no ovo batido e depois na farinha de rosca.',
            'Frite em óleo quente até dourar.',
            'Corte em pedaços e sirva com shoyu.'
        ],
        tip: 'Para um toque especial, sirva com molho tarê ou maionese temperada.'
    },
    'sushi-tropical': {
        title: 'Sushi Tropical',
        image: '../images/tropical.jpg',
        description: 'Combinação de salmão, manga e abacate com um toque de molho especial.',
        ingredients: [
            '200g de arroz para sushi',
            '3 colheres de sopa de vinagre de arroz',
            '1 colher de sopa de açúcar',
            '1/2 colher de chá de sal',
            '100g de salmão fresco',
            '1/2 manga madura',
            '1/4 de abacate',
            'Alga nori',
            'Gergelim torrado'
        ],
        preparation: [
            'Prepare o arroz para sushi seguindo o método tradicional.',
            'Corte o salmão, a manga e o abacate em tiras finas.',
            'Coloque uma folha de alga nori sobre a esteira de sushi.',
            'Espalhe o arroz sobre a alga, deixando uma borda livre.',
            'Vire a alga, colocando o arroz para baixo.',
            'No centro, coloque as tiras de salmão, manga e abacate.',
            'Enrole firmemente com a ajuda da esteira.',
            'Passe o rolinho no gergelim torrado.',
            'Corte em pedaços e sirva com molho tarê ou shoyu.'
        ],
        tip: 'Use frutas bem maduras para um sabor mais doce e agradável.'
    },
    'temaki': {
        title: 'Temaki Cremoso',
        image: '../images/temaki.jpg',
        description: 'O clássico cone japonês com toque brasileiro de cream cheese e cebolinha.',
        ingredients: [
            '200g de arroz para sushi',
            '3 colheres de sopa de vinagre de arroz',
            '1 colher de sopa de açúcar',
            '1/2 colher de chá de sal',
            '100g de salmão fresco',
            '50g de cream cheese',
            '1/2 pepino japonês',
            'Alga nori cortada em tiras',
            'Cebolinha verde picada',
            '1 colher de chá de shoyu',
            'Wasabi a gosto'
        ],
        preparation: [
            'Prepare o arroz para sushi conforme instruções tradicionais.',
            'Corte o salmão em cubos pequenos e misture com o cream cheese.',
            'Corte o pepino em tiras finas de aproximadamente 5cm.',
            'Pegue uma tira de alga nori e coloque uma camada fina de arroz no lado esquerdo.',
            'Adicione uma porção da mistura de salmão com cream cheese no centro.',
            'Coloque 2-3 tiras de pepino e uma pitada de cebolinha picada.',
            'Enrole a alga em formato de cone, começando pela ponta inferior esquerda.',
            'Feche bem as bordas para que o cone mantenha o formato.',
            'Sirva imediatamente com shoyu e wasabi.'
        ],
        tip: 'Para manter a crocância da alga, sirva os temakis imediatamente após o preparo.'
    },
    'camarao-empanado': {
        title: 'Camarão Empanado',
        image: '../images/camarao.jpg',
        description: 'Sushi frito com recheio de camarão empanado, uma delícia crocante.',
        ingredients: [
            '200g de arroz para sushi',
            '3 colheres de sopa de vinagre de arroz',
            '1 colher de sopa de açúcar',
            '1/2 colher de chá de sal',
            '150g de camarão médio limpo',
            'Farinha de trigo para empanar',
            'Farinha de rosca',
            '1 ovo batido',
            'Alga nori',
            'Óleo para fritar',
            'Sal e pimenta a gosto',
            'Maionese temperada para servir'
        ],
        preparation: [
            'Prepare o arroz para sushi e reserve.',
            'Tempere os camarões com sal e pimenta do reino.',
            'Passe os camarões na farinha de trigo, depois no ovo batido e por último na farinha de rosca.',
            'Frite os camarões em óleo quente (180°C) até ficarem dourados e crocantes.',
            'Escorra em papel toalha para remover o excesso de óleo.',
            'Coloque uma folha de alga nori sobre a esteira de sushi.',
            'Espalhe o arroz sobre a alga, deixando uma borda de 2cm livre na parte superior.',
            'No centro, coloque 3-4 camarões empanados em fila.',
            'Enrole firmemente com a ajuda da esteira, pressionando suavemente.',
            'Frite o rolinho por 2-3 minutos em óleo quente até dourar uniformemente.',
            'Retire e escorra o excesso de óleo.',
            'Corte em 8 pedaços iguais e sirva com maionese temperada.'
        ],
        tip: 'Para um sabor extra, adicione cream cheese ao recheio junto com os camarões.'
    },
    'hot-roll-doce': {
        title: 'Hot Roll Doce',
        image: '../images/hot-doce.jpg',
        description: 'Uma versão doce do hot roll, perfeita para sobremesa.',
        ingredients: [
            '200g de arroz para sushi',
            '3 colheres de sopa de vinagre de arroz',
            '2 colheres de sopa de açúcar',
            '1/2 colher de chá de sal',
            '1 banana madura',
            '2 colheres de sopa de chocolate em pó',
            '1 colher de sopa de açúcar mascavo',
            'Alga nori',
            'Farinha de rosca',
            '1 ovo batido',
            'Óleo para fritar',
            'Açúcar e canela para polvilhar',
            'Sorvete de baunilha para servir (opcional)'
        ],
        preparation: [
            'Prepare o arroz para sushi, adicionando um pouco mais de açúcar que o normal.',
            'Amasse a banana com um garfo e misture com o chocolate em pó e açúcar mascavo.',
            'Coloque uma folha de alga nori sobre a esteira de sushi.',
            'Espalhe o arroz sobre a alga, deixando uma borda de 2cm livre na parte superior.',
            'No centro, coloque a mistura de banana e chocolate formando uma linha.',
            'Enrole firmemente com a ajuda da esteira, pressionando para compactar.',
            'Passe o rolinho no ovo batido e depois na farinha de rosca, cobrindo completamente.',
            'Frite em óleo quente (170°C) por 3-4 minutos até dourar.',
            'Retire e escorra o excesso de óleo.',
            'Corte em 6 pedaços e polvilhe com a mistura de açúcar e canela.',
            'Sirva quente, acompanhado de sorvete de baunilha se desejar.'
        ],
        tip: 'Sirva com sorvete de baunilha para uma sobremesa completa e irresistível.'
    }
};

// Função para exibir a receita
function showRecipe(recipeId) {
    const recipe = recipes[recipeId];
    
    // Verificar se a receita existe
    if (!recipe) {
        console.error(`Receita não encontrada: ${recipeId}`);
        return;
    }
    
    const displayArea = document.getElementById('recipe-display');
    
    let ingredientsHtml = '<ul>';
    recipe.ingredients.forEach(ingredient => {
        ingredientsHtml += `<li>${ingredient}</li>`;
    });
    ingredientsHtml += '</ul>';
    
    let preparationHtml = '<ol>';
    recipe.preparation.forEach(step => {
        preparationHtml += `<li>${step}</li>`;
    });
    preparationHtml += '</ol>';
    
    displayArea.innerHTML = `
        <div class="recipe-container">
            <div class="recipe-title">
                <h1>${recipe.title}</h1>
                <p class="description">${recipe.description}</p>
            </div>
            
            <div class="recipe-layout">
                <div class="recipe-image-container">
                    <div class="recipe-image-frame">
                        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                    </div>
                </div>
                
                <div class="recipe-content">
                    <div class="recipe-section">
                        <h2>Ingredientes</h2>
                        <p><strong>Rende 4 porções</strong></p>
                        ${ingredientsHtml}
                    </div>

                    <div class="recipe-section">
                        <h2>Modo de Preparo</h2>
                        <p><strong>Tempo estimado: 40 minutos</strong></p>
                        ${preparationHtml}
                    </div>

                    <div class="recipe-tip">
                        <strong>Dica do Chef:</strong> ${recipe.tip}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Rolar suavemente até a receita
    displayArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Adicionar eventos de clique aos itens do carrossel quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    const carouselItems = document.querySelectorAll('.carousel-item');
    
    carouselItems.forEach(item => {
        item.addEventListener('click', function() {
            const recipeId = this.getAttribute('data-recipe');
            console.log(`Clicou na receita: ${recipeId}`); // Para debug
            showRecipe(recipeId);
        });
    });
    
    // Adicionar mensagem de debug no console
    console.log('JavaScript carregado. Receitas disponíveis:', Object.keys(recipes));
});