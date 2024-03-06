const anchor = document.querySelector('form a');

anchor.addEventListener('click', (event) => {
    const emailInput = document.querySelector('form input[type="email"]');
    const passwordInput = document.querySelector('form input[type="password"]');

    const emailSpan = document.querySelector('span#email-span');
    const passwordSpan = document.querySelector('span#password-span');

    emailSpan.textContent = '';
    passwordSpan.textContent = '';

    if (emailInput.value === '') {
        event.preventDefault();
        emailSpan.textContent = 'Preencha o campo de email';
    } if (passwordInput.value === '') {
        event.preventDefault();
        passwordSpan.textContent = 'Preencha o campo de senha';
    }
});