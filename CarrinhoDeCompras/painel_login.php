<?php
session_start();
// Verifica se o formulário de login foi enviado
if (isset($_POST['login'])) {
    $usuario = $_POST['email'];
    $senha = $_POST['pswd'];

    // Salva a preferência de tema na sessão
    if (isset($_POST['tema'])) {
        $_SESSION['tema'] = $_POST['tema'];
        setcookie('tema', $_POST['tema'], time() + (86400 * 30), "/"); // Armazena por 30 dias
    } else {
        $_SESSION['tema'] = 'claro'; // Tema padrão caso não escolha
        setcookie('tema', 'claro', time() + (86400 * 30), "/");
    }

    // Aqui você pode adicionar a verificação do login com o banco de dados
    header("Location: adicionar_carrinho.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">


</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <!-- Formulário de Cadastro -->
        <div class="login">
            <form action="" method="post">
                <label for="chk" aria-hidden="true">DuduStore</label>
                <input type="text" name="usuario" placeholder="User" required>
                <input type="email" name="email" placeholder="Email" required>          
                <input type="password" name="pswd" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <div class="tema-selector">
                    <label for="tema">Escolha o Tema:</label>
                    <select name="tema" id="tema">
                        <option value="claro">Tema Claro</option>
                        <option value="escuro">Tema Escuro</option>
                    </select>
                </div>
            </form>
        </div>

    </div>
</body>
</html>