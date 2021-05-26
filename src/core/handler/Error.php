<?php

namespace core\handler;

use core\constans\Constants;
use core\logger\Log;
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

        if(Constants::SHOW_ERRORS){
            echo "<h1>Fatal exception</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace: '" . $exception->getTraceAsString() . "'</p>";
            echo "<p>Throw in: '" . $exception->getFile() . "' on line " .$exception->getLine(). "</p>";
        }else{
            $fileName = '/system.log';
            $message = "<h1>Fatal exception</h1>";
            $message .= "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            $message .= "<p>Message: '" . $exception->getMessage() . "'</p>";
            $message .= "<p>Stack trace: '" . $exception->getTraceAsString() . "'</p>";
            $message .= "<p>Throw in: '" . $exception->getFile() . "' on line " .$exception->getLine(). "</p>";
            new Log($fileName, $message);
            echo "<h1>An error occured</h1>";
        }

    }
}
