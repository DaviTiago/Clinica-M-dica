async function sendForm(form) {
    // Limpa as mensagens de erro
    document.getElementById("email-span").textContent = '';
    document.getElementById("password-span").textContent = '';
    document.getElementById("loginFailMsg").textContent = '';

    // Verifica se os campos de email e senha estão preenchidos
    if (!form.email.value && !form.senha.value) {
        document.getElementById("email-span").textContent = 'Preencha o email.';
        document.getElementById("password-span").textContent = 'Preencha a senha.';

        return;
    }
    else if (!form.email.value) {
        document.getElementById("email-span").textContent = 'Preencha o email.';
        return;
    }
    else if (!form.senha.value) {
        document.getElementById("password-span").textContent = 'Preencha a senha.';
        return;
    }


    try {
        const response = await fetch("php/login.php", { method: 'post', body: new FormData(form) });
        if (!response.ok) throw new Error(response.statusText);
        const result = await response.json();
        // Se o login for bem sucedido, redireciona para a página de perfil
        if (result.success) {
            window.location = result.detail;
        } else {
            if (result.emailError) {
                document.getElementById("email-span").textContent = result.emailError;
            }
            if (result.passwordError) {
                document.getElementById("password-span").textContent = result.passwordError;
            }
            
            document.getElementById("loginFailMsg").textContent = result.message;
            form.senha.value = "";
            form.senha.focus();
        }
    } catch (e) {
        console.error('Erro:', e);
    }
}
window.onload = function () {
    const form = document.getElementById('formLogin');
    form.onsubmit = function (event) {
        event.preventDefault();
        sendForm(form);
    }
}
