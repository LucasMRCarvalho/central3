<?php
// Iniciar a sessão no início do arquivo
session_start();

// Conexão com o banco de dados MySQL
$host = 'localhost';
$db = 'central3'; // Substitua pelo nome do seu banco de dados
$user = 'root'; // Substitua pelo seu usuário do banco de dados
$password = ''; // Substitua pela sua senha do banco de dados

$conn = new mysqli($host, $user, $password, $db);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para redirecionar após registro/login
function redirect($url) {
    header("Location: $url");
    exit();
}

// Lógica de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username']; // Alterado de email para username
    $senha = $_POST['password']; // Alterado de senha para password

    // Validação básica
    if (empty($username) || empty($senha)) {
        redirect('index.php?error=' . urlencode("Por favor, preencha todos os campos."));
    } else {
        // Consulta ao banco de dados
        $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE username = ?"); // Alterado de email para username
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();
            if (password_verify($senha, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                redirect('dashboard.php?success=' . urlencode("Login bem-sucedido!")); // Mensagem de sucesso
            } else {
                redirect('index.php?error=' . urlencode("Senha incorreta.")); // Mensagem de erro
            }
        } else {
            redirect('index.php?error=' . urlencode("Usuário não encontrado.")); // Mensagem de erro
        }
        $stmt->close();
    }
}

// Lógica de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['new-username'];
    $email = $_POST['email'];
    $senha = $_POST['new-password'];

    // Validação básica
    if (empty($username) || empty($email) || empty($senha)) {
        redirect('index.php?error=' . urlencode("Por favor, preencha todos os campos."));
    } else {
        // Verificar se o email já existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Criptografar a senha
            $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir o novo usuário no banco de dados
            $stmt = $conn->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)"); // Ajustado
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($stmt->execute()) {
                redirect('index.php?success=' . urlencode("Registro bem-sucedido!")); // Mensagem de sucesso
            } else {
                redirect('index.php?error=' . urlencode("Erro ao registrar o usuário.")); // Mensagem de erro
            }
        } else {
            redirect('index.php?error=' . urlencode("Este e-mail já está cadastrado.")); // Mensagem de erro
        }
        $stmt->close();
    }
}

// Lógica de logout
if (isset($_GET['logout'])) {
    session_destroy();
    redirect('index.php'); // Redireciona para a página de login ao sair
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
