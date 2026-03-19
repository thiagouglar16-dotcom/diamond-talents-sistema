<?php
require_once __DIR__ . '/../config/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function isLoggedIn() { return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']); }

function requireLogin() {
    if (!isLoggedIn()) { header('Location: /login.php'); exit; }
}

function getNomeUsuario() { return $_SESSION['usuario_nome'] ?? 'Usuário'; }
function getUsuario() { return $_SESSION['usuario'] ?? null; }
function getToken() { return $_SESSION['token'] ?? ''; }

function login($usuario, $senha) {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND ativo = 1");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id']      = $user['id'];
        $_SESSION['usuario']         = $user['usuario'];
        $_SESSION['usuario_nome']    = $user['nome'];
        $_SESSION['usuario_empresa'] = $user['empresa'];
        $_SESSION['token']           = md5($user['usuario'] . SISTEMA_TOKEN_SALT . time());
        return true;
    }
    return false;
}

function logout() { session_destroy(); header('Location: /login.php'); exit; }
