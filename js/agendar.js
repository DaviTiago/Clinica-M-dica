async function agendar() {
    try {
        const form = document.querySelector("form#agendamento");
        const agendamento = new FormData(form);

        const response = await fetch("php/agendar.php", {
            method: 'POST',
            body: agendamento
        });

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const selectMedicos = document.querySelector("select#medico");
        let child = selectMedicos.lastElementChild;
        while (child && child !== selectMedicos.firstElementChild) {
            selectMedicos.removeChild(child);
            child = selectMedicos.lastChild;
        }
        form.reset();
    } catch (error) {
        console.error('Ocorreu um erro ao tentar realizar o agendamento:', error);
    }
}

window.addEventListener("load", () => {
    const button = document.querySelector("button");
    button.addEventListener("click", () => agendar());
});