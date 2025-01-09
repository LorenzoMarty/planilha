<?php
session_start();
if (isset($_SESSION['permissao'])) {
    if ($_SESSION['permissao'] == 1) {
    } else {
        header('Location: sair.php');
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <title>Navbar</title>
    <style>
        /* Estilo do corpo */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #800000;
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Logo */
        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar .logo img {
            height: 40px;
        }

        /* Links de navegação */
        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar .nav-links a:hover {
            color: #ffe4e1;
        }

        /* Botão de ação */
        .navbar .cta-button {
            background-color: #4b0000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .navbar .cta-button:hover {
            background-color: #660000;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <!-- Logo -->
        <div class="logo">
            <img src="https://via.placeholder.com/40" alt="Logo"> <!-- Substitua pela URL do seu logo -->
            <span>Caixa de Produtos</span>
        </div>

        <!-- Links de Navegação -->
        <div class="nav-links">
            <a href="#planilhas">Planilhas</a>
            <a href="#vendas">Página de Vendas</a>
            <a href="#sobre">Sobre</a>
        </div>

        <!-- Botão de Ação -->
        <button class="cta-button">Login</button>
    </nav>
</body>
</html>
