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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Comidas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lobster', serif;
        }

        body {
            background-color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            background-color: #800000;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .card {
            border: 2px solid #800000;
            border-radius: 10px;
            padding: 10px;
            background-color: #fff;
            text-align: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .card img {
            max-width: 100%;
            border-radius: 10px;
        }

        .card h2 {
            font-size: 18px;
            color: #800000;
            margin: 10px 0;
        }

        select {
            border: 1px solid #800000;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
            text-align: center;
        }

        .controls {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            gap: 10px;
        }

        .controls input {
            width: 40px;
            text-align: center;
            border: 1px solid #800000;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            background-color: #800000;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #a00000;
        }

        .add-btn {
            display: inline-block;
            background-color: #800000;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .add-btn:hover {
            background-color: #a00000;
        }

        .sales-list {
            margin: 20px 0;
            text-align: center;
        }

        .sales-list table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .sales-list table,
        .sales-list th,
        .sales-list td {
            border: 1px solid #800000;
        }

        .sales-list th,
        .sales-list td {
            padding: 10px;
            text-align: center;
        }

        .confirm-btn {
            background-color: #800000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }

        .confirm-btn:hover {
            background-color: #a00000;
        }
    </style>
</head>

<body>
    <h1>Seleção de Comidas</h1>
    <div class="container">
        <!-- Batata Frita -->
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Batata Frita">
            <h2>Batata Frita</h2>
            <select id="batata-size">
                <option value="" disabled selected>Selecione um tamanho</option> <!-- Label não selecionável -->
                <option value="batata pequena">Pequena - R$ 5,00</option>
                <option value="batata grande">Grande - R$ 10,00</option>
            </select>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
        </div>

        <!-- Sacolé -->
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Sacolé">
            <h2>Sacolé</h2>
            <select id="sacole-type">
                <option value="" disabled selected>Selecione um tipo</option> <!-- Label não selecionável -->
                <option value="sacole fruta">Fruta - R$ 3,00</option>
                <option value="sacole cremoso">Cremoso - R$ 5,00</option>
            </select>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
        </div>

        <!-- Cachorro Quente -->
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Cachorro quente">
            <h2>Cachorro Quente</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
        </div>

        <!-- Hambúrguer -->
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Hambúrguer">
            <h2>Hambúrguer</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
        </div>

    </div>


    <!-- Lista de vendas -->
    <div class="sales-list">
        <h2>Lista de Vendas</h2>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Opção</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <!-- Itens adicionados aparecerão aqui -->
            </tbody>
        </table>
        <a href="#" class="confirm-btn" id="confirm-sale">Confirmar Venda</a>
    </div>

    <script>
        document.querySelectorAll('.card').forEach(card => {
            const input = card.querySelector('input');
            const minusButton = card.querySelector('.minus');
            const plusButton = card.querySelector('.plus');
            const addButton = card.querySelector('.add-btn');
            const select = card.querySelector('select'); // Pode ser null para alguns itens

            minusButton.addEventListener('click', () => {
                const currentValue = parseInt(input.value) || 0;
                if (currentValue > 0) {
                    input.value = currentValue - 1;
                }
            });

            plusButton.addEventListener('click', () => {
                const currentValue = parseInt(input.value) || 0;
                input.value = currentValue + 1;
            });

            addButton.addEventListener('click', () => {
                const productName = card.querySelector('h2').innerText.trim();
                const quantity = parseInt(input.value) || 0;

                let option = 'Sem opção'; // Valor padrão para itens sem select
                if (select) {
                    // Só tenta acessar o select se ele existir
                    const selectedOption = select.selectedIndex > 0 ? select.options[select.selectedIndex].text : 'Sem opção';
                    option = selectedOption.split(' - ')[0]; // Recupera apenas a parte do nome (sem o preço)
                }

                if (quantity > 0) {
                    const tableBody = document.getElementById('sales-table-body');

                    // Verifica se o produto já está na tabela (com ou sem opção)
                    const existingRow = Array.from(tableBody.querySelectorAll('tr')).find(row => {
                        const cells = row.querySelectorAll('td');
                        return cells[0].innerText === productName && cells[2].innerText === option;
                    });

                    if (existingRow) {
                        // Atualiza a quantidade se o produto já estiver na tabela
                        const quantityCell = existingRow.querySelector('td:nth-child(2)');
                        quantityCell.innerText = parseInt(quantityCell.innerText) + quantity;
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                <td>${productName}</td>
                <td>${quantity}</td>
                <td>${option}</td>
            `;
                        tableBody.appendChild(row);
                    }
                    input.value = 0;
                } else {
                    alert("Adicione uma quantidade maior que 0.");
                }
            });
        });

        document.getElementById('confirm-sale').addEventListener('click', () => {
            const tableBody = document.getElementById('sales-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            if (rows.length === 0) {
                alert("Nenhuma venda adicionada!");
                return;
            }

            const sales = rows.map(row => {
                const cells = row.querySelectorAll('td');
                return {
                    product: cells[0].innerText.trim(),
                    quantity: parseInt(cells[1].innerText.trim()) || 0,
                    option: cells[2].innerText.trim(),
                };
            });

            // Gera a query string com verificação de valores válidos
            const queryParams = sales.map(sale =>
                `product[]=${encodeURIComponent(sale.product)}&quantity[]=${encodeURIComponent(sale.quantity)}&option[]=${encodeURIComponent(sale.option)}`
            ).join('&');

            // Debug para verificar os dados enviados
            console.log("Query Params:", queryParams);

            // Redireciona para o PHP
            window.location.href = `cadastrar.php?${queryParams}`;
        });
    </script>

</body>


</html>