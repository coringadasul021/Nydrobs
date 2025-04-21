<?php
$mensagemFormatada = '';
$whatsappButton = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoViagem = $_POST['tipo_viagem'];
    $saida = $_POST['saida'];
    $chegada = $_POST['chegada'];
    $ida = $_POST['ida'];
    $volta = $_POST['volta'];
    $adultos = $_POST['adultos'];
    $criancas = $_POST['criancas'];

    $mensagem = "Olá! Gostaria de informações sobre passagem de ônibus:\n";
    $mensagem .= "🚌 Saída: *$saida*\n";
    $mensagem .= "📍 Chegada: *$chegada*\n";
    $mensagem .= "🛣️ Tipo de viagem: *$tipoViagem*\n";
    $mensagem .= "📅 Ida: *$ida*\n";

    if ($tipoViagem === 'Ida e volta' && !empty($volta)) {
        $mensagem .= "📅 Volta: *$volta*\n";
    }

    $mensagem .= "👤 Adultos: *$adultos*\n";
    $mensagem .= "🧒 Crianças: *$criancas*";

    $mensagemFormatada = nl2br(htmlspecialchars($mensagem));
    $mensagemCodificada = urlencode($mensagem);
    $whatsappLink = "https://wa.me/555197270641?text=$mensagemCodificada";

    $whatsappButton = "<a href='$whatsappLink' target='_blank' class='whatsapp-btn'>Enviar para o WhatsApp</a>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Passagem de Ônibus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        video#bgVideo {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 90%;
            max-width: 400px;
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            color: #004080;
            margin-bottom: 20px;
        }

        .container label {
            display: block;
            text-align: left;
            margin-top: 12px;
            font-weight: bold;
            color: #004080;
        }

        .container input,
        .container select {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .container button {
            width: 100%;
            padding: 14px;
            margin-top: 20px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .container button:hover {
            background-color: #003366;
        }

        .whatsapp-btn {
            display: inline-block;
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            background-color: #004080;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .whatsapp-btn:hover {
            background-color: #003366;
        }

        .resumo {
            text-align: left;
            margin-top: 30px;
            background: #f1f1f1;
            padding: 15px;
            border-radius: 10px;
            color: #333;
            font-size: 16px;
        }

        @media (max-width: 480px) {
            .container {
                margin: 40px auto;
                padding: 20px;
            }

            .container button,
            .whatsapp-btn {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
    <script>
        function toggleVolta() {
            var tipo = document.getElementById("tipo_viagem").value;
            var voltaDiv = document.getElementById("voltaDiv");
            voltaDiv.style.display = tipo === "Ida e volta" ? "block" : "none";
        }
    </script>
</head>
<body>

<video autoplay muted loop id="bgVideo">
    <source src="onibus.mp4" type="video/mp4">
    Seu navegador não suporta vídeo em segundo plano.
</video>

<div class="container">
    <h2>Consulta de Passagens de Ônibus</h2>
    <form method="POST">
        <label for="saida">Local de saída</label>
        <input type="text" id="saida" name="saida" placeholder="Ex: Porto Alegre" required>

        <label for="chegada">Local de chegada</label>
        <input type="text" id="chegada" name="chegada" placeholder="Ex: Florianópolis" required>

        <label for="tipo_viagem">Tipo de viagem</label>
        <select id="tipo_viagem" name="tipo_viagem" onchange="toggleVolta()" required>
            <option value="Só ida">Só ida</option>
            <option value="Ida e volta">Ida e volta</option>
        </select>

        <label for="ida">Data de ida</label>
        <input type="date" id="ida" name="ida" required>

        <div id="voltaDiv" style="display: none;">
            <label for="volta">Data de volta</label>
            <input type="date" id="volta" name="volta">
        </div>

        <label for="adultos">Quantidade de adultos</label>
        <input type="number" id="adultos" name="adultos" placeholder="Ex: 2" min="0" required>

        <label for="criancas">Quantidade de crianças</label>
        <input type="number" id="criancas" name="criancas" placeholder="Ex: 1" min="0" required>

        <button type="submit">Buscar</button>
    </form>

    <?php if ($mensagemFormatada): ?>
        <div class="resumo">
            <strong>Resumo da Solicitação:</strong><br><br>
            <?= $mensagemFormatada ?>
        </div>
        <?= $whatsappButton ?>
    <?php endif; ?>
</div>

</body>
</html>
