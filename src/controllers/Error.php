<?php

namespace controllers;

use core\constans\Constants;
use core\logger\Log;
use core\twig\TwigConfigure;
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

        $httpSatusCode = $exception->getCode();
        if($httpSatusCode !== 404) $httpSatusCode = 500;
        http_response_code($httpSatusCode);

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
            if($httpSatusCode === 404)
                echo TwigConfigure::getTwigEnvironment()->render('404.twig', ['data' => "Page not found"]);
            else
                echo TwigConfigure::getTwigEnvironment()->render('500.twig', ['data' => "An error occurred"]);
        }

    }
}
