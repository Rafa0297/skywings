<?php
namespace SkyWings\Core;

class Router
{
  private $routes = [];

  public function add(string $method, string $path, string $controller, string $action)
  {
    $this->routes[] = [
      'method' => strtoupper($method),
      'path' => $path,
      'controller' => $controller,
      'action' => $action
    ];
  }

  public function dispatch(string $uri, string $method)
  {
    foreach ($this->routes as $route) {
      if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
        $controller = new $route['controller']();
        return $controller->{$route['action']}();
      }
    }

    http_response_code(404);
    View::render('errors/404');
  }

  private function matchPath(string $routePath, string $uri): bool
  {
    // Soporte para rutas dinámicas: /flight/{id}
    $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([^/]+)', $routePath);
    return preg_match("#^{$pattern}$#", $uri);
  }
}