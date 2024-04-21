document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mostrarDados').addEventListener('click', function () {
        const div = document.getElementById('listaConsultas');

        fetch('php/listagem-consultas.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar as consultas.');
                }
                return response.json();
            })
            .then(data => {
                const table = document.createElement('table');
                table.classList.add('table', 'table-striped');

                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                ['Especialidade Médica', 'CRM', 'Nome Médico', 'Data', 'Hórario'].forEach(colName => {
                    const headerCell = document.createElement('th');
                    headerCell.textContent = colName;
                    headerRow.appendChild(headerCell);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                const tbody = document.createElement('tbody');
                data.forEach(consultas => {
                    const row = document.createElement('tr');
                    ['especialidade', 'crm', 'nome', 'data', 'horario'].forEach(prop => {
                        const cell = document.createElement('td');
                        cell.textContent = consultas[prop];
                        row.appendChild(cell);
                    });
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);

                div.innerText = '';
                div.appendChild(table);
            })
            .catch(error => {
                console.error('Erro ao carregar as consultas', error);
            });
    });
});
