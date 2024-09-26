<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Registrar</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1 id="form-title">Login</h1>
        
        <!-- Exibir mensagens -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>


        <!-- Formulário de Login -->
        <form id="login-form" action="auth.php" method="POST">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="username" required>
        
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
        
            <button type="submit" name="login">Entrar</button>
        </form>

        <!-- Formulário de Registro, inicialmente oculto -->
        <form id="register-form" action="auth.php" method="POST" style="display: none;">
            <label for="new-username">Usuário</label>
            <input type="text" id="new-username" name="new-username" required>
        
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        
            <label for="new-password">Senha</label>
            <input type="password" id="new-password" name="new-password" required>
        
            <button type="submit" name="register">Registrar</button>
        </form>
        
        <!-- Botão para alternar entre Login e Registrar -->
        <button id="toggle-button">Registrar</button>
    </div>
    <script src="public/js/script.js"></script>
</body>
</html>
