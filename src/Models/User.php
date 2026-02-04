<?php
namespace SkyWings\Models;

use SkyWings\Core\Database;

class User
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance()->getConnection();
  }

  /**
   * Busca un usuario por email
   * @param string $email
   * @return array|null
   */
  public function findByEmail(string $email): ?array
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
    return $user ?: null;
  }

  /**
   * Busca un usuario por ID
   * @param int $id
   * @return array|null
   */
  public function findById(int $id): ?array
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
    return $user ?: null;
  }

  /**
   * Verifica si un email ya existe
   * @param string $email
   * @return bool
   */
  public function emailExists(string $email): bool
  {
    $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
  }

  /**
   * Crea un nuevo usuario
   * @param array $data
   * @return int|false ID del usuario creado o false si falla
   */
  public function create(array $data)
  {
    $stmt = $this->db->prepare(
      "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())"
    );

    $stmt->bind_param(
      'sss',
      $data['name'],
      $data['email'],
      $data['password']
    );

    if ($stmt->execute()) {
      return $this->db->insert_id;
    }

    return false;
  }

  /**
   * Actualiza un usuario
   * @param int $id
   * @param array $data
   * @return bool
   */
  public function update(int $id, array $data): bool
  {
    $fields = [];
    $values = [];
    $types = '';

    foreach ($data as $key => $value) {
      $fields[] = "$key = ?";
      $values[] = $value;
      $types .= 's';
    }

    $values[] = $id;
    $types .= 'i';

    $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param($types, ...$values);

    return $stmt->execute();
  }

  /**
   * Obtiene todos los usuarios
   * @return array
   */
  public function all(): array
  {
    $result = $this->db->query("SELECT id, name, email, created_at FROM users ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
  }
}