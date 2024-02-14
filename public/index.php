<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};


require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Process\Process;

$serverProcess = new Process(['php', '-S', 'localhost:8000', '-t', 'public/']);
$serverProcess->start();

echo "Server running at http://localhost:8000\n";
echo "Press Ctrl+C to stop the server\n";

$publicDirectory = __DIR__.'/public/www';

while ($serverProcess->isRunning()) {
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $filePath = $publicDirectory . $requestPath;

    if (is_file($filePath)) {
        return false;

    }

    
    if (is_file($publicDirectory.'/index.html')) {
        include $publicDirectory.'/index.html';
    } else {
        
        http_response_code(404);
        echo '404 Not Found';
    }
}
