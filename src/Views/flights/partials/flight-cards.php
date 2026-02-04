<?php foreach ($flights as $flight): ?>
  <div class='flight'>
    <img src='<?= htmlspecialchars($flight['image_url']) ?>' alt='Destino' class='flight-img'>
    <div class='flight-info'>
      <strong>Vuelo a:
        <?= htmlspecialchars($flight['destination']) ?>
      </strong>
      <p>
        <strong>Desde:</strong>
        <?= htmlspecialchars($flight['origin']) ?> &nbsp;&nbsp;
        <strong>Hasta:</strong>
        <?= htmlspecialchars($flight['destination']) ?>
      </p>
      <p><strong>Fecha:</strong>
        <?= $flight['formatted_date'] ?>
      </p>
      <p><strong>Precio:</strong>
        <?= $flight['formatted_price'] ?>
      </p>
      <button onclick="planFlight('<?= htmlspecialchars($flight['destination']) ?>')">
        Planificar Viaje
      </button>
    </div>
  </div>
<?php endforeach; ?>

<?php if (empty($flights)): ?>
  <p>No se encontraron vuelos con esa búsqueda.</p>
<?php endif; ?>