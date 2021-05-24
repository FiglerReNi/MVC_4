<?php

namespace core\handler;

use ErrorException;
use Exception;

class Error
{
    public static function errorHandler($level, $message, $file, $line): void
    {
        if (error_reporting() !== 0) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    public static function exceptionHandler($exception): void
    {
        /**
         * @var Exception $exception
        */
        echo "<h1>Fatal exception</h1>";
        echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
        echo "<p>Message: '" . $exception->getMessage() . "'</p>";
        echo "<p>Stack trace: '" . $exception->getTraceAsString() . "'</p>";
        echo "<p>Throw in: '" . $exception->getFile() . "' on line " .$exception->getLine(). "</p>";
    }
}
