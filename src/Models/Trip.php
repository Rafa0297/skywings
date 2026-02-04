<?php
namespace SkyWings\Models;

use SkyWings\Core\Database;

class Trip
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance()->getConnection();
  }

  /**
   * Crea una nueva solicitud de viaje
   * @param array $data
   * @return int|false ID del viaje creado o false si falla
   */
  public function create(array $data)
  {
    $stmt = $this->db->prepare(
      "INSERT INTO trips (user_id, destination, motivo, fecha_ida, fecha_vuelta, personas, presupuesto, preguntas, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())"
    );

    $stmt->bind_param(
      'issssids',
      $data['user_id'],
      $data['destination'],
      $data['motivo'],
      $data['fecha_ida'],
      $data['fecha_vuelta'],
      $data['personas'],
      $data['presupuesto'],
      $data['preguntas']
    );

    if ($stmt->execute()) {
      return $this->db->insert_id;
    }

    return false;
  }

  /**
   * Obtiene todos los viajes de un usuario
   * @param int $userId
   * @return array
   */
  public function getByUserId(int $userId): array
  {
    $stmt = $this->db->prepare(
      "SELECT * FROM trips WHERE user_id = ? ORDER BY created_at DESC"
    );
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  /**
   * Obtiene un viaje por ID
   * @param int $id
   * @return array|null
   */
  public function findById(int $id): ?array
  {
    $stmt = $this->db->prepare("SELECT * FROM trips WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $trip = $result->fetch_assoc();
    return $trip ?: null;
  }

  /**
   * Obtiene todos los viajes
   * @return array
   */
  public function all(): array
  {
    $result = $this->db->query(
      "SELECT t.*, u.name as user_name, u.email as user_email 
             FROM trips t 
             LEFT JOIN users u ON t.user_id = u.id 
             ORDER BY t.created_at DESC"
    );
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  /**
   * Elimina un viaje
   * @param int $id
   * @return bool
   */
  public function delete(int $id): bool
  {
    $stmt = $this->db->prepare("DELETE FROM trips WHERE id = ?");
    $stmt->bind_param('i', $id);
    return $stmt->execute();
  }
}