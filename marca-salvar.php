<?php
include("config.php");

switch ($_POST['acao']) {
    case 'cadastrar':
        $frota = $_POST['frota'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $placa = $_POST['placa'];
        $data_aquisicao = $_POST['data_aquisicao'];

        if (empty($frota) || empty($marca) || empty($modelo) || empty($placa) || empty($data_aquisicao)) {
            die("Erro: Todos os campos devem ser preenchidos!");
        }

        $stmt = $conn->prepare("INSERT INTO equipamentos (Frota, Marca, Modelo, Placa, Data_Aquisicao) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) die("Erro ao preparar: " . $conn->error);
        $stmt->bind_param('issss', $frota, $marca, $modelo, $placa, $data_aquisicao);
        if ($stmt->execute()) {
            echo "<script>alert('Cadastrou com sucesso!');</script>";
        } else {
            die("Erro ao inserir: " . $stmt->error);
        }
        $stmt->close();

        echo "<script>location.href='?page=marca-listar';</script>";
        break;
    case 'editar':
        $id = (int) $_POST['id'];
        $frota = $_POST['frota'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $placa = $_POST['placa'];
        $data_aquisicao = $_POST['data_aquisicao'];

        if (empty($id) || empty($frota) || empty($marca) || empty($modelo) || empty($placa) || empty($data_aquisicao)) {
            die("Erro: Todos os campos devem ser preenchidos!");
        }

        $stmt = $conn->prepare("UPDATE equipamentos SET Frota = ?, Marca = ?, Modelo = ?, Placa = ?, Data_Aquisicao = ? WHERE id = ?");
        if (!$stmt) die("Erro ao preparar: " . $conn->error);
        $stmt->bind_param('issssi', $frota, $marca, $modelo, $placa, $data_aquisicao, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Atualizado com sucesso!');</script>";
        } else {
            die("Erro ao atualizar: " . $stmt->error);
        }
        $stmt->close();

        echo "<script>location.href='?page=marca-listar';</script>";
        break;
}
?>
