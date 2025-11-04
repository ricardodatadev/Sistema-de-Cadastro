<h1>Cadastrar Equipamento</h1>
<form action="?page=marca-salvar" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    <div class="mb-3">
        <label for="frota">Número da Frota</label>
        <input type="number" id="frota" name="frota" class="form-control" required>

        <label for="marca">Marca</label>
        <input type="text" id="marca" name="marca" class="form-control" required>

        <label for="modelo">Modelo</label>
        <input type="text" id="modelo" name="modelo" class="form-control" required>

        <label for="placa">Placa</label>
        <input type="text" id="placa" name="placa" class="form-control" required>

        <label for="data_aquisicao">Data de Aquisição</label>
        <input type="date" id="data_aquisicao" name="data_aquisicao" class="form-control" required>
        
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-success">Enviar</button>
    </div>
</form>