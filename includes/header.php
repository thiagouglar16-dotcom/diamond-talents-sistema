<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
$nomeUsuario = getNomeUsuario();
?><!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $tituloPagina ?? 'Diamond Talents' ?> — Sistema de Gerenciamento</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="/css/custom.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-diamond fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">
      <span style="color:gold;font-size:20px;">&#9670;</span>
      <span style="font-size:11px;letter-spacing:1px;margin-left:4px;line-height:1.2;display:inline-block;vertical-align:middle;">DIAMOND<br><small>TALENTS BRASIL</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Cadastros</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/talentos.php">Talentos</a></li>
            <li><a class="dropdown-item" href="/produtoras.php">Produtoras</a></li>
            <li><a class="dropdown-item" href="/agencias.php">Agências</a></li>
            <li><a class="dropdown-item" href="/scouters.php">Scouters</a></li>
            <li><a class="dropdown-item" href="/telemarketings.php">Telemarketing</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="/contatos.php">Primeiro contato</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Contratos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-danger" href="/contratos.php?tipo=diamond_mais">Diamond +</a></li>
            <li><a class="dropdown-item text-danger" href="/contratos.php?tipo=completo">Preparação, Participação em Evento e Material Fotográfico (COMPLETO)</a></li>
            <li><a class="dropdown-item text-danger" href="/contratos.php?tipo=apenas_fotos">Apenas Material Fotográfico (SEM EVENTO E WORKSHOP)</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Fotos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/agendamentos-fotos.php?empresa=RS">Agendamento de fotos (RS)</a></li>
            <li><a class="dropdown-item" href="/agendamentos-fotos.php?empresa=SC">Agendamento de fotos (SC)</a></li>
            <li><a class="dropdown-item" href="/fotografos.php">Cadastro de fotógrafos</a></li>
            <li><a class="dropdown-item" href="/grade-horaria.php?empresa=RS">Grade horária (RS)</a></li>
            <li><a class="dropdown-item" href="/grade-horaria.php?empresa=SC">Grade horária (SC)</a></li>
            <li><a class="dropdown-item" href="/locais-para-fotos.php">Locais para fotos</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="/lista-de-aprovados.php">Aprovados</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Relatórios</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/relatorio-eventos.php">Eventos</a></li>
            <li><a class="dropdown-item" href="/relatorio-workshops.php">Workshops</a></li>
            <li><a class="dropdown-item" href="/relatorio-atendimentos.php">Atendimentos</a></li>
            <li><a class="dropdown-item" href="/relatorio-administrativo.php">Administrativo</a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i></a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><span class="dropdown-item-text fw-bold"><?= htmlspecialchars($nomeUsuario) ?></span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="/logout.php"><i class="bi bi-box-arrow-right"></i> Encerrar sessão</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid px-4 mt-2">
