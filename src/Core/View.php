<?php
namespace SkyWings\Core;

class View
{
  private static $viewsPath = __DIR__ . '/../Views/';

  /**
   * Renderiza una vista con datos
   * 
   * @param string $view Ruta de la vista (ej: 'flights/list')
   * @param array $data Datos a pasar a la vista
   * @return void
   */
  public static function render(string $view, array $data = []): void
  {
    // Extraer datos como variables
    extract($data);

    // Construir ruta completa
    $viewFile = self::$viewsPath . $view . '.php';

    if (!file_exists($viewFile)) {
      throw new \Exception("Vista no encontrada: {$view}");
    }

    // Incluir la vista
    require_once $viewFile;
  }

  /**
   * Renderiza una vista con layout
   * 
   * @param string $view
   * @param array $data
   * @param string $layout Layout a usar (default: 'main')
   * @return void
   */
  public static function renderWithLayout(string $view, array $data = [], string $layout = 'main'): void
  {
    extract($data);

    // Capturar el contenido de la vista
    ob_start();
    self::render($view, $data);
    $content = ob_get_clean();

    // Renderizar con layout
    require_once self::$viewsPath . "layouts/{$layout}.php";
  }

  /**
   * Incluye un partial
   * 
   * @param string $partial
   * @param array $data
   * @return void
   */
  public static function partial(string $partial, array $data = []): void
  {
    self::render("partials/{$partial}", $data);
  }
}