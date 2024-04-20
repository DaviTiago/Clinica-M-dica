async function selecionaMedicos(especialidade) {
    const response = await fetch(`php/select-medicos.php?especialidade=${especialidade}`);
    const medicos = await response.json();
    const selectMedicos = document.querySelector("select#medico");

    let child = selectMedicos.lastElementChild;
    while (child && child !== selectMedicos.firstElementChild) {
        selectMedicos.removeChild(child);
        child = selectMedicos.lastChild;
    }

    for(let i = 0; i < medicos.length; i++) {
        const option = document.createElement("option");
        option.value = medicos[i]["nome"];
        option.text = "Dr. " + medicos[i]["nome"];
        selectMedicos.appendChild(option);
    }
};

window.addEventListener("load", () => {
    const selectEspecialidade = document.querySelector("select#especialidade");
    selectEspecialidade.addEventListener("change", () => selecionaMedicos(selectEspecialidade.value));
});