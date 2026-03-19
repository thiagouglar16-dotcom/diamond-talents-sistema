<?php
$tituloPagina = 'Novo Talento';
require_once 'includes/header.php';
$pdo = getDB();
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nome']) || empty($_POST['sexo']) || empty($_POST['empresa'])) {
        $erro = 'Preencha os campos obrigatórios em vermelho.';
    } else {
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $foto = uniqid('talento_') . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/talentos/' . $foto);
            }
        }
        $pdo->prepare("INSERT INTO talentos (empresa,nome,nome_artistico,sexo,data_nascimento,rg,cpf,foto,
            resp_nome,resp_parentesco,resp_email,resp_telefone,
            pais,cep,estado,cidade,bairro,logradouro,numero,complemento,email,telefone,telefone2,
            cor_olhos,cor_cabelos,cor_pele,cicatriz,tatuagem,
            altura,confeccao,calcado,peso,torax_busto,quadril,cintura,obs_caracteristicas,trabalhou_antes)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")
        ->execute([
            $_POST['empresa'], $_POST['nome'], $_POST['nome_artistico'] ?? '',
            $_POST['sexo'], $_POST['data_nascimento'] ?? null, $_POST['rg'] ?? '', $_POST['cpf'] ?? '', $foto,
            $_POST['resp_nome'] ?? '', $_POST['resp_parentesco'] ?? '', $_POST['resp_email'] ?? '', $_POST['resp_telefone'] ?? '',
            $_POST['pais'] ?? 'BRASIL', $_POST['cep'] ?? '', $_POST['estado'] ?? '', $_POST['cidade'] ?? '',
            $_POST['bairro'] ?? '', $_POST['logradouro'] ?? '', $_POST['numero'] ?? '', $_POST['complemento'] ?? '',
            $_POST['email'] ?? '', $_POST['telefone'] ?? '', $_POST['telefone2'] ?? '',
            $_POST['cor_olhos'] ?? '', $_POST['cor_cabelos'] ?? '', $_POST['cor_pele'] ?? '',
            isset($_POST['cicatriz']) && $_POST['cicatriz'] == '1' ? 1 : 0,
            isset($_POST['tatuagem']) && $_POST['tatuagem'] == '1' ? 1 : 0,
            $_POST['altura'] ?? null, $_POST['confeccao'] ?? '', $_POST['calcado'] ?? '',
            $_POST['peso'] ?? null, $_POST['torax_busto'] ?? null, $_POST['quadril'] ?? null,
            $_POST['cintura'] ?? null, $_POST['obs_caracteristicas'] ?? '',
            isset($_POST['trabalhou_antes']) && $_POST['trabalhou_antes'] == '1' ? 1 : 0,
        ]);
        header('Location: /talentos.php?sucesso=1'); exit;
    }
}
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <a href="/talentos.php">Talentos</a> / Novo cadastro</div>
<h5 class="text-muted">Gerenciar talentos</h5><h2>Novo cadastro</h2>
<?php if ($erro): ?><div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<div class="alert-info-form">
  <i class="bi bi-info-circle-fill text-warning fs-5"></i><br>
  Preencha atentamente o formulário abaixo.<br>
  Campos em <strong class="text-danger">VERMELHO</strong> são de preenchimento obrigatório.
</div>
<form method="POST" enctype="multipart/form-data">
<div class="form-section">
  <h5>Dados pessoais</h5>
  <div class="row g-3">
    <div class="col-md-2"><label class="form-label text-danger fw-bold">Empresa:</label><select name="empresa" class="form-select" required><option value="">Selecione</option><option value="RS">RS</option><option value="SC">SC</option></select></div>
    <div class="col-md-5"><label class="form-label text-danger fw-bold">Nome:</label><input type="text" name="nome" class="form-control" placeholder="Nome completo" required></div>
    <div class="col-md-5"><label class="form-label">Nome artístico:</label><input type="text" name="nome_artistico" class="form-control"></div>
    <div class="col-md-2"><label class="form-label text-danger fw-bold">Sexo:</label><select name="sexo" class="form-select" required><option value="">Selecione</option><option value="MASCULINO">MASCULINO</option><option value="FEMININO">FEMININO</option></select></div>
    <div class="col-md-3"><label class="form-label text-danger fw-bold">Data de nascimento:</label><input type="date" name="data_nascimento" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">RG:</label><input type="text" name="rg" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">CPF:</label><input type="text" name="cpf" class="form-control" placeholder="000.000.000-00"></div>
    <div class="col-md-9"><label class="form-label">Foto:</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
    <div class="col-md-3 text-center"><div class="foto-placeholder mx-auto" id="fotoPreview" style="width:100px;height:120px;font-size:40px;"><i class="bi bi-person"></i></div></div>
  </div>
</div>
<div class="form-section">
  <h5>Responsável</h5>
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label">Nome:</label><input type="text" name="resp_nome" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Parentesco:</label><select name="resp_parentesco" class="form-select"><option value="">Selecione</option><option>MÃE</option><option>PAI</option><option>AVÓ</option><option>AVÔ</option><option>CÔNJUGE</option><option>OUTRO</option></select></div>
    <div class="col-md-5"><label class="form-label">E-mail:</label><input type="email" name="resp_email" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Telefone:</label><input type="text" name="resp_telefone" class="form-control"></div>
  </div>
</div>
<div class="form-section">
  <h5>Dados para contato</h5>
  <div class="row g-3">
    <div class="col-12"><label class="form-label">País:</label><input type="text" name="pais" class="form-control" value="BRASIL"></div>
    <div class="col-md-2"><label class="form-label">CEP:</label><input type="text" name="cep" id="cep" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Estado:</label><input type="text" name="estado" class="form-control" value="RIO GRANDE DO SUL"></div>
    <div class="col-md-4"><label class="form-label">Cidade:</label><input type="text" name="cidade" id="cidade" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Bairro:</label><input type="text" name="bairro" id="bairro" class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Logradouro:</label><input type="text" name="logradouro" id="logradouro" class="form-control" placeholder="Rua, Avenida..."></div>
    <div class="col-md-2"><label class="form-label">Número:</label><input type="text" name="numero" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Complemento:</label><input type="text" name="complemento" class="form-control"></div>
    <div class="col-md-5"><label class="form-label">E-mail:</label><input type="email" name="email" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Telefone:</label><input type="text" name="telefone" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Telefone alternativo:</label><input type="text" name="telefone2" class="form-control"></div>
  </div>
</div>
<div class="form-section">
  <h5>Características</h5>
  <div class="row g-3">
    <div class="col-md-4"><label class="form-label">Cor dos olhos:</label><select name="cor_olhos" class="form-select"><option value="">Selecione</option><?php foreach(['CASTANHO ESCURO','CASTANHO CLARO','AZUL','VERDE','CINZA','PRETO','AVELÃ'] as $o): ?><option><?= $o ?></option><?php endforeach; ?></select></div>
    <div class="col-md-4"><label class="form-label">Cor dos cabelos:</label><select name="cor_cabelos" class="form-select"><option value="">Selecione</option><?php foreach(['CASTANHO','LOIRO','PRETO','RUIVO','GRISALHO','BRANCO'] as $c): ?><option><?= $c ?></option><?php endforeach; ?></select></div>
    <div class="col-md-4"><label class="form-label">Cor da pele:</label><select name="cor_pele" class="form-select"><option value="">Selecione</option><?php foreach(['BRANCA','PARDA','NEGRA','AMARELA','INDÍGENA'] as $p): ?><option><?= $p ?></option><?php endforeach; ?></select></div>
    <div class="col-md-6"><label class="form-label">Possui alguma cicatriz?</label><br>
      <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="cicatriz" value="1" id="cic_sim"><label class="form-check-label" for="cic_sim">SIM</label></div>
      <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="cicatriz" value="0" id="cic_nao" checked><label class="form-check-label" for="cic_nao">NÃO</label></div>
    </div>
    <div class="col-md-6"><label class="form-label">Possui alguma tatuagem?</label><br>
      <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="tatuagem" value="1" id="tat_sim"><label class="form-check-label" for="tat_sim">SIM</label></div>
      <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="tatuagem" value="0" id="tat_nao" checked><label class="form-check-label" for="tat_nao">NÃO</label></div>
    </div>
  </div>
</div>
<div class="form-section">
  <h5>Medidas</h5>
  <div class="row g-3">
    <div class="col-md-2"><label class="form-label">Altura:</label><div class="input-group"><input type="number" name="altura" class="form-control" step="0.1"><span class="input-group-text">cm</span></div></div>
    <div class="col-md-3"><label class="form-label">Confecção:</label><input type="text" name="confeccao" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Calçado:</label><input type="text" name="calcado" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">Peso:</label><div class="input-group"><input type="number" name="peso" class="form-control" step="0.1"><span class="input-group-text">Kg</span></div></div>
    <div class="col-md-2"><label class="form-label">Tórax/Busto:</label><div class="input-group"><input type="number" name="torax_busto" class="form-control" step="0.1"><span class="input-group-text">cm</span></div></div>
    <div class="col-md-2"><label class="form-label">Quadril:</label><div class="input-group"><input type="number" name="quadril" class="form-control" step="0.1"><span class="input-group-text">cm</span></div></div>
    <div class="col-md-2"><label class="form-label">Cintura:</label><div class="input-group"><input type="number" name="cintura" class="form-control" step="0.1"><span class="input-group-text">cm</span></div></div>
    <div class="col-12"><label class="form-label">Observações sobre as características do(a) talento:</label><textarea name="obs_caracteristicas" class="form-control" rows="3"></textarea></div>
  </div>
</div>
<div class="form-section">
  <h5>Trabalhos anteriores</h5>
  <label class="form-label">Já fez algum trabalho como talento?</label><br>
  <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="trabalhou_antes" value="1" id="tr_sim"><label class="form-check-label" for="tr_sim">SIM</label></div>
  <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="trabalhou_antes" value="0" id="tr_nao" checked><label class="form-check-label" for="tr_nao">NÃO</label></div>
</div>
<div class="text-center mb-3">
  <button type="submit" class="btn btn-success px-4">Cadastrar</button>
  <button type="reset" class="btn btn-warning px-4 ms-2">Limpar</button>
</div>
<div class="text-center mb-5"><a href="/talentos.php" class="btn btn-outline-secondary">Voltar</a></div>
</form>
<?php require_once 'includes/footer.php'; ?>
