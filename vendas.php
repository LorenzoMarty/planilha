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
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <title>Dia Geek</title>
    <style>
        /* Estilos base */
        body {
            background: linear-gradient(135deg, #ffefba, #ffffff);
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: 'Lobster', serif;
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

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            border: 2px solid #771010;
            border-radius: 15px;
            padding: 10px;
            background-color: #fff;
            text-align: center;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 2px 6px 15px rgba(0, 0, 0, 0.3);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
            animation: fadeIn 1s ease;
        }

        .card h2 {
            font-size: 1.8rem;
            color: #771010;
            margin: 10px 0;
            text-shadow: 1px 1px #ffffff;
        }

        select:hover {
            border-color: #a00000;
        }

        select option {
            background-color: #ffffff;
            color: #771010;
            font-size: 1rem;
        }

        select {
            position: relative;
            appearance: none;
            /* Remove o estilo padrão */
            background-color: #ffffff;
            border: 2px solid #771010;
            border-radius: 5px;
            padding: 8px;
            width: 100%;
            max-width: 200px;
            font-size: 1rem;
            color: #771010;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        select:focus {
            border-color: #a00000;
            outline: none;
            box-shadow: 0 0 5px rgba(160, 0, 0, 0.5);
        }

        .btn {
            background-color: #771010;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #a00000;
            transform: scale(1.1);
        }

        .price-toggle-btn {
            background-color: #771010;
            color: #fff;
            font-size: 1rem;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .price-toggle-btn:hover {
            background-color: #a00000;
            transform: rotate(360deg);
        }

        .add-btn {
            display: inline-block;
            background-color: #771010;
            color: #fff;
            padding: 8px 15px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .add-btn:hover {
            background-color: #a00000;
            transform: scale(1.05);
        }

        .sales-list {
            margin: 20px 0;
            text-align: center;
            padding: 20px;
            background: #fff;
            border: 2px solid #771010;
            border-radius: 15px;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: 20px auto;
            animation: fadeIn 1s ease;
        }

        .sales-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            animation: fadeIn 0.8s ease;
        }

        .sales-list th,
        .sales-list td {
            padding: 10px;
            text-align: center;
            font-size: 1rem;
            border: 1px solid #771010;
        }

        .sales-list .remove-btn {
            color: #771010;
            font-size: 1.2rem;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .sales-list .remove-btn:hover {
            color: #a00000;
            transform: scale(1.2);
        }

        .confirm-btn {
            background-color: #771010;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 1.2rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .confirm-btn:hover {
            background-color: #a00000;
            transform: scale(1.05);
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
            border: 1px solid #771010;
            border-radius: 5px;
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
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="menu-icon" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="titulo">Seleção de Comidas</div>
        <div class="nav-links">
            <a href="planilhas.php">Planilhas</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>
    <div class="container">
        <!-- Batata Frita -->
        <div class="card">
            <img src="img/batata.jpg" alt="Batata Frita">
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
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- Sacolé -->
        <div class="card">
            <img src="img/sacole.jpg" alt="Sacolé">
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
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- Cachorro Quente -->
        <div class="card">
            <img src="img/cachorro.jpg" alt="Cachorro quente">
            <h2>Cachorro Quente</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- Hambúrguer -->
        <div class="card">
            <img src="img/hamburguer.jpg" alt="Hambúrguer">
            <h2>Hambúrguer</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- Pastel -->
        <div class="card">
            <img src="img/pastel.jpg" alt="pastel">
            <h2>Pastel</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- Enroladinho -->
        <div class="card">
            <img src="img/enroladinho.jpg" alt="enroladinho">
            <h2>Enroladinho</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- refri -->
        <div class="card">
            <img src="img/refri.webp" alt="refri">
            <h2>Refri</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
        </div>

        <!-- bolo de pote -->
        <div class="card">
            <img src="img/bolodepote.jpeg" alt="refri">
            <h2>Bolo de pote</h2>
            <div class="controls">
                <button class="btn minus">-</button>
                <input type="number" value="0" min="0" readonly>
                <button class="btn plus">+</button>
            </div>
            <a href="#" class="add-btn">Adicionar</a>
            <button class="price-toggle-btn normal"><i class="fa fa-times"></i></button>
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
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <!-- Itens adicionados aparecerão aqui -->
            </tbody>
        </table>
        <a href="#" class="confirm-btn" id="confirm-sale">Confirmar Venda</a>
    </div>

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
    <script>
        document.querySelectorAll('.card').forEach(card => {
            const input = card.querySelector('input');
            const minusButton = card.querySelector('.minus');
            const plusButton = card.querySelector('.plus');
            const addButton = card.querySelector('.add-btn');
            const select = card.querySelector('select'); // Pode ser null para alguns itens
            const priceToggleBtn = card.querySelector('.price-toggle-btn');

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

            priceToggleBtn.addEventListener('click', () => {
                if (priceToggleBtn.classList.contains('normal')) {
                    priceToggleBtn.classList.remove('normal');
                    priceToggleBtn.classList.add('promo');
                    priceToggleBtn.innerHTML = '<i class="fa fa-check"></i>'; // Ícone de "Corrigido"
                } else {
                    priceToggleBtn.classList.remove('promo');
                    priceToggleBtn.classList.add('normal');
                    priceToggleBtn.innerHTML = '<i class="fa fa-times"></i>'; // Ícone de "X"
                }
            });


            addButton.addEventListener('click', (event) => {
                event.preventDefault();

                const productName = card.querySelector('h2').innerText.trim();
                const quantity = parseInt(input.value) || 0;
                const isPromo = priceToggleBtn.classList.contains('promo') ? 'Promocional' : 'Normal';

                let option = 'Sem opção';
                if (select) {
                    const selectedOption = select.selectedIndex > 0 ? select.options[select.selectedIndex].text : 'Sem opção';
                    option = selectedOption.split(' - ')[0];
                }

                if (quantity > 0) {
                    const tableBody = document.getElementById('sales-table-body');

                    const existingRow = Array.from(tableBody.querySelectorAll('tr')).find(row => {
                        const cells = row.querySelectorAll('td');
                        return cells[0].innerText === productName && cells[2].innerText === option;
                    });

                    if (existingRow) {
                        const quantityCell = existingRow.querySelector('td:nth-child(2)');
                        quantityCell.innerText = parseInt(quantityCell.innerText) + quantity;
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${productName}</td>
                    <td>${quantity}</td>
                    <td>${option}</td>
                    <td>${isPromo}</td>
                    <td><button class="remove-btn"><i class="fas fa-times"></i></button></td>
                `;
                        tableBody.appendChild(row);

                        const removeButton = row.querySelector('.remove-btn');
                        removeButton.addEventListener('click', () => {
                            row.remove();
                        });
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
                    promo: cells[3].innerText.trim(),
                };
            });

            const queryParams = sales.map(sale =>
                `product[]=${encodeURIComponent(sale.product)}&quantity[]=${encodeURIComponent(sale.quantity)}&option[]=${encodeURIComponent(sale.option)}&promo[]=${encodeURIComponent(sale.promo)}`
            ).join('&');

            console.log("Query Params:", queryParams);

            window.location.href = `cadastrar.php?${queryParams}`;
        });
    </script>

</body>


</html>