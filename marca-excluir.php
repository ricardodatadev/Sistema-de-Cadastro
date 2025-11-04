<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Método inválido.'); location.href='?page=marca-listar';</script>";
    exit;
}

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    echo "<script>alert('Falha de validação de segurança.'); location.href='?page=marca-listar';</script>";
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if (!$id) {
    echo "<script>alert('ID não informado.'); location.href='?page=marca-listar';</script>";
    exit;
}

$stmt = $conn->prepare('DELETE FROM equipamentos WHERE id = ?');
if (!$stmt) {
    echo "<script>alert('Erro ao preparar exclusão.'); location.href='?page=marca-listar';</script>";
    exit;
}
$stmt->bind_param('i', $id);
$ok = $stmt->execute();
$stmt->close();

if ($ok) {
    echo "<script>alert('Registro excluído com sucesso!'); location.href='?page=marca-listar';</script>";
} else {
    echo "<script>alert('Erro ao excluir.'); location.href='?page=marca-listar';</script>";
}


