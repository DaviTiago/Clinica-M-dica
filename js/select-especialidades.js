window.addEventListener("load", async () => {
    try {
        const response = await fetch("php/select-especialidades.php");
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const especialidades = await response.json();
        if (especialidades.error) {
            throw new Error(especialidades.error);
        }
        const selectEspecialidade = document.querySelector("select#especialidade");
        for(let especialidade of especialidades) {
            let option = document.createElement("option");
            option.value = especialidade["especialidade"];
            option.text = especialidade["especialidade"];
            selectEspecialidade.appendChild(option);
        }
    } catch (e) {
        alert(e);
    }
});