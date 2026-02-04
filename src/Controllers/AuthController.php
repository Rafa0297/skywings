<?php
namespace SkyWings\Controllers;

use SkyWings\Core\View;
use SkyWings\Models\User;

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Muestra el formulario de login
     */
    public function showLogin()
    {
        // Si ya está logueado, redirigir a flights
        if (isset($_SESSION['user_id'])) {
            header('Location: /flights');
            exit;
        }

        View::render('auth/login');
    }

    /**
     * Procesa el login
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validar campos vacíos
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Por favor completa todos los campos';
            header('Location: /login');
            exit;
        }

        // Buscar usuario
        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            header('Location: /flights');
            exit;
        } else {
            // Credenciales incorrectas
            $_SESSION['error'] = 'Email o contraseña incorrectos';
            header('Location: /login');
            exit;
        }
    }

    /**
     * Muestra el formulario de registro
     */
    public function showRegister()
    {
        // Si ya está logueado, redirigir a flights
        if (isset($_SESSION['user_id'])) {
            header('Location: /flights');
            exit;
        }

        View::render('auth/register');
    }

    /**
     * Procesa el registro
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validaciones
        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Por favor completa todos los campos';
            header('Location: /register');
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: /register');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres';
            header('Location: /register');
            exit;
        }

        // Verificar si el email ya existe
        if ($this->userModel->emailExists($email)) {
            $_SESSION['error'] = 'El email ya está registrado';
            header('Location: /register');
            exit;
        }

        // Crear usuario
        $userId = $this->userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($userId) {
            // Registro exitoso - auto login
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['success'] = '¡Registro exitoso! Bienvenido a SkyWings';

            header('Location: /flights');
            exit;
        } else {
            $_SESSION['error'] = 'Error al crear la cuenta. Intenta nuevamente.';
            header('Location: /register');
            exit;
        }
    }

    /**
     * Cierra la sesión
     */
    public function logout()
    {
        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Destruir la sesión
        session_destroy();

        // Redirigir al home
        header('Location: /');
        exit;
    }
}