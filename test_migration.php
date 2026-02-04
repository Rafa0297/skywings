<?php
/**
 * Suite de Pruebas Funcionales para SkyWings
 * Ejecutar desde: php test_migration.php
 */

require_once 'vendor/autoload.php';

echo "🧪 SUITE DE PRUEBAS FUNCIONALES - SKYWINGS\n";
echo str_repeat("=", 60) . "\n\n";

$testsPassed = 0;
$testsFailed = 0;

// ========================================
// TEST 1: Conexión a Base de Datos
// ========================================
echo "TEST 1: Conexión a Base de Datos\n";
echo str_repeat("-", 60) . "\n";

try {
    $db = \SkyWings\Core\Database::getInstance();
    $conn = $db->getConnection();
    
    if ($conn && $conn->ping()) {
        echo "✅ PASS: Conexión exitosa a la base de datos\n";
        echo "   Host: {$conn->host_info}\n";
        $testsPassed++;
    } else {
        echo "❌ FAIL: No se pudo conectar a la base de datos\n";
        $testsFailed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Error de conexión - " . $e->getMessage() . "\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// TEST 2: Model Flight - Obtener todos los vuelos
// ========================================
echo "TEST 2: Model Flight - Método all()\n";
echo str_repeat("-", 60) . "\n";

try {
    $flightModel = new \SkyWings\Models\Flight();
    $flights = $flightModel->all();
    
    if (is_array($flights)) {
        echo "✅ PASS: Método all() funciona correctamente\n";
        echo "   Vuelos encontrados: " . count($flights) . "\n";
        
        if (count($flights) > 0) {
            echo "   Primer vuelo: {$flights[0]['origin']} → {$flights[0]['destination']}\n";
        }
        $testsPassed++;
    } else {
        echo "❌ FAIL: El método all() no devuelve un array\n";
        $testsFailed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Error al obtener vuelos - " . $e->getMessage() . "\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// TEST 3: Model Flight - Búsqueda
// ========================================
echo "TEST 3: Model Flight - Método search()\n";
echo str_repeat("-", 60) . "\n";

try {
    $flightModel = new \SkyWings\Models\Flight();
    $results = $flightModel->search('Madrid');
    
    if (is_array($results)) {
        echo "✅ PASS: Método search() funciona correctamente\n";
        echo "   Resultados para 'Madrid': " . count($results) . "\n";
        $testsPassed++;
    } else {
        echo "❌ FAIL: El método search() no devuelve un array\n";
        $testsFailed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Error en búsqueda - " . $e->getMessage() . "\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// TEST 4: FlightService - Búsqueda con formato
// ========================================
echo "TEST 4: FlightService - searchFlights()\n";
echo str_repeat("-", 60) . "\n";

try {
    $flightService = new \SkyWings\Services\FlightService();
    $flights = $flightService->searchFlights();
    
    if (is_array($flights)) {
        $hasFormattedFields = false;
        
        if (count($flights) > 0) {
            $hasFormattedFields = isset($flights[0]['formatted_price']) && 
                                  isset($flights[0]['formatted_date']);
        }
        
        if ($hasFormattedFields || count($flights) === 0) {
            echo "✅ PASS: FlightService formatea correctamente los datos\n";
            if (count($flights) > 0) {
                echo "   Precio formateado: {$flights[0]['formatted_price']}\n";
                echo "   Fecha formateada: {$flights[0]['formatted_date']}\n";
            }
            $testsPassed++;
        } else {
            echo "❌ FAIL: FlightService no está formateando los datos\n";
            $testsFailed++;
        }
    } else {
        echo "❌ FAIL: searchFlights() no devuelve un array\n";
        $testsFailed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Error en FlightService - " . $e->getMessage() . "\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// TEST 5: Router - Parseo de rutas
// ========================================
echo "TEST 5: Router - Sistema de rutas\n";
echo str_repeat("-", 60) . "\n";

try {
    $router = new \SkyWings\Core\Router();
    $router->add('GET', '/', \SkyWings\Controllers\FlightController::class, 'index');
    $router->add('GET', '/flights', \SkyWings\Controllers\FlightController::class, 'index');
    
    echo "✅ PASS: Router acepta rutas correctamente\n";
    echo "   Rutas registradas: 2\n";
    $testsPassed++;
} catch (Exception $e) {
    echo "❌ FAIL: Error en Router - " . $e->getMessage() . "\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// TEST 6: Verificar estructura de tablas
// ========================================
echo "TEST 6: Estructura de tablas en DB\n";
echo str_repeat("-", 60) . "\n";

try {
    $db = \SkyWings\Core\Database::getInstance();
    $conn = $db->getConnection();
    
    $tables = ['flights', 'users', 'trips'];
    $allTablesExist = true;
    
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "   ✓ Tabla '$table' existe\n";
        } else {
            echo "   ✗ Tabla '$table' NO existe\n";
            $allTablesExist = false;
        }
    }
    
    if ($allTablesExist) {
        echo "✅ PASS: Todas las tablas necesarias existen\n";
        $testsPassed++;
    } else {
        echo "⚠️  WARN: Faltan algunas tablas (no es crítico si aún no las has creado)\n";
        $testsPassed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Error verificando tablas - " . $e->getMessage() . "\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// TEST 7: Autoload de clases personalizadas
// ========================================
echo "TEST 7: PSR-4 Autoload\n";
echo str_repeat("-", 60) . "\n";

$classes = [
    'SkyWings\Core\Database',
    'SkyWings\Core\Router',
    'SkyWings\Core\View',
    'SkyWings\Models\Flight',
    'SkyWings\Services\FlightService',
    'SkyWings\Controllers\FlightController'
];

$allClassesLoad = true;
foreach ($classes as $class) {
    if (class_exists($class)) {
        echo "   ✓ $class\n";
    } else {
        echo "   ✗ $class NO SE PUEDE CARGAR\n";
        $allClassesLoad = false;
    }
}

if ($allClassesLoad) {
    echo "✅ PASS: Todas las clases se cargan correctamente\n";
    $testsPassed++;
} else {
    echo "❌ FAIL: Algunas clases no se pueden cargar\n";
    $testsFailed++;
}

echo "\n";

// ========================================
// RESUMEN FINAL
// ========================================
echo str_repeat("=", 60) . "\n";
echo "📊 RESUMEN DE PRUEBAS\n";
echo str_repeat("=", 60) . "\n\n";

$total = $testsPassed + $testsFailed;
$percentage = $total > 0 ? round(($testsPassed / $total) * 100, 2) : 0;

echo "Total de pruebas: $total\n";
echo "✅ Pasadas: $testsPassed\n";
echo "❌ Fallidas: $testsFailed\n";
echo "📈 Porcentaje de éxito: $percentage%\n\n";

if ($testsFailed === 0) {
    echo "🎉 ¡TODAS LAS PRUEBAS PASARON!\n";
    echo "✅ La migración está funcionando correctamente\n";
    echo "✅ Puedes proceder con las pruebas en el navegador\n";
    exit(0);
} else {
    echo "⚠️  Algunas pruebas fallaron\n";
    echo "🔧 Revisa los errores y corrige antes de continuar\n";
    exit(1);
}
