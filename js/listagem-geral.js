const button = document.querySelector("button");

button.addEventListener('click', function () {
    const div = document.querySelector("div.tabela");
    if (div.classList.contains("tabs")) {
        div.classList.remove("tabs");
        div.classList.add("tabActive");
        button.textContent = "Ocultar dados";
    } else {
        div.classList.remove("tabActive");
        div.classList.add("tabs");
        button.textContent = "Mostrar dados";
    }
})