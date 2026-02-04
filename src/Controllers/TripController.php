<?php
namespace SkyWings\Controllers;

use SkyWings\Models\Trip;

class TripController
{
  private $tripModel;

  public function __construct()
  {
    $this->tripModel = new Trip();
  }

  /**
   * Guarda una solicitud de viaje
   */
  public function save()
  {
    // Verificar que el usuario esté logueado
    if (!isset($_SESSION['user_id'])) {
      header('Location: /login');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: /flights');
      exit;
    }

    // Obtener datos del formulario
    $data = [
      'user_id' => $_SESSION['user_id'],
      'destination' => $_POST['destination'] ?? '',
      'motivo' => $_POST['motivo'] ?? '',
      'fecha_ida' => $_POST['fecha_ida'] ?? '',
      'fecha_vuelta' => $_POST['fecha_vuelta'] ?? '',
      'personas' => $_POST['personas'] ?? 1,
      'presupuesto' => $_POST['presupuesto'] ?? 0,
      'preguntas' => $_POST['preguntas'] ?? ''
    ];

    // Validaciones básicas
    if (empty($data['destination']) || empty($data['fecha_ida']) || empty($data['fecha_vuelta'])) {
      $_SESSION['error'] = 'Por favor completa todos los campos obligatorios';
      header('Location: /flights');
      exit;
    }

    // Guardar en base de datos
    $tripId = $this->tripModel->create($data);

    if ($tripId) {
      $_SESSION['success'] = '¡Solicitud de viaje enviada exitosamente! Te contactaremos pronto.';
    } else {
      $_SESSION['error'] = 'Error al enviar la solicitud. Intenta nuevamente.';
    }

    header('Location: /flights');
    exit;
  }
}