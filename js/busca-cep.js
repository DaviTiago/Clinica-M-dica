async function buscaEndereco(cep) {
    let form = document.querySelector("form");
    if (cep.length != 9) {
        form.logradouro.value = "";
        form.cidade.value = "";
        form.estado.value = "";
        return;
    }

    try {
        const response = await fetch(`php/busca-cep.php?cep=${cep}`);
        if (!response.ok) throw new Error(response.statusText);
        const endereco = await response.json();

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