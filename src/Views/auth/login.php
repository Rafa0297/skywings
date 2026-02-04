<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión - SkyWings</title>
  <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="/assets/css/style.css">
  <style>
    .auth-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 2rem;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .auth-container h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
      font-weight: 500;
    }

    .form-group input {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-group input:focus {
      outline: none;
      border-color: #667eea;
    }

    .btn-submit {
      width: 100%;
      padding: 0.75rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
    }

    .alert {
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 5px;
    }

    .alert-error {
      background: #fee;
      color: #c33;
      border: 1px solid #fcc;
    }

    .alert-success {
      background: #efe;
      color: #3c3;
      border: 1px solid #cfc;
    }

    .text-center {
      text-align: center;
      margin-top: 1rem;
    }

    .text-center a {
      color: #667eea;
      text-decoration: none;
    }

    .text-center a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <!-- Encabezado -->
  <header class="main-header">
    <div class="header-content">
      <h1><a href="/" style="color: white; text-decoration: none;">🌍 SkyWings Travel</a></h1>
    </div>
  </header>

  <div class="auth-container">
    <h2>✈️ Iniciar Sesión</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
      </div>
      <?php unset($_SESSION['success']); ?>
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

  <footer align="center">
    <p>Hecho por: <strong><a href="https://www.instagram.com/adri.planetas?igsh=MW1paXkyMXNkZnc1NA=="
          target="_blank">Adrián</a>, y Rafael</strong></p>
  </footer>
</body>

</html>