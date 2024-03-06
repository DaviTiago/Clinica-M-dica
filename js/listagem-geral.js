const buttons = document.querySelectorAll("button");

buttons.forEach(function (button) {
    button.addEventListener('click', function () {
        const sections = document.querySelectorAll("section");

        sections.forEach(function (section) {
            if (section.classList.contains("tabs")) {
                // Se a classe "tabs" estiver presente, oculta o conteúdo
                section.classList.remove("tabs");
                section.classList.add("tabActive");
                button.textContent = "Ocultar dados";
            } else {
                // Se a classe "tabsActive" não estiver presente, mostra o conteúdo
                section.classList.remove("tabActive");
                section.classList.add("tabs");
                button.textContent = "Mostrar dados";
            }
        });
    });
});