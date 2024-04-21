document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('mostrarDados').addEventListener('click', function () {
        const div = document.getElementById('listaPaciente');

        fetch('php/listagem-pacientes.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar os dados dos pacientes.');
                }
                return response.json();
            })
            .then(data => {
                const table = document.createElement('table');
                table.classList.add('table', 'table-striped');

                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                ['Nome', 'Sexo', 'Email', 'Telefone'].forEach(colName => {
                    const headerCell = document.createElement('th');
                    headerCell.textContent = colName;
                    headerRow.appendChild(headerCell);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                const tbody = document.createElement('tbody');
                data.forEach(funcionario => {
                    const row = document.createElement('tr');
                    ['nome', 'sexo', 'email', 'telefone'].forEach(prop => {
                        const cell = document.createElement('td');
                        cell.textContent = funcionario[prop];
                        row.appendChild(cell);
                    });
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);

                div.innerText = '';
                div.appendChild(table);
            })
            .catch(error => {
                console.error('Erro ao carregar os dados dos pacientes', error);
            });
    });
});
