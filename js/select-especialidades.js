window.addEventListener("load", async () => {
    const response = await fetch("php/select-especialidades.php");
    const especialidades = await response.json();
    const selectEspecialidade = document.querySelector("select#especialidade");
    for(let i = 0; i < especialidades.length; i++) {
        let option = document.createElement("option");
        option.value = especialidades[i]["especialidade"];
        option.text = especialidades[i]["especialidade"];
        selectEspecialidade.appendChild(option);
    }
});