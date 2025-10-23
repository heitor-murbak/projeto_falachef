// Dados das receitas de Bolinho de Chuva
const recipes = {
    'classico': {
        title: 'Bolinho de Chuva Clássico',
        image: '../images/bolinho (2).jpg',
        description: 'A receita tradicional que lembra a infância, perfeita para dias frios.',
        ingredients: [
            '2 xícaras de farinha de trigo',
            '2 ovos',
            '1/2 xícara de leite',
            '1/2 xícara de açúcar',
            '1 colher (sopa) de fermento em pó',
            '1 pitada de sal',
            'Óleo para fritar',
            'Canela e açúcar para polvilhar'
        ],
        preparation: [
            'Em uma tigela, misture os ovos com o açúcar até obter um creme claro.',
            'Adicione o leite e misture bem.',
            'Aos poucos, acrescente a farinha de trigo peneirada com o fermento e o sal.',
            'Misture até obter uma massa homogênea, mas não bata demais.',
            'Aqueça o óleo em uma panela funda.',
            'Com duas colheres, forme os bolinhos e coloque cuidadosamente no óleo quente.',
            'Frite até ficarem dourados por todos os lados.',
            'Retire com uma escumadeira e coloque sobre papel toalha.',
            'Polvilhe com a mistura de canela e açúcar.',
            'Sirva ainda quente.'
        ],
        tip: 'Para bolinhos mais fofos, deixe a massa descansar por 15 minutos antes de fritar.'
    },
    'canela-acucar': {
        title: 'Bolinho de Chuva com Canela e Açúcar',
        image: '../images/docecanela.jpg',
        description: 'A combinação perfeita de canela e açúcar que todo mundo adora.',
        ingredients: [
            '2 xícaras de farinha de trigo',
            '2 ovos',
            '3/4 xícara de leite',
            '1/3 xícara de açúcar',
            '1 colher (chá) de canela em pó',
            '1 colher (sopa) de fermento em pó',
            '1 pitada de sal',
            'Óleo para fritar',
            '1/2 xícara de açúcar para polvilhar',
            '2 colheres (sopa) de canela em pó para polvilhar'
        ],
        preparation: [
            'Em uma tigela, bata os ovos com o açúcar até ficar cremoso.',
            'Adicione o leite e a canela, misturando bem.',
            'Incorpore a farinha peneirada com o fermento e o sal.',
            'Misture apenas até incorporar os ingredientes.',
            'Aqueça o óleo em fogo médio.',
            'Com uma colher de sopa, pegue porções da massa e com outra colher, empurre no óleo.',
            'Frite até dourar, virando para fritar por igual.',
            'Escorra em papel toalha.',
            'Misture o açúcar com a canela e passe os bolinhos nessa mistura.',
            'Sirva imediatamente.'
        ],
        tip: 'Misture a canela com o açúcar antes de polvilhar para distribuição uniforme.'
    },

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
                        <p><strong>Rende aproximadamente 30 bolinhos</strong></p>
                        ${ingredientsHtml}
                    </div>

                    <div class="recipe-section">
                        <h2>Modo de Preparo</h2>
                        <p><strong>Tempo estimado: 25 minutos</strong></p>
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
            console.log(`Clicou na receita: ${recipeId}`);
            showRecipe(recipeId);
        });
    });
    
    // Adicionar mensagem de debug no console
    console.log('JavaScript carregado. Receitas disponíveis:', Object.keys(recipes));
});