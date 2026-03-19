<?php
$tituloPagina = 'Talentos';
require_once 'includes/header.php';
$pdo = getDB();
$busca = trim($_GET['busca'] ?? '');
$empresa = $_GET['empresa'] ?? '';
$por_pagina = max(1,(int)($_GET['por_pagina'] ?? 20));
$pagina = max(1,(int)($_GET['pagina'] ?? 1));
$offset = ($pagina-1)*$por_pagina;
$where = ['1=1']; $params = [];
if ($busca) { $where[] = '(nome LIKE ? OR nome_artistico LIKE ? OR cpf LIKE ? OR email LIKE ?)'; $params = array_merge($params, ["%$busca%","%$busca%","%$busca%","%$busca%"]); }
if ($empresa) { $where[] = 'empresa = ?'; $params[] = $empresa; }
$ws = implode(' AND ', $where);
$tot = $pdo->prepare("SELECT COUNT(*) FROM talentos WHERE $ws"); $tot->execute($params); $total = $tot->fetchColumn();
$stmt = $pdo->prepare("SELECT * FROM talentos WHERE $ws ORDER BY nome ASC LIMIT $por_pagina OFFSET $offset"); $stmt->execute($params);
$talentos = $stmt->fetchAll();
$totalPag = ceil($total/$por_pagina);
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a> / <span>Talentos</span>
  <span class="float-end"><form method="GET" class="d-inline-flex gap-1"><input type="text" name="busca" class="form-control form-control-sm" placeholder="Pesquise aqui..." value="<?= htmlspecialchars($busca) ?>"><button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-search"></i></button></form></span>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Gerenciar talentos</h2>
  <div>
    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#filtros">Filtrar</button>
    <a href="/cadastrar-talento.php" class="btn btn-info btn-sm text-white ms-2">Novo cadastro</a>
  </div>
</div>
<div class="collapse mb-3" id="filtros"><div class="card card-body"><form method="GET" class="row g-2">
  <div class="col-md-3"><label class="form-label">Empresa</label><select name="empresa" class="form-select form-select-sm"><option value="">Todas</option><option value="RS" <?= $empresa=='RS'?'selected':'' ?>>RS</option><option value="SC" <?= $empresa=='SC'?'selected':'' ?>>SC</option></select></div>
  <div class="col-md-4"><label class="form-label">Buscar</label><input type="text" name="busca" class="form-control form-control-sm" value="<?= htmlspecialchars($busca) ?>"></div>
  <div class="col-md-2 d-flex align-items-end gap-1"><button type="submit" class="btn btn-primary btn-sm">Filtrar</button><a href="/talentos.php" class="btn btn-secondary btn-sm">Limpar</a></div>
</form></div></div>
<div class="table-responsive"><table class="table table-bordered table-hover table-listagem align-middle">
  <thead><tr><th>EMPRESA</th><th>FOTO</th><th>DADOS PESSOAIS</th><th>CARACTERÍSTICAS</th><th>MEDIDAS</th><th>CONTATO</th><th>OPÇÕES</th></tr></thead>
  <tbody>
  <?php if(empty($talentos)): ?><tr><td colspan="7" class="text-center text-muted py-4">Nenhum talento encontrado.</td></tr>
  <?php else: foreach($talentos as $t):
    $idade = $t['data_nascimento'] ? date_diff(date_create($t['data_nascimento']),date_create('today'))->y : null;
    $classif = $idade !== null ? ($idade < 12 ? 'INFANTIL' : ($idade < 18 ? 'ADOLESCENTE' : 'ADULTO')) : '';
  ?>
  <tr>
    <td><strong><?= $t['empresa'] ?></strong></td>
    <td><div class="foto-placeholder" style="width:70px;height:80px;font-size:28px;"><i class="bi bi-person"></i></div><div class="text-center" style="font-size:11px;color:#999">Foto</div></td>
    <td style="font-size:12px"><strong><?= htmlspecialchars($t['nome']) ?></strong><br>
      Sexo: <strong style="color:#337ab7"><?= $t['sexo'] ?></strong><br>
      <?php if($t['nome_artistico']): ?>Nome artístico: <?= htmlspecialchars($t['nome_artistico']) ?><br><?php endif; ?>
      <?php if($t['data_nascimento']): ?>DN: <?= date('d/m/Y',strtotime($t['data_nascimento'])) ?><br>Idade: <strong style="color:#337ab7"><?= $idade ?> Anos</strong><br>Classificação: <strong style="color:#337ab7"><?= $classif ?></strong><br><?php endif; ?>
      <?php if($t['cpf']): ?>CPF: <?= htmlspecialchars($t['cpf']) ?><?php endif; ?>
    </td>
    <td style="font-size:12px">
      <?php if($t['cor_olhos']): ?>Olhos: <strong><?= htmlspecialchars($t['cor_olhos']) ?></strong><br><?php endif; ?>
      <?php if($t['cor_cabelos']): ?>Cabelos: <?= htmlspecialchars($t['cor_cabelos']) ?><br><?php endif; ?>
      <?php if($t['cor_pele']): ?>Pele: <?= htmlspecialchars($t['cor_pele']) ?><?php endif; ?>
    </td>
    <td style="font-size:12px">Confecção: <?= $t['confeccao']?:0 ?><br>Calçado: <?= $t['calcado']?:0 ?></td>
    <td style="font-size:12px">
      <?php if($t['email']): ?>E-mail: <?= htmlspecialchars($t['email']) ?><br><?php endif; ?>
      <?php if($t['telefone']): ?>Telefone: <?= htmlspecialchars($t['telefone']) ?><br><?php endif; ?>
      <?php if($t['cidade']): ?>Endereço:<br><?= htmlspecialchars($t['logradouro']??'') ?><?= $t['numero']?', '.$t['numero']:'' ?><br><?= htmlspecialchars($t['cidade']) ?>, <?= htmlspecialchars($t['estado']??'') ?><?php endif; ?>
    </td>
    <td class="text-center"><a href="/editar-talento.php?id=<?= $t['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
    <form method="POST" action="/excluir.php" class="d-inline" onsubmit="return confirm('Excluir este talento?')"><input type="hidden" name="tabela" value="talentos"><input type="hidden" name="id" value="<?= $t['id'] ?>"><input type="hidden" name="redirect" value="/talentos.php"><button type="submit" class="btn btn-danger btn-sm ms-1"><i class="bi bi-trash"></i></button></form></td>
  </tr>
  <?php endforeach; endif; ?>
  </tbody>
</table></div>
<div class="d-flex justify-content-between mt-2">
  <form method="GET" class="d-flex align-items-center gap-2"><input type="hidden" name="busca" value="<?= htmlspecialchars($busca) ?>"><input type="hidden" name="empresa" value="<?= $empresa ?>">
    <span>Mostrar</span><select name="por_pagina" class="form-select form-select-sm" style="width:80px" onchange="this.form.submit()"><?php foreach([10,20,50,100] as $n): ?><option value="<?= $n ?>" <?= $por_pagina==$n?'selected':'' ?>><?= $n ?></option><?php endforeach; ?></select><span>registros por página</span>
  </form>
  <div class="pagination-info">Mostrando <?= $offset+1 ?> a <?= min($offset+$por_pagina,$total) ?> de <?= $total ?></div>
</div>
<?php if($totalPag>1): ?><nav class="mt-2"><ul class="pagination pagination-sm justify-content-center">
  <li class="page-item <?= $pagina<=1?'disabled':'' ?>"><a class="page-link" href="?pagina=1&busca=<?= urlencode($busca) ?>&empresa=<?= $empresa ?>&por_pagina=<?= $por_pagina ?>">«</a></li>
  <li class="page-item <?= $pagina<=1?'disabled':'' ?>"><a class="page-link" href="?pagina=<?= $pagina-1 ?>&busca=<?= urlencode($busca) ?>&empresa=<?= $empresa ?>&por_pagina=<?= $por_pagina ?>">‹</a></li>
  <?php for($i=max(1,$pagina-2);$i<=min($totalPag,$pagina+2);$i++): ?><li class="page-item <?= $i==$pagina?'active':'' ?>"><a class="page-link" href="?pagina=<?= $i ?>&busca=<?= urlencode($busca) ?>&empresa=<?= $empresa ?>&por_pagina=<?= $por_pagina ?>"><?= $i ?></a></li><?php endfor; ?>
  <li class="page-item <?= $pagina>=$totalPag?'disabled':'' ?>"><a class="page-link" href="?pagina=<?= $pagina+1 ?>&busca=<?= urlencode($busca) ?>&empresa=<?= $empresa ?>&por_pagina=<?= $por_pagina ?>">›</a></li>
  <li class="page-item <?= $pagina>=$totalPag?'disabled':'' ?>"><a class="page-link" href="?pagina=<?= $totalPag ?>&busca=<?= urlencode($busca) ?>&empresa=<?= $empresa ?>&por_pagina=<?= $por_pagina ?>">»</a></li>
</ul></nav><?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
