<?php
$tituloPagina = 'Grade Horária';
require_once 'includes/header.php';
$pdo = getDB();
$empresa = $_GET['empresa'] ?? 'RS';
$mes = $_GET['mes'] ?? date('Y-m');
$fotografos = $pdo->query("SELECT * FROM fotografos WHERE situacao='ATIVO' ORDER BY nome")->fetchAll();
$stmt = $pdo->prepare("SELECT gh.*,f.nome AS fn FROM grade_horaria gh LEFT JOIN fotografos f ON f.id=gh.fotografo_id WHERE gh.empresa=? AND DATE_FORMAT(gh.data_grade,'%Y-%m')=? ORDER BY gh.data_grade,gh.horario_inicio");
$stmt->execute([$empresa, $mes]);
$grades = $stmt->fetchAll();
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Grade horária (<?= $empresa ?>)</span></div>
<div class="d-flex justify-content-between mb-3">
  <h2>Grade horária de fotógrafos (<?= $empresa ?>)</h2>
  <div>
    <a href="?empresa=<?= $empresa === 'RS' ? 'SC' : 'RS' ?>&mes=<?= $mes ?>" class="btn btn-outline-secondary btn-sm me-2">Ver <?= $empresa === 'RS' ? 'SC' : 'RS' ?></a>
    <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#mGrade">+ Adicionar</button>
  </div>
</div>
<form method="GET" class="row g-2 mb-3">
  <input type="hidden" name="empresa" value="<?= $empresa ?>">
  <div class="col-md-3"><label class="form-label">Mês</label><input type="month" name="mes" class="form-control form-control-sm" value="<?= $mes ?>"></div>
  <div class="col-md-2 d-flex align-items-end"><button type="submit" class="btn btn-primary btn-sm">Filtrar</button></div>
</form>
<div class="table-responsive">
<table class="table table-bordered table-hover table-listagem">
  <thead><tr><th>DATA</th><th>FOTÓGRAFO</th><th>INÍCIO</th><th>FIM</th><th>DISPONÍVEL</th><th>OPÇÕES</th></tr></thead>
  <tbody>
  <?php if (empty($grades)): ?><tr><td colspan="6" class="text-center text-muted py-4">Nenhum horário cadastrado.</td></tr>
  <?php else: foreach ($grades as $g): ?>
  <tr>
    <td><?= $g['data_grade'] ? date('d/m/Y',strtotime($g['data_grade'])) : '-' ?></td>
    <td><?= htmlspecialchars($g['fn'] ?? '') ?></td>
    <td><?= $g['horario_inicio'] ?></td>
    <td><?= $g['horario_fim'] ?></td>
    <td><span class="<?= $g['disponivel'] ? 'status-ativo' : 'status-inativo' ?>"><?= $g['disponivel'] ? 'SIM' : 'NÃO' ?></span></td>
    <td class="text-center">
      <form method="POST" action="/excluir.php" onsubmit="return confirm('Excluir?')">
        <input type="hidden" name="tabela" value="grade_horaria">
        <input type="hidden" name="id" value="<?= $g['id'] ?>">
        <input type="hidden" name="redirect" value="/grade-horaria.php?empresa=<?= $empresa ?>&mes=<?= $mes ?>">
        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
      </form>
    </td>
  </tr>
  <?php endforeach; endif; ?>
  </tbody>
</table>
</div>
<div class="modal fade" id="mGrade" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
  <div class="modal-header bg-danger text-white"><h5 class="modal-title">Adicionar horário</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
  <form method="POST" action="/salvar-grade.php">
    <input type="hidden" name="empresa" value="<?= $empresa ?>">
    <input type="hidden" name="redirect" value="/grade-horaria.php?empresa=<?= $empresa ?>&mes=<?= $mes ?>">
    <div class="modal-body"><div class="row g-3">
      <div class="col-md-6"><label class="form-label">Fotógrafo</label><select name="fotografo_id" class="form-select" required><option value="">Selecione</option><?php foreach($fotografos as $f): ?><option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-6"><label class="form-label">Data</label><input type="date" name="data_grade" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">Horário início</label><input type="time" name="horario_inicio" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">Horário fim</label><input type="time" name="horario_fim" class="form-control"></div>
    </div></div>
    <div class="modal-footer"><button type="submit" class="btn btn-success">Salvar</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button></div>
  </form>
</div></div></div>
<?php require_once 'includes/footer.php'; ?>
