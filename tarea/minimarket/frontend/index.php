<?php
$apiUrl = "http://localhost:8000";

// Manejar acciones del formulario enviadas al mismo frontend para que este llame a la API
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action =$_POST['action'] ?? '';
    if ($action === 'create' || $action === 'edit') {$data = [
            'nombre' => $_POST['nombre'],
            'proveedor' => $_POST['proveedor'],
            'fecha_vencimiento' => $_POST['fecha_vencimiento'],
            'precio' => $_POST['precio'],
            'stock' => $_POST['stock']
        ];
        
        $ch = curl_init($apiUrl);
        if ($action === 'edit') {
            $data['id'] =$_POST['id'];
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        } else {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
    } elseif ($action === 'delete') {$ch = curl_init($apiUrl . "?id=" . $_POST['id']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_exec($ch);
        curl_close($ch);
    }
    header("Location: index.php");
    exit;
}

// Obtener productos de la API
$productos = json_decode(file_get_contents($apiUrl), true) ?? [];
?>
<!DOCTYPE html>
<html>
<head><title>Minimarket Frontend</title></head>
<body>
    <h1>Gestión de Productos</h1>
    
    <h3>Registrar / Editar Producto</h3>
    <form method="POST">
        <input type="hidden" name="action" value="create" id="form-action">
        <input type="hidden" name="id" id="prod-id">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="proveedor" placeholder="Proveedor" required>
        <input type="date" name="fecha_vencimiento" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <button type="submit" id="btn-submit">Guardar</button>
    </form>

    <h3>Listado de Productos Activos</h3>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Nombre</th><th>Proveedor</th><th>Vencimiento</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr>
        <?php foreach ($productos as$p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['nombre'] ?></td>
            <td><?= $p['proveedor'] ?></td>
            <td><?= $p['fecha_vencimiento'] ?></td>
            <td><?= $p['precio'] ?></td>
            <td><?= $p['stock'] ?></td>
            <td>
                <button onclick="editar(<?= htmlspecialchars(json_encode($p)) ?>)">Editar</button>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
        function editar(p) {
            document.getElementById('form-action').value = 'edit';
            document.getElementById('prod-id').value = p.id;
            document.getElementsByName('nombre')[0].value = p.nombre;
            document.getElementsByName('proveedor')[0].value = p.proveedor;
            document.getElementsByName('fecha_vencimiento')[0].value = p.fecha_vencimiento;
            document.getElementsByName('precio')[0].value = p.precio;
            document.getElementsByName('stock')[0].value = p.stock;
            document.getElementById('btn-submit').innerText = 'Actualizar';
        }
    </script>
</body>
</html>