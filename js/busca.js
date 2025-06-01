document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.querySelector('.search-button');
    let searchTimeout;

    const resultadosContainer = document.createElement('div');
    resultadosContainer.className = 'search-results';
    document.querySelector('.search-container').appendChild(resultadosContainer);

    const modalHTML = `
        <div class="modal fade" id="sinopseModal" tabindex="-1" aria-labelledby="sinopseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sinopseModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="" alt="" class="sinopse-image img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <p class="sinopse-text"></p>
                                <div class="mt-3">
                                    <a href="" class="btn btn-primary ver-mais-btn">Ver mais detalhes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const sinopseModal = new bootstrap.Modal(document.getElementById('sinopseModal'));

    window.exibirSinopse = function(item) {
        const modal = document.getElementById('sinopseModal');
        if (!modal) {
            console.error('Modal não encontrado');
            return;
        }

        try {
            modal.querySelector('.modal-title').textContent = item.titulo;
            modal.querySelector('.sinopse-image').src = item.imagem;
            modal.querySelector('.sinopse-image').alt = item.titulo;
            modal.querySelector('.sinopse-text').textContent = item.descricao || 'Sinopse não disponível.';
            modal.querySelector('.ver-mais-btn').href = item.url;
            sinopseModal.show();
        } catch (erro) {
            console.error('Erro ao exibir sinopse:', erro);
        }
    };

    async function realizarBusca(termo) {
        if (!termo.trim()) {
            resultadosContainer.style.display = 'none';
            return;
        }

        try {
            const response = await fetch(`buscar.php?termo=${encodeURIComponent(termo)}`);
            const data = await response.json();

            if (data.erro) {
                resultadosContainer.innerHTML = `<div class="search-error">${data.erro}</div>`;
                resultadosContainer.style.display = 'block';
                return;
            }

            if (data.resultados.length === 0) {
                resultadosContainer.innerHTML = '<div class="search-no-results">Nenhum resultado encontrado</div>';
                resultadosContainer.style.display = 'block';
                return;
            }

            const html = data.resultados.map(item => `
                <div class="search-result-item" onclick="window.location.href = '${item.url}';">
                    <img src="${item.imagem}" alt="${item.titulo}" class="search-result-image">
                    <div class="search-result-info">
                        <h6>${item.titulo}</h6>
                        <span class="search-result-type">${item.tipo === 'filme' ? '🎬 Filme' : '📚 Livro'}</span>
                        <span class="search-result-genre">${item.genero ? `🎭 ${item.genero}` : ''}</span>
                        <p class="search-result-desc">${item.descricao ? item.descricao.substring(0, 100) + '...' : ''}</p>
                    </div>
                </div>
            `).join('');

            resultadosContainer.innerHTML = html;
            resultadosContainer.style.display = 'block';
        } catch (erro) {
            console.error('Erro na busca:', erro);
            resultadosContainer.innerHTML = '<div class="search-error">Erro ao realizar a busca</div>';
            resultadosContainer.style.display = 'block';
        }
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            realizarBusca(this.value);
        }, 300);
    });

    searchButton.addEventListener('click', function() {
        realizarBusca(searchInput.value);
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            realizarBusca(this.value);
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            resultadosContainer.style.display = 'none';
        }
    });
}); 