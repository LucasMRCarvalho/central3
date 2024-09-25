// Selecionar elementos
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const toggleButton = document.getElementById('toggle-button');
const formTitle = document.getElementById('form-title');

// Função para alternar entre Login e Registrar
toggleButton.addEventListener('click', () => {
    if (registerForm.style.display === 'none') {
        // Mostrar o formulário de registro e esconder o de login
        registerForm.style.display = 'block';
        loginForm.style.display = 'none';
        formTitle.textContent = 'Registrar';
        toggleButton.textContent = 'Voltar para Login';
    } else {
        // Mostrar o formulário de login e esconder o de registro
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
        formTitle.textContent = 'Login';
        toggleButton.textContent = 'Registrar';
    }
});

// Função para validar o formulário de registro
registerForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Previne o envio do formulário automático

    const username = document.getElementById('new-username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('new-password').value;

    // Verifica se o username tem pelo menos 3 caracteres
    if (username.length < 3) {
        alert('O nome de usuário deve ter pelo menos 3 caracteres.');
        return;
    }

    // Verifica se o email é válido
    if (!validateEmail(email)) {
        alert('Por favor, insira um email válido.');
        return;
    }

    // Verifica se a senha tem pelo menos 6 caracteres
    if (password.length < 6) {
        alert('A senha deve ter pelo menos 6 caracteres.');
        return;
    }

    // Se todas as validações passarem, o formulário é enviado
    alert('Registro realizado com sucesso!');
    registerForm.submit();
});

// Função simples para validar o formato de email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

// Função para validar o formulário de login
loginForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Previne o envio do formulário automático

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === '' || password === '') {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    // Se a validação passar, o formulário é enviado
    alert('Login realizado com sucesso!');
    loginForm.submit();
});
