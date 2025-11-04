<h1>Frotas Cadastradas</h1>
<?php
    $sql = "SELECT * FROM equipamentos ORDER BY Frota";
    $res = $conn->query($sql);
    $qtd = $res ? $res->num_rows : 0;

    if($qtd > 0){
        print "<p>Encontrou <b>$qtd</b> resultado(s).</p>";
        print "<div class='table-responsive'>";
        print "<table class='table table-bordered table-striped table-hover align-middle'>";
        print "<thead class='table-light'>";
        print "<tr>";
        print "<th scope='col'>Número da Frota</th>";
        print "<th scope='col'>Marca</th>";
        print "<th scope='col'>Modelo</th>";
        print "<th scope='col'>Placa</th>";
        print "<th scope='col'>Data de Aquisição</th>";
        print "<th scope='col' class='text-center' style='width: 180px;'>Ações</th>";
        print "</tr>";
        print "</thead><tbody>";
        while($row = $res->fetch_object()){
            $data = !empty($row->Data_Aquisicao) ? date('d/m/Y', strtotime($row->Data_Aquisicao)) : '';
            print "<tr>";
            print "<td>". htmlspecialchars($row->Frota) . "</td>";
            print "<td>". htmlspecialchars($row->Marca) . "</td>";
            print "<td>". htmlspecialchars($row->Modelo) . "</td>";
            print "<td>". htmlspecialchars($row->Placa) . "</td>";
            print "<td>". $data . "</td>";
            $csrf = $_SESSION['csrf_token'] ?? '';
            print "<td class='text-center'>
                    <a href='?page=marca-editar&id=".urlencode($row->id)."' class='btn btn-sm btn-primary me-2'>Editar</a>
                    <form action='?page=marca-excluir' method='POST' class='d-inline' onsubmit=\"return confirm('Deseja realmente excluir?');\"> 
                        <input type='hidden' name='id' value='".htmlspecialchars($row->id)."'>
                        <input type='hidden' name='csrf_token' value='".htmlspecialchars($csrf)."'>
                        <button type='submit' class='btn btn-sm btn-danger'>Excluir</button>
                    </form>
                   </td>";
            print "</tr>";
        }
        print "</tbody></table></div>";
    }else{
        print "<div class='alert alert-warning'>Nenhum equipamento cadastrado.</div>";
        print "<a href='?page=marca-cadastrar' class='btn btn-success'>Cadastrar Equipamento</a>";
    }