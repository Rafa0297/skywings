<?php
/**
 * Script de Verificación de Migración SkyWings
 * Ejecutar desde la raíz del proyecto: php verify_migration.php
 */

echo "🔍 VERIFICANDO MIGRACIÓN DE SKYWINGS\n";
echo str_repeat("=", 60) . "\n\n";

$errors = [];
$warnings = [];
$success = [];

// 1. Verificar estructura de directorios
echo "📂 1. VERIFICANDO ESTRUCTURA DE DIRECTORIOS\n";
echo str_repeat("-", 60) . "\n";

$requiredDirs = [
    'config',
    'public',
    'public/assets',
    'public/assets/css',
    'public/assets/js',
    'public/assets/images',
    'src',
    'src/Controllers',
    'src/Services',
    'src/Models',
    'src/Views',
    'src/Views/layouts',
    'src/Views/flights',
    'src/Views/auth',
    'src/Core',
    'vendor'
];

foreach ($requiredDirs as $dir) {
    if (is_dir($dir)) {
        $success[] = "✅ Directorio encontrado: /$dir";
        echo "✅ /$dir\n";
    } else {
        $errors[] = "❌ Falta directorio: /$dir";
        echo "❌ /$dir (FALTA)\n";
    }
}

echo "\n";

// 2. Verificar archivos críticos
echo "📄 2. VERIFICANDO ARCHIVOS CRÍTICOS\n";
echo str_repeat("-", 60) . "\n";

$requiredFiles = [
    'composer.json' => 'Configuración de Composer',
    'vendor/autoload.php' => 'Autoloader de Composer',
    'config/database.php' => 'Configuración de base de datos',
    'public/index.php' => 'Front Controller',
    'public/.htaccess' => 'Configuración Apache',
    'src/Core/Database.php' => 'Singleton de base de datos',
    'src/Core/Router.php' => 'Sistema de rutas',
    'src/Core/View.php' => 'Motor de vistas',
    'src/Models/Flight.php' => 'Model de vuelos',
    'src/Controllers/FlightController.php' => 'Controlador de vuelos',
    'src/Services/FlightService.php' => 'Servicio de vuelos'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        $success[] = "✅ $description: $file";
        echo "✅ $file\n";
    } else {
        $errors[] = "❌ Falta: $file ($description)";
        echo "❌ $file (FALTA - $description)\n";
    }
}

echo "\n";

// 3. Verificar composer.json
echo "📦 3. VERIFICANDO COMPOSER.JSON\n";
echo str_repeat("-", 60) . "\n";

if (file_exists('composer.json')) {
    $composerData = json_decode(file_get_contents('composer.json'), true);
    
    if (isset($composerData['autoload']['psr-4']['SkyWings\\'])) {
        echo "✅ PSR-4 autoload configurado correctamente\n";
        echo "   Namespace: SkyWings\\ → " . $composerData['autoload']['psr-4']['SkyWings\\'] . "\n";
        $success[] = "PSR-4 configurado";
    } else {
        echo "❌ PSR-4 autoload NO configurado\n";
        $errors[] = "Falta configuración PSR-4 en composer.json";
    }
    
    if (file_exists('vendor/autoload.php')) {
        echo "✅ Autoloader generado\n";
        $success[] = "Autoloader disponible";
    } else {
        echo "⚠️  Ejecutar: composer dump-autoload\n";
        $warnings[] = "Necesita ejecutar composer dump-autoload";
    }
} else {
    echo "❌ composer.json no encontrado\n";
    $errors[] = "Falta composer.json";
}

echo "\n";

// 4. Verificar sintaxis PHP de archivos críticos
echo "🔧 4. VERIFICANDO SINTAXIS PHP\n";
echo str_repeat("-", 60) . "\n";

$phpFiles = [
    'src/Core/Database.php',
    'src/Core/Router.php',
    'src/Models/Flight.php',
    'src/Controllers/FlightController.php',
    'src/Services/FlightService.php',
    'public/index.php'
];

foreach ($phpFiles as $file) {
    if (file_exists($file)) {
        $output = [];
        $returnVar = 0;
        exec("php -l $file 2>&1", $output, $returnVar);
        
        if ($returnVar === 0) {
            echo "✅ $file\n";
            $success[] = "Sintaxis correcta: $file";
        } else {
            echo "❌ $file (ERROR DE SINTAXIS)\n";
            echo "   " . implode("\n   ", $output) . "\n";
            $errors[] = "Error de sintaxis en $file";
        }
    }
}

echo "\n";

// 5. Verificar .htaccess
echo "🌐 5. VERIFICANDO CONFIGURACIÓN APACHE\n";
echo str_repeat("-", 60) . "\n";

if (file_exists('.htaccess')) {
    $content = file_get_contents('.htaccess');
    if (strpos($content, 'RewriteEngine On') !== false) {
        echo "✅ .htaccess raíz configurado\n";
        $success[] = ".htaccess raíz OK";
    } else {
        echo "⚠️  .htaccess raíz sin RewriteEngine\n";
        $warnings[] = ".htaccess raíz necesita configuración";
    }
}

if (file_exists('public/.htaccess')) {
    $content = file_get_contents('public/.htaccess');
    if (strpos($content, 'RewriteEngine On') !== false) {
        echo "✅ public/.htaccess configurado\n";
        $success[] = "public/.htaccess OK";
    } else {
        echo "⚠️  public/.htaccess sin RewriteEngine\n";
        $warnings[] = "public/.htaccess necesita configuración";
    }
} else {
    echo "❌ Falta public/.htaccess\n";
    $errors[] = "Falta public/.htaccess";
}

echo "\n";

// 6. Probar autoload
echo "🔄 6. PROBANDO AUTOLOAD DE CLASES\n";
echo str_repeat("-", 60) . "\n";

if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    
    $classes = [
        'SkyWings\Core\Database',
        'SkyWings\Core\Router',
        'SkyWings\Models\Flight',
        'SkyWings\Controllers\FlightController',
        'SkyWings\Services\FlightService'
    ];
    
    foreach ($classes as $class) {
        if (class_exists($class)) {
            echo "✅ $class\n";
            $success[] = "Clase cargable: $class";
        } else {
            echo "❌ $class (NO SE PUEDE CARGAR)\n";
            $errors[] = "Clase no cargable: $class";
        }
    }
} else {
    echo "❌ No se puede probar autoload (falta vendor/autoload.php)\n";
    $errors[] = "Falta vendor/autoload.php";
}

echo "\n";

// 7. Verificar archivos antiguos (deben estar eliminados o movidos)
echo "🗑️  7. VERIFICANDO ARCHIVOS ANTIGUOS\n";
echo str_repeat("-", 60) . "\n";

$oldFiles = [
    'flights.php',
    'search_flights.php',
    'login.php',
    'logout.php',
    'register.php',
    'save_trip.php'
];

$foundOldFiles = false;
foreach ($oldFiles as $file) {
    if (file_exists($file)) {
        echo "⚠️  Archivo antiguo encontrado: $file (considera eliminarlo)\n";
        $warnings[] = "Archivo antiguo: $file";
        $foundOldFiles = true;
    }
}

if (!$foundOldFiles) {
    echo "✅ No se encontraron archivos antiguos en la raíz\n";
    $success[] = "Archivos antiguos movidos/eliminados";
}

echo "\n";

// RESUMEN
echo str_repeat("=", 60) . "\n";
echo "📊 RESUMEN DE VERIFICACIÓN\n";
echo str_repeat("=", 60) . "\n\n";

echo "✅ ÉXITOS: " . count($success) . "\n";
echo "⚠️  ADVERTENCIAS: " . count($warnings) . "\n";
echo "❌ ERRORES: " . count($errors) . "\n\n";

if (count($errors) > 0) {
    echo "🚨 ERRORES CRÍTICOS:\n";
    foreach ($errors as $error) {
        echo "   • $error\n";
    }
    echo "\n";
}

if (count($warnings) > 0) {
    echo "⚠️  ADVERTENCIAS:\n";
    foreach ($warnings as $warning) {
        echo "   • $warning\n";
    }
    echo "\n";
}

// Conclusión
if (count($errors) === 0 && count($warnings) === 0) {
    echo "🎉 ¡MIGRACIÓN COMPLETADA EXITOSAMENTE!\n";
    echo "✅ Todos los componentes están en su lugar\n";
    echo "✅ La estructura es correcta\n";
    echo "✅ Las clases se pueden autocargar\n\n";
    echo "📝 PRÓXIMOS PASOS:\n";
    echo "   1. Configurar el servidor web para apuntar a /public\n";
    echo "   2. Probar las rutas en el navegador\n";
    echo "   3. Ejecutar tests funcionales\n";
    exit(0);
} elseif (count($errors) === 0) {
    echo "✅ Migración completada con advertencias menores\n";
    echo "📝 Revisa las advertencias y continúa con las pruebas\n";
    exit(0);
} else {
    echo "❌ La migración tiene errores críticos\n";
    echo "🔧 Corrige los errores antes de continuar\n";
    exit(1);
}
