<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planilha de Comidas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lobster', serif;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        /* Navbar */
        .navbar {
            background-color: #800000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1000;
        }

        /* Título no centro */
        .navbar .titulo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        /* Links à direita */
        .navbar .nav-links {
            display: flex;
            gap: 20px;
            margin-left: auto;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .navbar .nav-links a:hover {
            background-color: #f1f1f1;
            color: #800000;
            transform: scale(1.1);
        }

        /* Ícone do menu hambúrguer */
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

        /* Animação do hambúrguer ao clicar */
        .navbar .menu-icon.active span:nth-child(1) {
            transform: translateY(10px) rotate(45deg);
        }

        .navbar .menu-icon.active span:nth-child(2) {
            opacity: 0;
        }

        .navbar .menu-icon.active span:nth-child(3) {
            transform: translateY(-10px) rotate(-45deg);
        }

        /* Navbar responsiva */
        @media screen and (max-width: 768px) {
            .navbar .nav-links {
                display: none;
                flex-direction: column;
                gap: 10px;
                width: 100%;
                background-color: #800000;
                position: absolute;
                top: 45px;
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

        /* Tabelas responsivas */
        .table-container {
            overflow-x: auto;
            margin: 20px;
        }

        .planilha {
            border: 2px solid #800000;
            border-radius: 10px;
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            min-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .planilha caption {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            background-color: #800000;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }

        .planilha th,
        .planilha td {
            border: 1px solid #800000;
            text-align: center;
            padding: 12px 20px;
            transition: background-color 0.3s ease;
        }

        .planilha th {
            background-color: #e0b0b0;
            color: #000;
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

        /* Footer */
        footer {
            background-color: #800000;
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
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="menu-icon" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="titulo">Planilhas de Comida</div>
        <div class="nav-links">
            <a href="main.php">Início</a>
            <a href="vendas.php">Vendas</a>
        </div>
    </nav>

    <?php
    require_once 'conexao.php';

    $queries = [
        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            COUNT(vendas.id_venda) AS numero_de_vendas
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 1 OR produto.id_produto = 2 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            COUNT(vendas.id_venda) AS numero_de_vendas
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 3 OR produto.id_produto = 4 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            COUNT(vendas.id_venda) AS numero_de_vendas
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 5 
        GROUP BY produto.id_produto;",

        "SELECT 
            produto.id_produto,
            produto.nome,
            produto.valor_custo,
            produto.valor_venda,
            produto.qntdC,
            produto.ponto_equilibrio,
            SUM(vendas.qtd) AS quantidade_vendida,
            COUNT(vendas.id_venda) AS numero_de_vendas
        FROM produto 
        INNER JOIN vendas ON produto.id_produto = vendas.id_produto 
        WHERE produto.id_produto = 6 
        GROUP BY produto.id_produto;"
    ];

    $balanco_total = 0;
    function exibirTabela($conexao, $sql, $titulo, $isKg)
    {
        $resultado = mysqli_query($conexao, $sql);

        $balanco_total = 0;
        $dados_produtos = [];

        while ($dados = mysqli_fetch_array($resultado)) {
            $balanco = ($dados['quantidade_vendida'] * $dados['valor_venda']) - ($dados['qntdC'] * $dados['valor_custo']);

            $balanco_total += $balanco;

            if ($balanco >= 0 && empty($dados['ponto_equilibrio'])) {
                $horaPe = date('H:i:s');
                $pe = "UPDATE produto SET ponto_equilibrio = '$horaPe' WHERE id_produto = " . $dados['id_produto'];
                mysqli_query($conexao, $pe);
                $dados['ponto_equilibrio'] = $horaPe;
            }

            $dados_produtos[] = $dados;
        }
        echo "<div class='table-container'>";
        echo "<table class='planilha'>";
        echo "<caption>" . $titulo . "</caption>";
        echo "<thead>
                <tr>
                    <th>Custo</th>
                    <th>Venda</th>
                    <th>Quantidade Comprada</th>
                    <th>Quantidade Vendida</th>
                    <th>Número de Vendas</th>
                    <th>Balanço</th>
                    <th>Balanço Total</th>
                    <th>P.E</th>
                </tr>
            </thead>";

        foreach ($dados_produtos as $dados) {
            $balanco = ($dados['quantidade_vendida'] * $dados['valor_venda']) - ($dados['qntdC'] * $dados['valor_custo']);

            echo "<tr>";
            echo "<td> " . $dados['valor_custo'] . ",00 </td>";
            echo "<td> " . $dados['valor_venda'] . ",00 </td>";

            if ($isKg) {
                echo "<td>" . $dados['qntdC'] . " kg </td>";
            } else {
                echo "<td>" . $dados['qntdC'] . " </td>";
            }

            echo "<td>" . $dados['quantidade_vendida'] . " </td>";
            echo "<td>" . $dados['numero_de_vendas'] . " </td>";
            echo "<td>" . $balanco . ",00 </td>";
            echo "<td>" . $balanco_total . ",00 </td>";
            echo "<td>" . $dados['ponto_equilibrio'] . " </td>";
            echo '</tr>';
        }

        echo "</table></div><br>";
    }

    $conexao = conectar();
    exibirTabela($conexao, $queries[0], "Batata Frita", true);
    exibirTabela($conexao, $queries[1], "Sacolé", false);
    exibirTabela($conexao, $queries[2], "Cachorro Quente", false);
    exibirTabela($conexao, $queries[3], "Hambúrguer", false);
    ?>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Planilha de Comidas. Todos os direitos reservados. <a href="#">Política de Privacidade</a> | <a
                href="#">Termos de Uso</a></p>
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