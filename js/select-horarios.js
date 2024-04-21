async function selecionaHorarios() {
    try {
        const selectEspecialidade = document.querySelector("select#especialidade");
        const selectMedico = document.querySelector("select#medico");
        const data = document.querySelector("input#data");
        const response = await fetch(`php/select-horarios.php?especialidade=${selectEspecialidade.value}&medico=${selectMedico.value}&data=${data.value}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const horariosIndisponiveis = await response.json();
        if (horariosIndisponiveis.error) {
            throw new Error(horariosIndisponiveis.error);
        }

        const selectHorario = document.querySelector("select#horario");

        selectHorario.innerHTML = '';

        for (let i = 8; i <= 17; i++) {
            const option = document.createElement("option");
            option.value = (i < 10 ? '0' : '') + i + ':00:00';
            option.text = `${i}h`;
            selectHorario.appendChild(option);
        }

        for (let i = 0; i < selectHorario.options.length; i++) {
            const option = selectHorario.options[i];
            if (horariosIndisponiveis.some(horarioIndisponivel => horarioIndisponivel.horario === option.value)) {
                selectHorario.removeChild(option);
                i--;
            }
        }
    } catch (e) {
        alert(e);
    }
}

window.addEventListener("load", () => {
    const inputData = document.querySelector("input#data");
    const selectMedico = document.querySelector("select#medico");
    inputData.addEventListener("change", () => selecionaHorarios());
    selectMedico.addEventListener("change", () => selecionaHorarios());
})