<?php
namespace SkyWings\Controllers;

use SkyWings\Core\View;

class HomeController
{
  /**
   * Muestra la página de inicio
   */
  public function index()
  {
    // Iniciamos sesión para verificar si el usuario existe
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $isLoggedIn = isset($_SESSION['user_id']);

    // Pasamos la variable a la vista
    return View::render('home/index', [
      'isLoggedIn' => $isLoggedIn,
      'userName' => $_SESSION['user_name'] ?? 'Viajero'
    ]);
  }
}