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


document.addEventListener("DOMContentLoaded", function() {
    const alertDanger = document.querySelector('.alert-danger');
    const alertSuccess = document.querySelector('.alert-success');

    // Ocultar alertas de erro
    if (alertDanger) {
        setTimeout(() => {
            alertDanger.style.display = 'none';
        }, 5000); // 5 segundos
    }

    // Ocultar alertas de sucesso
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.display = 'none';
        }, 5000); // 5 segundos
    }
});