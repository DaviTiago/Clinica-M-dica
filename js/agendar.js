async function agendar(e) {
    e.preventDefault();
    try {
        const form = document.querySelector("form#agendamento");
        const agendamento = new FormData(form);

        const dataAgendamento = new Date(agendamento.get('data'));
        const dataAtual = new Date();

        if (dataAgendamento.setHours(0,0,0,0) < dataAtual.setHours(0,0,0,0)) {
            throw new Error('A data do agendamento deve ser hoje ou uma data futura');
        }

        const response = await fetch("php/agendar.php", {
            method: 'POST',
            body: agendamento
        });

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const data = await response.json();
        if (data.error) {
            throw new Error(data.error);
        }

        const selectMedicos = document.querySelector("select#medico");
        let child = selectMedicos.lastElementChild;
        while (child && child !== selectMedicos.firstElementChild) {
            selectMedicos.removeChild(child);
            child = selectMedicos.lastChild;
        }
        form.reset();
        alert('Agendamento realizado com sucesso!');
    } catch (e) {
        alert(e.message);
    }
}

window.addEventListener("load", () => {
    const button = document.querySelector("button");
    button.addEventListener("click", (e) => agendar(e));
});