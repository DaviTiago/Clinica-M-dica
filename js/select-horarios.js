async function selecionaHorarios() {
    const selectEspecialidade = document.querySelector("select#especialidade");
    const selectMedico = document.querySelector("select#medico");
    const data = document.querySelector("input#data");
    const response = await fetch(`php/select-horarios.php?especialidade=${selectEspecialidade.value}&medico=${selectMedico.value}&data=${data.value}`);
    const horariosIndisponiveis = await response.json();

    const selectHorario = document.querySelector("select#horario");
    for (let i = 0; i < selectHorario.options.length; i++) {
        const option = selectHorario.options[i];
        if (horariosIndisponiveis.some(horarioIndisponivel => horarioIndisponivel.horario === option.value)) {
            selectHorario.removeChild(option);
            i--;
        }
    }
}

window.addEventListener("load", () => {
    const inputData = document.querySelector("input#data");
    inputData.addEventListener("change", () => selecionaHorarios());
})