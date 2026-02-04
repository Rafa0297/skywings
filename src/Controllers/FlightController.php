<?php
namespace SkyWings\Controllers;

use SkyWings\Services\FlightService;
use SkyWings\Core\View;

class FlightController
{
  private $flightService;

  public function __construct()
  {
    $this->flightService = new FlightService();
  }

  /**
   * Muestra la lista de vuelos disponibles
   */
  public function index()
  {
    session_start();

    if (!isset($_SESSION['user_id'])) {
      header('Location: /login');
      exit;
    }

    $flights = $this->flightService->searchFlights();

    View::render('flights/list', [
      'flights' => $flights,
      'user' => $_SESSION['user_name']
    ]);
  }

  /**
   * Búsqueda AJAX de vuelos
   */
  public function search()
  {
    header('Content-Type: application/json');

    $query = $_GET['search'] ?? '';
    $flights = $this->flightService->searchFlights($query);

    // Renderizar HTML para AJAX
    ob_start();
    View::render('flights/partials/flight-cards', ['flights' => $flights]);
    $html = ob_get_clean();

    echo json_encode(['html' => $html]);
  }
}