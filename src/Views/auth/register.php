<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
  <h2>✈️ Registrarse</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-error">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form action="/register" method="POST">
    <div class="form-group">
      <label for="name">Nombre completo:</label>
      <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" minlength="6" required>
      <small style="color: #666; display: block; margin-top: 5px;">Mínimo 6 caracteres</small>
    </div>

    <div class="form-group">
      <label for="confirm_password">Confirmar contraseña:</label>
      <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>
    </div>

    <button type="submit" class="btn-submit">Crear Cuenta</button>
  </form>

  <div class="text-center">
    <p>¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>
    <p><a href="/">← Volver al inicio</a></p>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>