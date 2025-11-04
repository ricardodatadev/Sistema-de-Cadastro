<h1>Colaboradores</h1>
<?php
    $sql = "SELECT * FROM colaboradores ORDER BY nome";
    $res = $conn->query($sql);
    $qtd = $res ? $res->num_rows : 0;

    if ($qtd > 0) {
        print "<p>Encontrou <b>$qtd</b> resultado(s).</p>";
        print "<div class='table-responsive'>";
        print "<table class='table table-bordered table-striped table-hover align-middle'>";
        print "<thead class='table-light'>";
        print "<tr>";
        print "<th scope='col'>Nome</th>";
        print "<th scope='col'>Cargo</th>";
        print "<th scope='col'>Setor</th>";
        print "<th scope='col'>Número Registro</th>";
        print "<th scope='col'>Data de Admissão</th>";
        print "<th scope='col' class='text-center' style='width: 180px;'>Ações</th>";
        print "</tr>";
        print "</thead><tbody>";

        while ($row = $res->fetch_object()) {
            $data = !empty($row->data_admissao) ? date('d/m/Y', strtotime($row->data_admissao)) : '';
            print "<tr>";
            print "<td>" . htmlspecialchars($row->nome) . "</td>";
            print "<td>" . htmlspecialchars($row->cargo) . "</td>";
            print "<td>" . htmlspecialchars($row->setor) . "</td>";
            print "<td>" . htmlspecialchars($row->numero_registro) . "</td>";
            print "<td>" . $data . "</td>";
            $csrf = $_SESSION['csrf_token'] ?? '';
            print "<td class='text-center'>
                    <a href='?page=colaborador-editar&id=" . urlencode($row->id) . "' class='btn btn-sm btn-primary me-2'>Editar</a>
                    <form action='?page=colaborador-excluir' method='POST' class='d-inline' onsubmit=\"return confirm('Deseja realmente excluir?');\"> 
                        <input type='hidden' name='id' value='" . htmlspecialchars($row->id) . "'>
                        <input type='hidden' name='csrf_token' value='" . htmlspecialchars($csrf) . "'>
                        <button type='submit' class='btn btn-sm btn-danger'>Excluir</button>
                    </form>
                   </td>";
            print "</tr>";
        }

        print "</tbody></table></div>";
    } else {
        print "<div class='alert alert-warning'>Nenhum colaborador cadastrado.</div>";
        print "<a href='?page=colaborador-cadastrar' class='btn btn-success'>Cadastrar Colaborador</a>";
    }


