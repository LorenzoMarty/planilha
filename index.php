<?php
session_start();
if (isset($_POST['login'])) {

    require_once('conexao.php');
    $conexao = conectar();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email='$email'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $dados = mysqli_fetch_assoc($resultado);
        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['senha'] = $senha;
            $_SESSION['permissao'] = $dados['perm'];
            $_SESSION['id'] = $dados['idusuario'];
            header("Location: main.php");
        }
    } else {
        echo "<script>alert('Usuário e/ou senha incorreto(s)');</script>";
    }
}

if (isset($_SESSION['permissao'])) {
    if ($_SESSION['permissao'] == 1) {
        header('Location: main.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dia Geek</title>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lobster', serif;
        }

        body {
            font-family: 'Lobster', serif;
            background-color: #640d14;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('img/fundo.png');
            background-blend-mode: overlay;
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .login {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 400px;
        }

        .login-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            display: none;
            flex-direction: column;
        }

        .login-section.login {
            display: flex;
        }

        .logo img {
            width: 200px;
            height: auto;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
            width: 100%;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #640d14;
        }

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 25px;
            background-color: #640d14;
            color: white;
            font-size: 18px;
            text-indent: 5px;
        }

        .form-group input::placeholder {
            color: #ffffffaa;
        }

        .form-group input:focus {
            outline: 2px solid #771010;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            background-color: #640d14;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: bold;
        }

        .login-button:hover {
            background-color: #771010;
        }

        .center {
            margin-top: 15px;
        }

        .center a {
            color: #640d14;
            text-decoration: none;
            font-weight: bold;
        }

        .center a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .login {
                padding: 10px;
            }

            .logo img {
                width: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="login">
        <!-- Formulário de login -->
        <div class="login-section login">
            <div class="logo">
                <img src="img/diageek-logo.png" alt="Diageek Logo">
            </div>
            <form method="post">
                <div class="form-group">
                    <label for="email">User</label>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required />
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required />
                </div>
                <button type="submit" name="login" class="login-button">Entrar</button>
            </form>
            <div class="center">
                <a href="javascript:void(0);" onclick="toggleForm()">Cadastre-se já</a>
            </div>
        </div>

        <!-- Formulário de cadastro -->
        <div class="login-section register">
            <div class="logo">
                <img src="img/diageek-logo.png" alt="Diageek Logo">
            </div>
            <form action="cadastrar.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required />
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required />
                </div>
                <button type="submit" name="cadastrarUsuario" class="login-button">Cadastrar</button>
            </form>
            <div class="center">
                <a href="javascript:void(0);" onclick="toggleForm()">Já tenho uma conta</a>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            const loginSection = document.querySelector('.login-section.login');
            const registerSection = document.querySelector('.login-section.register');

            if (loginSection.style.display === 'none') {
                loginSection.style.display = 'flex';
                registerSection.style.display = 'none';
                localStorage.setItem('form', 'login');
            } else {
                loginSection.style.display = 'none';
                registerSection.style.display = 'flex';
                localStorage.setItem('form', 'register');
            }
        }

        window.onload = function () {
            const loginSection = document.querySelector('.login-section.login');
            const registerSection = document.querySelector('.login-section.register');

            if (localStorage.getItem('form') === 'register') {
                loginSection.style.display = 'none';
                registerSection.style.display = 'flex';
            } else {
                loginSection.style.display = 'flex';
                registerSection.style.display = 'none';
            }
        };
    </script>
</body>

</html>
