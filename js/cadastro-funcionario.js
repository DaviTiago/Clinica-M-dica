const checkboxMedico = document.querySelector('#is-medico');
const campoMedicos = document.querySelectorAll('.campo-medico');
checkboxMedico.addEventListener('click', () => {
    campoMedicos.forEach((campo) => {
        if (checkboxMedico.checked) {
            campo.classList.remove('hidden');
            campo.classList.add('shown');
            campo.required = true;
        } else {
            campo.classList.remove('shown');
            campo.classList.add('hidden');
            campo.required = false;
        }
    })
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

        form.reset();
        campoMedicos.forEach((campo) => {
            campo.classList.remove('shown');
            campo.classList.add('hidden');
            campo.required = false;
        })
    } catch (e) {
        console.error("Erro ao cadastrar funcionário: ", e);
    }
});