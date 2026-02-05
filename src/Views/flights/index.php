<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="flights-container">
  <h2>Hola,
    <?= htmlspecialchars($userName) ?>. ¿A dónde volamos hoy? ✈️
  </h2>

  <div class="search-box" style="text-align: center; margin: 20px 0;">
    <input type="text" id="search" placeholder="Busca por ciudad o país..."
      style="padding: 10px; width: 80%; max-width: 500px; border-radius: 20px; border: 1px solid #ccc;">
  </div>

  <div id="flight-results" class="flight-list">
    <?php include __DIR__ . '/partials/flight-cards.php'; ?>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>