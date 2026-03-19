<?php
$tituloPagina = 'Início';
require_once 'includes/header.php';
?>
<div class="breadcrumb-bar"><a href="/index.php"><i class="bi bi-house-fill"></i></a></div>
<div class="text-center my-4">
  <h2>Bem-vindo(a), <strong><?= htmlspecialchars($nomeUsuario) ?></strong>!</h2>
  <p class="text-muted">Escolha abaixo o que deseja fazer, clicando sobre o botão correspondente ou, ainda, no menu superior.</p>
</div>
<div class="row g-3">
  <div class="col-md-6">
    <div class="dashboard-section">
      <h4>Cadastros</h4>
      <a href="/talentos.php" class="btn btn-danger btn-sm m-1">Talentos</a>
      <a href="/produtoras.php" class="btn btn-danger btn-sm m-1">Produtoras</a>
      <a href="/scouters.php" class="btn btn-danger btn-sm m-1">Scouters</a>
      <a href="/telemarketings.php" class="btn btn-danger btn-sm m-1">Telemarketing</a>
      <a href="/agencias.php" class="btn btn-danger btn-sm m-1">Agências</a>
    </div>
  </div>
  <div class="col-md-6">
    <div class="dashboard-section">
      <h4>Atendimento</h4>
      <div class="d-flex gap-2 flex-wrap">
        <a href="/contatos.php" class="btn btn-warning btn-sm">Primeiro contato</a>
        <a href="/contratos.php?tipo=completo" class="btn btn-outline-secondary btn-sm text-danger">Contratos — Preparação, Participação em Evento e Material Fotográfico (COMPLETO)</a>
        <a href="/contratos.php?tipo=diamond_mais" class="btn btn-outline-secondary btn-sm text-danger">Contratos Diamond +</a>
        <a href="/contratos.php?tipo=apenas_fotos" class="btn btn-outline-secondary btn-sm text-danger">Contratos — Apenas Material Fotográfico</a>
        <a href="/lista-de-aprovados.php" class="btn btn-warning btn-sm">Aprovados</a>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="dashboard-section">
      <h4>Fotos</h4>
      <a href="/fotografos.php" class="btn btn-secondary btn-sm m-1">Fotógrafos</a>
      <a href="/grade-horaria.php?empresa=RS" class="btn btn-secondary btn-sm m-1">Grade horária (RS)</a>
      <a href="/grade-horaria.php?empresa=SC" class="btn btn-secondary btn-sm m-1">Grade horária (SC)</a>
      <a href="/locais-para-fotos.php" class="btn btn-secondary btn-sm m-1">Locais para fotos</a>
      <a href="/agendamentos-fotos.php?empresa=RS" class="btn btn-secondary btn-sm m-1">Agendamento de fotos (RS)</a>
      <a href="/agendamentos-fotos.php?empresa=SC" class="btn btn-secondary btn-sm m-1">Agendamento de fotos (SC)</a>
    </div>
  </div>
  <div class="col-md-6">
    <div class="dashboard-section">
      <h4>Relatórios</h4>
      <a href="/relatorio-eventos.php" class="btn btn-success btn-sm m-1">Eventos</a>
      <a href="/relatorio-workshops.php" class="btn btn-success btn-sm m-1">Workshops</a>
      <a href="/relatorio-atendimentos.php" class="btn btn-success btn-sm m-1">Atendimentos</a>
      <a href="/relatorio-administrativo.php" class="btn btn-success btn-sm m-1">Administrativo</a>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>
