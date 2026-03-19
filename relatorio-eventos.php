<?php
$tituloPagina = 'Relatórios de Eventos';
require_once 'includes/header.php';
$pdo = getDB();
$tipo = $_GET['tipo'] ?? '';
$evento_id = (int)($_GET['evento_id'] ?? 0);
$resultado = [];
$eventos = $pdo->query("SELECT * FROM eventos ORDER BY data_evento DESC")->fetchAll();
if ($tipo && $evento_id && isset($_GET['gerar'])) {
    $stmt = $pdo->prepare("SELECT c.*, t.nome AS talento_nome, t.sexo, t.data_nascimento, t.email AS t_email, t.telefone AS t_tel, t.cpf FROM contratos c JOIN talentos t ON t.id=c.talento_id WHERE c.evento_id=? AND c.situacao='ATIVO' ORDER BY t.nome");
    $stmt->execute([$evento_id]); $resultado = $stmt->fetchAll();
}
$tipos = ['aprovados'=>'Aprovados','composit'=>'Composit','chamada'=>'Chamada do evento','camisetas'=>'Relação de entrega das camisetas','certificados'=>'Relação de nomes para certificados','lista_eventos'=>'Lista de eventos por período'];
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Relatórios de eventos</span></div>
<h2>Relatórios de eventos</h2>
<div class="relatorio-config-box mb-3">
  <strong><i class="bi bi-gear"></i> Configure seu relatório</strong>
  <form method="GET" class="mt-3">
    <div class="row g-3">
      <?php foreach($tipos as $k=>$v): ?><div class="col-12"><div class="form-check"><input class="form-check-input" type="radio" name="tipo" value="<?= $k ?>" id="t<?= $k ?>" <?= $tipo===$k?'checked':'' ?>><label class="form-check-label" for="t<?= $k ?>"><?= $v ?></label></div></div><?php endforeach; ?>
      <div class="col-md-6"><label class="form-label">Evento</label><select name="evento_id" class="form-select form-select-sm"><option value="">-- Selecione --</option><?php foreach($eventos as $e): ?><option value="<?= $e['id'] ?>" <?= $evento_id===$e['id']?'selected':'' ?>><?= htmlspecialchars($e['nome'].' - '.($e['data_evento']?date('d/m/Y',strtotime($e['data_evento'])):'')) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-2 d-flex align-items-end"><button type="submit" name="gerar" value="1" class="btn btn-primary btn-sm w-100">Gerar</button></div>
    </div>
  </form>
</div>
<div class="relatorio-resultado-box">
  <strong><i class="bi bi-bar-chart"></i> Conteúdo do relatório</strong>
  <?php if(!empty($resultado)): ?>
  <div class="table-responsive mt-3"><table class="table table-sm table-bordered">
    <thead><tr><th>#</th><th>Talento</th><th>Sexo</th><th>Idade</th><th>CPF</th><th>E-mail</th><th>Telefone</th></tr></thead>
    <tbody><?php foreach($resultado as $i=>$r): $idade=$r['data_nascimento']?date_diff(date_create($r['data_nascimento']),date_create('today'))->y:'-'; ?>
    <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($r['talento_nome']) ?></td><td><?= $r['sexo'] ?></td><td><?= $idade ?></td><td><?= htmlspecialchars($r['cpf']??'') ?></td><td><?= htmlspecialchars($r['t_email']??'') ?></td><td><?= htmlspecialchars($r['t_tel']??'') ?></td></tr>
    <?php endforeach; ?></tbody>
  </table></div><p class="text-muted">Total: <?= count($resultado) ?> talentos</p>
  <?php elseif(isset($_GET['gerar'])): ?><p class="text-muted mt-3">Nenhum resultado.</p><?php endif; ?>
</div>
<div class="text-center mt-3"><a href="/index.php" class="btn btn-outline-secondary btn-sm">Voltar</a></div>
<?php require_once 'includes/footer.php'; ?>