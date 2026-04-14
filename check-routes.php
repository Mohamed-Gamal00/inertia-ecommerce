<?php

// Simple script to check for route name conflicts
// Run with: php check-routes.php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    // Try to load routes without caching
    $router = $app['router'];
    
    // Load all route files
    require 'routes/web.php';
    require 'routes/api.php';
    require 'routes/dashboard.php';
    require 'routes/vendor.php';
    
    $routes = $router->getRoutes();
    $names = [];
    $conflicts = [];
    
    foreach ($routes as $route) {
        $name = $route->getName();
        if ($name) {
            if (isset($names[$name])) {
                $conflicts[] = $name;
            } else {
                $names[$name] = true;
            }
        }
    }
    
    if (empty($conflicts)) {
        echo "✅ No route name conflicts found!\n";
    } else {
        echo "❌ Route name conflicts found:\n";
        foreach ($conflicts as $conflict) {
            echo "  - $conflict\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error checking routes: " . $e->getMessage() . "\n";
}