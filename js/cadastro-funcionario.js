const checkboxMedico = document.querySelector('#is-medico');
const campoMedicos = document.querySelectorAll('.campo-medico');

function toggleCamposMedico(show) {
    campoMedicos.forEach((campo) => {
        if (show) {
            campo.classList.remove('hidden');
            campo.classList.add('shown');
            campo.required = true;
        } else {
            campo.classList.remove('shown');
            campo.classList.add('hidden');
            campo.required = false;
        }
    });
}

checkboxMedico.addEventListener('click', () => {
    toggleCamposMedico(checkboxMedico.checked);
});

const form = document.querySelector("form");
form.addEventListener("submit", async (e) => {
    e.preventDefault();
    try {
        let formData = new FormData(form);
        let response = await fetch("php/cadastro-funcionario.php", {
            method: "POST",
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        let data = await response.json();
        if (data.error) {
            throw new Error(data.error);
        }

        form.reset();
        toggleCamposMedico(false);
        alert('Cadastro realizado com sucesso!');
    } catch (e) {
        alert(e);
    }
});