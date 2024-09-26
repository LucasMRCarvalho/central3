const toggleButton = document.getElementById('toggle-btn')
const sidebar = document.getElementById('sidebar')

function toggleSidebar() {
    sidebar.classList.toggle('close')
    toggleButton.classList.toggle('rotate')

    closeAllSubMenus()
}


function toggleSubMenu(button){

    if(!button.nextElementSibling.classList.contains('show')) {
        closeAllSubMenus()
    }
    

    button.nextElementSibling.classList.toggle('show')
    button.classList.toggle('rotate')

    if(sidebar.classList.contains('close')) {
        sidebar.classList.toggle('close')
        toggleButton.classList.toggle('rotate')
    }
}

function closeAllSubMenus() {
    Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
        ul.classList.remove('show')
        ul.previousElementSibling.classList.remove('rotate')
    })
}
// Daqui pra cima e do side bar!!!
//======================================================================

// ==== Quebra de linhas ====
// Função para transformar as quebras de linha do texto original
function transformarQuebraDeLinha() {
    const textoNormal = document.getElementById("textoNormal").value;

    // Substitui as quebras de linha por '\n' literal
    const textoTransformado = textoNormal.replace(/\n/g, '\\n');

    // Exibe o resultado no textarea de resultado
    document.getElementById("textoResultado").value = textoTransformado;
}

// Função para copiar o resultado para a área de transferência
function copiarResultado() {
    const textoResultado = document.getElementById("textoResultado");

    // Seleciona o conteúdo do campo de resultado
    textoResultado.select();
    textoResultado.setSelectionRange(0, 99999); // Para mobile

    // Copia o conteúdo selecionado
    document.execCommand("copy");

    // Alerta de confirmação
    alert('Texto copiado para a área de transferência!');
}
//====================================================================

// ==== Organizador de Logins====

// Função para substituir a lista de email e senha no texto original
function substituirListaEmailSenha() {
    const textoOriginal = document.getElementById('textoOriginal').value;
    const listaDados = document.getElementById('listaDados').value.split('\n');
    let resultado = '';

    listaDados.forEach(par => {
        const [email, senha] = par.split(':');
        let novoTexto = textoOriginal.replace('[EMAIL]', email).replace('[SENHA]', senha);
        resultado += novoTexto.trim() + '\n' + '\n'; // Remove espaços no final e adiciona quebra de linha
    });

    // Remove a última quebra de linha extra
    document.getElementById('textoResultado').value = resultado.trimEnd();
}

// Função para limpar os campos
function limparCampos() {
    document.getElementById('listaDados').value = '';
    document.getElementById('textoResultado').value = '';
}

// Função para copiar o resultado
function copiarResultado() {
    const textoResultado = document.getElementById('textoResultado');
    textoResultado.select();
    document.execCommand('copy');
    alert('Resultado copiado para a área de transferência!');
}
//==============================================================================

// Função para exibir alertas
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${type}`;
    alertDiv.textContent = message;
    document.body.prepend(alertDiv);

    // Remover o alerta após 3 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// Verificar mensagens de sessão (definidas no PHP)
const urlParams = new URLSearchParams(window.location.search);
const successMessage = urlParams.get('success');
const errorMessage = urlParams.get('error');

if (successMessage) {
    showAlert('success', successMessage);
}

if (errorMessage) {
    showAlert('error', errorMessage);
}