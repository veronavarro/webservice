<?php
require_once("vendor/econea/nusoap/src/nusoap.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente = new nusoap_client("http://localhost/webservice/promedio.php?wsdl", true);

    $nombre = $_POST['nombre'];
    $lab1 = (float) $_POST['lab1'];
    $lab2 = (float) $_POST['lab2'];
    $parcial = (float) $_POST['parcial'];

    $result = $cliente->call('calcularPromedio', [
        'nombre' => $nombre,
        'lab1' => $lab1,
        'lab2' => $lab2,
        'parcial' => $parcial,
    ]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promedio Alumno</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ece9e6, #ffffff);
            padding: 40px;
        }
        .container {
            max-width: 500px;
            margin: auto;
        }
        .card {
            background: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input {
            padding: 12px;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #1e90ff;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #0066cc;
        }
        .resultado {
            background: #f4f4f4;
            border-left: 5px solid #1e90ff;
            padding: 15px;
            border-radius: 8px;
        }
        .resultado p {
            font-size: 16px;
            margin: 5px 0;
        }
        .label {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Formulario Alumno</h2>
        <form method="post">
            <input type="text" name="nombre" placeholder="Nombre del alumno" required>
            <input type="number" name="lab1" placeholder="Nota Laboratorio 1" step="0.01" required>
            <input type="number" name="lab2" placeholder="Nota Laboratorio 2" step="0.01" required>
            <input type="number" name="parcial" placeholder="Nota Parcial" step="0.01" required>
            <button type="submit">Calcular Promedio</button>
        </form>
    </div>

    <?php if (isset($result)): ?>
        <div class="card resultado">
            <h3>Resultado:</h3>
            <p><span class="label">Nombre:</span> <?= htmlspecialchars($result['nombre']) ?></p>
            <p><span class="label">Promedio:</span> <?= $result['promedio'] ?></p>
            <p><span class="label">Observación:</span> <?= $result['observacion'] ?></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
