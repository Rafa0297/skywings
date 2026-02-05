<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
  <h2>✈️ Iniciar Sesión</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-error">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <?php if (isset($success)): ?>
    <div class="alert alert-success">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <form action="/login" method="POST">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="btn-submit">Iniciar Sesión</button>
  </form>

  <div class="text-center">
    <p>¿No tienes cuenta? <a href="/register">Regístrate aquí</a></p>
    <p><a href="/">← Volver al inicio</a></p>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>