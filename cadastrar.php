<?php

include "conexao.php";
$conexao = conectar();

if (isset($_GET['product'], $_GET['quantity'], $_GET['option'], $_GET['promo'])) {
    $products = $_GET['product'];
    $quantities = $_GET['quantity'];
    $options = $_GET['option'];
    $promos = $_GET['promo']; // Promoção (normal ou promocional)

    $productMap = [
        'Batata Frita' => ['Pequena' => 1, 'Grande' => 2],
        'Sacolé' => ['Fruta' => 3, 'Cremoso' => 4],
        'Cachorro Quente' => 5,
        'Hambúrguer' => 6,
        'Pastel' => 7,
        'Refri' => 8,
        'Enroladinho' => 9,
        'Bolo de pote' => 10
    ];

    foreach ($products as $index => $product) {
        $quantity = intval($quantities[$index]);
        $option = isset($options[$index]) ? $options[$index] : '';
        $isPromo = isset($promos[$index]) && $promos[$index] === 'Promocional'; // Verifica se é promocional

        $productId = null;
        if (isset($productMap[$product]) && is_array($productMap[$product])) {
            $productId = $productMap[$product][$option] ?? null;
        } elseif (isset($productMap[$product])) {
            $productId = $productMap[$product];
        }

        if ($productId && $quantity > 0) {
            $checkQuery = "SELECT COUNT(*) AS count FROM produto WHERE id_produto = '$productId'";
            $result = mysqli_query($conexao, $checkQuery);
            $row = mysqli_fetch_assoc($result);

            if ($row['count'] > 0) {
                if ($isPromo) {
                    // Insere no campo qntd_desconto e registra o tipo
                    $sql = "INSERT INTO vendas (id_produto, qntd_desconto, tipo) VALUES ('$productId', '$quantity', '$option')";
                } else {
                    // Insere no campo qtd e registra o tipo
                    $sql = "INSERT INTO vendas (id_produto, qtd, tipo) VALUES ('$productId', '$quantity', '$option')";
                }

                if (!mysqli_query($conexao, $sql)) {
                    echo "Erro ao cadastrar venda: " . mysqli_error($conexao);
                    exit;
                }
            } else {
                echo "Produto inválido: ID $productId não encontrado na tabela produto.<br>";
                exit;
            }
        } else {
            echo "Produto ou quantidade inválidos. Produto: $product, Opção: $option.<br>";
            exit;
        }
    }
    header("Location: vendas.php");
    exit;
} elseif (isset($_POST['cadastrarUsuario'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    if ($hash) {
        $sql = "INSERT INTO usuario(nome, email, senha) VALUES ('$nome','$email', '$hash')";

        if (mysqli_query($conexao, $sql)) {
            header("Location: index.php");
        } else {
            echo "<script>alert('Não foi possível realizar o cadastro!');
        location.href='index.php'</script>";
        exit;
        }
    } else {
        echo "Erro na encriptografia da senha!!!!";
        exit;
    }
}