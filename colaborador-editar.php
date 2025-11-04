<?php
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID não informado.</div>";
    return;
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM colaboradores WHERE id = ? LIMIT 1");
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

<h1>Editar Colaborador</h1>
<form action="?page=colaborador-salvar" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row->id); ?>">
    <div class="mb-3">
        <label for="nome">Nome do Colaborador</label>
        <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($row->nome); ?>" required>

        <label for="cargo">Cargo</label>
        <input type="text" id="cargo" name="cargo" class="form-control" value="<?php echo htmlspecialchars($row->cargo); ?>" required>

        <label for="setor">Setor</label>
        <input type="text" id="setor" name="setor" class="form-control" value="<?php echo htmlspecialchars($row->setor); ?>" required>

        <label for="registro">Número de Registro</label>
        <input type="number" id="registro" name="registro" class="form-control" value="<?php echo htmlspecialchars($row->numero_registro); ?>" required>

        <label for="data_admissao">Data de Admissão</label>
        <input type="date" id="data_admissao" name="data_admissao" class="form-control" value="<?php echo htmlspecialchars($row->data_admissao); ?>" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="?page=colaborador-listar" class="btn btn-secondary">Cancelar</a>
    </div>
</form>


