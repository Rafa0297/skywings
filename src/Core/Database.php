<?php
namespace SkyWings\Core;

class Database
{
  private static $instance = null;
  private $connection;

  private function __construct()
  {
    require_once __DIR__ . '/../../config/database.php';

    $this->connection = new \mysqli("localhost", "root", "", "skywings");

    if ($this->connection->connect_error) {
      throw new \Exception("Error de conexión: " . $this->connection->connect_error);
    }

    $this->connection->set_charset("utf8mb4");
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getConnection(): \mysqli
  {
    return $this->connection;
  }

  private function __clone()
  {
  }
  public function __wakeup()
  {
  }
}