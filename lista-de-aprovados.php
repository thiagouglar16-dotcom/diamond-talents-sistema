<?php
$tituloPagina = 'Lista de Aprovados';
require_once 'includes/header.php';
$pdo = getDB();
$eventos = $pdo->query("SELECT * FROM eventos ORDER BY data_evento DESC")->fetchAll();
$eventoSel = (int)($_GET['evento_id'] ?? 0);
$aprovados = [];
if ($eventoSel) {
    $aprovados = $pdo->prepare("SELECT c.*, t.nome AS talento_nome, t.data_nascimento, t.sexo, t.email AS t_email, t.telefone AS t_tel FROM contratos c JOIN talentos t ON t.id=c.talento_id WHERE c.evento_id=? AND c.situacao='ATIVO' ORDER BY t.nome")->execute([$eventoSel]) ? $pdo->prepare("SELECT c.*, t.nome AS talento_nome, t.data_nascimento, t.sexo, t.email AS t_email, t.telefone AS t_tel FROM contratos c JOIN talentos t ON t.id=c.talento_id WHERE c.evento_id=? AND c.situacao='ATIVO' ORDER BY t.nome") : null;
    if ($aprovados) { $aprovados->execute([$eventoSel]); $aprovados = $aprovados->fetchAll(); }
}
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Lista de Aprovados</span></div>
<h2>Lista de Aprovados</h2>
<h4>Selecione o evento</h4>
<div class="table-responsive"><table class="table table-bordered table-hover table-listagem">
  <thead><tr><th>EMPRESA</th><th>EVENTO</th><th>LOCAL</th><th>DATA</th><th>HORA</th><th>OPÇÕES</th></tr></thead>
  <tbody>
  <?php foreach($eventos as $e): ?>
  <tr>
    <td><strong><?= $e['empresa'] ?></strong></td>
    <td><?= htmlspecialchars($e['nome']) ?></td>
    <td><?= htmlspecialchars($e['local_evento']??'') ?></td>
    <td><?= $e['data_evento'] ? date('d/m/Y',strtotime($e['data_evento'])) : '-' ?></td>
    <td><?= $e['hora_inicio'] ?> às <?= $e['hora_fim'] ?></td>
    <td><a href="?evento_id=<?= $e['id'] ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-people"></i> Aprovados</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table></div>
<?php if ($eventoSel && is_array($aprovados)): ?>
<h4 class="mt-4">Aprovados para o evento selecionado (<?= count($aprovados) ?>)</h4>
<div class="table-responsive"><table class="table table-bordered table-sm">
  <thead><tr><th>#</th><th>TALENTO</th><th>SEXO</th><th>IDADE</th><th>CONTATO</th></tr></thead>
  <tbody>
  <?php foreach($aprovados as $i => $a):
    $idade = $a['data_nascimento'] ? date_diff(date_create($a['data_nascimento']),date_create('today'))->y : '-';
  ?>
  <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($a['talento_nome']) ?></td><td><?= $a['sexo'] ?></td><td><?= $idade ?></td>
  <td><?= htmlspecialchars($a['t_email']??'') ?> <?= htmlspecialchars($a['t_tel']??'') ?></td></tr>
  <?php endforeach; ?>
  </tbody>
</table></div>
<?php endif; ?>
<div class="text-center mt-3"><a href="/lista-de-aprovados.php" class="btn btn-outline-secondary btn-sm">Voltar</a></div>
<?php require_once 'includes/footer.php'; ?>