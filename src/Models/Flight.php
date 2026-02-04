<?php
namespace SkyWings\Models;

use SkyWings\Core\Database;

class Flight
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance()->getConnection();
  }

  /**
   * Busca vuelos por origen o destino
   * @param string $search
   * @return array
   */
  public function search(string $search = ''): array
  {
    $sql = "SELECT origin, destination, date, price, image_url 
                FROM flights";

    if (!empty($search)) {
      $stmt = $this->db->prepare(
        $sql . " WHERE origin LIKE ? OR destination LIKE ? ORDER BY date ASC"
      );
      $searchTerm = "%{$search}%";
      $stmt->bind_param('ss', $searchTerm, $searchTerm);
    } else {
      $stmt = $this->db->prepare($sql . " ORDER BY date ASC");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  /**
   * Obtiene todos los vuelos
   * @return array
   */
  public function all(): array
  {
    return $this->search('');
  }
}