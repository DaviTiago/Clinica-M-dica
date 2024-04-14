async function buscaEndereco(cep) {
    if (cep.length != 9) {
        return;
    }

    try {
        const response = await fetch(`../php/busca-cep.php?cep=${cep}`);
        if (!response.ok) throw new Error(response.statusText);
        const endereco = await response.json();

        let form = document.querySelector("form");
        form.logradouro.value = endereco["logradouro"];
        form.cidade.value = endereco["cidade"];
        form.estado.value = endereco["estado"];
    } catch (e) {
        console.error(e);
        return;
    }
}

window.onload = function() {
    const inputCep = document.querySelector("input#cep");
    inputCep.addEventListener("input", () => {
        buscaEndereco(inputCep.value);
    })
}