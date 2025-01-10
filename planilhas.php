<?php
session_start();
if (isset($_SESSION['permissao'])) {
    if ($_SESSION['permissao'] == 1) {
    } else {
        header('Location: sair.php');
    }
}

if (!isset($_SESSION['balanco_geral'])) {
    $_SESSION['balanco_geral'] = 0;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <title>Planilha de Comidas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lobster', serif;
        }

        body {
            background: linear-gradient(135deg, #ffefba, #ffffff);
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Navbar */
        .navbar {
            background-color: #771010;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1000;
            animation: slideDown 0.8s ease;
        }

        .navbar .titulo {
            color: #fff;
            font-size: 2.5rem;
            text-shadow: 2px 2px #4d0000;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            text-align: center;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
            margin-left: auto;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 22px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .navbar .nav-links a:hover {
            background-color: #f1f1f1;
            color: #771010;
            transform: scale(1.1);
        }

        .navbar .menu-icon {
            display: none;
            cursor: pointer;
            width: 30px;
            height: 25px;
            position: relative;
        }

        .navbar .menu-icon span {
            display: block;
            width: 100%;
            height: 4px;
            background-color: white;
            margin: 4px 0;
            border-radius: 2px;
            transition: 0.3s ease;
        }

        .navbar .menu-icon.active span:nth-child(1) {
            transform: translateY(10px) rotate(45deg);
        }

        .navbar .menu-icon.active span:nth-child(2) {
            opacity: 0;
        }

        .navbar .menu-icon.active span:nth-child(3) {
            transform: translateY(-10px) rotate(-45deg);
        }

        @media screen and (max-width: 768px) {
            .navbar .nav-links {
                display: none;
                flex-direction: column;
                gap: 10px;
                width: 100%;
                background-color: #771010;
                position: absolute;
                top: 65px;
                right: 0;
                z-index: 1000;
                text-align: center;
                padding: 10px 0;
            }

            .navbar .nav-links.active {
                display: flex;
            }

            .navbar .menu-icon {
                display: block;
            }

            .navbar .titulo {
                font-size: 20px;
            }
        }

        /* Tabelas */
        .table-container {
            overflow-x: auto;
            margin: 20px;
        }

        .planilha {
            border: 2px solid #771010;
            border-radius: 10px;
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            min-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            animation: slideDown 1s ease;
        }

        .planilha caption {
            font-size: 24px;
            color: #fff;
            background-color: #771010;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }

        .planilha th,
        .planilha td {
            border: 1px solid #771010;
            text-align: center;
            padding: 12px 20px;
            transition: background-color 0.3s ease;
        }

        .planilha th {
            background-color: #e0b0b0;
            color: #000;
        }

        .planilha td {
            animation: fadeIn 2s ease;
        }

        .planilha td:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .planilha {
                width: 95%;
                min-width: unset;
            }

            .planilha caption {
                font-size: 20px;
                padding: 8px;
            }

            .planilha th,
            .planilha td {
                padding: 10px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .planilha {
                font-size: 12px;
            }

            .planilha caption {
                font-size: 18px;
                padding: 6px;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }

            to {
                transform: translateY(0);
            }
        }

        /* Footer */
        footer {
            background-color: #771010;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 16px;
            position: relative;
            bottom: 0;
            left: 0;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .total-arrecadado {
            margin: 20px auto;
            padding: 20px;
            background-color: #771010;
            color: #fff;
            font-size: 24px;
            border-radius: 10px;
            text-align: center;
            width: 80%;
            max-width: 800px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="menu-icon" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="titulo">Planilhas de Comidas</div>
        <div class="nav-links">
            <a href="vendas.php">Vendas</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>

    <div class="total-arrecadado">Total Arrecadado:
        <?= number_format($_SESSION['balanco_geral'], 2, ',', '.'); ?>
    </div>
    <?php
    require_once 'conexao.php';

    $queries = [
        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            vendas.tipo,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 1 OR produto.id_produto = 2 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            vendas.tipo,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 3 OR produto.id_produto = 4 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 5 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 6 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 7
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 8
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 9
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.valor_desconto,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            SUM(vendas.qntd_desconto) AS quantidade_desconto
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 10
        GROUP BY produto.id_produto;"
    ];

    $balanco_geral = 0; // Variável global para armazenar o total arrecadado
    
    function exibirTabela($conexao, $sql, $titulo, $isKg)
    {
        global $balanco_geral; // Tornar a variável global acessível
        $resultado = mysqli_query($conexao, $sql);

        $balanco_total = 0;
        $dados_produtos = [];

        while ($dados = mysqli_fetch_array($resultado)) {
            // Inicializa as variáveis de quantidade vendida e desconto
            $quantidade_vendida = $dados['quantidade_vendida'];
            $quantidade_desconto = $dados['quantidade_desconto'];

            if ($titulo === "Batata Frita") {
                if (isset($dados['tipo'])) {
                    switch ($dados['tipo']) {
                        case "Pequena":
                            $quantidade_vendida = $dados['quantidade_vendida'] * 200;
                            $quantidade_desconto = $dados['quantidade_desconto'] * 200;
                            break;
                        case "Grande":
                            $quantidade_vendida = $dados['quantidade_vendida'] * 500;
                            $quantidade_desconto = $dados['quantidade_desconto'] * 500;
                            break;
                        default:
                            break;
                    }
                }
            }

            // Calcula o balanço
            $balanco = ($dados['quantidade_vendida'] * $dados['valor_venda']) + ($dados['quantidade_desconto'] * $dados['valor_desconto']) - ($dados['qntdC'] * $dados['valor_custo']);
            $balanco_total += $balanco;

            // Atualiza o ponto de equilíbrio
            if ($balanco >= 0 && empty($dados['ponto_equilibrio'])) {
                date_default_timezone_set('America/Sao_Paulo');
                $horaPe = date('H:i:s');
                $pe = "UPDATE produto SET ponto_equilibrio = '$horaPe' WHERE id_produto = " . $dados['id_produto'];
                mysqli_query($conexao, $pe);
                $dados['ponto_equilibrio'] = $horaPe;
            }

            // Adiciona os cálculos ao array de dados
            $dados['quantidade_vendida_calculada'] = $quantidade_vendida;
            $dados['quantidade_desconto_calculada'] = $quantidade_desconto;
            $dados['balanco_calculado'] = $balanco;

            $dados_produtos[] = $dados;
        }

        $balanco_geral += $balanco_total;
        $_SESSION['balanco_geral'] = $balanco_geral;

        echo "<div class='table-container'>";
        echo "<table class='planilha'>";
        echo "<caption>" . $titulo . "</caption>";

        // Ajusta o cabeçalho de acordo com o título
        if ($titulo === "Batata Frita") {
            echo "<thead>
            <tr>
                <th>Tamanho</th>
                <th>Custo</th>
                <th>Venda</th>
                <th>Desconto</th>
                <th>Qnt Comprada</th>
                <th>Qnt Vendida</th>
                <th>Qnt Desconto</th>
                <th>Nº Vendido</th>
                <th>Nº Desconto</th>
                <th>Balanço</th>
                <th>Balanço Total</th>
                <th>P.E</th>
            </tr>
        </thead>";
        } elseif ($titulo === "Sacolé") {
            echo "<thead>
            <tr>
                <th>Tipo</th>
                <th>Custo</th>
                <th>Venda</th>
                <th>Desconto</th>
                <th>Qnt Comprada</th>
                <th>Qnt Vendida</th>
                <th>Nº Desconto</th>
                <th>Balanço</th>
                <th>Balanço Total</th>
                <th>P.E</th>
            </tr>
        </thead>";
        } else {
            echo "<thead>
            <tr>
                <th>Custo</th>
                <th>Venda</th>
                <th>Desconto</th>
                <th>Nº Comprado</th>
                <th>Nº Vendido</th>
                <th>Nº Desconto</th>
                <th>Balanço</th>
                <th>Balanço Total</th>
                <th>P.E</th>
            </tr>
        </thead>";
        }

        foreach ($dados_produtos as $dados) {
            echo "<tr>";
            if ($titulo === "Batata Frita" || $titulo === "Sacolé") {
                echo "<td>" . $dados['tipo'] . "</td>";
            }
            echo "<td>" . $dados['valor_custo'] . ",00 </td>";
            echo "<td>" . $dados['valor_venda'] . ",00 </td>";
            echo "<td>" . $dados['valor_desconto'] . ",00 </td>";

            // Ajusta os dados de acordo com o título
            if ($titulo === "Batata Frita") {
                echo "<td>" . $dados['qntdC'] . " kg </td>";
                echo "<td>" . $dados['quantidade_vendida_calculada'] . " g </td>";
                echo "<td>" . $dados['quantidade_desconto_calculada'] . " g </td>";
                echo "<td>" . $dados['quantidade_vendida'] . " </td>";
                echo "<td>" . $dados['quantidade_desconto'] . " </td>";
            } else {
                echo "<td>" . $dados['qntdC'] . " </td>";
                echo "<td>" . $dados['quantidade_vendida'] . " </td>";
                echo "<td>" . $dados['quantidade_desconto'] . " </td>";
            }

            echo "<td>" . $dados['balanco_calculado'] . ",00 </td>";
            echo "<td>" . $balanco_total . ",00 </td>";
            echo "<td>" . $dados['ponto_equilibrio'] . " </td>";
            echo "</tr>";
        }

        echo "</table></div><br>";
    }

    $conexao = conectar();
    exibirTabela($conexao, $queries[0], "Batata Frita", true);
    exibirTabela($conexao, $queries[1], "Sacolé", false);
    exibirTabela($conexao, $queries[2], "Cachorro Quente", false);
    exibirTabela($conexao, $queries[3], "Hambúrguer", false);
    exibirTabela($conexao, $queries[4], "Pastel", false);
    exibirTabela($conexao, $queries[5], "Refri", false);
    exibirTabela($conexao, $queries[6], "Enroladinho", false);
    exibirTabela($conexao, $queries[7], "Bolo de pote", false);

    ?>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Planilha de Comidas. Todos os direitos reservados.</p>
    </footer>

    <script>
        function toggleMenu() {
            const menuIcon = document.querySelector('.menu-icon');
            const navLinks = document.querySelector('.nav-links');
            menuIcon.classList.toggle('active');
            navLinks.classList.toggle('active');
        }
    </script>
</body>

</html>