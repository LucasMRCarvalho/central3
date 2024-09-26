<?php
// Configuração do banco de dados
$host = 'localhost';
$db   = 'central3'; // Nome do banco de dados
$user = 'root'; // Seu usuário MySQL
$pass = ''; // Sua senha MySQL
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

session_start();

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header('Location: login.php');
    exit();
}

// Processar o Registro
if (isset($_POST['register'])) {
    $username = $_POST['new-username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['new-password'], PASSWORD_DEFAULT); // Hash da senha

    // Verificar se o email já existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        // Redirecionar para a página de login com mensagem de erro
        header("Location: login.php?error=Email já cadastrado.");
        exit();
    }

    // Verificar se o usuário já existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        // Redirecionar para a página de login com mensagem de erro
        header("Location: login.php?error=Nome de usuário já cadastrado.");
        exit();
    }

    // Inserir novo usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
        // Redirecionar com mensagem de sucesso
        header("Location: login.php?success=Registro realizado com sucesso!");
        exit();
    } else {
        header("Location: login.php?error=Erro ao registrar usuário.");
        exit();
    }
}

// Processar o Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Procurar o usuário
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sessão e armazenar o ID do usuário
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirecionar para a página inicial
        header("Location: index.php");
        exit();
    } else {
        // Redirecionar com erro de login
        header("Location: login.php?error=Usuário ou senha inválidos.");
        exit();
    }
}

// Processar o Logout
if (isset($_GET['logout'])) {
    // Destruir a sessão
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
