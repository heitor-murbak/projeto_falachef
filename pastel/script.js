// script.js - Funcionalidades para a página do Pastel

document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript do Pastel carregado!');
    
    // Dados das receitas de pastel
    const receitasPastel = {
        'carne': {
            titulo: 'Pastel de Carne',
            descricao: 'O clássico das feiras livres, crocante por fora e suculento por dentro',
            ingredientes: [
                '500g de carne moída',
                '1 cebola média picada',
                '2 dentes de alho picados',
                '1/2 xícara de salsinha picada',
                '1/2 xícara de cebolinha picada',
                'Sal e pimenta a gosto',
                '1 colher de sopa de óleo',
                'Massa para pastel (pronta ou caseira)',
                'Óleo para fritar'
            ],
            preparo: [
                'Aqueça o óleo em uma panela e refogue a cebola e o alho até dourarem.',
                'Adicione a carne moída e cozinhe até que esteja totalmente dourada.',
                'Tempere com sal, pimenta e acrescente a salsinha e cebolinha. Reserve para esfriar.',
                'Abra a massa para pastel em uma superfície enfarinhada.',
                'Coloque uma porção do recheio sobre uma metade da massa.',
                'Dobre a massa sobre o recheio e pressione as bordas para selar bem.',
                'Frite em óleo quente até dourar dos dois lados.',
                'Escorra em papel toalha e sirva quente.'
            ]
        },
        'queijo': {
            titulo: 'Pastel de Queijo',
            descricao: 'Simples, cremoso e irresistível - o favorito de muitas pessoas',
            ingredientes: [
                '300g de queijo mussarela ralado',
                '200g de queijo prato ralado',
                '1/4 xícara de parmesão ralado',
                '1 ovo (opcional, para dar liga)',
                'Sal a gosto',
                'Orégano a gosto',
                'Massa para pastel',
                'Óleo para fritar'
            ],
            preparo: [
                'Misture todos os queijos em uma tigela.',
                'Se desejar uma textura mais cremosa, adicione o ovo e misture bem.',
                'Tempere com orégano e um pouco de sal, se necessário.',
                'Abra a massa e recheie com a mistura de queijos.',
                'Feche bem as bordas pressionando com os dedos ou usando um garfo.',
                'Frite em óleo quente até ficar dourado e crocante.',
                'Escorra o excesso de óleo e sirva imediatamente.'
            ]
        },
        'frango': {
            titulo: 'Pastel de Frango',
            descricao: 'Cremoso e saboroso, perfeito para um lanche completo',
            ingredientes: [
                '500g de peito de frango cozido e desfiado',
                '1 cebola picada',
                '2 dentes de alho picados',
                '1/2 xícara de milho verde',
                '1/2 xícara de ervilhas',
                '1 cenoura ralada',
                '200g de creme de leite',
                'Sal, pimenta e cheiro-verde a gosto',
                'Massa para pastel',
                'Óleo para fritar'
            ],
            preparo: [
                'Refogue a cebola e o alho em uma panela com um fio de óleo.',
                'Adicione o frango desfiado e misture bem.',
                'Incorpore o milho, ervilhas e cenoura ralada.',
                'Tempere com sal, pimenta e cheiro-verde.',
                'Adicione o creme de leite e cozinhe por mais 5 minutos.',
                'Deixe o recheio esfriar completamente.',
                'Recheie a massa e feche bem as bordas.',
                'Frite em óleo quente até dourar.'
            ]
        },
        'camarao': {
            titulo: 'Pastel de Camarão',
            descricao: 'Um clássico sofisticado da culinária brasileira',
            ingredientes: [
                '300g de camarões médios limpos',
                '1 cebola picada',
                '2 dentes de alho picados',
                '1 pimentão vermelho picado',
                '1/2 xícara de leite de coco',
                '2 colheres de sopa de coentro picado',
                '1 colher de sopa de azeite',
                'Sal e pimenta a gosto',
                'Massa para pastel',
                'Óleo para fritar'
            ],
            preparo: [
                'Pique os camarões em pedaços pequenos.',
                'Aqueça o azeite e refogue a cebola e o alho.',
                'Adicione o pimentão e cozinhe por 2 minutos.',
                'Acrescente os camarões e tempere com sal e pimenta.',
                'Quando os camarões estiverem cozidos, adicione o leite de coco e coentro.',
                'Cozinhe até o líquido reduzir ligeiramente.',
                'Deixe o recheio esfriar completamente.',
                'Recheie a massa e frite em óleo quente.'
            ]
        }
    };

    // Função para exibir receita
    function exibirReceita(tipo) {
        console.log('Exibindo receita:', tipo);
        
        const receita = receitasPastel[tipo];
        if (!receita) return;

        const recipeDisplay = document.getElementById('recipe-display');
        
        recipeDisplay.innerHTML = `
            <div class="recipe-container">
                <div class="recipe-title">
                    <h1>${receita.titulo}</h1>
                    <p class="description">${receita.descricao}</p>
                </div>
                
                <div class="recipe-layout">
                    <div class="recipe-image-container">
                        <div class="recipe-image-frame">
                            <img src="../images/pastel-${tipo}.jpg" alt="${receita.titulo}" class="recipe-image">
                        </div>
                    </div>
                    
                    <div class="recipe-content">
                        <div class="recipe-section">
                            <h2>Ingredientes</h2>
                            <ul>
                                ${receita.ingredientes.map(ingrediente => `<li>${ingrediente}</li>`).join('')}
                            </ul>
                        </div>
                        
                        <div class="recipe-section">
                            <h2>Modo de Preparo</h2>
                            <ol>
                                ${receita.preparo.map(passo => `<li>${passo}</li>`).join('')}
                            </ol>
                        </div>
                        
                        <div class="recipe-tip">
                            <strong>💡 Dica:</strong> Sirva com caldo de cana para a experiência completa de feira!
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Scroll suave para a receita
        recipeDisplay.scrollIntoView({ 
            behavior: 'smooth' 
        });
    }

    // Adicionar eventos aos itens do carrossel
    const carouselItems = document.querySelectorAll('.carousel-item');
    console.log('Itens do carrossel:', carouselItems.length);

    carouselItems.forEach(item => {
        item.addEventListener('click', function() {
            const recipeType = this.getAttribute('data-recipe');
            exibirReceita(recipeType);
        });
    });

    // Efeitos hover nos cards de informação
    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Prevenir comportamento padrão de links
    document.querySelectorAll('.recipe-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
        });
    });

    console.log('Todas as funcionalidades carregadas!');
});