<?php
namespace SkyWings\Services;

use SkyWings\Models\Flight;

class FlightService
{
  private $flightModel;

  public function __construct()
  {
    $this->flightModel = new Flight();
  }

  /**
   * Busca vuelos y los formatea para la vista
   * @param string $query
   * @return array
   */
  public function searchFlights(string $query = ''): array
  {
    $flights = $this->flightModel->search($query);

    // Aquí puedes agregar lógica adicional:
    // - Calcular descuentos
    // - Agregar datos de APIs externas
    // - Formatear fechas

    foreach ($flights as &$flight) {
      $flight['formatted_price'] = '$' . number_format($flight['price'], 2);
      $flight['formatted_date'] = date('d/m/Y', strtotime($flight['date']));
    }

    return $flights;
  }
}