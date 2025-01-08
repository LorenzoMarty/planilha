<?php

include "conexao.php";
$conexao = conectar();

if (isset($_GET['product'], $_GET['quantity'], $_GET['option'])) {
    $products = $_GET['product'];
    $quantities = $_GET['quantity'];
    $options = $_GET['option'];

    $productMap = [
        'Batata Frita' => ['Pequena' => 1, 'Grande' => 2],
        'Sacolé' => ['Fruta' => 3, 'Cremoso' => 4],
        'Cachorro Quente' => 5,
        'Hambúrguer' => 6,
    ];

    foreach ($products as $index => $product) {
        $quantity = intval($quantities[$index]);
        $option = isset($options[$index]) ? $options[$index] : '';

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
                $sql = "INSERT INTO vendas (id_produto, qtd) VALUES ('$productId', '$quantity')";
                if (!mysqli_query($conexao, $sql)) {
                    echo "Erro ao cadastrar venda: " . mysqli_error($conexao);
                }
            } else {
                echo "Produto inválido: ID $productId não encontrado na tabela produto.<br>";
            }
        } else {
            echo "Produto ou quantidade inválidos. Produto: $product, Opção: $option.<br>";
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
        }
    } else {
        echo "Erro na encriptografia da senha!!!!";
    }
}