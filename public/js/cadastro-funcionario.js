const checkboxMedico = document.querySelector('#is-medico');
checkboxMedico.addEventListener('click', () => {
    const campoMedicos = document.querySelectorAll('.campo-medico');
    campoMedicos.forEach(campo => {
        if (checkboxMedico.checked) {
            campo.classList.remove('hidden');
            campo.classList.add('shown');
        } else {
            campo.classList.remove('shown');
            campo.classList.add('hidden');
        }
    })
});