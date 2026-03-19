<?php
$tituloPagina = 'Locais para fotos';
require_once 'includes/header.php';
$pdo = getDB();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = $_POST['acao'] ?? '';
    if ($a === 'novo') $pdo->prepare("INSERT INTO locais_fotos (empresa,identificacao,situacao) VALUES (?,?,?)")->execute([$_POST['empresa'],$_POST['identificacao'],$_POST['situacao']??'BLOQUEADO']);
    elseif ($a === 'editar') $pdo->prepare("UPDATE locais_fotos SET empresa=?,identificacao=?,situacao=? WHERE id=?")->execute([$_POST['empresa'],$_POST['identificacao'],$_POST['situacao']??'BLOQUEADO',(int)$_POST['id']]);
    elseif ($a === 'excluir') $pdo->prepare("DELETE FROM locais_fotos WHERE id=?")->execute([(int)$_POST['id']]);
    header('Location: /locais-para-fotos.php'); exit;
}
$rows = $pdo->query("SELECT * FROM locais_fotos ORDER BY empresa,identificacao")->fetchAll();
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Locais para fotos</span></div>
<div class="d-flex justify-content-between mb-3"><h2>Gerenciar locais para fotos</h2>
  <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalLocal">Novo cadastro</button>
</div>
<div class="table-responsive"><table class="table table-bordered table-hover table-listagem">
  <thead><tr><th>EMPRESA</th><th>IDENTIFICAÇÃO</th><th>SITUAÇÃO</th><th>OPÇÕES</th></tr></thead>
  <tbody>
  <?php foreach($rows as $r): ?>
  <tr class="<?= $r['situacao']==='BLOQUEADO'?'table-warning':'' ?>">
    <td><strong><?= $r['empresa'] ?></strong></td>
    <td><?= htmlspecialchars($r['identificacao']) ?></td>
    <td><span class="<?= $r['situacao']==='LIBERADO'?'status-liberado':'status-bloqueado' ?>"><?= $r['situacao'] ?>!</span></td>
    <td class="text-center"><button class="btn btn-warning btn-sm" onclick='editLocal(<?= json_encode($r) ?>)'><i class="bi bi-pencil"></i></button>
      <form method="POST" class="d-inline" onsubmit="return confirm('Excluir?')"><input type="hidden" name="acao" value="excluir"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button type="submit" class="btn btn-danger btn-sm ms-1"><i class="bi bi-trash"></i></button></form></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table></div>
<div class="modal fade" id="modalLocal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
  <div class="modal-header bg-danger text-white"><h5 class="modal-title" id="lTitle">Novo local</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
  <form method="POST"><input type="hidden" name="acao" id="lAcao" value="novo"><input type="hidden" name="id" id="lId">
  <div class="modal-body"><div class="row g-3">
    <div class="col-md-4"><label class="form-label">Empresa</label><select name="empresa" id="lEmpresa" class="form-select"><option value="RS">RS</option><option value="SC">SC</option></select></div>
    <div class="col-12"><label class="form-label">Identificação</label><input type="text" name="identificacao" id="lIdent" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Situação</label><select name="situacao" id="lSit" class="form-select"><option value="BLOQUEADO">BLOQUEADO</option><option value="LIBERADO">LIBERADO</option></select></div>
  </div></div>
  <div class="modal-footer"><button type="submit" class="btn btn-success">Salvar</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button></div>
  </form></div></div></div>
<script>function editLocal(r){document.getElementById('lTitle').textContent='Editar local';document.getElementById('lAcao').value='editar';document.getElementById('lId').value=r.id;document.getElementById('lEmpresa').value=r.empresa;document.getElementById('lIdent').value=r.identificacao;document.getElementById('lSit').value=r.situacao;new bootstrap.Modal(document.getElementById('modalLocal')).show();}</script>
<?php require_once 'includes/footer.php'; ?>
