<?php
$tituloPagina = 'Agendamento de Fotos';
require_once 'includes/header.php';
$pdo = getDB();
$empresa = $_GET['empresa'] ?? 'RS';
$stmt = $pdo->prepare("SELECT af.*,t.nome AS tn,f.nome AS fn,l.identificacao AS ln FROM agendamentos_fotos af LEFT JOIN talentos t ON t.id=af.talento_id LEFT JOIN fotografos f ON f.id=af.fotografo_id LEFT JOIN locais_fotos l ON l.id=af.local_id WHERE af.empresa=? ORDER BY af.data_agendamento DESC,af.horario");
$stmt->execute([$empresa]);
$rows = $stmt->fetchAll();
$fotografos = $pdo->query("SELECT * FROM fotografos WHERE situacao='ATIVO' ORDER BY nome")->fetchAll();
$locais = $pdo->query("SELECT * FROM locais_fotos WHERE situacao='LIBERADO' ORDER BY identificacao")->fetchAll();
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Agendamento de fotos (<?= $empresa ?>)</span></div>
<div class="d-flex justify-content-between mb-3">
  <h2>Agendamento de fotos (<?= $empresa ?>)</h2>
  <a href="?empresa=<?= $empresa === 'RS' ? 'SC' : 'RS' ?>" class="btn btn-outline-secondary btn-sm">
    Ver <?= $empresa === 'RS' ? 'SC' : 'RS' ?>
  </a>
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-listagem">
  <thead><tr><th>DATA</th><th>HORÁRIO</th><th>TALENTO</th><th>FOTÓGRAFO</th><th>LOCAL</th><th>SITUAÇÃO</th><th>OPÇÕES</th></tr></thead>
  <tbody>
  <?php if (empty($rows)): ?><tr><td colspan="7" class="text-center text-muted py-4">Nenhum agendamento encontrado.</td></tr>
  <?php else: foreach ($rows as $r): ?>
  <tr>
    <td><?= $r['data_agendamento'] ? date('d/m/Y',strtotime($r['data_agendamento'])) : '-' ?></td>
    <td><?= $r['horario'] ?></td>
    <td><?= htmlspecialchars($r['tn'] ?? '') ?></td>
    <td><?= htmlspecialchars($r['fn'] ?? '') ?></td>
    <td><?= htmlspecialchars($r['ln'] ?? '') ?></td>
    <td><span class="<?= $r['situacao']==='AGENDADO'?'text-primary':($r['situacao']==='REALIZADO'?'status-ativo':'status-inativo') ?>"><?= $r['situacao'] ?></span></td>
    <td class="text-center">
      <form method="POST" action="/excluir.php" onsubmit="return confirm('Excluir agendamento?')">
        <input type="hidden" name="tabela" value="agendamentos_fotos">
        <input type="hidden" name="id" value="<?= $r['id'] ?>">
        <input type="hidden" name="redirect" value="/agendamentos-fotos.php?empresa=<?= $empresa ?>">
        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
      </form>
    </td>
  </tr>
  <?php endforeach; endif; ?>
  </tbody>
</table>
</div>
<p class="text-muted text-end" style="font-size:12px">Total: <?= count($rows) ?> agendamentos</p>
<?php require_once 'includes/footer.php'; ?>
