<?php
session_start();

require_once 'conexao.php'; // Inclua o arquivo de conexão com o banco de dados

$conexao = conectar(); // Função para conectar ao banco (certifique-se de que funciona corretamente)

// Inicializa o balanço geral a partir do banco de dados
$query = "SELECT *
          FROM produto WHERE id_produto = 12"; 

$resultado = mysqli_query($conexao, $query);
if($resultado){
    $dados = mysqli_fetch_assoc($resultado);
}
// Inicializa as variáveis de sessão se ainda não estiverem definidas
if (!isset($_SESSION['balanco_geral'])) {
    $_SESSION['balanco_geral'] = 0; // Define o balanço geral inicial como 0
}

if (!isset($_SESSION['ponto_equilibrio_total']) || !is_string($_SESSION['ponto_equilibrio_total'])) {
    $_SESSION['ponto_equilibrio_total'] = 'Não Alcançado'; // Define o valor inicial como "Não Alcançado"
}

// Verifica se o balanço geral é positivo e define o ponto de equilíbrio total
if ($_SESSION['balanco_geral'] >= 0) {
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['ponto_equilibrio_total'] = $dados['ponto_equilibrio'];
}

// Retorna os valores formatados como resposta
echo '<p>Total Arrecadado: R$ ' . number_format($_SESSION['balanco_geral'], 2, ',', '.') . '</p>';
echo '<p>Ponto de Equilíbrio Total: ' . htmlspecialchars($_SESSION['ponto_equilibrio_total']) . '</p>';
?>
