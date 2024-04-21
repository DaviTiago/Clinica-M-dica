async function selecionaMedicos(especialidade) {
    try {
        const response = await fetch(`php/select-medicos.php?especialidade=${especialidade}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const medicos = await response.json();
        if (medicos.error) {
            throw new Error(medicos.error);
        }
        const selectMedicos = document.querySelector("select#medico");

        let child = selectMedicos.lastElementChild;
        while (child && child !== selectMedicos.firstElementChild) {
            selectMedicos.removeChild(child);
            child = selectMedicos.lastChild;
        }

        for (let i = 0; i < medicos.length; i++) {
            const option = document.createElement("option");
            option.value = medicos[i]["nome"];
            option.text = "Dr. " + medicos[i]["nome"];
            selectMedicos.appendChild(option);
        }

        selectMedicos.selectedIndex = 0;
    } catch (e) {
        alert(e);
    }
};

window.addEventListener("load", () => {
    const selectEspecialidade = document.querySelector("select#especialidade");
    selectEspecialidade.addEventListener("change", () => selecionaMedicos(selectEspecialidade.value));
});