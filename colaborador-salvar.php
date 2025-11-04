<?php
include("config.php");

switch ($_POST['acao']) {
    case 'cadastrar':
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $setor = $_POST['setor'];
        $registro = $_POST['registro'];
        $data_admissao = $_POST['data_admissao'];

        if (empty($nome) || empty($cargo) || empty($setor) || empty($registro) || empty($data_admissao)) {
            die("Erro: Todos os campos devem ser preenchidos!");
        }

        $stmt = $conn->prepare("INSERT INTO colaboradores (nome, cargo, setor, numero_registro, data_admissao) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) die("Erro ao preparar: " . $conn->error);
        $stmt->bind_param('sssds', $nome, $cargo, $setor, $registro, $data_admissao);
        if ($stmt->execute()) {
            echo "<script>alert('Cadastrou com sucesso!');</script>";
        } else {
            die("Erro ao inserir: " . $stmt->error);
        }
        $stmt->close();

        echo "<script>location.href='?page=colaborador-listar';</script>";
        break;
    case 'editar':
        $id = (int) $_POST['id'];
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $setor = $_POST['setor'];
        $registro = $_POST['registro'];
        $data_admissao = $_POST['data_admissao'];

        if (empty($id) || empty($nome) || empty($cargo) || empty($setor) || empty($registro) || empty($data_admissao)) {
            die("Erro: Todos os campos devem ser preenchidos!");
        }

        $stmt = $conn->prepare("UPDATE colaboradores SET nome = ?, cargo = ?, setor = ?, numero_registro = ?, data_admissao = ? WHERE id = ?");
        if (!$stmt) die("Erro ao preparar: " . $conn->error);
        $stmt->bind_param('sssisi', $nome, $cargo, $setor, $registro, $data_admissao, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Atualizado com sucesso!');</script>";
        } else {
            die("Erro ao atualizar: " . $stmt->error);
        }
        $stmt->close();

        echo "<script>location.href='?page=colaborador-listar';</script>";
        break;
}
?>