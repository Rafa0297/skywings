<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="hero">
  <h2>Descubre el mundo con SkyWings Travel ✈️</h2>
  <p>Los mejores precios y destinos esperándote. Regístrate gratis y comienza tu aventura.</p>

  <div class="nav-buttons">
    <?php if (!$isLoggedIn): ?>
      <a href="/register" class="cta-btn">Registrarse Ahora</a>
      <a href="/login" class="cta-btn btn-secondary">Iniciar Sesión</a>
    <?php else: ?>
      <p>¡Hola de nuevo, <?= htmlspecialchars($userName) ?>!</p>
      <a href="/flights" class="cta-btn">Buscar mis vuelos</a>
    <?php endif; ?>
  </div>
</section>

<section class="popular-destinations">
  <h2>🌍 Destinos Populares</h2>
  <div class="destinations-grid">
    <div class="destination">
      <img src="/assets/images/paris.jpg" alt="Paris" onclick="openDestinationModal('paris')">
      <h3>París</h3>
      <p>La ciudad del amor te espera con sus luces y su encanto.</p>
    </div>
    <div class="destination">
      <img src="/assets/images/newyork.jpg" alt="New York" onclick="openDestinationModal('newyork')">
      <h3>New York</h3>
      <p>La ciudad que nunca duerme.</p>
    </div>
    <div class="destination">
      <img src="/assets/images/tokyo.jpg" alt="Tokyo" onclick="openDestinationModal('tokyo')">
      <h3>Tokio</h3>
      <p>Modernidad y tradición fascinante.</p>
    </div>
  </div>
</section>

<section class="benefits">
  <h2>¿Por qué elegirnos?</h2>
  <ul>
    <li>✈️ Más de 100 destinos internacionales</li>
    <li>💸 Ofertas exclusivas para miembros</li>
    <li>🕑 Atención al cliente 24/7</li>
  </ul>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>