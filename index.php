<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>
        <div class="search">
            <form id="container-formulario" action="server.php" method="POST">
                <input type="text" name="task" placeholder="Agregar tarea...">
                <button class="btn-add">+</button>
            </form>
        </div>
        <div class="li-container">
            <ul>
                <!-- Las tareas se cargarán aquí mediante JavaScript -->
            </ul>
        </div>
        <div class="empty">
            <p>No tienes tareas pendientes.</p>
        </div>
    </div>
    <script src="main.js"></script>
</body>
</html>
