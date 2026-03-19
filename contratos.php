<?php
$tituloPagina = 'Contratos';
require_once 'includes/header.php';
$pdo = getDB();
$tipo   = $_GET['tipo'] ?? 'completo';
$labels = ['completo'=>'Preparação, Participação em Evento e Material Fotográfico (COMPLETO)','diamond_mais'=>'DIAMOND +','apenas_fotos'=>'Apenas Material Fotográfico (SEM EVENTO E WORKSHOP)'];
$enums  = ['completo'=>'COMPLETO','diamond_mais'=>'DIAMOND_MAIS','apenas_fotos'=>'APENAS_FOTOS'];
$stmt = $pdo->prepare("SELECT c.*,t.nome AS tn,t.sexo,t.data_nascimento,p.nome AS pn,e.nome AS en,e.local_evento,e.data_evento FROM contratos c JOIN talentos t ON t.id=c.talento_id LEFT JOIN produtoras p ON p.id=c.produtora_id LEFT JOIN eventos e ON e.id=c.evento_id WHERE c.tipo=? ORDER BY c.data_contrato DESC LIMIT 100");
$stmt->execute([$enums[$tipo] ?? 'COMPLETO']);
$contratos = $stmt->fetchAll();
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Contratos — <?= htmlspecialchars($labels[$tipo] ?? '') ?></span></div>
<div class="d-flex justify-content-between align-items-start mb-3">
  <div><small class="text-muted">Gerenciar contratos do tipo</small><h2><?= htmlspecialchars($labels[$tipo] ?? '') ?></h2></div>
  <a href="/cadastrar-contrato.php?tipo=<?= $tipo ?>" class="btn btn-info btn-sm text-white">Novo cadastro</a>
</div>
<?php if (empty($contratos)): ?>
<div class="alert text-center" style="background:#fffaed;border:1px solid #e8d97e;">
  <strong>NENHUM REGISTRO</strong><br><span class="text-muted">Nenhum registro foi encontrado no banco de dados</span>
</div>
<?php else: foreach ($contratos as $c):
  $dn = $c['data_nascimento'] ? date_diff(date_create($c['data_nascimento']),date_create('today'))->y : 0;
  $cl = $dn < 12 ? 'INFANTIL' : ($dn < 18 ? 'ADOLESCENTE' : 'ADULTO');
?>
<div class="contrato-card mb-3">
  <div class="row g-0">
    <div class="col-md-2 p-3 border-end" style="font-size:12px;background:#fafafa;">
      <strong>Número:</strong><br><?= htmlspecialchars($c['numero']) ?><br>
      <strong>Filial:</strong> <?= $c['empresa'] ?><br>
      <strong>Data:</strong> <?= $c['data_contrato'] ? date('d/m/Y',strtotime($c['data_contrato'])) : '-' ?><br>
      <strong>Local:</strong> <?= htmlspecialchars($c['local_contrato'] ?? '') ?><br>
      Credencial: <?= htmlspecialchars($c['credencial'] ?? '') ?>
    </div>
    <div class="col-md-2 p-3 border-end" style="font-size:12px;">
      <strong style="color:#337ab7;"><?= htmlspecialchars($c['tn']) ?></strong><br>
      Sexo: <strong><?= $c['sexo'] ?></strong><br>
      <?php if ($c['data_nascimento']): ?>
        DN: <?= date('d/m/Y',strtotime($c['data_nascimento'])) ?><br>
        Idade: <strong><?= $dn ?> Anos</strong><br>
        Classificação: <strong><?= $cl ?></strong>
      <?php endif; ?>
    </div>
    <div class="col-md-2 p-3 border-end text-center" style="font-size:12px;">
      <strong><?= htmlspecialchars($c['pn'] ?? '-') ?></strong>
    </div>
    <div class="col-md-2 p-3 border-end" style="font-size:12px;">
      <?php if ($c['en']): ?>
        <strong><?= htmlspecialchars($c['en']) ?></strong><br>
        Local: <?= htmlspecialchars($c['local_evento'] ?? '') ?><br>
        Data: <?= $c['data_evento'] ? date('d/m/Y',strtotime($c['data_evento'])) : '-' ?>
      <?php else: echo '<span class="text-muted">--</span>'; endif; ?>
    </div>
    <div class="col-md-2 p-3 border-end" style="font-size:12px;">
      A) PLATAFORMA: R$ <?= number_format($c['val_plataforma'],2,',','.') ?><br>
      B) PREPARAÇÃO: R$ <?= number_format($c['val_preparacao'],2,',','.') ?><br>
      C) APRESENTAÇÃO: R$ <?= number_format($c['val_apresentacao'],2,',','.') ?><br>
      <strong class="text-primary">TOTAL: R$ <?= number_format($c['total_contrato'],2,',','.') ?></strong><br>
      D) FOTOS: R$ <?= number_format($c['val_fotos'],2,',','.') ?>
    </div>
    <div class="col-md-2 p-3 text-center" style="font-size:12px;">
      <a href="/editar-contrato.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm mb-1 w-100"><i class="bi bi-pencil"></i> Editar</a>
      <form method="POST" action="/excluir.php" onsubmit="return confirm('Cancelar este contrato?')">
        <input type="hidden" name="tabela" value="contratos">
        <input type="hidden" name="id" value="<?= $c['id'] ?>">
        <input type="hidden" name="redirect" value="/contratos.php?tipo=<?= $tipo ?>">
        <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-1">Cancelamento de contrato</button>
      </form>
    </div>
  </div>
</div>
<?php endforeach; endif; ?>
<?php require_once 'includes/footer.php'; ?>
