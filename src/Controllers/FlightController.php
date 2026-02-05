<?php
namespace SkyWings\Controllers;

use SkyWings\Core\View;
use SkyWings\Services\FlightService;

class FlightController
{
  private $flightService;

  public function __construct()
  {
    // Asegúrate de que el Service también esté en el namespace SkyWings\Services
    $this->flightService = new FlightService();
  }

  /**
   * Muestra la lista de vuelos disponibles
   */
  public function index()
  {
    // Seguridad: Si no hay sesión, al login
    if (!isset($_SESSION['user_id'])) {
      header('Location: /login');
      exit;
    }

    $flights = $this->flightService->searchFlights();

    // Renderizamos la vista principal de vuelos
    return View::render('flights/index', [
      'flights' => $flights,
      'userName' => $_SESSION['user_name']
    ]);
  }

  /**
   * Búsqueda AJAX de vuelos (Para cuando actives el script.js)
   */
  public function search()
  {
    $query = $_GET['search'] ?? '';
    $flights = $this->flightService->searchFlights($query);

    // Usamos el buffer de salida para capturar solo la parte de las tarjetas
    ob_start();
    View::render('flights/partials/flight-cards', ['flights' => $flights]);
    $html = ob_get_clean();

    header('Content-Type: application/json');
    echo json_encode(['html' => $html]);
    exit;
  }
}