<?php
$host = 'localhost';
$db = 'tasklist_db';
$user = 'root'; 
$pass = '';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verifica la conexión
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Manejo de las solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task'])) {
        $task = $_POST['task'];

        // Insertar la nueva tarea en la base de datos
        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
        $stmt->bind_param('s', $task);
        $stmt->execute();

        // Devolver el ID de la tarea recién insertada
        echo json_encode(['insertId' => $stmt->insert_id]);

        $stmt->close();
        exit; // Salir para evitar que se ejecute el resto del código
    } elseif (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];

        // Eliminar la tarea de la base de datos
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Manejo de las solicitudes GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todas las tareas desde la base de datos
    $result = $conn->query("SELECT * FROM tasks");

    $tasks = [];

    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    echo json_encode($tasks);
}

$conn->close();
?>
