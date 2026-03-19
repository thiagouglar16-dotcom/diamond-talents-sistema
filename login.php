<?php
require_once 'includes/auth.php';
if (isLoggedIn()) { header('Location: index.php'); exit; }
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (login(trim($_POST['usuario'] ?? ''), $_POST['senha'] ?? '')) {
        header('Location: index.php'); exit;
    }
    $erro = 'Usuário ou senha inválidos.';
}
?><!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — Diamond Talents Brasil</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
body{background:#1a1a1a;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0}
.box{background:#fff;border-radius:8px;padding:40px;width:100%;max-width:400px;box-shadow:0 4px 20px rgba(0,0,0,.5)}
.logo{text-align:center;margin-bottom:25px}
.logo-icon{width:80px;height:80px;background:#222;border-radius:50%;margin:0 auto;display:flex;align-items:center;justify-content:center;font-size:32px;color:gold}
</style>
</head>
<body>
<div class="box">
  <div class="logo">
    <div class="logo-icon">&#9670;</div>
    <h5 class="mt-2 mb-0">Diamond Talents Brasil</h5>
    <small class="text-muted">Sistema de Gerenciamento</small>
  </div>
  <?php if($erro): ?><div class="alert alert-danger py-2 text-center small"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label fw-bold">Usuário</label>
      <input type="text" name="usuario" class="form-control" required autofocus>
    </div>
    <div class="mb-4">
      <label class="form-label fw-bold">Senha</label>
      <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-danger w-100 fw-bold">ENTRAR</button>
  </form>
  <p class="text-center text-muted mt-3" style="font-size:11px">© <?= date('Y') ?> Diamond Talents Brasil</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
