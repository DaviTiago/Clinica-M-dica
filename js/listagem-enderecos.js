document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mostrarDados').addEventListener('click', function () {
        const div = document.getElementById('listaEnderecos');

        fetch('php/listagem-enderecos.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar os endereços.');
                }
                return response.json();
            })
            .then(data => {
                const table = document.createElement('table');
                table.classList.add('table', 'table-striped');

                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                ['CEP', 'Logradouro', 'Cidade', 'Estado'].forEach(colName => {
                    const headerCell = document.createElement('th');
                    headerCell.textContent = colName;
                    headerRow.appendChild(headerCell);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

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

                div.innerText = '';
                div.appendChild(table);
            })
            .catch(error => {
                console.error('Erro ao carregar os endereços', error);
            });
    });
});
