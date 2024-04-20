document.addEventListener('DOMContentLoaded', function() {
    // Adiciona o evento de clique ao botão "Mostrar dados"
    document.getElementById('mostrarDados').addEventListener('click', function () {
        // Seleciona a seção onde os dados das consultas serão inseridos
        const section = document.getElementById('listaConsultas');

        // Faz a requisição usando a API Fetch
        fetch('php/listagem-consultas.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar as consultas.');
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
                ['Codigo Medico', 'Especialidade Médica', 'Nome Médico', 'Data', 'Hórario'].forEach(colName => {
                    const headerCell = document.createElement('th');
                    headerCell.textContent = colName;
                    headerRow.appendChild(headerCell);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Preenche os dados da tabela
                const tbody = document.createElement('tbody');
                data.forEach(consultas => {
                    const row = document.createElement('tr');
                    ['codigo', 'especialidade', 'nome', 'data', 'horario'].forEach(prop => {
                        const cell = document.createElement('td');
                        cell.textContent = consultas[prop];
                        row.appendChild(cell);
                    });
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);

                // Limpa o conteúdo da seção e insere a tabela
                section.innerText = '';
                section.appendChild(table);
            })
            .catch(error => {
                console.error('Erro ao carregar as consultas', error);
            });
    });
});
