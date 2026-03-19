<?php
$tituloPagina = 'Fotógrafos';
require_once 'includes/header.php';
$pdo = getDB();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = $_POST['acao'] ?? '';
    if ($a === 'novo' || $a === 'editar') {
        $fields = ["empresa","nome","email","telefone","situacao"];
        $vals = array_map(fn($f) => $_POST[$f] ?? '', $fields);
        if ($a === 'novo') {
            $cols = implode(',', $fields);
            $phs  = implode(',', array_fill(0, count($fields), '?'));
            $pdo->prepare("INSERT INTO fotografos ($cols) VALUES ($phs)")->execute($vals);
        } else {
            $set = implode('=?,', $fields) . '=?';
            $vals[] = (int)$_POST['id'];
            $pdo->prepare("UPDATE fotografos SET $set WHERE id=?")->execute($vals);
        }
    }
    if ($a === 'excluir') $pdo->prepare("DELETE FROM fotografos WHERE id=?")->execute([(int)$_POST['id']]);
    header('Location: /fotografos.php'); exit;
}
$busca = trim($_GET['busca'] ?? '');
$ppp = max(1,(int)($_GET['p'] ?? 20)); $pg = max(1,(int)($_GET['pg'] ?? 1)); $off = ($pg-1)*$ppp;
$w = $busca ? "WHERE nome LIKE ?" : '';
$bp = $busca ? ["%$busca%"] : [];
$tot = $pdo->prepare("SELECT COUNT(*) FROM fotografos $w"); $tot->execute($bp); $total = $tot->fetchColumn();
$stmt = $pdo->prepare("SELECT * FROM fotografos $w ORDER BY nome ASC LIMIT $ppp OFFSET $off"); $stmt->execute($bp);
$rows = $stmt->fetchAll();
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Fotógrafos</span></div>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Gerenciar fotógrafos</h2>
  <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalForm">Novo cadastro</button>
</div>
<div class="table-responsive"><table class="table table-bordered table-hover table-listagem">
  <thead><tr><th>EMPRESA</th><th>NOME</th><th>SITUAÇÃO</th><th>CONTATO</th><th>OPÇÕES</th></tr></thead>
  <tbody>
  <?php if(empty($rows)): ?><tr><td colspan="5" class="text-center text-muted py-4">Nenhum registro encontrado.</td></tr>
  <?php else: foreach($rows as $r): ?>
  <tr class="<?= ($r['situacao'] ?? 'ATIVO') === 'INATIVO' ? 'table-warning' : '' ?>">
    <td><?= htmlspecialchars($r['empresa'] ?? '') ?></td>
    <td><?= htmlspecialchars($r['nome']) ?></td>
    <td><span class="<?= ($r['situacao'] ?? 'ATIVO') === 'ATIVO' ? 'status-ativo' : 'status-inativo' ?>"><?= htmlspecialchars($r['situacao'] ?? 'ATIVO') ?></span></td>
    <td style="font-size:12px">E-mail: <?= htmlspecialchars($r['email'] ?? '') ?><br>Telefone: <?= htmlspecialchars($r['telefone'] ?? '') ?></td>
    <td class="text-center">
      <button class="btn btn-warning btn-sm" onclick='editarRow(<?= json_encode($r) ?>)'><i class="bi bi-pencil"></i></button>
      <form method="POST" class="d-inline" onsubmit="return confirm('Excluir?')"><input type="hidden" name="acao" value="excluir"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button type="submit" class="btn btn-danger btn-sm ms-1"><i class="bi bi-trash"></i></button></form>
    </td>
  </tr>
  <?php endforeach; endif; ?>
  </tbody>
</table></div>
<div class="pagination-info text-end">Total: <?= $total ?> registros</div>
<div class="modal fade" id="modalForm" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
  <div class="modal-header bg-danger text-white"><h5 class="modal-title" id="mTitle">Novo cadastro</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
  <form method="POST"><input type="hidden" name="acao" id="fAcao" value="novo"><input type="hidden" name="id" id="fId">
  <div class="modal-body"><div class="row g-3">
    <div class="col-md-6"><label class="form-label">Empresa</label><select name="empresa" id="fEmpresa" class="form-select"><option value="RS">RS</option><option value="SC">SC</option><option value="RS E SC">RS E SC</option></select></div>
    <div class="col-md-6"><label class="form-label">Nome</label><input type="text" name="nome" id="fNome" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">E-mail</label><input type="email" name="email" id="fEmail" class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Telefone</label><input type="text" name="telefone" id="fTelefone" class="form-control"></div>
    <div class="col-md-6"><label class="form-label">Situação</label><select name="situacao" id="fSituacao" class="form-select"><option value="ATIVO">ATIVO</option><option value="INATIVO">INATIVO</option></select></div>
    
  </div></div>
  <div class="modal-footer"><button type="submit" class="btn btn-success">Salvar</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button></div>
  </form>
</div></div></div>
<script>
function editarRow(r) {
  document.getElementById('mTitle').textContent = 'Editar cadastro';
  document.getElementById('fAcao').value = 'editar';
  document.getElementById('fId').value = r.id;
  document.getElementById('fEmpresa').value = r.empresa;
  document.getElementById('fNome').value = r.nome;
  document.getElementById('fEmail').value = r.email || '';
  document.getElementById('fTelefone').value = r.telefone || '';
  document.getElementById('fSituacao').value = r.situacao || 'ATIVO';
  new bootstrap.Modal(document.getElementById('modalForm')).show();
}
</script>
<?php require_once 'includes/footer.php'; ?>
