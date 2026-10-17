<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$host = '127.0.0.1';
$db = 'db_minimarket_pro413';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Error de conexión: " . $e->getMessage()]));
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET': // Consultar activos
        $stmt = $pdo->query("SELECT * FROM Producto WHERE eliminado = 0");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;
    case 'POST': // Registrar
        $stmt = $pdo->prepare("INSERT INTO Producto (nombre, proveedor, fecha_vencimiento, precio, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$input['nombre'], $input['proveedor'], $input['fecha_vencimiento'], $input['precio'], $input['stock']]);
        echo json_encode(["message" => "Producto creado"]);
        break;
    case 'PUT': // Editar
        $stmt = $pdo->prepare("UPDATE Producto SET nombre=?, proveedor=?, fecha_vencimiento=?, precio=?, stock=? WHERE id=?");
        $stmt->execute([$input['nombre'], $input['proveedor'], $input['fecha_vencimiento'], $input['precio'], $input['stock'], $input['id']]);
        echo json_encode(["message" => "Producto actualizado"]);
        break;
    case 'DELETE': // Eliminar lógicamente
        $id = $_GET['id'];
        $stmt = $pdo->prepare("UPDATE Producto SET eliminado = 1 WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Producto eliminado lógicamente"]);
        break;
}
?>