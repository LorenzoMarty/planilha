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
    <script>
        // Função para atualizar o valor do total arrecadado
        function atualizarTotalArrecadado() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "atualizar_total.php", true); // Faz requisição ao arquivo PHP
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Atualiza o valor do total arrecadado na página
                    const totalArrecadadoDiv = document.getElementById('total-arrecadado');
                    totalArrecadadoDiv.innerHTML = xhr.responseText; // Certifique-se de que o PHP retorna HTML adequado
                } else {
                    console.error("Erro na resposta do servidor: ", xhr.status);
                }
            };
            xhr.onerror = function () {
                console.error("Erro ao tentar conectar ao servidor.");
            };
            xhr.send();
        }

        // Configura a atualização ao carregar e periodicamente
        window.onload = function () {
            atualizarTotalArrecadado(); // Atualiza ao carregar a página
            setInterval(atualizarTotalArrecadado, 5000); // Atualiza a cada 5 segundos
        };
    </script>


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

    <div class="total-arrecadado" id="total-arrecadado">
        <p>Total Arrecadado: <?= number_format($_SESSION['balanco_geral'], 2, ',', '.'); ?></p>
        <p>Ponto de Equilíbrio Total: <?= ($_SESSION['balanco_geral'] >= 0) ? 'Alcançado' : 'Não Alcançado'; ?></p>
    </div>
    <?php
    require_once 'conexao.php';

    $queries = [
        ["Sacolé", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, vendas.tipo, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto IN (3, 4) GROUP BY produto.id_produto;"],
        ["Cachorro Quente", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto = 5 GROUP BY produto.id_produto;"],
        ["Hambúrguer", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto = 6 GROUP BY produto.id_produto;"],
        ["Pastel", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto = 7 GROUP BY produto.id_produto;"],
        ["Refri", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, vendas.tipo, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto IN (1, 2, 8, 11) GROUP BY produto.id_produto;"],
        ["Enroladinho", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto = 9 GROUP BY produto.id_produto;"],
        ["Bolo de pote", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto = 10 GROUP BY produto.id_produto;"],
        ["Pipoca", "SELECT produto.id_produto, produto.nome, produto.valor_custo, produto.valor_venda, produto.valor_desconto, produto.qntdC, produto.ponto_equilibrio, COALESCE(SUM(vendas.qtd), 0) AS quantidade_vendida, COALESCE(SUM(vendas.qntd_desconto), 0) AS quantidade_desconto FROM produto LEFT JOIN vendas ON produto.id_produto = vendas.id_produto WHERE produto.id_produto = 13 GROUP BY produto.id_produto;"]
    ];

    $balanco_geral = 0; // Variável global para armazenar o balanço total
    
    function renderizarCabecalho($titulo)
    {
        if ($titulo === "Sacolé" || $titulo === "Refri") {
            return "<thead>
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
        }
        return "<thead>
        <tr>
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
    }

    function exibirTabela($conexao, $sql, $titulo)
    {
        global $balanco_geral;
        $resultado = mysqli_query($conexao, $sql);

        $balanco_total = 0;
        $dados_produtos = [];

        while ($dados = mysqli_fetch_array($resultado)) {
            $quantidade_vendida = $dados['quantidade_vendida'] ?? 0;
            $quantidade_desconto = $dados['quantidade_desconto'] ?? 0;

            $balanco = ($quantidade_vendida * $dados['valor_venda']) +
                ($quantidade_desconto * $dados['valor_desconto']) -
                ($dados['qntdC'] * $dados['valor_custo']);

            $balanco_total += $balanco;

            if ($balanco >= 0 && empty($dados['ponto_equilibrio'])) {
                date_default_timezone_set('America/Sao_Paulo');
                $horaPe = date('H:i:s');
                $pe = "UPDATE produto SET ponto_equilibrio = '$horaPe' WHERE id_produto = " . $dados['id_produto'];
                mysqli_query($conexao, $pe);
                $dados['ponto_equilibrio'] = $horaPe;
            }

            $dados['balanco_calculado'] = $balanco;
            $dados_produtos[] = $dados;
        }

        $balanco_geral += $balanco_total;
        $_SESSION['balanco_geral'] = $balanco_geral;

        echo "<div class='table-container'>";
        echo "<table class='planilha'>";
        echo "<caption>$titulo</caption>";
        echo renderizarCabecalho($titulo);

        foreach ($dados_produtos as $dados) {
            echo "<tr>";
            if ($titulo === "Sacolé" or $titulo === "Refri") {
                echo "<td>" . $dados['tipo'] . "</td>";
            }
            echo "<td>" . $dados['valor_custo'] . ",00 </td>";
            echo "<td>" . $dados['valor_venda'] . ",00 </td>";
            echo "<td>" . $dados['valor_desconto'] . ",00 </td>";

            // Ajusta os dados de acordo com o título
            echo "<td>" . $dados['qntdC'] . " </td>";
            echo "<td>" . ($dados['quantidade_vendida'] ?? '0') . " </td>";
            echo "<td>" . ($dados['quantidade_desconto'] ?? '0') . " </td>";
            echo "<td>" . $dados['balanco_calculado'] . ",00 </td>";
            echo "<td>" . $balanco_total . ",00 </td>";
            echo "<td>" . ($dados['ponto_equilibrio'] ?? 'N/A') . " </td>";
            echo "</tr>";
        }

        echo "</table></div><br>";
    }

    $conexao = conectar();
    foreach ($queries as [$titulo, $sql]) {
        exibirTabela($conexao, $sql, $titulo);
    }

    if ($balanco_geral >= 0) {
        date_default_timezone_set('America/Sao_Paulo');
        $horaPe = date('H:i:s');

        // Verifica se o ponto de equilíbrio já foi registrado
        $verificaPe = "SELECT ponto_equilibrio FROM produto WHERE id_produto = 12";
        $resultado = mysqli_query($conexao, $verificaPe);
        $linha = mysqli_fetch_assoc($resultado);

        // Se o ponto de equilíbrio ainda não foi registrado, realiza o UPDATE
        if (empty($linha['ponto_equilibrio'])) {
            $sql_ponto_equilibrio = "UPDATE produto SET ponto_equilibrio = '$horaPe' WHERE id_produto = 12";
            mysqli_query($conexao, $sql_ponto_equilibrio);
        }
    }

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