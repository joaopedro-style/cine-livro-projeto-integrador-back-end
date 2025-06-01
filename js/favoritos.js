document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('.favorite-button');
    favoriteButtons.forEach(button => {
        const card = button.closest('.card-item');
        if (card) {
            const id = card.dataset.id;
            const tipo = card.dataset.tipo;
            verificarFavorito(id, tipo, button);
        }
    });

    const removeButtons = document.querySelectorAll('.remove-favorite');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const tipo = this.dataset.tipo;
            removerFavorito(id, tipo, this);
        });
    });
});

async function verificarFavorito(id, tipo, button) {
    try {
        const response = await fetch('verificar_favorito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&tipo=${tipo}`
        });

        const data = await response.json();
        if (data.favorito) {
            button.classList.add('added');
            button.innerHTML = '<i class="fas fa-heart"></i> Remover dos Favoritos';
        } else {
            button.classList.remove('added');
            button.innerHTML = '<i class="fas fa-heart"></i> Adicionar aos Favoritos';
        }
    } catch (erro) {
        console.error('Erro ao verificar favorito:', erro);
    }
}

async function toggleFavorito(id, tipo, button) {
    if (!button || typeof button.classList === 'undefined') {
        console.error('Elemento do botão inválido passado para toggleFavorito:', button);
        alert('Erro interno: Não foi possível identificar o botão.');
        return;
    }

    try {
        const isFavorito = button.classList.contains('added');
        const acao = isFavorito ? 'remover' : 'adicionar';

        console.log('Processando favorito:', { id, tipo, acao });

        const response = await fetch('favoritos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&tipo=${tipo}&acao=${acao}`
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro HTTP na requisição de favorito:', response.status, response.statusText, errorText);
            throw new Error(`Erro HTTP! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Resposta do servidor (toggleFavorito):', data);

        if (data.sucesso) {
            if (isFavorito) {
                button.classList.remove('added');
                button.innerHTML = '<i class="fas fa-heart"></i> Adicionar aos Favoritos';
            } else {
                button.classList.add('added');
                button.innerHTML = '<i class="fas fa-heart"></i> Remover dos Favoritos';
            }
            alert(data.mensagem);
        } else {
            throw new Error(data.erro || 'Erro desconhecido ao processar favorito');
        }
    } catch (erro) {
        console.error('Erro geral ao processar favorito:', erro);
        alert('Erro ao processar a requisição: ' + erro.message);
    }
}

async function removerFavorito(id, tipo, button) {
    if (!confirm('Tem certeza que deseja remover este item dos favoritos?')) {
        return;
    }

    try {
        const response = await fetch('favoritos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&tipo=${tipo}&acao=remover`
        });

        const data = await response.json();
        if (data.sucesso) {
            const favoriteItem = button.closest('.favorite-item');
            favoriteItem.remove();
            alert(data.mensagem);
        } else {
            alert(data.erro || 'Erro ao remover dos favoritos');
        }
    } catch (erro) {
        console.error('Erro ao remover favorito:', erro);
        alert('Erro ao processar a requisição');
    }
} 