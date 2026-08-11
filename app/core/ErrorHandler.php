<?php

declare(strict_types=1);

namespace App\Core;

use Throwable;

class ErrorHandler
{
    public function __construct(
        private array $config
    ) {
    }

public function register(): void
{
    set_exception_handler(
        [$this, 'handleException']
    );

    set_error_handler(
        [$this, 'handleError']
    );

    register_shutdown_function(
        [$this, 'handleShutdown']
    );
}

public function handleError(
    int $severity,
    string $message,
    string $file,
    int $line
): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }

    $exception = new \ErrorException(
        $message,
        0,
        $severity,
        $file,
        $line
    );

    $this->handleException($exception);

    return true;
}

public function handleShutdown(): void
{
    $error = error_get_last();

    if ($error === null) {
        return;
    }

    $fatalErrors = [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
    ];

    if (!in_array(
        $error['type'],
        $fatalErrors,
        true
    )) {
        return;
    }

    $exception = new \ErrorException(
        $error['message'],
        0,
        $error['type'],
        $error['file'],
        $error['line']
    );

    $this->handleException($exception);
}


    public function handleException(
        Throwable $exception
    ): void {

        $this->logException($exception);

        if (!headers_sent()) {
            http_response_code(500);
        }


        if ($this->isDebug()) {
            $this->renderDevelopmentError($exception);
            return;
        }

        $this->renderProductionError();
    }

    private function isDebug(): bool
    {
        return $this->config['app']['debug'] ?? false;
    }

private function logException(
    Throwable $exception
): void {

    $logDirectory = dirname(__DIR__, 2)
        . '/storage/logs';

    if (!is_dir($logDirectory)) {
        mkdir(
            $logDirectory,
            0755,
            true
        );
    }

    $logFile = $logDirectory . '/app.log';

    $message = sprintf(
        "[%s] %s: %s in %s:%d\n%s\n\n",
        date('Y-m-d H:i:s'),
        get_class($exception),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        $exception->getTraceAsString()
    );

    file_put_contents(
        $logFile,
        $message,
        FILE_APPEND | LOCK_EX
    );
}


    private function renderDevelopmentError(
        Throwable $exception
    ): void {

        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Application Error</title>';

        echo '<style>';
        echo 'body{font-family:Arial,sans-serif;background:#f5f5f5;color:#222;padding:30px;}';
        echo '.error{max-width:1000px;margin:0 auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,.08);}';
        echo 'h1{color:#b91c1c;}';
        echo 'pre{background:#111;color:#eee;padding:20px;overflow:auto;border-radius:6px;}';
        echo '</style>';

        echo '</head>';
        echo '<body>';

        echo '<div class="error">';

        echo '<h1>Application Error</h1>';

        echo '<p><strong>';
        echo htmlspecialchars(
            get_class($exception),
            ENT_QUOTES,
            'UTF-8'
        );
        echo '</strong></p>';

        echo '<p>';
        echo htmlspecialchars(
            $exception->getMessage(),
            ENT_QUOTES,
            'UTF-8'
        );
        echo '</p>';

        echo '<p>';
        echo '<strong>File:</strong> ';
        echo htmlspecialchars(
            $exception->getFile(),
            ENT_QUOTES,
            'UTF-8'
        );
        echo '</p>';

        echo '<p>';
        echo '<strong>Line:</strong> ';
        echo (int) $exception->getLine();
        echo '</p>';

        echo '<h2>Stack Trace</h2>';

        echo '<pre>';
        echo htmlspecialchars(
            $exception->getTraceAsString(),
            ENT_QUOTES,
            'UTF-8'
        );
        echo '</pre>';

        echo '</div>';

        echo '</body>';
        echo '</html>';
    }

  private function renderProductionError(): void
{
    $viewPath = dirname(__DIR__)
        . '/Views/errors/500.php';

    if (!is_readable($viewPath)) {
        echo 'Something went wrong.';
        return;
    }

    require $viewPath;
}

}
