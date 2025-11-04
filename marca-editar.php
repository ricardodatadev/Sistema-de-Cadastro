<?php
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID não informado.</div>";
    return;
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM equipamentos WHERE id = ? LIMIT 1");
if (!$stmt) {
    echo "<div class='alert alert-danger'>Erro interno ao preparar consulta.</div>";
    return;
}
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows === 0) {
    echo "<div class='alert alert-warning'>Registro não encontrado.</div>";
    $stmt->close();
    return;
}

$row = $res->fetch_object();
$stmt->close();
?>

<h1>Editar Equipamento</h1>
<form action="?page=marca-salvar" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row->id); ?>">
    <div class="mb-3">
        <label for="frota">Número da Frota</label>
        <input type="number" id="frota" name="frota" class="form-control" value="<?php echo htmlspecialchars($row->Frota); ?>" required>

        <label for="marca">Marca</label>
        <input type="text" id="marca" name="marca" class="form-control" value="<?php echo htmlspecialchars($row->Marca); ?>" required>

        <label for="modelo">Modelo</label>
        <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo htmlspecialchars($row->Modelo); ?>" required>

        <label for="placa">Placa</label>
        <input type="text" id="placa" name="placa" class="form-control" value="<?php echo htmlspecialchars($row->Placa); ?>" required>

        <label for="data_aquisicao">Data de Aquisição</label>
        <input type="date" id="data_aquisicao" name="data_aquisicao" class="form-control" value="<?php echo htmlspecialchars($row->Data_Aquisicao); ?>" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="?page=marca-listar" class="btn btn-secondary">Cancelar</a>
    </div>
</form>


