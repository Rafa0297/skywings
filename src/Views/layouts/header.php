<?php
// Aseguramos que la sesión esté iniciada para mostrar el menú correcto
if (session_status() === PHP_SESSION_NONE) {

}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SkyWings Travel - Tu aventura comienza aquí</title>

  <link rel="stylesheet" href="/assets/css/style.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

  <header class="main-header">
    <div class="header-content">
      <h1>SkyWings ✈️</h1>
      <nav>
        <a href="/">Inicio</a> |
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="/flights">Buscar Vuelos</a> |
          <a href="/logout">Cerrar Sesión</a>
        <?php else: ?>
          <a href="/login">Iniciar Sesión</a> |
          <a href="/register">Registro</a>
        <?php endif; ?>
      </nav>

      <?php if (isset($_SESSION['user_name'])): ?>
        <p style="font-size: 0.9rem; margin-top: 10px;">
          Conectado como: <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
        </p>
      <?php endif; ?>
    </div>
  </header>