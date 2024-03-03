const checkboxMedico = document.querySelector('#idis-medico');
checkboxMedico.addEventListener('click', function () {
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