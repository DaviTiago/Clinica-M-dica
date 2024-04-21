document.addEventListener('DOMContentLoaded', function() {
    // Adiciona o evento de clique ao botão "Mostrar dados"
    document.getElementById('mostrarDados').addEventListener('click', function () {
        // Seleciona a seção onde os dados dos enderecos serão inseridos
        const div = document.getElementById('listaEnderecos');

        // Faz a requisição usando a API Fetch
        fetch('php/listagem-enderecos.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar os endereços.');
                }
                return response.json(); // Parseia a resposta como JSON
            })
            .then(data => {
                // Cria a tabela HTML
                const table = document.createElement('table');
                table.classList.add('table', 'table-striped');

                // Cria o cabeçalho da tabela
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                ['CEP', 'Logradouro', 'Cidade', 'Estado'].forEach(colName => {
                    const headerCell = document.createElement('th');
                    headerCell.textContent = colName;
                    headerRow.appendChild(headerCell);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Preenche os dados da tabela
                const tbody = document.createElement('tbody');
                data.forEach(enderecos => {
                    const row = document.createElement('tr');
                    ['cep', 'logradouro', 'cidade', 'estado'].forEach(prop => {
                        const cell = document.createElement('td');
                        cell.textContent = enderecos[prop];
                        row.appendChild(cell);
                    });
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);

                // Limpa o conteúdo da seção e insere a tabela
                div.innerText = '';
                div.appendChild(table);
            })
            .catch(error => {
                console.error('Erro ao carregar os endereços', error);
            });
    });
});
