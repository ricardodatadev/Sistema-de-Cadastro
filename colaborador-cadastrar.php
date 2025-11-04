<h1>Cadastrar Colaborador</h1>
<form action="?page=colaborador-salvar" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    <div class="mb-3">
        <label for="nome">Nome do Colaborador</label>
        <input type="text" id="nome" name="nome" class="form-control" required>

        <label for="cargo">Cargo</label>
        <input type="text" id="cargo" name="cargo" class="form-control" required>

        <label for="setor">Setor</label>
        <input type="text" id="setor" name="setor" class="form-control" required>

        <label for="registro">Número de Registro</label>
        <input type="number" id="registro" name="registro" class="form-control" required>

        <label for="data_admissao">Data de Admissão</label>
        <input type="date" id="data_admissao" name="data_admissao" class="form-control" required>
        
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-success">Enviar</button>
    </div>
</form>